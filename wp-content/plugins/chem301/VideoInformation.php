<?php
class VideoInformation {

	public static function getID($url) {
		if (preg_match('%(?:youtube\.com/(?:user/.+/|(?:v|e(?:mbed)?)/|.*[?&]v=)|youtu\.be/)([^"&?/ ]{11})%i', $q, $match)) {
		    $id = $match[1];
		    return $match[1];
		}
		return "None";
	}

	function getInformation($url) {
		$pattern = '/watch\?v\=(.+)/';
		$id = "";
    	if (preg_match($pattern, $url, $matches)) {
			$ = preg_replace("/watch\?v\=/", "v/", $q['url']);
			//echo "<p>" . $q['url'] . "</p>";
		}
		
		if(preg_match('/^[^v]+v.(.{11}).*/',$url,$matches) {
			echo "match 0" . $matches[0];
			echo "match 1" . $matches[1];
			echo "match 2" . $matches[2];
		}
		
		/*
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
    		*/
    		
    		
    		
    		/* //from single-unit
    		foreach ($videos as $url) {
                    		    $videoURLs[$url] = urlencode($url);
                    		}
                    		$videoURLs = implode(",", $videoURLs);
                    		$stringToSend = "http://api.embed.ly/1/oembed?key=92481528b30711e0adda4040d3dc5c07&urls=" . $videoURLs;
                    		echo $stringToSend;
                    		$videos = json_decode(file_get_contents($stringToSend), True);
            				$pattern = '/watch\?v\=/';
            	            foreach ($videos as $video) :
                				if (preg_match($pattern, $video['url'], $matches)) {
            						$video['url'] = preg_replace("/watch\?v\=/", "v/", $video['url']);
            					}
                    	        ?>
            	                <div class="video">
            	                    <img class="thumb" src="<?php echo $video['thumbnail_url']; ?>" />
            	                    <div class="info_overlay">
            	                        <div class="title"><?php echo ellipsis_end($video['title'],20); ?></div>
            	                        <div class="description"><?php echo ellipsis_end($video['description'],20); ?></div>
            	                        <div class="play">&raquo; <a rel="shadowbox[gallery];width=640;height=360;player=swf" href="<?php echo $video['url'] . "?fs=1"; ?>">play</a></div>
            	                    </div>
            	                </div>
            	            <?php endforeach;?>
    		*/
    		
    		
    		/* //from single-module
    		foreach ($videos as $url) {
                                		    $videoURLs[$url] = urlencode($url);
                                		}
                                		$videoURLs = implode(",", $videoURLs);
                                		$stringToSend = "http://api.embed.ly/1/oembed?key=92481528b30711e0adda4040d3dc5c07&urls=" . $videoURLs;
                                		$videos = json_decode(file_get_contents($stringToSend), True);
                        				$pattern = '/watch\?v\=/';
                        	            foreach ($videos as $video) :
                            				if (preg_match($pattern, $video['url'], $matches)) {
                        						$video['url'] = preg_replace("/watch\?v\=/", "v/", $video['url']);
                        					}
                                	        ?>
                        	                <div class="video">
                        	                    <img class="thumb" src="<?php echo $video['thumbnail_url']; ?>" />
                        	                    <div class="info_overlay">
                        	                        <div class="title"><?php echo ellipsis_end($video['title'],20); ?></div>
                        	                        <div class="description"><?php echo ellipsis_end($video['description'],20); ?></div>
                        	                        <div class="play">&raquo; <a rel="shadowbox[gallery];width=640;height=360;player=swf" href="<?php echo $video['url'] . "?fs=1"; ?>">play</a></div>
                        	                    </div>
                        	                </div>
                        	            <?php endforeach;?>

    		*/
	}
}