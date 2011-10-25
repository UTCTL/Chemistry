<?php
/**
 * The template for displaying all pages.
 *
 * This is the template that displays all pages by default.
 * Please note that this is the WordPress construct of pages
 * and that other 'pages' on your WordPress site will use a
 * different template.
 *
 * @package WordPress
 * @subpackage Twenty_Eleven
 * @since Twenty Eleven 1.0
 */
?>

 <?php
  $browser = strpos($_SERVER['HTTP_USER_AGENT'],"iPhone");
    if ($browser == true){
    $browser = 'iphone';
  }
?>

<?php
function ellipsis_middle($text, $max=100, $div='&hellip;')
{
    if (strlen($text) <= $max) return $text;
    $characters = floor($max / 2);
    return substr($text, 0, $characters) . ' ' . $div . ' ' . substr($text, -1 * $characters);
}
function ellipsis_end($text, $max=100, $div='&hellip;')
{
    if (strlen($text) <= $max) return $text;
    $out = substr($text,0,$max);
    if (strpos($text,' ') === FALSE) return $out.$div;
    return preg_replace('/\w+$/','',$out).$div;
}

get_header(); ?>

        <style>
            #access {
                margin-bottom:0;
            }
            #page {
                background-color: rgba(255, 255, 255, .7);
            }
            .single-module #main {
                padding:0;
            }
            .section #content {
                width: 35em;
                margin: 0 2.5em 4em;
                color: #FFFFFF;
                float:left;
                line-height: 1.2em;
                text-shadow: none;
            }
            
            
            .section .submodule .submodule-content {
                
            }
            .module .submodule .submodule-content:after {
                content: ".";
                display: block;
                height: 0;
                clear: both;
                visibility: hidden;
            }
            .module .submodule .submodule-post-content {
                margin-top:20px;
                padding-top:20px;
                border-top: 1px dashed rgba(242, 242, 242, 0.5);
            }
            .section .submodule:first-child {
                margin-top:0;
            }
            .section .submodule {
                margin-top:30px;
            }
                .section .submodule .subtitle {
                    font-size: 16px;
                    background: -moz-linear-gradient(left, rgba(121,72,42,1) 0%, rgba(255,255,255,0) 100%); /* FF3.6+ */
                    background: -webkit-gradient(linear, left top, right top, color-stop(0%,rgba(121,72,42,1)), color-stop(100%,rgba(255,255,255,0))); /* Chrome,Safari4+ */
                    background: -webkit-linear-gradient(left, rgba(121,72,42,1) 0%,rgba(255,255,255,0) 100%); /* Chrome10+,Safari5.1+ */
                    background: -o-linear-gradient(left, rgba(121,72,42,1) 0%,rgba(255,255,255,0) 100%); /* Opera11.10+ */
                    background: -ms-linear-gradient(left, rgba(121,72,42,1) 0%,rgba(255,255,255,0) 100%); /* IE10+ */
                    filter: progid:DXImageTransform.Microsoft.gradient( startColorstr='#79482a', endColorstr='#00ffffff',GradientType=1 ); /* IE6-9 */
                    background: linear-gradient(left, rgba(121,72,42,1) 0%,rgba(255,255,255,0) 100%); /* W3C */
                    border-width:1px 0;
                    border-style:solid;
                    border-color:#FFFFFF;
                    position:relative;
                    left:-2.5em;
                    padding-left:2.5em;
                    width: 37.5em;
                }
                .section .submodule hr {
                    margin-bottom: 1em;
                    margin-top: 0;
                    background-color:#2F2F2F;
                }
                .section .submodule .main_text p:first-child {
                    margin-top:0;
                }
                .section .submodule .main_text p {
                    margin-bottom:0;
                    margin-top:1.625em;
                }
                .section p span {
                    text-shadow:none;
                }
                .section .submodule .videos {
                    float:left;
                    border-top: 1px solid rgba(255, 255, 255, 0.05);
                    width:100%;
                    margin-top: 20px;
                    padding-top: 20px;
                }
                .section .submodule .video {
                    margin: 0.3em 0.28em;
                    position:relative;
                    display:block;
                    text-align:right;
                    width:180px;
                    float:left;
                }
                .section .submodule .video .thumb {
                    width:180px;
                    max-width:100%;
                }
                .section .submodule .video .close_button {
                    display:none;
                    position: absolute;
                    top: 0;
                    right: -16px;
                    background-color: rgba(47, 47, 47, .5);
                    width: 5px;
                    padding: 3px 7px 7px 4px;
                    line-height: 24px;
                    border-radius: 0 5px 5px 0;
                }
                .section .submodule .video .info_overlay {
                    position:absolute;
                    background-color:rgba(0,0,0,0.5);
                    top:30px;
                    left:0;
                    width:160px;
                    padding:10px;
                    color:#FFFFFF;
                    text-shadow:1px 1px 1px #000000;
                    text-align:left;
                }
                    .section .submodule .video .info_overlay .title {
                        font-weight:bold;
                    }
                    .section .submodule .video .info_overlay .play {
                        text-shadow:1px 1px 1px #333333;
                    }
                        .section .submodule .video .info_overlay .play a{
                            cursor:pointer;
                            font-size:0.8em;
                            color:#FFFFFF;
                        }
                        .section .submodule .video .info_overlay .play a:hover {
                            text-decoration:underline;
                        }
                    .section .quiz {
                        margin-bottom:20px;
                    }
                        .section .quiz .show_hide {
                            color:#D25D1D;
                            text-shadow:none;
                            font-size:0.85em;
                            margin-left:1em;
                            cursor:pointer;
                        }
                        .section .quiz .show_hide:hover {
                            text-decoration:underline;
                        }
                        .section .quiz ul {
                            list-style:lower-alpha;
                            list-style-position:inside;
                            margin:0;
                        }
                            .section .quiz ul li {
                                text-indent: 20px;
                            }
                        .section .quiz .question_A {
                            display:none;
                            color:#D25D1D;
                            text-shadow: none;
                            margin-top: 0.5em;
                        }
                    .section ul.external-resources, .section ul.attachments {    
                        list-style-position:inside;
                        margin:0 0 20px 0;
                    }    
                        .section ul.external-resources li, .section ul.attachments li {
                            text-indent: 20px;
                        }
            .section .entry-meta {
                margin-top: 3em !important;
            }
            .unit-title {
                display:none;
            }
        </style>
        <script>
            var module_page = true;
        </script>

		<div id="primary" class="section">
		    
			<?php get_template_part( 'module', 'nav' ); ?>
			
			<div id="content" role="main">

				<?php the_post(); ?>
				
				<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
					<header class="entry-header">
					    
					    <h1 class="unit-title"><?php echo get_post($post->post_parent)->post_title; ?></h1>
					    
						<h1 class="entry-title"><?php the_title(); ?></h1>
				
						<?php if ( 'post' == get_post_type() ) : ?>
						<div class="entry-meta">
							<?php twentyeleven_posted_on(); ?>
						</div><!-- .entry-meta -->
						<?php endif; ?>
					</header><!-- .entry-header -->
					
<!-- 					NOTE: The following 2 lines reference the browser variable (declared at the top of this page) to modify the page for the iPhone -->
					<?php if($browser == 'iphone'){ ?><div class="entry-content module" style="margin-left: -2em; width: 503px;"><?php } 
						else{ ?> <div class="entry-content module"><?php }?>
					
					    
					    <?php echo wpautop($post->post_content);
					    
                        if( function_exists( 'attachments_get_attachments' ) )
                        {
                            $attachments = attachments_get_attachments($post->ID);
                    		$selected_html_page_ids = get_post_meta($post->ID, 'html-pages');
                    		if (!empty($selected_html_page_ids[0])) {
                        		$html_pages = get_pages(array('post_type'=>'html-page','include'=>$selected_html_page_ids[0]));
                    		} else {
                    		    $html_pages = array();
                    		}
                            $total_attachments = count( $attachments ) + count( $html_pages );
                            if( $total_attachments ) : ?>
                                <ul class="attachments">
                                    Attachments
                                    <?php for( $i=0; $i<count( $attachments ); $i++ ) : 
                                        $caption = !empty($attachments[$i]['caption']) ? " - <caption>" . $attachments[$i]['caption'] . "</caption>" : "";
                                        ?>
                                        <li><a href="<?php echo $attachments[$i]['location']; ?>" TARGET="_blank"><?php echo $attachments[$i]['title']; ?></a><?php echo $caption; ?></li>
                                    <?php endfor; ?>    
                                    <?php
                            		foreach($html_pages as $aPage) { ?>
                            			<li><a target='_blank' href="<?php echo $aPage->guid; ?>"><?php echo $aPage->post_title ?></a></li>
                            		<?php } ?>
                                </ul>
                            <?php endif;
                        }

                    	$submodules = get_children( array('post_parent' => $post->ID, 'post_type' => 'submodule','orderby'=>'menu_order','order'=>'ASC') );
                    	
                    	foreach ($submodules as $submodule) : 
                    	    $videoURLs = array();
                    	    $videos = null;
                    	    ?>
                    	    
                    	    <div class="submodule" id="topic<?php echo $submodule->ID; ?>">
                    	        <h3 class="subtitle"><?php echo $submodule->post_title; ?></h3>
                    	        <hr />
                    	        <div class="submodule-content">
                        	        <div class="main_text">
                            	        <?php echo wpautop($submodule->post_content); ?>
                        	        </div>
                        	        
                    	            <?php
                    	            $videos = field_get_meta('url-link', false, $submodule->ID);
                    	            
                    	            if (!empty($videos) && !empty($videos[0])) {
                    	            ?>
                        	        <div class="videos">
                        	            <?php

                        	            foreach ($videos as $q) :
                            				$tubeID = getID($q);
											$tubeData = simplexml_load_file("http://gdata.youtube.com/feeds/api/videos/" . $tubeID);
											
											$tubeTitle = $tubeData->title;
											$tubeDescription = $tubeData->content;
											$tubeThumbNail = "http://i.ytimg.com/vi/". $tubeID ."/2.jpg";
											$correctUrl = "http://www.youtube.com/v/" . $tubeID;
                                	        ?>
                        	                <div class="video">
                        	                    <img class="thumb" src="<?php echo $tubeThumbNail; ?>" />
                        	                    <div class="info_overlay">
                        	                        <div class="title"><?php echo ellipsis_end($tubeTitle,20); ?></div>
                        	                        <div class="description"><?php echo ellipsis_end($tubeDescription,20); ?></div>
                        	                        <div class="play">&raquo; <a rel="shadowbox[gallery];width=640;height=360;player=swf" href="<?php echo $correctUrl . "?fs=1"; ?>">play</a></div>
                        	                    </div>
                        	                </div>
                        	            <?php endforeach;?>
                    	            </div>
                    	            <?php } ?>
                    	        </div>
                    	        
                	            
                	            <?php
                	            $question = end(field_get_meta('question', false, $submodule->ID));
                	            
                                $attachments = attachments_get_attachments($submodule->ID);
                        		$selected_html_page_ids = get_post_meta($submodule->ID, 'html-pages');
                        		if (!empty($selected_html_page_ids[0])) {
                            		$html_pages = get_pages(array('post_type'=>'html-page','include'=>$selected_html_page_ids[0]));
                        		} else {
                        		    $html_pages = array();
                        		}
                                $total_attachments = count( $attachments ) + count( $html_pages );
                        		
                	            $resources = field_get_meta('additional-resources', false, $submodule->ID);

                                    
                                if (!empty($question) || $total_attachments || (!empty($resources) && !empty($resources[0]))) { ?>
                    	            <div class="submodule-post-content">
                    	        <?php } ?>
                    	            
                    	            <?php if (!empty($question)) { ?>
                            	        <div class="quiz">
                            	            <div class="question">
                            	                <?php echo $question; ?> <span class="show_hide">(show/hide answer)</span>
                            	            </div>
                            	            <ul class="answer-choices">
                            	                <?php
                            	                $choices = array_reverse(field_get_meta('choices', false, $submodule->ID));
                            	                foreach ($choices as $choice) : ?>
                            	                    <li class="choice"><?php echo $choice; ?></li>
                            	                <?php endforeach; ?>
                            	            </ul>
                            	            <div class="question_A">
                            	                <?php echo end(field_get_meta('answer', false, $submodule->ID)); ?>
                            	            </div>
                            	        </div>
                        	        <?php }
                        	        
                                    
                                    if( $total_attachments ) : ?>
                                        <ul class="attachments">
                                            Attachments
                                            <?php for( $i=0; $i<count( $attachments ); $i++ ) :
                                                $caption = !empty($attachments[$i]['caption']) ? " - <caption>" . $attachments[$i]['caption'] . "</caption>" : "";
                                                ?>
                                                <li><a href="<?php echo $attachments[$i]['location']; ?>" TARGET="_blank"><?php echo $attachments[$i]['title']; ?></a><?php echo $caption; ?></li>
                                            <?php endfor; ?>
                                            <?php
                                    		foreach($html_pages as $aPage) { ?>
                                    			<li><a target='_blank' href="<?php echo $aPage->guid; ?>"><?php echo $aPage->post_title ?></a></li>
                                    		<?php } ?>
                                        </ul>
                                    <?php endif;
                                        
                        	        
                    	            if (!empty($resources) && !empty($resources[0])) { ?>
                            	        <ul class="external-resources">
                    	                External Resources
                        	            <?php foreach ($resources as $resource) :
                        	                preg_match_all('#\bhttps?://[^\s()<>]+(?:\([\w\d]+\)|([^[:punct:]\s]|/))#', $resource, $url);
                        	                $url = $url[0][0];
                        	                $desc = trim(substr(strstr($resource, $url), strlen($url)));
                        	                $short_url = ellipsis_middle($url,50);
                        	                ?>
                            	            <li><a href="<?php echo $url; ?>"><?php echo $short_url; ?></a> - <?php echo $desc; ?></li>
                        	            <?php endforeach; ?>
                            	        </ul>
                        	        <?php }
                        	        
                                if (!empty($question) || $total_attachments || (!empty($resources) && !empty($resources[0]))) { ?>
                    	            </div>
                    	        <?php } ?>
                    	    </div>
                    	
                    	<?php endforeach; ?>
					
					</div><!-- .entry-content -->
                </article>
			</div><!-- #content -->
		</div><!-- #primary -->

<?php get_footer(); ?>