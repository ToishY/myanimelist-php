<?php
class MyAnimeListHandler{
	/**
	* PHP class for getting MyAnimeList anime information
	* 
	* @author     ToishY
	* @version    1.0.2
	*/

	// MAL domain name
	public const MAL_URL = 'myanimelist.net';

	// MAL CDN domain
	public const MAL_CDN = 'cdn';

	public $mid;
	public $slug;
	private $show;
	private $auth;

	public function __construct( $id, $slug = NULL ){
		$this->mid = $id;
		if( !is_null( $slug ) ){ $this->slug = $slug; } ;		
	}

	public function getShowInfo(){
		$this->content = $this->file_get_content_main( 'https://' . self::MAL_URL . '/anime/' . $this->mid );
		if($this->content == 404 || $this->content == 429) return $this->content;
		$this->show = preg_replace('/\s\s+|\n/', ' ', $this->content );
		return json_decode( json_encode( array( 'name'=>$this->showName(),
			        'alternative_titles'=>$this->showAlternativeTitles(),
					'slug'=>$this->showSlug(),
			        'description'=>$this->showDescription(),
			        'thumbnail'=>$this->showThumbnail(),
			        'tags'=>$this->showTags(),
			        'type'=>$this->showType(),
			        'rating'=>$this->showRating(),
			        'voters'=>$this->showVoters(),
			        'age'=>$this->showAgeRestriction(),
			        'status'=>$this->showStatus(),
			        'airdate'=>$this->showAirDate(),
			        'studio'=>$this->showStudio(),
			      	'relations'=>$this->showRelations(),
			        'pv'=>$this->showPromotionalVideo(),
			        'eps_dur'=>$this->showEpisodeDuration(),
			        'eps_count'=>$this->showEpisodeCount() ) ), FALSE);
	}

	public function getCharacters(){
		/*
		* Get characters and corresponding Japanese VA's.
		*/
		$cn = $this->file_get_content_main( 'https://' . self::MAL_URL . '/anime/' . $this->mid . '/' . $this->slug . '/characters' );
		# Check if content found
		if( $cn == 404 || $cn == 429) return $cn;

		# Match the character table
		$html = preg_replace('/\s\s+|\n/', ' ', $cn );
		preg_match_all('/<table border="0" cellpadding="0" cellspacing="0" width="100%">[\s+]?<tr>[\s+]?<td valign="top" width="\d{2}" class="ac borderClass bgColor\d{1}">[\s+]?<div class="picSurround">.*?<\/a>[\s+]?<\/div>[\s+]?<\/td>[\s+]?<td valign="top" class="borderClass bgColor\d{1}">[\s+]?<a href="https:\/\/myanimelist.net\/character\/(.*?)\/(.*?)">(.*?)<\/a>[\s+]?<div class="spaceit_pad">[\s+]?<small>([A-Za-z]+?)<\/small>[\s+]?<\/div>[\s+]?<\/td>[\s+]?<td align="right" valign="top" class="borderClass bgColor\d{1}">[\s+]?<table border="0" cellpadding="0" cellspacing="0">(.*?)<\/table>[\s+]?<\/td>[\s+]?<\/tr>[\s+]?<\/table>/', $html, $matches); unset($matches[0]); $matches = array_values($matches);

		# Check if there are any characters at all
		if( empty( $matches[0] ) ) return 'No characters found';

		# Match character-va pair and construct array
		$nar = [];
		for($i = 0; $i < count($matches[0]); $i++){
			$str2 = '<a href="https:\/\/myanimelist.net\/character\/%s\/%s">%s<\/a>[\s+]?<div class="spaceit_pad">[\s+]?<small>%s<\/small>[\s+]?<\/div>[\s+]?<\/td>[\s+]?<td align="right" valign="top" class="borderClass bgColor\d{1}">[\s+]?<table border="0" cellpadding="0" cellspacing="0"><tr>[\s+]?<td valign="top" align="right" style="padding: 0 4px;" nowrap="">[\s+]?(.*?)<\/table>[\s+]?<\/td>[\s+]?<\/tr>[\s+]?<\/table>';
			preg_match('/'.sprintf($str2, $matches[0][$i], $matches[1][$i], $matches[2][$i], $matches[3][$i]).'/', $html, $cmatches);
			if( !isset($cmatches[1]) || (stripos($cmatches[1], 'japanese') === FALSE ) ){
				$va = ['voice_actor'=>NULL];
			}else{
				preg_match('/<a href="https:\/\/myanimelist.net\/people\/(\d{1,20})\/([A-Za-z-_]+?)">([^<>]+?)<\/a><br>[\s+]?<small>Japanese<\/small>/',$cmatches[1], $fmatches);
				$va = ['voice_actor'=>['id'=>$fmatches[1], 'slug'=>$fmatches[2], 'name'=>trim($fmatches[3])]];
			}
			$nar[] = array_merge( ['character'=>['id'=>$matches[0][$i], 'slug'=>$matches[1][$i], 'name'=>trim($matches[2][$i]), 'role'=>$matches[3][$i], 'importance'=>$i]], $va );
		}
		return $nar;
	}

	public function showAllPictures(){
		/*
		* More show pictures as {int}/{int}.jpg
		*/
		$pslug = 'https://'. self::MAL_URL .'/anime/' . $this->mid . '/' . $this->slug . '/pics';
		preg_match_all('/rel="gallery-anime"><img src="https:\/\/' . self::MAL_CDN . '.' . self::MAL_URL . '\/images\/anime\/(.*)" alt=/', file_get_contents($pslug), $matches);
		return array_values( array_diff( $matches[1], array( $this->showThumbnail() ) ) );
	}

	public function showAllPromotionalVideos(){
		/*
		* More promotional videos
		*/
		$pvslug = 'https://'. self::MAL_URL .'/anime/' . $this->mid . '/' . $this->slug . '/video';
		preg_match_all('/https:\/\/www.youtube.com\/embed\/(.{1,11}).*<span class="title">(.*)<\/span><\/div>/', file_get_contents( $pvslug ), $matches);
		return $matches[1];
	}

	private function showName(){
		/*
		* Show name (H1)
		*/
		preg_match('/<h1 class=\"h1\"><span itemprop=\"name\">(.*?)<\/span><\/h1>/', $this->show, $match);
		return $match[1];
	}

	private function showDescription(){
		preg_match('/<span itemprop=\"description\">(.*?)<\/span>/', $this->show, $match);
		return ( isset( $match[1] ) ? $match[1] : $this->showName() );
	}

	private function showThumbnail(){
		/*
		* Main show thumbnail as {int}/{int}.jpg
		*/
		preg_match('/<img src="https:\/\/' . self::MAL_CDN . '.' . self::MAL_URL . '\/images\/anime\/(.*?). alt/', $this->show, $match);
		return (isset($match[1]) ? $match[1] : NULL);
	}

	private function showType(){
		/*
		* Type of show, e.g. TV
		*/
		preg_match('/<span class="dark_text">Type:<\/span>[\s]?(<a href=".*?">)?([A-Za-z]+?)(<\/a>)?<\/div>/', $this->show, $match);
		return $match[2];
	}

	private function showAlternativeTitles(){
		/*
		* Alternative titles, e.g. Japanese
		*/
		preg_match_all('/<div class="spaceit_pad">\s+<span class="dark_text">(.*?):<\/span>\s+(.*?)\s+<\/div>/', $this->show, $matches);
		return ( isset( $matches[1] ) ? array_combine( $matches[1], $matches[2] ) : array() );
	}

	private function showRating(){
		/*
		* Overall score
		*/
		preg_match('/Score:<\/span>[\s+]<span( itemprop="ratingValue")?>(.*?)<\/span>/', $this->show, $match);
		if( isset( $match[2] ) ){
			if( is_numeric( $match[2] ) ){
				return $match[2];
			}
			return 0;
		}
		return 0;
	}

	private function showVoters(){
		/*
		* Amount of voters for corresponding rating
		*/
		preg_match('/scored by <span( itemprop="ratingCount")?>(.*?)<\/span>/', $this->show, $match);
		if( isset( $match[2] ) ){
			$voters = str_replace( ',', '', $match[2] );
			if( is_numeric( $voters ) ){
				return intval($voters);
			}
			return 0;
		}
		return 0;
	}

	private function showAgeRestriction(){
		/*
		* Age restriction
		*/
		preg_match('/<span class="dark_text">Rating:<\/span>\s(.*?)\s<\/div>/', $this->show, $match);
		return $match[1];
	}

	private function showStatus(){
		/*
		* Currently airing status, e.g. Finished Airing
		*/
		preg_match('/<span class=\"dark_text\">Status:<\/span>\s(.*?)\s<\/div>/', $this->show, $match);
		return $match[1];
	}

	private function showAirDate(){
		/*
		* Airdate start/end as start=>datetime, end=>datetime pair
		*/
		preg_match('/<span class="dark_text">Aired:<\/span>[\s]?(.*?)[\s]?<\/div>/', $this->show, $match);
		if( $match[1] == 'Not available') {
			return array('start' => NULL, 'end' => NULL );
		}elseif ( strpos($match[1], ' to ?' ) !== FALSE ){
			list($s, $e) = explode(' to ?', $match[1]);
			$st = date('Y-m-d H:i:s', strtotime($s) );
			if(strpos($st, '00:00:00') !== FALSE){
			    return array('start' => date('Y-m-d H:i:s', strtotime($s) ), 'end' => NULL );
			}else{
			    preg_match('/\d{4}-\d{2}/', $st, $match);
			    if (isset($match[0])){
			    	return array('start' => ( $match[0] . '-01 00:00:02' ), 'end' => NULL );
			    }else{
			    	return array('start' => NULL, 'end' => NULL );
			    }
			}
		}elseif( strpos($match[1], ' to ') !== FALSE ){				
			list($s, $e) = explode(' to ', $match[1]);
			if( is_numeric( $s ) && is_numeric( $e ) ){
				return array('start' => $s . '-01-01 00:00:01', 'end' => $e . '-01-01 00:00:01' );
			}elseif( is_numeric( $s ) && !is_numeric( $e ) ){
				return array('start' => $s . '-01-01 00:00:01', 'end' => date( 'Y-m-d H:i:s', strtotime( $e ) ) );
			}elseif( !is_numeric( $s ) && is_numeric( $e ) ){
				return array('start' => date('Y-m-d H:i:s', strtotime( $s ) ), 'end' => $e . '-01-01 00:00:01' );
			}else{
				return array('start' => date('Y-m-d H:i:s', strtotime( $s ) ), 'end' => date( 'Y-m-d H:i:s', strtotime( $e ) ) );
			}
		}elseif( is_numeric( $match[1] ) ){
			return array('start' => $match[1] . '-01-01 00:00:01', 'end' => $match[1] . '-01-01 00:00:01' );
		}else{
			return array('start' => date('Y-m-d H:i:s', strtotime( $match[1] ) ), 'end' => date( 'Y-m-d H:i:s', strtotime( $match[1] ) ) );
		}
	}

	private function showEpisodeCount(){
		/*
		*	Amount of episodes
		*/
		preg_match('/<span class=\"dark_text\">Episodes:<\/span>\s(.*?)\s<\/div>/', $this->show, $match);
		return ( ( is_numeric($match[1]) ) ? ( $match[1] ) : ( NULL ) );
	}

	private function showEpisodeDuration(){
		/*
		* Duration of each episode
		*/
		preg_match('/<span class="dark_text">Duration:<\/span>\s(.*?)\s<\/div>/', $this->show, $match);
		# format duration to minutes
		preg_match_all('/\d{1,}/', $match[1], $duration);
		if( isset($duration[0][0] ) ){
			if(count($duration[0]) > 1){
				return ( (int) $duration[0][0] * 60 ) + (int) $duration[0][1]; #hours to minutes + minutes
			}
			return ( (int) $duration[0][0] );
		}
		return NULL;
	}

	private function showTags(){
		/*
		* Show genres as id=>name pair
		*/
		preg_match_all('/<a href="\/anime\/genre\/(\d+).*?" title=".*?">(.*?)<\/a>/', $this->show, $matches);
		$cmb = array_combine($matches[1],$matches[2]);
		return ( !empty($cmb) ? $cmb : NULL );
	}

	private function showStudio(){
		/*
		* Studios as id=>name pair
		*/
		preg_match('/Studios:<\/span>[\s+]?[\/producer\/\d+.*?" title=".*?">](.*?)[\s+]?<\/div>/', $this->show, $match);
		if( isset( $match[1] ) && !empty( $match[1] ) ){
			preg_match_all('/<a href="\/anime\/producer\/(\d+).*?" title="[^"]*">(.*?)<\/a>/', $match[1], $matchf); unset($matchf[0]); $matchf = array_values($matchf);
			if ( isset( $matchf[0] ) && !empty( $matchf[0] ) ){
				return array_combine($matchf[0],$matchf[1]);
			}
			return NULL;
		}
		return NULL;
	}

	private function showRelations(){
		/*
		* Relationship with other anime as id=>relation pair
		*/
		preg_match('/<table class="anime_detail_related_anime" style="border-spacing:0px;">(.*?)<\/table>/', $this->show, $related_table);
		if( !isset( $related_table[1] ) ) return NULL;
		preg_match_all('/<td nowrap="" valign="top" class="ar fw-n borderClass">([a-zA-Z\s]+):/', $related_table[1], $cat_names);
		$split_cat = array_values(array_filter(preg_split('/<tr><td nowrap="" valign="top" class="ar fw-n borderClass">([a-zA-Z\s]+):<\/td>/', $related_table[1]))); 
		if( !isset( $cat_names[1] ) ) return NULL;
		$resa = array();
		for($i = 0; $i < count($cat_names[1]); $i++){
		    preg_match_all('/[manga|anime]\/(\d+)/', $split_cat[$i], $related_ids);
		    if(isset($related_ids[1]) && !empty($related_ids[1])){
		        $resa[$cat_names[1][$i]] = $related_ids[1];
		    }elseif(isset($related_ids[0]) && !empty($related_ids[0])){
		        $resa[$cat_names[1][$i]] = $related_ids[0];
		    }
		    
		}

		if( isset($resa['Adaptation'] ) ){
		    unset( $resa['Adaptation'] );
		}
		return ( !empty($resa) ? $resa : NULL );
	}

	private function showPromotionalVideo(){
		/*
		* Main promotional YouTube video
		*/
		preg_match('/https:\/\/www.youtube.com\/embed\/(.{1,11})/', $this->show, $match);
		return (!empty($match[1]) ? $match[1] : NULL);
	}

	private function showSlug(){
		/*
		* Slug
		*/
		preg_match('/"https:\/\/' . self::MAL_URL . '\/anime\/' . $this->mid . '\/(.*?)"/',  $this->show, $match);
		if(!isset($this->slug)){
			$this->slug = $match[1];
		}
		return $this->slug;
	}

	private function episodeTitles(){
		/*
		* Titles for each episode
		*/
		$eslug = 'https://'. self::MAL_URL .'/anime/' . $this->mid . '/' . $this->slug . '/episode';

		//test if episode naming available
		if($ehtml = @file_get_contents( $eslug )){
			preg_match_all('/(\d+)" class="fl-l fw-b ">([.\S\s]+?)<\/a>/', $ehtml , $ematches);

			//remove trash and 'reindex'
			unset($ematches[0]); $ematches = array_values($ematches);

			$ematches[1] = preg_replace('/\s+/', ' ', $ematches[1]);
			$ematches = array_combine($ematches[0], $ematches[1]);

			if(!empty($ematches)){
				//check if 100+ episodes
				preg_match_all('/offset=(\d+)">/', $ehtml, $cmatches);
				if(!empty($cmatches[1])){
					$max_pages = max($cmatches[1]);
					foreach ($cmatches[1] as $v) {
						preg_match_all('/(\d+)" class="fl-l fw-b ">([.\S\s]+?)<\/a>/', file_get_contents( $eslug . '?offset=' . $v ), $ecmatches);
						//remove unwanted newlines in eps titles
						$ecmatches[2] = preg_replace('/\s+/', ' ', $ecmatches[2]);
						//append new entries to existing array
						$nmatches = ( isset($nmatches) ? ( $this->subarray_merge($nmatches, $ecmatches) ) : $ecmatches );
					}
					return array_combine($nmatches[1], $nmatches[2]);
				}
				return $ematches;
			}
			return NULL;
		}
		return NULL;
	}

	private function file_get_content_main( $url ){
		/*
		* Get contents with response checking
		*/
	    $context  = stream_context_create(array('http' => array('ignore_errors' => true)));
	    $response = file_get_contents($url, false, $context);
		if ( strpos($http_response_header[0], '404') !== FALSE ) return 404;
		if ( strpos($http_response_header[0], '429') !== FALSE ) return 429;
		return $response;
	}

	private function subarray_merge(...$arrays){
		/*
		* Merging subarrays
		*/
	    $result = array();
	    foreach ($arrays as $k => $v) {
	        if($k === 0) {
	            $result = $v;
	        }else{
	            foreach ($v as $ks => $vs) {
	                $result[$ks] = array_merge($result[$ks], $v[$ks]);
	            }
	        }
	    }
	    return $result;
	}
}
?>
