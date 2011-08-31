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
    min-height: 120px;
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


</style>

<?php
// The Query
$units = get_posts(array('post_type'=>'unit','numberposts'=>-1,'orderby'=>'menu_order','order'=>'ASC'));
?>

<div id="content" class="widecolumn">
    
    
    <div id="wrap">
	<ul id="video_list">
    <?php
        
    $videos = array();
	
    for ($i = 0; $i < count($units); $i += 1) {
        
        $unit = $units[$i];
        $enable = intval(end(get_post_meta($unit->ID, 'enable_module')));
        if ($enable) {
            $unitTitle = $unit->post_title;

        	$video_urls = field_get_meta('url-link', false, $unit->ID); // key, return 1 result, post ID
    	
        	for ($j = 0; $j < count($video_urls); $j += 1) {
    	    
        	    $url = $video_urls[$j];

    			if(!empty($url)) {
    				$tubeID = getID($url);
    				if (!array_key_exists($tubeID, $videos)) {
        				$videos[$tubeID] = simplexml_load_file("http://gdata.youtube.com/feeds/api/videos/" . $tubeID);
        				$videos[$tubeID]->header = $unitTitle;
        				$videos[$tubeID]->tubeID = $tubeID;
        			}
        		}
        	}
    	}
    	
    	
        $modules = get_posts(array('post_type'=>'module','numberposts'=>-1,'orderby'=>'menu_order','order'=>'ASC','post_parent'=>$unit->ID));
        
        for ($j = 0; $j < count($modules); $j += 1) {
            
            $module = $modules[$j];
            $enable = intval(end(get_post_meta($module->ID, 'enable_module')));
            if ($enable) {
                
                $moduleTitle = $module->post_title;
                $submodules = get_posts(array('post_type'=>'submodule','numberposts'=>-1,'orderby'=>'menu_order','order'=>'ASC','post_parent'=>$module->ID));
            
                for ($k = 0; $k < count($submodules); $k += 1) {
                
                    $submodule = $submodules[$k];
                    $submoduleTitle = $submodule->post_title;
                	$video_urls = field_get_meta('url-link', false, $submodule->ID); // key, return 1 result, post ID

                	for ($l = 0; $l < count($video_urls); $l += 1) {

                	    $url = $video_urls[$l];

            			if(!empty($url)) {
            				$tubeID = getID($url);
            				if (!array_key_exists($tubeID, $videos)) {
                				$videos[$tubeID] = simplexml_load_file("http://gdata.youtube.com/feeds/api/videos/" . $tubeID);
                				$videos[$tubeID]->header = $unitTitle . ' > ' . $moduleTitle . ' > ' . $submoduleTitle ;
                				$videos[$tubeID]->tubeID = $tubeID;
                			}
                		}
                	}
                
                }
            
            }
            
        }
    	
    }
    	
	$videos = array_values($videos);
	
	for ($j = 0; $j < count($videos); $j += 1) {
	    
	    $tubeData = $videos[$j];
		$tubeTitle = $tubeData->title;
		$thisTitle = $tubeData->header;
		$tubeDescription = $tubeData->content;
		$tubeID = $tubeData->tubeID;
		$tubeThumbNail = "http://i.ytimg.com/vi/". $tubeID ."/2.jpg";
		$correctUrl = "http://www.youtube.com/v/" . $tubeID;
	    ?>
	    
		<li class="thumbnail_gallery">
			<a rel="shadowbox[gallery];width=640;height=360;player=swf;" class="vid_gallery" href="<?php echo $correctUrl . "?fs=1"; ?>"><img src="<?php echo $tubeThumbNail ?>" /></a>
			<div class ="title_description">
				<div class="caption">
					<h4><?php echo $thisTitle; ?></h4>
					<h3><?php echo $tubeTitle; ?></h3>
				</div>
				<div class="vid_gal_description">
					<?php echo $tubeDescription; ?>
				</div>
			</div>
		</li>
	    
	    <?php
	}

    ?>
    </ul>
    </div>
    
</div>

<?php get_footer(); ?>