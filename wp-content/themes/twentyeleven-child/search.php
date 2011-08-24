<?php
/**
 * The template for displaying Search Results pages.
 *
 * @package WordPress
 * @subpackage Twenty_Eleven
 * @since Twenty Eleven 1.0
 */

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
                 width: 51em;
                 margin: 0 2.5em 4em;
                 color: #FFFFFF;
                 float:left;
                 line-height: 1.2em;
                 text-shadow: 0px 0px 1px white;
             }
             .section .entry-meta {
                 margin-top: 3em !important;
             }
             
             .section input#s {
                 background: url(<?php echo get_template_directory_uri(); ?>/images/search.png) no-repeat 298px center;
                 width: 300px;
                 padding-left:9px;
                 border-radius: 5px;
                 border-width:2px;
                 border-color:rgba(255, 255, 255, 0.3);
                 height: 1.75em;
                 background-color:rgba(103, 165, 172, 0.3);
                 font-size:0.8em;
                 position:relative;
                 top:-0.6em;
                 color:#FFFFFF;
             }
             
             .page-header .page-title {
                 margin:2.6em 0;
                 font-size:1em;
                 color:#FFFFFF;
             }
             
         </style>

		<section id="primary" class="section search">
			<div id="content" role="main">

			<?php if ( have_posts() ) : ?>

				<header class="page-header">
					<h1 class="page-title"><?php printf( __( 'Search Results for "%s" found in:', 'twentyeleven' ), '<span>' . get_search_query() . '</span>' ); ?></h1>
				</header>

                <?php
                
                $result_ids = array();
                
                $wp_query->query_vars["posts_per_page"] = 300;
                
                $results = $wp_query->get_posts();
                foreach ($results as $result) {
				    $post_type = $result->post_type;
                    if ($post_type == 'submodule') {
                        if (!in_array($result->post_parent,$modules)) {
                            $result_ids[] = $result->post_parent;
                        }
                    } else if ($post_type == 'module') {
                        if (!in_array($result->ID,$modules)) {
                            $result_ids[] = $result->ID;
                        }
                    } else if ($post_type == 'unit') {
                        if (!in_array($result->ID,$modules)) {
                            $result_ids[] = $result->ID;
                        }
                    }
                }
                
                if (!empty($result_ids)) {
                    $include = implode(',',$result_ids);
                    $results = get_posts(array('post_type' => array('unit','submodule','module'), 'posts_per_page' => '300','include'=>$include));
                    
                    foreach ($results as $result) {
                        echo '<article class="result">';
                        echo    '<header class="entry-header">';
                        echo        '<h1 class="entry-title"><a href="'.$result->guid.'">'.$result->post_title.'</a></h1>';
                        echo    '</header>';
                        echo '</article>';
                    }
                }
                
            ?>

			<?php else : ?>

				<article id="post-0" class="post no-results not-found">
					<header class="entry-header">
						<h1 class="entry-title"><?php _e( 'Nothing Found', 'twentyeleven' ); ?></h1>
					</header><!-- .entry-header -->

					<div class="entry-content">
						<p><?php _e( 'Sorry, but nothing matched your search criteria. Please try again with some different keywords.', 'twentyeleven' ); ?></p>
						<?php get_search_form(); ?>
					</div><!-- .entry-content -->
				</article><!-- #post-0 -->

			<?php endif; ?>

			</div><!-- #content -->
		</section><!-- #primary -->

<?php get_footer(); ?>