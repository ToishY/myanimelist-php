<?php
class MyAnimeListHandler{
	/**
	* PHP class for getting MyAnimeList information
	* 
	* @author     ToishY
	* @version    1.0.0
	*/

	// MAL domain name
	private const MAL_URL = 'myanimelist.net';

	// MAL CDN domain
	private const MAL_CDN = 'cdn'; #used to be cdn-dena or something

	public $mid;
	public $slug;
	private $show;

	function __construct($MALid){
		$this->mid = $MALid;
		$this->show = preg_replace('/\s\s+|\n/', ' ', file_get_contents( 'https://' . self::MAL_URL . '/anime/' . $MALid ) );
		$this->slug = $this->showSlug();
	}

	function getShowInfo(){
		return array('name'=>$this->showName(),
			        'alternative_titles'=>$this->showAlternativeTitles(),
					'slug'=>$this->slug,
			        'description'=>$this->showDescription(),
			        'thumbnail'=>$this->showThumbnail(),
			        'pics'=>$this->showPictures(),
			        'tags'=>$this->showTags(),
			        'type'=>$this->showType(),
			        'rating'=>$this->showRating(),
			        'age'=>$this->showAgeRestriction(),
			        'status'=>$this->showStatus(),
			        'airdate'=>$this->showAirDate(),
			        'eps_dur'=>$this->showEpisodeDuration(),
			        'eps_count'=>$this->showEpisodeCount(),
			        'eps_names'=>$this->episodeTitles(),
			        'eps_dur'=>$this->showEpisodeDuration(),
			        'pv'=>$this->showPromotionalVideo());
	}

	private function showName(){
		preg_match('/<h1 class=\"h1\"><span itemprop=\"name\">(.*?)<\/span><\/h1>/', $this->show, $match);
		return $match[1];
	}

	private function showDescription(){
		preg_match('/<span itemprop=\"description\">(.*?)<\/span>/', $this->show, $match);
		return $match[1];
	}

	private function showThumbnail(){
		preg_match('/<img src="https:\/\/' . self::MAL_CDN . '.' . self::MAL_URL . '\/images\/anime\/(.*?). alt/', $this->show, $match);
		return $match[1];
	}

	private function showPictures(){
		$pslug = 'https://'. self::MAL_URL .'/anime/' . $this->mid . '/' . $this->slug . '/pics';
		preg_match_all('/rel="gallery-anime"><img src="https:\/\/' . self::MAL_CDN . '.' . self::MAL_URL . '\/images\/anime\/(.*)" alt=/', file_get_contents($pslug), $matches);
		return array_values( array_diff( $matches[1], array( $this->showThumbnail() ) ) );
	}

	private function showType(){
		preg_match('/<span class="dark_text">Type:<\/span>\s<a href=".*?type=.*?">(.*?)<\/a><\/div>/', $this->show, $match);
		return $match[1];
	}

	private function showAlternativeTitles(){
		preg_match_all('/<div class="spaceit_pad">\s+<span class="dark_text">(.*?):<\/span>\s+(.*?)\s+<\/div>/', $this->show, $matches);
		return array_combine( $matches[1], $matches[2] );
	}

	private function showRating(){
		preg_match('/<span itemprop=\"ratingValue\">(.*?)<\/span>/', $this->show, $match);
		return $match[1];
	}

	private function showAgeRestriction(){
		preg_match('/<span class="dark_text">Rating:<\/span>\s(.*?)\s<\/div>/', $this->show, $match);
		return $match[1];
	}

	private function showStatus(){
		preg_match('/<span class=\"dark_text\">Status:<\/span>\s(.*?)\s<\/div>/', $this->show, $match);
		return $match[1];
	}

	private function showAirDate(){
		preg_match('/<span class="dark_text">Aired:<\/span>\s(.*?)\s<\/div>/', $this->show, $match);
		
		//check if field contained start AND end date
		if(strpos($match[1], ' to ') !== false){
			list($s, $e) = explode(' to ', $match[1]);
			return array('start' => date('Y-m-d G:i:s', strtotime( $s ) ), 'end' => date('Y-m-d G:i:s', strtotime( $e ) ) );
		}
		//else return start date = end date; more consistent
		return array('start' => date('Y-m-d G:i:s', strtotime( $match[1] ) ), 'end' => date('Y-m-d G:i:s', strtotime( $match[1] ) ) );
	}

	private function showEpisodeCount(){
		preg_match('/<span class=\"dark_text\">Episodes:<\/span>\s(.*?)\s<\/div>/', $this->show, $match);
		return $match[1];
	}

	private function showEpisodeDuration(){
		preg_match('/<span class="dark_text">Duration:<\/span>\s(.*?)\s<\/div>/', $this->show, $match);
		//format duration to minutes
		preg_match_all('/\d{1,}/', $match[1], $duration);
		if(count($duration[0]) > 1){
			return ( (int) $duration[0][0] * 60 ) + (int) $duration[0][1]; #hours to minutes + minutes
		}
		return ( (int) $duration[0][0] );
	}

	private function showTags(){
		preg_match_all('/<a href="\/anime\/genre\/(\d+).*?" title=".*?">(.*?)<\/a>/', $this->show, $matches);
		return array_combine($matches[1],$matches[2]);
	}

	private function showPromotionalVideo(){
		preg_match('/https:\/\/www.youtube.com\/embed\/(.{1,11})/', $this->show, $match);
		return (!empty($match[1]) ? $match[1] : NULL);
	}

	private function showSlug(){
		preg_match('/"https:\/\/' . self::MAL_URL . '\/anime\/' . $this->mid . '\/(.*?)"/',  $this->show, $match);
		return $match[1];
	}

	private function episodeTitles(){
		$eslug = 'https://'. self::MAL_URL .'/anime/' . $this->mid . '/' . $this->slug . '/episode';

		//test if episode naming available
		$ehtml = file_get_contents( $eslug );
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

	private function subarray_merge(...$arrays){
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