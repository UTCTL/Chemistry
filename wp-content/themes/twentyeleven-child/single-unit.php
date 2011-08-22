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
            .single-unit #main {
                padding:0;
            }

            .section .entry-content p:first-child {
                margin-top:0;
            }
            .section .entry-content p {
                margin-bottom:0;
                margin-top:1.625em;
            }
            .section #content {
                width: 35em;
                margin: 0 2.5em 4em;
                color: #FFFFFF;
                float:left;
                line-height: 1.2em;
                text-shadow: 0px 0px 1px white;
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
            .post-content {
                margin-top:20px;
                padding-top:20px;
                border-top: 1px dashed rgba(242, 242, 242, 0.5);
            }
            .section .videos {
                border-top: 1px solid rgba(255, 255, 255, 0.05);
                width:100%;
                margin-top: 20px;
                padding-top: 20px;
            }
            .section .videos:after {
                content: ".";
                display: block;
                height: 0;
                clear: both;
                visibility: hidden;
            }
            .section .video {
                margin: 0.3em 0.28em;
                position:relative;
                display:block;
                text-align:right;
                width:180px;
                float:left;
            }
            .section .video .thumb {
                width:180px;
                max-width:100%;
            }
            .section .video .close_button {
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
            .section .video .info_overlay {
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
                .section .video .info_overlay .title {
                    font-weight:bold;
                }
                .section .video .info_overlay .play {
                    text-shadow:1px 1px 1px #333333;
                }
                    .section .video .info_overlay .play a{
                        cursor:pointer;
                        font-size:0.8em;
                        color:#FFFFFF;
                    }
                    .section .video .info_overlay .play a:hover {
                        text-decoration:underline;
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
						
						<h1 class="entry-title"><?php the_title(); ?></h1>
				
						<?php if ( 'post' == get_post_type() ) : ?>
						<div class="entry-meta">
							<?php twentyeleven_posted_on(); ?>
						</div><!-- .entry-meta -->
						<?php endif; ?>
					</header><!-- .entry-header -->
				
					<div class="entry-content unit">
					    
            	        <?php echo wpautop($post->post_content);
            	        
        	            $videos = field_get_meta('url-link', false, $submodule->ID);
        	            
        	            if (!empty($videos) && !empty($videos[0])) {
        	            ?>
            	        <div class="videos">
            	            <?php
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
        	            </div>    
            	        <div class="post-content">
        	            <?php }

                        if( function_exists( 'attachments_get_attachments' ) )
                        {
                            $attachments = attachments_get_attachments($post->ID);
                            $total_attachments = count( $attachments );
                            if( $total_attachments ) : ?>
                                <ul class="attachments">
                                    Attachments
                                    <?php for( $i=0; $i<$total_attachments; $i++ ) : ?>
                                        <li><a href="<?php echo $attachments[$i]['location']; ?>" TARGET="_blank"><?php echo $attachments[$i]['title']; ?></a> - <caption><?php echo $attachments[$i]['caption']; ?></caption></li>
                                    <?php endfor; ?>
                                </ul>
                            <?php endif;
                        }
            	        
        	            $resources = field_get_meta('additional-resources', false, $submodule->ID);
        	            if (count($resources) > 0) { ?>
                	        <ul class="external-resources">
                	        	<?php
                	        	if($resources[0] != '')
									{
										echo "External Resources:";
									}
									
									
								foreach ($resources as $resource) :
                	                preg_match_all('#\bhttps?://[^\s()<>]+(?:\([\w\d]+\)|([^[:punct:]\s]|/))#', $resource, $url);
                	                $url = $url[0][0];
                	                $desc = trim(substr(strstr($resource, $url), strlen($url)));
                	                $short_url = ellipsis_middle($url,50);
                	                if($resource != "") 
									{
										?>
										 <li><a href="<?php echo $url; ?>"><?php echo $short_url; ?></a> - <?php echo $desc; ?></li>
										 <?php
									}
									
									endforeach; ?>
                	        </ul>
            	        <?php } ?>
            	        </div>
						
					</div><!-- .entry-content -->

			</div><!-- #content -->
		</div><!-- #primary -->

<?php get_footer(); ?>