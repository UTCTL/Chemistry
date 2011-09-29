<?php
/*
Plugin Name: Page Restrict
Plugin URI: http://theandystratton.com/pagerestrict
Description: Restrict certain pages to logged in users
Author: Matt Martz & Andy Stratton
Author URI: http://theandystratton.com
Version: 2.03

	Copyright (c) 2008 Matt Martz (http://sivel.net)
        Page Restrict is released under the GNU Lesser General Public License (LGPL)
	http://www.gnu.org/licenses/lgpl-3.0.txt
*/

// ff we are in the admin load the admin functionality
if ( is_admin () )
	require_once( dirname ( __FILE__ ) . '/inc/admin.php' );

// get specific option
function pr_get_opt ( $option ) {
	$pr_options = get_option ( 'pr_options' );
	// clean up PHP warning for in_array() later when they have not been saved
	if ( $option == 'posts' || $option == 'pages' ) {
		if ( !is_array($pr_options[$option]) ) {
			$pr_options[$option] = array();
		}
	}
    return $pr_options[$option];
}

// Add headers to keep browser from caching the pages when user not logged in
// Resolves a problem where users see the login form after logging in and need 
// to refresh to see content
function pr_no_cache_headers () {
	global $user_ID;
	get_currentuserinfo ();
        if ( ! $user_ID ) {
		nocache_headers ();
	}
}

// gets standard page content when page/post is restricted.
function pr_get_page_content() {
	$pr_page_content = '
		<p>' . pr_get_opt ( 'message' )  . '</p>';
	if ( pr_get_opt ( 'loginform' ) == true ) :
		if ( ! isset ( $user_login ) )
			$user_login = '';
		$pr_page_content .= '
		<form style="text-align: left;" action="' . get_bloginfo ( 'wpurl' ) . '/wp-login.php" method="post">
			<p>
				<label for="log"><input type="text" name="log" id="log" value="' . wp_specialchars ( stripslashes ( $user_login ) , 1 ) . '" size="22" /> Username</label><br />
				<label for="pwd"><input type="password" name="pwd" id="pwd" size="22" /> Password</label><br />
				<input type="submit" name="submit" value="Log In" class="button" />
				<label for="rememberme"><input name="rememberme" id="rememberme" type="checkbox" checked="checked" value="forever" /> Remember me</label><br />
			</p>
			<input type="hidden" name="redirect_to" value="' . $_SERVER['REQUEST_URI'] . '" />
		</form>
		<p>
		';
		
		if ( get_option('users_can_register') )
			$pr_page_content .= '	<a href="' . get_bloginfo ( 'wpurl' ) . '/wp-register.php">Register</a> | ';

		$pr_page_content .= '<a href="' . get_bloginfo ( 'wpurl' ) . '/wp-login.php?action=lostpassword">Lost your password?</a>
		</p>
		';
		$post->comment_status = 'closed';
	endif;
	return $pr_page_content;
}

// Perform the restriction and if restricted replace the page content with a login form
function pr_page_restrict ( $pr_page_content ) {
	global $user_ID, $post;
	get_currentuserinfo ();
	$pr_check = pr_get_opt('method') == 'all';
	$pr_check = $pr_check || (
		( is_array(pr_get_opt('pages')) || is_array(pr_get_opt('posts')) ) 
		&& ( count(pr_get_opt('pages')) + count(pr_get_opt('posts')) > 0 )
	);
	if ( ! $user_ID  && $pr_check ) :
		// current post is in either page / post restriction array
		$is_restricted = ( in_array($post->ID, pr_get_opt('pages')) || in_array($post->ID, pr_get_opt('posts')) ) && pr_get_opt ( 'method' ) != 'none';
		// content is restricted OR everything is restricted
		if ( $is_restricted  || pr_get_opt('method') == 'all' ):
			$pr_page_content = pr_get_page_content();
		elseif ( ( in_array($post->ID, pr_get_opt('pages')) || in_array($post->ID, pr_get_opt('posts')) ) && ( is_archive () || is_search () ) ) :
            $pr_page_content = '<p>' . pr_get_opt ( 'message' )  . '</p>';
            $pr_page_content = str_replace('login', '<a href="' . get_bloginfo ( 'wpurl' ) . '/wp-login.php?redirect_to=' . urlencode($_SERVER['REQUEST_URI'])  . '">login</a>', $pr_page_content);
		endif;
	endif;
	return $pr_page_content;
}

function pr_comment_restrict ( $pr_comment_array ) {
	global $user_ID, $post;
	get_currentuserinfo ();
    if ( ! $user_ID  && is_array ( pr_get_opt ( 'pages' ) ) ) :
		$is_restricted = ( in_array($post->ID, pr_get_opt('pages')) || in_array($post->ID, pr_get_opt('posts')) ) && pr_get_opt ( 'method' ) != 'none';
       	if ( $is_restricted || pr_get_opt('method') == 'all' ):
			$pr_comment_array = array();
		endif;
	endif;
	return $pr_comment_array;
}

// Add Actions
add_action( 'send_headers' , 'pr_no_cache_headers' );

// Add Filters
add_filter ( 'the_content' , 'pr_page_restrict' , 50 );
add_filter ( 'the_excerpt' , 'pr_page_restrict' , 50 );
add_filter ( 'comments_array' , 'pr_comment_restrict' , 50 );
?>
