<?php
/**
 * The Header for our theme.
 *
 * Displays all of the <head> section and everything up till <div id="main">
 *
 * @package WordPress
 * @subpackage Twenty_Eleven
 * @since Twenty Eleven 1.0
 */
?><!DOCTYPE html>
<!--[if IE 6]>
<html id="ie6" <?php language_attributes(); ?>>
<![endif]-->
<!--[if IE 7]>
<html id="ie7" <?php language_attributes(); ?>>
<![endif]-->
<!--[if IE 8]>
<html id="ie8" <?php language_attributes(); ?>>
<![endif]-->
<!--[if !(IE 6) | !(IE 7) | !(IE 8)  ]><!-->
<html <?php language_attributes(); ?>>
<!--<![endif]-->
<head>
<meta charset="<?php bloginfo( 'charset' ); ?>" />
<meta name="viewport" content="width=device-width" />
<title><?php
	/*
	 * Print the <title> tag based on what is being viewed.
	 */
	global $page, $paged;
    
	wp_title( '|', true, 'right' );

	// Add the blog name.
	bloginfo( 'name' );

	// Add the blog description for the home/front page.
	$site_description = get_bloginfo( 'description', 'display' );
	if ( $site_description && ( is_home() || is_front_page() ) )
		echo " | $site_description";

	// Add a page number if necessary:
	if ( $paged >= 2 || $page >= 2 )
		echo ' | ' . sprintf( __( 'Page %s', 'twentyeleven' ), max( $paged, $page ) );

	?></title>
<link rel="profile" href="http://gmpg.org/xfn/11" />
<link rel="stylesheet" type="text/css" media="screen,handheld" href="<?php bloginfo( 'stylesheet_url' ); ?>" />
<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>" />
<!--[if lt IE 9]>
<script src="<?php echo get_template_directory_uri(); ?>/js/html5.js" type="text/javascript"></script>
<![endif]-->
<?php
	/* We add some JavaScript to pages with the comment form
	 * to support sites with threaded comments (when in use).
	 */
	if ( is_singular() && get_option( 'thread_comments' ) )
		wp_enqueue_script( 'comment-reply' );

	/* Always have wp_head() just before the closing </head>
	 * tag of your theme, or you will break many plugins, which
	 * generally use this hook to add elements to <head> such
	 * as styles, scripts, and meta tags.
	 */
	wp_head();
?>
    <style>
        /* header style */
        body {
            font-family:'Helvetica Neue', 'HelveticaNeue-Light', 'Helvetica Neue Light', Arial, Helvetica, sans-serif;
            font-size:16px;
        }
        #page {
            width:60em;
        }
        #banner {
            height:0em;
            position:relative;
            padding: 3.593em 0 4.593em 0;
        }    
            #banner #header_icon {
                margin:0 auto;
                top:-2.5em;
                background:url(<?php echo get_template_directory_uri(); ?>/images/HeaderIcon.png);
                height:9.2em;
                width:7.945em;
                position: relative;
            }
            
            #banner #header_icon > a{
                margin:0 auto;
                top:0.20em;
                display: block;
                height:9.2em;
                width:7.945em;
                position: relative;
            }
                #banner #nav1, #banner #nav2 {
                    height:0.2em;
                    background-color: rgba(26,84,91,0.4);
                    -ms-filter: "progid:DXImageTransform.Microsoft.gradient(startColorstr=#661A545B,endColorstr=#661A545B)"; /* IE8 */
                    filter: progid:DXImageTransform.Microsoft.gradient(startColorstr=#661A545B,endColorstr=#661A545B);   /* IE6 & 7 */
                    border-width: 3px 0;
                    border-style: solid;
                    border-color: rgba(255,255,255,0.3);
                    -moz-box-shadow: 0 0 1.797em rgba(0,0,0,0.5);
                    -webkit-box-shadow: 0 0 1.797em rgba(0,0,0,0.5);
                    box-shadow: 0 0 1.797em rgba(0,0,0,0.5);
                    position: relative;
                    list-style: none;
                    padding: 2.0em 0 1.8em 0;               
                    position: absolute;
                    margin: 0;
                    width: 24.19em;
                }        
                    #banner #nav1 li, #banner #nav2 li {
                        display:block;
                        float:left;
                        margin-top: -1em;
                    }
                    #banner #nav2 li.search {
                        padding-left:0;
                        margin-left:2em;
                        margin-top: -0.7em;
                    }
                        #banner #nav1 li a, #banner #nav2 li a {
                            color:#FFFFFF;
                            font-stretch: condensed;
                            font-weight:bold;
                            line-height:1.554em;
                            font-size:1.3em;
                            display: block;
                            padding-left: 45px;
                        }
                #banner #nav1 {
                    left:0;
                    padding-left:2em;
                }
                    #banner #nav1 li {
                        margin-right:2em;
                    }
                #banner #nav2 {
                    right:0;
                    padding-right:2em;
                }
                    #banner #nav2 li {
                        margin-left:2em;
                    }
                #banner input#s {
                    background: url(<?php echo get_template_directory_uri(); ?>/images/search.png) no-repeat 133px center;
                    width: 135px;
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
        #cns_link, #cns_link:hover {
            background:url(<?php echo get_template_directory_uri(); ?>/images/utwordmark.gif) no-repeat 5px center;
            bottom: 0;
            width: 301px;
            display: block;
            color: #000;
            text-decoration: none;
            padding-left: 2.5em;
            padding-top: 1.20em;
            padding-bottom: 1em;
        }
        
        #top_branding {
        	background:#ffffff;
        	height: 34px;
        	position:relative;
        	border-bottom:1px solid rgba(74,74,74,0.5);
        }
    
    	#branding_frame {
        	height: 34px;
        	width: 950px;
        	margin: 0 auto;
        	padding: 0px;
        	background:url(<?php echo get_template_directory_uri(); ?>/images/utwordmark.gif) no-repeat 5px left;
    	}

               
        
    </style>
<script type="text/javascript"
   src="http://cdn.mathjax.org/mathjax/latest/MathJax.js?config=TeX-AMS-MML_HTMLorMML">
   
    var _gaq = _gaq || [];
  _gaq.push(['_setAccount', 'UA-25328401-1']);
  _gaq.push(['_trackPageview']);

  (function() {
    var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
    ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
    var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
  })();
</script>
</head>

<body <?php body_class(); ?>>
<div id="top_branding">
    <div id="branding_frame">
    	<a id = "cns_link" href="http://utexas.edu" target="blank">
	        <!-- College of Natural Sciences image -->
<!-- 	        <span>asdfasdf</span> -->
      </a>
    </div>
</div>
<div id="page" class="hfeed">
	<header id="banner" role="banner">
        <ul id="nav1">
            <li><a style="background: url(<?php echo get_template_directory_uri(); ?>/images/icons/Menu_Icons/HomeIcon.png) no-repeat;" href="<?php echo get_home_url(); ?>">Home</a></li>
            <li><a style="background: url(<?php echo get_template_directory_uri(); ?>/images/icons/Menu_Icons/VideoIcon.png) no-repeat;" href="<?php echo get_page_link(43); ?>">Video Gallery</a></li>
        </ul>
	    <ul id="nav2">
            <li><a href="<?php echo get_permalink_by_name('credits'); ?>">Credits</a></li>
            <li class="search"><?php get_search_form(); ?></li>
	    </ul>
	    
	   
        <div id="header_icon">
        	 <a href="<?php echo get_home_url(); ?>"></a>
        </div>
	    
    <!--
			<hgroup>
				<h1 id="site-title"><span><a href="<?php echo esc_url( home_url( '/' ) ); ?>" title="<?php echo esc_attr( get_bloginfo( 'name', 'display' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a></span></h1>
				<h2 id="site-description"><?php bloginfo( 'description' ); ?></h2>
			</hgroup>
	
			<?php
				// Has the text been hidden?
				if ( 'blank' == get_header_textcolor() ) :
			?>
				<div class="only-search<?php if ( ! empty( $header_image ) ) : ?> with-image<?php endif; ?>">
				<?php get_search_form(); ?>
				</div>
			<?php
				else :
			?>
				<?php get_search_form(); ?>
			<?php endif; ?>
	-->
			<nav id="access" role="navigation">
				<h3 class="assistive-text"><?php _e( 'Main menu', 'twentyeleven' ); ?></h3>
				<?php /*  Allow screen readers / text browsers to skip the navigation menu and get right to the good stuff. */ ?>
				<div class="skip-link"><a class="assistive-text" href="#content" title="<?php esc_attr_e( 'Skip to primary content', 'twentyeleven' ); ?>"><?php _e( 'Skip to primary content', 'twentyeleven' ); ?></a></div>
				<div class="skip-link"><a class="assistive-text" href="#secondary" title="<?php esc_attr_e( 'Skip to secondary content', 'twentyeleven' ); ?>"><?php _e( 'Skip to secondary content', 'twentyeleven' ); ?></a></div>
				<?php /* Our navigation menu.  If one isn't filled out, wp_nav_menu falls back to wp_page_menu. The menu assiged to the primary position is the one used. If none is assigned, the menu with the lowest ID is used. */ ?>
				<?php //wp_nav_menu( array( 'theme_location' => 'primary' ) ); ?>
			</nav><!-- #access -->
	</header><!-- #branding -->


	<div id="main">