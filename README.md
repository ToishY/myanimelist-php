# myanimelist-php
Just an easy to use PHP class for getting anime information from [MyAnimeList](https://myanimelist.net) (without API).

### How To Use
Just include it in the PHP file where you want to use it and supply the MyAnimeList ID (from URL)
```php
//include or require
include('malClass.php');

//get Gintama information
$stmt = new MyAnimeListHandler(918);
$res = $stmt->getShowInfo();

print_r($res);
```

The result:
```
Array
(
    [name] => Gintama
    [alternative_titles] => Array
        (
            [English] => Gintama
            [Synonyms] => Gin Tama, Silver Soul, Yorinuki Gintama-san
            [Japanese] => 銀魂
        )

    [slug] => Gintama
    [description] => The Amanto, aliens from outer space, have invaded Earth and taken over feudal Japan. As a result, a prohibition on swords has been established, and the samurai of Japan are treated with disregard as a consequence.<br /> <br /> However one man, Gintoki Sakata, still possesses the heart of the samurai, although from his love of sweets and work as a yorozuya, one might not expect it. Accompanying him in his jack-of-all-trades line of work are Shinpachi Shimura, a boy with glasses and a strong heart, Kagura with her umbrella and seemingly bottomless stomach, as well as Sadaharu, their oversized pet dog. Of course, these odd jobs are not always simple, as they frequently have run-ins with the police, ragtag rebels, and assassins, oftentimes leading to humorous but unfortunate consequences.<br /> <br /> Who said life as an errand boy was easy?<br /> <br /> [Written by MAL Rewrite]
    [thumbnail] => 10/73274.jpg
    [pics] => Array
        (
            [0] => 12/7239.jpg
            [1] => 11/8307.jpg
            [2] => 7/8438.jpg
            [3] => 2/22442.jpg
            [4] => 10/22443.jpg
            [5] => 9/60557.jpg
            [6] => 1694/95903.jpg
        )

    [tags] => Array
        (
            [1] => Action
            [4] => Comedy
            [13] => Historical
            [20] => Parody
            [21] => Samurai
            [24] => Sci-Fi
            [27] => Shounen
        )

    [type] => TV
    [rating] => 8.99
    [age] => PG-13 - Teens 13 or older
    [status] => Finished Airing
    [airdate] => Array
        (
            [start] => 2006-04-04 0:00:00
            [end] => 2010-03-25 0:00:00
        )

    [eps_dur] => 24
    [eps_count] => 201
    [eps_names] => Array
        (
            [1] => You Jerks! And You Claim To Have Gintama?! (part 1)
            [2] => You Jerks! And You Claim To Have Gintama?! (part 2)
            [3] => Nobody With Naturally Wavy Hair Can Be That Bad
            [4] => Watch Out! Weekly Shonen JUMP Sometimes Comes Out On Saturdays!
            [5] => Make Friends You Can Call By Their Nicknames, Even When You&#039;re An Old Fart
            [6] => Keep Your Promise Even If It Kills You
            [7] => Responsible Owners Should Clean Up After Their Pets
            [8] => There Is Butt A Fine Line Between Persistence And Stubbornness
            [9] => Fighting Should Be Done With Fists
            [10] => Eat Something Sour When You&#039;re Tired
            [11] => Look, Overly Sticky Sweet Dumplings Are Not Real Dumplings, You Idiot!
            [12] => People Who Make Good First Impressions Usually Suck
            [13] => If You&#039;re Going To Cosplay, Go All Out
            [14] => Boys Have A Weird Ritual That Makes Them Think They Turn Into Men When They Touch A Frog You Only Gotta Wash Under Your Armpits - Just The Armpits
            [15] => Pets Resemble Their Owners
            [16] => If You Stop And Think About It, Your Life&#039;s A Lot Longer As An Old Guy Than A Kid! Whoa, Scary!
            [17] => Sons Only Take After Their Fathers&#039; Negative Attributes
            [18] => Oh, Yeah! Our Crib Is Number One!
            [19] => Why Is The Sea So Salty? Because You City Folk Pee Whenever You Go Swimming!
            [20] => Watch Out For Conveyor Belts!
            [21] => If You&#039;re A Man, Try The Swordfish! If You Go To Sleep With The Fan On You&#039;ll Get A Stomachache, So Be Careful
            [22] => Marriage Is Prolonging An Illusion For Your Whole Life
            [23] => When You&#039;re In A Fix, Keep On Laughing, Laughing...
            [24] => Cute Faces Are Always Hiding Something
            [25] => A Shared Soup Pot Is A Microcosm Of Life
            [26] => Don&#039;t Be Shy - Just Raise Your Hand And Say It
            [27] => Some Things Can&#039;t Be Cut With A Sword
            [28] => Good Things Never Come In Twos (But Bad Things Do)
            [29] => Don&#039;t Panic - There&#039;s A Return Policy! I Told You To Pay Attention To The News!
            [30] => Even Teen Idols Act Like You Guys
            [31] => You Always Remember The Things That Matter The Least
            [32] => Life Moves On Like A Conveyor Belt
            [33] => Mistaking Someone&#039;s Name Is Rude!
            [34] => Love Doesn&#039;t Require A Manual
            [35] => Love Doesn&#039;t Require A Manual (Continued) You Can&#039;t Judge A Person By His Appearance, Either
            [36] => People With Dark Pasts Can&#039;t Shut Up
            [37] => People Who Say That Santa Doesn&#039;t Really Exist Actually Want To Believe In Him Prayer Won&#039;t Make Your Worldly Desires Go Away! Control Yourself
            [38] => Only Children Play In The Snow Eating Ice Cream In Winter Is Awesome
            [39] => Ramen Shops With Long Menus Never Do Well
            [40] => Give A Thought To Planned Pregnancy
            [41] => You Can&#039;t Judge A Movie By Its Title
            [42] => You Know What Happens If You Pee On A Worm
            [43] => Make Characters So Anybody Can Tell Who They Are By Just Their Silhouettes Since It Ended A Bit Early, We&#039;re Starting The Next One
            [44] => Mom&#039;s Busy, Too, So Quit Complaining About What&#039;s For Dinner
            [45] => Walk Your Dog At An Appropriate Speed
            [46] => Adults Only. We Wouldn&#039;t Want Anyone Immature In Here...
            [47] => Do Cherries Come From Cherry Trees?
            [48] => The More You&#039;re Alike, The More You Fight Whatever You Play, Play To Win
            [49] => A Life Without Gambling Is Like Sushi Without Wasabi
            [50] => Pending Means Pending, It&#039;s Not Final
            [51] => Milk Should Be Served At Body Temperature
            [52] => If You Want To See Someone, Make An Appo First
            [53] => Stress Makes You Bald, But It&#039;s Stressful To Avoid Stress, So You End Up Stressed Out Anyway, So In The End There&#039;s Nothing You Can Do
            [54] => Mothers Everywhere Are All The Same
            [55] => Don&#039;t Make Munching Noises When You Eat
            [56] => Keep An Eye On The Chief For The Day
            [57] => When Looking For Things You&#039;ve Lost, Remember What You Were Doing On The Day You Lost It
            [58] => Croquette Sandwiches Are Always The Most Popular Food Sold At The Stalls
            [59] => Be Careful Not To Leave Your Umbrella Somewhere
            [60] => The Sun Will Rise Again
            [61] => On A Moonless Night, Insects Are Drawn To The Light
            [62] => Even Mummy Hunters Sometimes Turn into Mummys
            [63] => The Preview Section in JUMP is Always Unreliable
            [64] => Eating Nmaibo Can Make You Full in No Time!
            [65] => Rhinoceros Beetles Teach Boys that Life is Precious
            [66] => Dango Over Flowers
            [67] => For the Wind Is the Life
            [68] => Like a Haunted House, Life is Filled with Horrors
            [69] => Please Help by Separating Your Trash
            [70] => Too Many Cuties Can Make You Sick
            [71] => Some Data Cannot Be Erased
            [72] => A Dog&#039;s Paws Smell Fragrant Drive With A Might Attitude
            [73] => Think For A Minute Now, Do Matsutake Mushrooms Really Taste All That Good?
            [74] => The Manga Writer Becomes A Pro, After Doing A Stock Of Manuscripts
            [75] => Don&#039;t Complain About Your Job At Home, Do It Somewhere Else
            [76] => In Those Situations, Keep Quiet And Cook Red Rice With Beans
            [77] => Yesterday&#039;s Enemy, After All Is Said And Done, Is Still The Enemy
            [78] => People Who Are Picky About Food Are Also Picky About People, Too
            [79] => Four Heads Are Better Than One
            [80] => When Someone Who Wears Glasses Takes Them Off, It Looks Like Something&#039;s Missing
            [81] => A Woman&#039;s Best Make Up Is Her Smile
            [82] => You Don&#039;t Stand In Line For The Ramen, You Stand In Line For The Self Satisfaction You Say Kawaii So Often, You Must Really Think You&#039;re Cute Stuff
            [83] => Rank Has Nothing To Do With Luck
            [84] => Hard-Boiled Egg On A Man&#039;s Heart
            [85] => Hard-Boiled Eggs Don&#039;t Crack
            [86] => It&#039;s Often Difficult To Sleep When You&#039;re Engrossed With Counting Sheep
            [87] => Perform A German Suplex On A Woman Who Asks If She Or The Job Is More Important
            [88] => The Most Exciting Part Of A Group Date Is Before It Starts
            [89] => What Happens Twice, Happens Thrice
            [90] => The More Delicious The Food, The Nastier It Is When It Goes Bad
            [91] => If You Want To Lose Weight, Then Stop Eating And Start Moving
            [92] => Be A Person Who Can See People&#039;s Strong Points And Not Their Weak Points
            [93] => Even A Hero Has Issues
            [94] => When Riding A Train, Make Sure You Grab The Straps With Both Hands
            [95] => Men, Be A Madao
            [96] => If You&#039;re A Man, Don&#039;t Give Up
            [97] => Exaggerate The Tales Of Your Exploits By A Third, So Everyone Has A Good Time Men Have A Weakness For Girls Who Sell Flowers And Work In Pastry Shops
            [98] => Play Video Games For Only An Hour A Day
            [99] => Life And Video Games Are Full Of Bugs
            [100] => The More Something Is Disliked, The More Lovely It Is
            [101] => Rules Are Made To Be Broken
            [102] => Otaku Are Talkative
            [103] => There&#039;s A Thin Line Between Strengths And Weaknesses
            [104] => Important Things Are Hard To See
            [105] => It&#039;s All About The Beat And Timing
            [106] => Love Is Often Played Out In Sudden Death
            [107] => Kids Don&#039;t Understand How Their Parents Feel
            [108] => Some Things Are Better Left Unsaid
            [109] => Life Is A Test
            [110] => People Are All Escapees Of Their Own Inner Prisons
            [111] => Definitely Do Not Let Your Girlfriend See The Things You Use For Cross-Dressing There&#039;s Almost A 100% Chance You&#039;ll Forget Your Umbrella And Hate Yourself For It
            [112] => Lucky Is A Man Who Gets Up And Goes To Work
            [113] => The Act of Polishing a Urinal Is Like the Act of Polishing One`s Heart / Subtitle Undecided
            [114] => When Sweet and Spicy Things Are Switched... / They Say That Adding Soy Sauce to Pudding Gives the Taste of Sea Urchin, but Really, Adding Soy Sauce to Pudding Only Gives the Taste of Soy Sauce and Pudding
            [115] => Summer Vacation Is The Most Fun Right Before It Begins
            [116] => The Older, The Wiser
            [117] => Beauty Is Like A Summer Fruit
            [118] => Even If Your Back Is Bent, Go Straight Forward
            [119] => Within Each Box Of Cigarettes, Are One Or Two Cigarettes That Smell Like Horse Dung
            [120] => Japanese Restaurants Abroad Taste Pretty Much Like School Cafeteria Lunches Once You&#039;ve Taken A Dish, You Can&#039;t Put It Back
            [121] => Novices Only Need A Flathead And A Phillips
            [122] => Imagination Is Nurtured In The 8th Grade
            [123] => Always Keep A Screwdriver In Your Heart
            [124] => When Nagging Goes Too Far It Becomes Intimidating
            [125] => Entering The Final Chapter!
            [126] => Some Things Can Only Be Conveyed Through The Written Word
            [127] => Sometimes You Must Meet To Understand
            [128] => Sometimes You Can&#039;t Tell Just By Meeting Someone
            [129] => Beware Of Food You Pick Up Off The Ground
            [130] => Cat Lovers And Dog Lovers Are Mutually Exclusive
            [131] => Fights Often Ensue During Trips
            [132] => Briefs Will Unavoidably Get Skidmarks
            [133] => Gin And His Excellency&#039;s Good-For-Nothings
            [134] => Be Very Careful When Using Ghost Stories
            [135] => Before Worrying About The Earth, Think About The Even More Endangered Future Of &#039;Gintaman&#039;
            [136] => It&#039;s Your House, You Build It
            [137] => 99% Of Men Aren&#039;t Confident In Confessing Their Love People Who Don&#039;t Believe In Santa Are The Very Ones Who Want To Believe, You Contentious Bastard
            [138] => Let&#039;s Talk About The Old Days Once In A While
            [139] => Don&#039;t Put Your Wallet In Your Back Pocket
            [140] => Beware Of Those Who Use An Umbrella On A Sunny Day!
            [141] => Butting Into A Fight Is Dangerous
            [142] => Life Is A Series Of Choices
            [143] => Those Who Stand On Four Legs Are Beasts. Those Who Stand On Two Legs, Guts, And Glory Are Men
            [144] => Don&#039;t Trust Bedtime Stories
            [145] => The Color For Each Person&#039;s Bond Comes In Various Colors
            [146] => The Taste Of Drinking Under Broad Daylight Is Something Special
            [147] => All Adults Are Instructors For All Children
            [148] => Zip Up Your Fly Nice And Slowly
            [149] => When Breaking A Chuubert In Half, The End With The Knob Should Be Better. It&#039;s Also Tasty To Drink From There
            [150] => If You Can&#039;t Beat Them, Join Them
            [151] => A Conversation With A Barber, During A Haircut, Is The Most Pointless Thing In The World
            [152] => The Heavens Created Chonmage Above Man Instead Of Another Man
            [153] => Sleep Helps A Child Grow
            [154] => That Person Looks Different From Usual During A Birthday Party
            [155] => The Other Side Of The Other Side Of The Other Side Would Be The Other Side
            [156] => It Takes A Bit Of Courage To Enter A Street Vendor&#039;s Stand
            [157] => Any Place With A Bunch Of Men Gathered Around Will Turn Into A Battlefield
            [158] => If A Friend Gets Injured, Take Him To The Hospital, Stat!
            [159] => If One Orange In The Box Is Rotten, The Rest Of Them Will Become Rotten Before You Realize It
            [160] => From A Foreigner&#039;s Perspective, You&#039;re The Foreigner. From An Alien&#039;s Perspective, You&#039;re The Alien
            [161] => Laputa&#039;s Still Good After Seeing It So Many Times
            [162] => Love Is Unconditional
            [163] => The Black Ships Even Make A Scene When They Sink
            [164] => That Matsutake Soup Stuff Tastes Better Than The Real Deal People Who Die Stay Dead
            [165] => If It Works Once, It&#039;ll Work Over And Over Again
            [166] => Two Is Better Than One. Two People Are Better Than One
            [167] => Smooth Polygons Smooth Men&#039;s Hearts Too
            [168] => The Human Body Is Like A Little Universe
            [169] => The Chosen Idiots
            [170] => And Into The Legend...
            [171] => You&#039;ll Get Sued If All You Do Is Copy Others You Don&#039;t Know What You&#039;ve Got Till It&#039;s Gone
            [172] => It All Depends On How You Use The &#039;Carrot And Stick&#039; Method
            [173] => It&#039;s What&#039;s On The Inside That Counts It&#039;s What&#039;s On The Inside That Counts, But Only To A Certain Extent
            [174] => Are There Still People Who Go To The Ocean And Yell Out &#039;Bakayaro&#039;? When A Person Is Trapped, Their Inner Door Opens
            [175] => People Of All Ages Hate The Dentist!
            [176] => Countdown Begins
            [177] => It&#039;s Bad Luck To See A Spider At Night
            [178] => Once You&#039;re Entangled In A Spiderweb, It&#039;s Hard To Get It Off
            [179] => It&#039;s The Irresponsible One Who&#039;s Scary When Pissed
            [180] => The More Precious The Burden, The Heavier And More Difficult It Is To Shoulder It
            [181] => Watch Out For A Set Of Women And A Drink
            [182] => Screw Popularity Polls
            [183] => Popularity Polls Can Burn In Hell
            [184] => Popularity Polls Can...
            [185] => Hometowns And Boobs Are Best Thought From Afar The Whole Peeing On A Bee Sting Is A Myth. You&#039;ll Get Germs, So Don&#039;t Do It!!
            [186] => Beware Of Foreshadows
            [187] => It&#039;s Goodbye Once A Flag Is Set
            [188] => An Observation Journal Should Be Seen Through To The Very End
            [189] => It&#039;s Better To Take Care Of This Year&#039;s Business Within The Year, But Once The Year Is About To End, You Figure That You Might As Well Put It Off Till Next Year For A Fresh Start. That&#039;s How The End Of The Year Goes Radio Exercises Are Socials For Boys And Girls
            [190] => When Looking For Something, Try Using Its Perspective
            [191] => Freedom Means To Live True To Yourself, Not Without Law!
            [192] => Kabukicho Stray Cat Blues
            [193] => Cooking Is About Guts
            [194] => Whenever I Hear Leviathan, I Think Of Sazae-san. Stupid Me!!
            [195] => Not Losing To The Rain
            [196] => Not Losing To The Wind
            [197] => Not Losing To The Storm
            [198] => Never Losing That Smile
            [199] => That&#039;s How I Wish To Be, Beautiful And Strong
            [200] => Santa Claus Red Is Blood Red
            [201] => Everybody&#039;s A Santa
        )

    [pv] => 
)
```

Also, it's possible to get the characters with corresponding Japanese VAs like so:
```php
$stmt = new MyAnimeListHandler(918);
$res = $stmt->getShowInfo();
$char = $stmt->getCharacters();
print_r($char);
```

Or provide with 'slug' directly:

```php
$stmt = new MyAnimeListHandler(918, 'Gintama');
$char = $stmt->getCharacters();
print_r($char);
```

The result:

```
Array
(
    [0] => Array
        (
            [character] => Array
                (
                    [id] => 674
                    [slug] => Kagura
                    [name] => Kagura
                    [role] => Main
                    [importance] => 0
                )

            [0] => Array
                (
                    [voice_actor] => Array
                        (
                            [id] => 8
                            [slug] => Rie_Kugimiya
                            [name] => Kugimiya, Rie
                        )

                )

        )

    [1] => Array
        (
            [character] => Array
                (
                    [id] => 672
                    [slug] => Gintoki_Sakata
                    [name] => Sakata, Gintoki
                    [role] => Main
                    [importance] => 1
                )

            [0] => Array
                (
                    [voice_actor] => Array
                        (
                            [id] => 2
                            [slug] => Tomokazu_Sugita
                            [name] => Sugita, Tomokazu
                        )

                )

        )

    [2] => Array
        (
            [character] => Array
                (
                    [id] => 673
                    [slug] => Shinpachi_Shimura
                    [name] => Shimura, Shinpachi
                    [role] => Main
                    [importance] => 2
                )

            [0] => Array
                (
                    [voice_actor] => Array
                        (
                            [id] => 278
                            [slug] => Daisuke_Sakaguchi
                            [name] => Sakaguchi, Daisuke
                        )

                )

        )
  )
```
