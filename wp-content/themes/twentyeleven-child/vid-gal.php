<?php
/*
Template Name: Video Gallery
*/
?>

<?php get_header(); ?>

<style>

#content {
    margin:2em auto !important;
    width:50em !important;
}

#page {
    padding-bottom:1em;
}

.caption h4, h3 {
	clear:none;
	color:#fff;
	font-weight: bold;
}
.caption h4 {
	font-size: 0.85em;
}

.caption h3 {
	font-size: 1.1em;

}

.vid_gal_description {
	color:#fff;
	font-size: 0.75em;
}

.title_description {
	padding: 10px 10px 10px 160px;
	text-shadow: 2px 2px 2px rgba(0, 0, 0, 0.7);
}

a.vid_gallery {
	display:block !important;
}

li.thumbnail_gallery {
	display: block;
    clear: both;
    height: 120px;
    border-width: 0 0 1px;
    border-style: solid;
    border-color: #98C6CD;
}

li.thumbnail_gallery img {
	height: 80px;
    float: left;
    margin: 15px 10px 15px 15px;
    border: 6px solid rgba(152, 198, 205, 0.5);
    border-radius: 7px;
}

#video_list {
    margin: 2em 0 5em 0;
    border-width:1px 1px 0;
    border-style:solid;
    border-color:#98C6CD;
}
    #video_list li {
        background-color:rgba(24,77,83,0.5);
        box-shadow: inset 0 0 100px rgba(0,0,0,0.75);
    }
    #video_list li:nth-child(even) {
        background-color:rgba(33,105,114,0.5);
        box-shadow: inset 0 0 100px rgba(40,40,40,0.9);
    }

/*li.thumbnail_gallery img:hover {
	width: 260px;
	float:left;
	margin: 0px 10px 10px 0px;
	border: 3px;
	border-color: #fff;
}*/

</style>

<?php
// The Query
query_posts( array( 'post_type' => 'submodule' ) );
?>

<div id="content" class="widecolumn">
    
    <div id="wrap">
	<ul id="video_list">
    <?php
     // The Loop
    $videosUsed = array();	//var_dump($lectureText);
	
    while ( have_posts() ) : the_post();
    	$listOfUrls = array();
    	$parent = $post -> post_parent;
    	$parentPost = get_post($parent);
    	$thisTitle = $parentPost -> post_title;
    	
    	$parentsUnit = $parentPost -> post_parent;
    	$parentUnitPost = get_post($parentsUnit);
    	$thisUnit = $parentUnitPost -> post_title;
    	//echo $thisTitle;
    	//echo $parent;
    	//$unit = end(get_the_terms( $post -> ID, 'unit'));
    	//var_dump($unit);
    	$title = the_title('', '', false);

    	$urlsArray = field_get_meta('url-link', false, $post->ID); // key, return 1 result, post ID
    	//OLD ONE $lectureText = field_get_meta('lecture-text', false, $post->ID);
		//preg_match_all($urlTest, $lectureText[0], $urlsArray);
		//echo '<br />###############<br />'; urlencode	
		/*
		http://api.embed.ly/1/oembed?
		key=:key&url=:url&maxwidth=:maxwidth&maxheight=:maxheight&format=:format&callback=:callback
		*/
		//var_dump($urlsArray);
		foreach ($urlsArray as $val) {
		    $listOfUrls[$val] = urlencode($val);
		}
		//var_dump($listOfUrls);
		
	     
		
		$embedlyUrls = implode(",", $listOfUrls);
		//echo $embedlyUrls;
		$stringToSend = "http://api.embed.ly/1/oembed?key=92481528b30711e0adda4040d3dc5c07&urls=" . $embedlyUrls;
		//echo $stringToSend;
		$embedlyContents = file_get_contents($stringToSend);
		$embedlyObjects = json_decode(file_get_contents($stringToSend), True);
		
		for($i = 0; $i < count($embedlyObjects); $i+=1){
			$obj = $embedlyObjects[$i];
			//var_dump($obj);
			$url = $obj['type'];
			if ($url!="video"){
				
				//$newObject = $obj['url'];
				//$urlLinksArray[] = $newObject;
				unset($embedlyObjects[$i]);
			}
		}
		
		foreach($embedlyObjects as $q)
    		{
    			if($q != '') {
    			//echo "<p>" . $q['url'] . "</p>";
    				$pattern = '/watch\?v\=/';
    				if (preg_match($pattern, $q['url'], $matches)) {
						$q['url'] = preg_replace("/watch\?v\=/", "v/", $q['url']);
						//echo "<p>" . $q['url'] . "</p>";
					}
    					?>
        					<li class="thumbnail_gallery">
	        					<a rel="shadowbox[gallery];width=640;height=360;player=swf;" class="vid_gallery" href="<?php echo $q['url'] . "?fs=1"; ?>"><img src="<?php echo $q['thumbnail_url'] ?>" /></a>
	        					<div class ="title_description">
		        					<div class="caption">
		        						<h4><?php echo $thisUnit; echo " > ". $thisTitle; ?></h4>
		        						<h3><?php echo $q['title']; ?></h3>
		        					</div>
		        					<div class="vid_gal_description">
		        						<?php echo $q['description']; ?>
		        					</div>
	        					</div>
        					</li>
    					<?php
    				}
    		}
    endwhile;
		    	    
    wp_reset_query();
    ?>
    </ul>
    </div>
    
</div>

<?php get_footer(); ?>