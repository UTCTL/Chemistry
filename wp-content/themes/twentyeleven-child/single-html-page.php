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
                text-shadow: none;
            }
            
            .section .entry-meta {
                margin-top: 3em !important;
            }
        </style>
        <script>
            var module_page = true;
        </script>

		<div id="primary" class="section">
			
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
				
					<div class="entry-content">
					    
					    <?php echo wpautop($post->post_content); ?>
					
					</div><!-- .entry-content -->

                </article>
			</div><!-- #content -->
		</div><!-- #primary -->

<?php get_footer(); ?>