<?php
/*
	This file loads the core of the plugin and outputs the stuff which your site visitors see

	PixoPoint Menu Plugin
	Copyright (c) 2009 PixoPoint Web Development

	This program is free software; you can redistribute it and/or modify
	it under the terms of the GNU General Public License as
	published by the Free Software Foundation.

	This program is distributed in the hope that it will be useful,
	but WITHOUT ANY WARRANTY; without even the implied warranty of
	MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.
*/




/************************************************************
 *************** Sets up enqueue scripts ********************
 ************ enqueue prevents clashes between **************
 ************ plugins which use the same script *************
 *************************************************************/
wp_register_script('hoverIntent', $javascript_location.'hoverIntent.js.php', array('jquery'), 'r5', true); // Loads the hover intent plugin which is used to control the sensitivity of dropdowns when used with the Superfish plugin
wp_register_script('superfish', $javascript_location.'superfish.js', array('hoverIntent'), '1.4.8', true); // Loads the Superfish plugin which adds support for animated menus etc.
wp_register_script('superfish_init', $javascript_location.'superfish_settings.js.php', array('superfish'), '1.0', true); // Loads the settings for the Superfish plugin
// Removed as contained bug      wp_register_script('sfkeyboard', $javascript_location.'suckerfish_keyboard.js', array('hoverIntent'), '1.0', true); // Adds keyboard support for dropdown menus




/************************************************************
 ************************************************************
 ************ Add support for various themes ****************
 ************************************************************
 ************************************************************/
if (get_option('suckerfish_themesupport') == 'on') { // Checks if users want theme support (some will prefer to do it themselves or want to do it differently)
	// Function for adding to theme hooks
	function pixopoint_themesupport() {
		pixopoint_menu(); // Adds main menu
		if (get_option('suckerfish_secondmenu') == 'on') {pixopoint_menu(2);}  // Adds second menu
	}

	// Hybrid by Justin Tadlock ... http://themehybrid.com/themes/hybrid
	add_action('init','remove_header_hybrid'); // Plugin is loaded before the theme, so its remove_action() won't work unless fired later ... hat tip to Justin Tadlock (http://justintadlock.com/)
	function remove_header_hybrid() {remove_action( 'hybrid_after_header', 'hybrid_page_nav' );}
	add_action( 'hybrid_after_header', 'pixopoint_themesupport' ); // Add new function(s)
	// Thesis (yes it sucks, but we support it anyway)
	add_action('init','remove_header_thesis'); // Plugin is loaded before the theme, so its remove_action() won't work unless fired later ... hat tip to Justin Tadlock (http://justintadlock.com/)
	function remove_header_thesis() {remove_action( 'thesis_hook_before_header', 'thesis_nav_menu' );}
	add_action('thesis_hook_after_header', 'pixopoint_themesupport');

	// Adds function to wp_page_menu() hook
	add_action('wp_page_menu','pixopoint_themesupport'); // Add new function(s)
}


/************************************************************
 ************************************************************
 ************* Add content to HEAD section ******************
 ************************************************************
 ************************************************************/
add_action('wp_print_scripts', 'suckerfish_mainhead');
function suckerfish_mainhead() {global $pixopoint_menu_version;
	// Only load this if not on an admin page
	if (!is_admin()) {echo '
<!-- PixoPoint Menu Plugin v'.$pixopoint_menu_version.' by PixoPoint Web Development ... http://pixopoint.com/pixopoint-menu/ -->
';
		// Maintenance mode
		if ($_SESSION['mln'] == 'on') {echo '<!-- MAINTENANCE MODE IS ACTIVATED! -->
';}
		// If we're not using the theme generated CSS, we've disabled CSS or the test CSS is enabled the style.php file is loaded
		elseif (get_option('suckerfish_generator') != 'Theme CSS' AND get_option('suckerfish_displaycss') != 'Disable' AND $_SESSION['mln_testcss'] != 'on') {
			if (get_option('enableeditingpane') != 'on' OR !current_user_can('manage_options')) { // Don't load if editing pane is on
				echo '<link rel="stylesheet" type="text/css" href="'.WP_PLUGIN_URL.'/pixopoint-menu/css/style.php" />'; // There is a way to enqueue CSS now which should be used here - will be added in future release
			}
		}
		// If test CSS is activated then loads that (useful for debugging purposes)
		elseif ($_SESSION['mln_testcss'] == 'on') {echo '<!-- Test CSS for PixoPoint Menu Plugin v'.$pixopoint_menu_version.' maintenance mode --><link rel="stylesheet" type="text/css" href="'.WP_PLUGIN_URL.'/pixopoint-menu/css/test.css" />';}


		// ******** SCRIPTS TO BE ADDED TO HEAD *******
/*		// Adds script for keyboard accessibility    Removed as it contained a bug
		if (get_option('suckerfish_keyboard') == 'on') {
			wp_enqueue_script('sfkeyboard', 'pixopoint-menu/scripts/suckerfish_keyboard.js', array('dependency'), '1', true ); // TRUE makes it load in footer
			wp_enqueue_script( 'superfish_init', 'pixopoint-menu/scripts/superfish_settings.js.php', array('dependency'), '1', true ); // TRUE makes it load in footer
		}*/
		// Checks if Superfish mode is needed, if not then goes back to suckerfish approach
		if (get_option('suckerfish_delay') != '0' || get_option('suckerfish_superfish_arrows') == 'on' || get_option('suckerfish_superfish_speed') != 'instant') {
				wp_enqueue_script( 'superfish_init', 'pixopoint-menu/scripts/superfish_settings.js.php', array('dependency'), '1', true ); // TRUE makes it load in footer
		}
		// Any ideas how to enqueue a script in IE conditional comments?
		else {echo '
<!--[if lte IE 7]><script type="text/javascript" src="'.WP_PLUGIN_URL.'/pixopoint-menu/scripts/suckerfish_ie.js"></script><![endif]-->
';
		}
	}
}





/************************************************************
 ************************************************************
 ****** Functions for displaying various menu contents ******
 ************************************************************
*************************************************************/

// Displays the 'Pages' option
function pages($meta_key='') { // $meta_key has something to do with Gregs custom fields mod
	($meta_key==''?$suckerfish_pages_title= get_option('suckerfish_pagestitle'):$suckerfish_pages_title=$meta_key);
	$suckerfish_depthpages = get_option('suckerfish_depthpages');
	switch ($suckerfish_depthpages){ // Sets nesting of pages
		case "Top level only":$suckerfish_depthpagesecho = '&depth=1';break;
		case "No nesting":$suckerfish_depthpagesecho = '&depth=-1';break;
		case "1 level of children":$suckerfish_depthpagesecho = '&depth=2';break;
		case "2 levels of children":$suckerfish_depthpagesecho = '&depth=3';break;
		case "Infinite":$suckerfish_depthpagesecho = '&depth=0';break;
		case "":$suckerfish_depthpagesecho = '&depth=0';break;
	}
	if (is_page()&&get_post_custom_values($meta_key)!='') {$class=' class="pages current_page_parent current_page_item"';}
	else {$class=' class="pages haschildren"';}
	// For putting the pages into a sinle dropdown
	if (get_option('suckerfish_pages_singledropdown') == 'on') {
		echo '<li'.$class.'><a href="'; if (get_option('suckerfish_pagesurl') != '') {echo  get_option('suckerfish_pagesurl');} echo '">' . $suckerfish_pages_title . '</a><ul>';
	}
	// Sets page order
	$suckerfish_pageorder=get_option('suckerfish_pageorder');
	switch ($suckerfish_pageorder){
		case "Normal":$suckerfish_pageorderecho = 'sort_column=menu_order&';break;
		case "Ascending Name":$suckerfish_pageorderecho = 'sort_column=post_title&sort_order=asc&';break;
		case "Descending Name":$suckerfish_pageorderecho = 'sort_column=post_title&sort_order=desc&';break;
		case "":$suckerfish_pageorderecho = 'sort_column=menu_order&';break;
	}
	// Displays the actual pages
	echo ereg_replace( 
		"\"><a [/\?a-zA-Z0-9\-\.\:\"\=\_ >]+</a>([\t\n]+)<ul"," haschildren\\0",
		wp_list_pages(
			'title_li=&' . $suckerfish_pageorderecho . get_option('suckerfish_includeexcludepages').'='. get_option('suckerfish_excludepages').'&echo=0'.$suckerfish_depthpagesecho.'&meta_key='.$meta_key)) , "";
	// For putting the pages into a sinle dropdown
	if (get_option('suckerfish_pages_singledropdown') == 'on') {
		echo '</ul></li>';
	}
}
// Displays the 'Categories' option
function category() {
	if (get_option('suckerfish_categorycount') == 'on') {$suckerfish_categorycount = 'show_count=1';} // Adds category count
	if (get_option('suckerfish_categoryshowempty') == 'on') {$suckerfish_categoryshowempty = '&hide_empty=0';} // Hides empty categories
	// Sets category nesting
	$suckerfish_depthcategories = get_option('suckerfish_depthcategories');
	switch ($suckerfish_depthcategories){
		case "Top level only":$suckerfish_depthcategoriesecho = '&depth=1';break;
		case "No nesting":$suckerfish_depthcategoriesecho = '&depth=-1';break;
		case "1 level of children":$suckerfish_depthcategoriesecho = '&depth=2';
		break;case "2 levels of children":$suckerfish_depthcategoriesecho = '&depth=3';break;
		case "Infinite":$suckerfish_depthcategoriesecho = '&depth=0';break;
		case "":$suckerfish_depthcategoriesecho = '&depth=0';break;
	}
	// Sets category order
	$suckerfish_categoryorder= get_option('suckerfish_categoryorder');
	switch ($suckerfish_categoryorder){
		case "My Category Order plugin":$suckerfish_categoryorderecho = '&orderby=order';break;
		case "Ascending ID #":$suckerfish_categoryorderecho = '&orderby=id&order=ASC';break;
		case "Descending ID #":$suckerfish_categoryorderecho = '&orderby=id&order=DESC';break;
		case "Ascending Name":$suckerfish_categoryorderecho = '&orderby=name&order=ASC';break;
		case "Descending Name":$suckerfish_categoryorderecho = '&orderby=name&order=DESC';break;
		case "":$suckerfish_categoryorderecho = '&orderby=name&order=DESC';break;
	}
	// If single dropdown is set, then adds the extra HTML
	if (get_option('suckerfish_categories_singledropdown') == 'on') {
		// If on a category page, then sets the 'current_page_item' class
		if (is_category()) {$suckerfish_class=' class="categories current_page_parent current_page_item haschildren"';}
		else {$suckerfish_class=' class="categories haschildren"';}
		echo '<li'.$suckerfish_class.'><a href="';
		// If URL for category is set, then adds it, otherwise is left as a dead link
		if (get_option('suckerfish_categoriesurl') != '') {echo  get_option('suckerfish_categoriesurl');}
		// Adds the 'Categories' title
		echo '">' . get_option('suckerfish_categoriestitle') . '</a><ul>';
	}
	// Displays the actual categories
	echo implode("</a><ul",explode("</a><ul",str_replace("\t",'',wp_list_categories('title_li='.$suckerfish_categoryshowempty.'&'.$suckerfish_categorycount.'&'.get_option('suckerfish_includeexcludecategories').'='.  get_option('suckerfish_excludecategories').'&echo=0'.$suckerfish_categoryorderecho.$suckerfish_depthcategoriesecho))));
	// If single dropdown is set, then adds the extra HTML
	if (get_option('suckerfish_categories_singledropdown') == 'on') {echo '</ul></li>';}
}

// Displays the 'Categories' option when the 'Nest posts' option is used ... note: code written by itsanderson
function categories_and_posts($parent = 0, $depth = 0) {
	if ( get_option('suckerfish_categoryshowempty') == 'on' ) {
		$suckerfish_categoryshowempty = '&hide_empty=0';
	}
	$suckerfish_depthcategories = get_option('suckerfish_depthcategories');
	switch($suckerfish_depthcategories){
		case "Top level only":$suckerfish_depthcategoriesecho=1;break;
		case "No nesting":$suckerfish_depthcategoriesecho=-1;break;
		case "1 level of children":$suckerfish_depthcategoriesecho=2;break;
		case "2 levels of children":$suckerfish_depthcategoriesecho=3;break;
		case "Infinite":$suckerfish_depthcategoriesecho=0;break;
		case "":$suckerfish_depthcategoriesecho=0;break;
	}
	$suckerfish_categoryorder= get_option('suckerfish_categoryorder');
	switch($suckerfish_categoryorder) {
		case "My Category Order plugin":$suckerfish_categoryorderecho='&orderby=order';break;
		case "Ascending ID #":$suckerfish_categoryorderecho='&orderby=id&order=ASC';break;
		case "Descending ID #":$suckerfish_categoryorderecho='&orderby=id&order=DESC';break;
		case "Ascending Name":$suckerfish_categoryorderecho='&orderby=name&order=ASC';break;
		case "Descending Name":$suckerfish_categoryorderecho='&orderby=name&order=DESC';break;
		case "":$suckerfish_categoryorderecho='&orderby=name&order=DESC';break;
	}
	$categories = get_categories("child_of=$parent".$suckerfish_categoryshowempty.'&'. get_option('suckerfish_includeexcludecategories').'='. get_option('suckerfish_excludecategories').$suckerfish_categoryorderecho);

	$posts = ($parent ? get_posts("category=$parent&numberposts=-1") : array());
	if($parent==0){
		if(is_category()){$suckerfish_class=' class="current_page_parent current_page_item"';}
		//echo '<li'.$suckerfish_class.'><a href="' . get_option('suckerfish_categoriesurl') . '">' . get_option('suckerfish_categoriestitle') . '</a>'; // Used for single dropdown
	}
	if ((count($categories)&&($suckerfish_depthcategoriesecho<1||$suckerfish_depthcategoriesecho>$depth))||count($posts)){
		if($parent!=0){echo '<ul>';}// Remove if statement to create single dropdown
		if($suckerfish_depthcategoriesecho<1||$suckerfish_depthcategoriesecho>$depth){foreach($categories as $category){if($category->parent==$parent){echo '<li class="cat-item cat-item-'.$category->cat_ID.'"><a href="'.get_category_link($category->cat_ID).'" title="View all posts filed under '.$category->cat_name.'">'.$category->cat_name."</a>";if($suckerfish_depthcategoriesecho<1||$suckerfish_depthcategoriesecho>=$depth)categories_and_posts($category->cat_ID,$depth+1);echo "</li>";}}}
		foreach($posts as $current_post){
			echo '<li class="post-item post-item-' . $current_post->ID . '"><a href="' . get_permalink($current_post->ID) . '" title="' . $current_post->post_title . '">' . $current_post->post_title . "</a></li>";
		}
		if ($parent != 0) {echo '</ul>';}// Remove if statement to create single dropdown
	}
	if ($parent == 0) { /* REMOVED IN VERSION 0.6.17 AS SEEMS TO BE CAUSING IT TO GLITCH echo '</li>'; */ }
}

// Display the 'Home' option
function home() {
	// if on the home page, then add 'current-page-item' class
	if ( is_front_page() ) {$suckerfish_class=' class="current_page_item"';}
	// Add the HTML
	echo '<li'.$suckerfish_class.'><a href="';
	if (get_option('suckerfish_homeurl') != '') {echo get_option('suckerfish_homeurl');} // If URL set, then use that
	else {echo bloginfo('url').'/';} // If no URL set, then use built in one
	echo '">' . get_option('suckerfish_hometitle') . '</a></li>';
}

// Display the 'Links' option
// No these functions do not need to be seperate, but it's all legacy code and I haven't gotten around to cleaning it up yet
function blogroll() {wp_list_bookmarks('title_li=&categorize=0');}
function blogrolldropdown() {
	echo '<li class="links haschildren"><a href="';
	if (get_option('suckerfish_blogrollurl') != '') {echo get_option('suckerfish_blogrollurl');}
	echo '">' . get_option('suckerfish_blogrolltitle') . '</a> <ul>' , wp_list_bookmarks('title_li=&categorize=0') , '</ul></li>';
}
function blogrollcategories() {wp_list_bookmarks('title_li=&title_before=<a href="">&title_after=</a>&categorize=1&before=<li>&after=</li>&show_images=0&show_description=0&orderby=url');}
function blogrollcategoriesdropdown() {
	echo '<li><a href="';
	if (get_option('suckerfish_blogrollurl') != '') {echo get_option('suckerfish_blogrollurl');}
	echo '">' . get_option('suckerfish_blogrolltitle'). '</a> <ul>' , wp_list_bookmarks('title_li=&title_before=<a href="">&title_after=</a>&categorize=1&before=<li>&after=</li>&show_images=0&show_description=0&orderby=url') , '</ul></li>';
}

// Display the 'Archives' option
// No these functions do not need to be seperate, but it's all legacy code and I haven't gotten around to cleaning it up yet
function archivesmonths() {wp_get_archives('type=monthly');}
function archivesyears() {wp_get_archives('type=yearly');}
function archivesyearsandmonths() {
	// Buffering months archives
	ob_start();
	wp_get_archives('type=monthly');
	$archives_monthly = ob_get_contents();
	ob_end_clean();
	$archives_monthly = explode('</li>', $archives_monthly);
	foreach($archives_monthly as $key => $value){
		$year[$key] = substr($archives_monthly[$key], -9,-4);
	}
	// Buffering years archives
	ob_start();
	wp_get_archives('type=yearly');
	$archives_yearly = ob_get_contents();
	ob_end_clean();
	$archives_yearly = explode('</li>', $archives_yearly);
	// Display years and months
	foreach($year as $key => $value){
		if ($year[$key] != $year[$key-1]) {
			foreach($archives_yearly as $key3 => $value3){
				$archives_yearly2[$key3] = substr($archives_yearly[$key3], -8,-4);
				if ($year[$key] == $archives_yearly2[$key3]) {
					echo $archives_yearly[$key3];
				}
			}
			if ($archives_monthly[0] != '') {
				if ($year[$key] != '') {echo '<ul>';}
				foreach($archives_monthly as $key2 => $value2){
					$length = strlen($archives_monthly[$key2]);
					$archivessnipped[$key2] = substr($archives_monthly[$key2], 0,$length-9);
					$archivessnipped2[$key2] = substr($archives_monthly[$key2], $length-8,4);
					if ($archivessnipped2[$key2] == $year[$key]) {
						if ($archivessnipped[$key2] != '') {
							echo $archivessnipped[$key2].'</a></li>';
						}
					}
				}
				if ($year[$key] != '') {echo '</ul></li>';}
			}
		}
	}
}
function archivesmonthsdropdown() {
	if (is_month()) {$suckerfish_class=' class="archives current_page_parent current_page_item"';}
	else {$suckerfish_class=' class="archives haschildren"';}
	echo '<li'.$suckerfish_class.'><a href="';
	if (get_option('suckerfish_archivesurl') != '') {echo get_option('suckerfish_archivesurl');}
	echo '">' . get_option('suckerfish_archivestitle') . '</a><ul>';archivesmonths(); echo '</ul></li>';
}
function archivesyearsdropdown() {
	if (is_year()) {$suckerfish_class=' class="archives current_page_parent current_page_item"';}
	else {$suckerfish_class=' class="archives haschildren"';}
	echo '<li'.$suckerfish_class.'><a href="';
	if (get_option('suckerfish_archivesurl') != '') {echo get_option('suckerfish_archivesurl');}
	echo '">' . get_option('suckerfish_archivestitle') . '</a><ul>';archivesyears();echo '</ul></li>';
}
function archivesyearsandmonthsdropdown() {
	if (is_year() || is_month()) {$suckerfish_class=' class="archives current_page_parent current_page_item"';}
	else {$suckerfish_class=' class="archives haschildren"';}
	echo '<li'.$suckerfish_class.'><a href="';
	if (get_option('suckerfish_archivesurl') != '') {echo get_option('suckerfish_archivesurl');}
	echo '">' . get_option('suckerfish_archivestitle'). '</a><ul>';archivesyearsandmonths();echo '</ul></li>';
}

// Display the 'Recent Comments' option
function recentcomments() {
	echo '<li class="recentcomments haschildren"><a href="';
	if (get_option('suckerfish_recentcommentsurl') != '') {echo get_option('suckerfish_recentcommentsurl');}
	echo '">' .  get_option('suckerfish_recentcommentstitle') . '</a>';
	global $wpdb; $sql = "SELECT DISTINCT ID, post_title, post_password, comment_ID, comment_post_ID, comment_author, comment_date_gmt, comment_approved, comment_type,comment_author_url, SUBSTRING(comment_content,1,30) AS com_excerpt FROM $wpdb->comments LEFT OUTER JOIN $wpdb->posts ON ($wpdb->comments.comment_post_ID = $wpdb->posts.ID) WHERE comment_approved = '1' AND comment_type = '' AND post_password = '' ORDER BY comment_date_gmt DESC LIMIT 10";
	$comments = $wpdb->get_results($sql);
	$output = $pre_HTML;
	$output .= "<ul>";
	foreach ($comments as $comment) {
		$output .= "<li><a href=\"" . get_permalink($comment->ID) . "#comment-" . $comment->comment_ID . "\" title=\"on " . $comment->post_title . "\">".strip_tags($comment->comment_author) .":" . " " . strip_tags($comment->com_excerpt) ."</a></li>";
	}
	$output .= "</ul>";
	$output .= $post_HTML;
	echo $output;
	echo '</li>';
	}

// Display the 'Custom Code 1' option
function custom() {
	// Check if to be displayed to non-logged in users or not
	if (get_option('suckerfish_customcodelogged1') == 'on') {
		// Check if logged in
		if (is_user_logged_in()) {
			if (!function_exists('pixopoint_mln_custom1php')) {echo get_option('suckerfish_custommenu');} // Check that custom PHP mode is not on
			else {pixopoint_mln_custom1php();} // Else load custom PHP
		}
	}
	// Else display to everyone
	else {
		if (!function_exists('pixopoint_mln_custom1php')) {echo get_option('suckerfish_custommenu');} // Check that custom PHP mode is not on
		else {pixopoint_mln_custom1php();} // Else load custom PHP
	}
}

// Display the 'Custom Code 2' option
function custom2() {
	// Check if to be displayed to non-logged in users or not
	if (get_option('suckerfish_customcodelogged2') == 'on') {
		// Check if logged in
		if (is_user_logged_in()) {
			if (!function_exists('pixopoint_mln_custom2php')) {echo get_option('suckerfish_custommenu2');} // Check that custom PHP mode is not on
			else {pixopoint_mln_custom2php();} // Else load custom PHP
		}
	}
	else {
		if (!function_exists('pixopoint_mln_custom2php')) {echo get_option('suckerfish_custommenu2');} // Check that custom PHP mode is not on
		else {pixopoint_mln_custom2php();} // Else load custom PHP
	}
}

// Display the 'Custom Code 3' option
function custom3() {
	// Check if to be displayed to non-logged in users or not
	if (get_option('suckerfish_customcodelogged3') == 'on') {
		// Check if logged in
		if (is_user_logged_in()) {
			if (!function_exists('pixopoint_mln_custom3php')) {echo  get_option('suckerfish_custommenu3');} // Check that custom PHP mode is not on
			else {pixopoint_mln_custom3php();} // Else load custom PHP
		}
	}
	// Else display to everyone
	else {
		if (!function_exists('pixopoint_mln_custom3php')) {echo get_option('suckerfish_custommenu3');} // Check that custom PHP mode is not on
		else {pixopoint_mln_custom3php();} // Else load custom PHP
	}
}

// Display the 'Custom Code 4' option
function custom4() {
	// Check if to be displayed to non-logged in users or not
	if (get_option('suckerfish_customcodelogged4') == 'on') {
		// Check if logged in
		if (is_user_logged_in()) {
			if (!function_exists('pixopoint_mln_custom4php')) {echo get_option('suckerfish_custommenu4');} // Check that custom PHP mode is not on
			else {pixopoint_mln_custom4php();} // Else load custom PHP
		}
	}
	// Else display to everyone
	else {
		if (!function_exists('pixopoint_mln_custom4php')) {echo get_option('suckerfish_custommenu4');} // Check that custom PHP mode is not on
		else {pixopoint_mln_custom4php();} // Else load custom PHP
	}
}

// Display the 'Recent Posts' option
function recentposts() {
	echo '<li class="recentposts haschildren"><a href="';
	if (get_option('suckerfish_recentpostsurl') != '') {echo get_option('suckerfish_recentpostsurl');}
	echo '">' . get_option('suckerfish_recentpoststitle') . '</a><ul>';
	query_posts('showposts=10');
	while (have_posts()) {
		the_post();
		echo '<li><a href="';
		the_permalink();
		echo '">';
		the_title();
		echo '</a></li>';
	}
	wp_reset_query();
	echo '</ul></li>';
}

// The rest of the options
// Yes these functions do not need to be seperate, but it's all legacy code and I haven't gotten around to cleaning it up yet
function pages_excludechildren() {$args = array('post_type' => 'page','post_parent' => get_option('suckerfish_excludepages'), /*any parent*/); $suckerfish_excludepageschildren .= get_option('suckerfish_excludepages').','; if(get_option('suckerfish_excludepages') != ''){$attachments = get_children($args);} if ($attachments) {foreach ($attachments as $post) {$suckerfish_excludepageschildren .= $post->ID.',';} } echo '', ereg_replace("\"><a [/\?a-zA-Z0-9\-\.\:\"\=\_ >]+</a>([\t\n]+)<ul"," haschildren\\0",wp_list_pages('title_li=&exclude='.$suckerfish_excludepageschildren.'&echo=0')) , '';}
function pagesdropdown_excludechildren() {$args = array('post_type' => 'page','post_parent' => get_option('suckerfish_excludepages'), /*any parent*/); $suckerfish_excludepageschildren .= get_option('suckerfish_excludepages').','; if(get_option('suckerfish_excludepages') != ''){$attachments = get_children($args);} if ($attachments) {foreach ($attachments as $post) {$suckerfish_excludepageschildren .= $post->ID.',';} } if (is_page()) $class=' class="current_page_parent current_page_item"'; echo '<li'.$class.'><a href="'; if (get_option('suckerfish_pagesurl') != '') {echo get_option('suckerfish_pagesurl');} echo '">' . get_option('suckerfish_pagestitle') . '</a><ul>', ereg_replace("\"><a [/\?a-zA-Z0-9\-\.\:\"\=\_ >]+</a>([\t\n]+)<ul"," haschildren\\0",wp_list_pages('title_li=&exclude='.$suckerfish_excludepageschildren.'&echo=0')) , "</ul></li>"; }





/************************************************************
*************************************************************
 *** The main function used to add the menu to the site *****
*************************************************************
*************************************************************/
function pixopoint_menu($pixo_which=1) {

if ((get_option('suckerfish_secondmenu') == 'on' AND $pixo_which == '2') OR ($pixo_which == '1')) { // Only loads if second menu turned on
echo '
<!-- PixoPoint Menu Plugin by PixoPoint Web Development ... http://pixopoint.com/pixopoint-menu/ -->
';
	// Checks to see if theme CSS should be used and if so serves different IDs
	if (get_option('suckerfish_generator') == 'Theme CSS') {echo '
<div id="menu_wrapper'.$pixo_which.'">
	<div id="menu'.$pixo_which.'">
';
	}
	// If not using theme CSS, then uses regular plugin IDs
	else {

	echo '
<div id="pixopoint_menu'.$pixo_which.'_wrapper">
	<div id="pixopoint_menu'.$pixo_which.'">
';
	}
	// If title tags are to be removed, then starts output buffering (title tags removed via ereg_replace)
	if ((get_option('suckerfish_titletags') == 'on') || (get_option('suckerfish_pagesnoparentlinks') != '')) {ob_start();}

	echo '
		<ul class="sf-menu" id="suckerfishnav">
';
	// Menu contents are stored in the 'suckerfish_menucontents' option
	if (get_option('suckerfish_menucontents') != '') { // Checks if any menu options are stored
		$temp = explode('|', get_option('suckerfish_menucontents')); // Explodes 'suckerfish_menucontents' into an array
		foreach ($temp as $set) { // Splits array into two
			$set = explode('=', $set);
			// The seperator between inactive and active menu items
			if ($set[0] == 'XXX') {$XXX=1;}
			if ($set[0] == 'ZZZ') {$XXX=2;}
			if (($XXX == '' AND $pixo_which == 1) || ($XXX == 1 AND $pixo_which == 2)) { // Crude hack coz couldn't figure out how to finish a foreach early
				// 'Pages' option
				if ($set[0] == 'pages') {
					pages();
				}
				// 'Categories' option
				if ($set[0] == 'categories') {
					if (get_option('suckerfish_categories_showchildposts') == 'on') {
						if (is_category()) {$suckerfish_class=' class="current_page_parent current_page_item"';}
						if (get_option('suckerfish_categories_singledropdown') == 'on') {echo '<li'.$suckerfish_class.'>
							<a href="';if (get_option('suckerfish_categoriesurl') != '') {echo get_option('suckerfish_categoriesurl');}echo '">' .
								get_option('suckerfish_categoriestitle').
							'</a><ul>';
						}
						categories_and_posts();
						if (get_option('suckerfish_categories_singledropdown') == 'on') {echo '</ul></li>';}
					}
					else {category();}
				}
				// 'Recent Comments' option
				if ($set[0] == 'recentcomments') {recentcomments();}
				// 'Recent Posts' option
				if ($set[0] == 'recentposts') {recentposts();}
				// 'Search' option
				if ($set[0] == 'search') {
					echo '<li class="pixo_search'; if (get_option('suckerfish_searchalignment') == 'on') {echo ' pixo_right';} echo '">
					<form method="get" action="'.get_bloginfo('siteurl').'" > &nbsp;
					<input type="text" value="" class="pixo_inputsearch" name="s" /> <input type="submit" value="'; _e('Search','pixopoint_menu_lang');echo '" /> &nbsp;
					</form></li>';}
				// 'Home' option
				if ($set[0] == 'home') {home();}
				// 'Archive' option
				if ($set[0] == 'archives') {
					if (get_option('suckerfish_archivesdropdown') == 'on' AND get_option('suckerfish_archivesperiod') == 'Months') {archivesmonthsdropdown();}
					if (get_option('suckerfish_archivesdropdown') == 'on' AND get_option('suckerfish_archivesperiod') == 'Years') {archivesyearsdropdown();}
					if (get_option('suckerfish_archivesdropdown') == 'on' AND get_option('suckerfish_archivesperiod') == 'Years and Months') {archivesyearsandmonthsdropdown();}
					if (get_option('suckerfish_archivesdropdown') != 'on' AND get_option('suckerfish_archivesperiod') == 'Months') {archivesmonths();}
					if (get_option('suckerfish_archivesdropdown') != 'on' AND get_option('suckerfish_archivesperiod') == 'Years') {archivesyears();}
					if (get_option('suckerfish_archivesdropdown') != 'on' AND get_option('suckerfish_archivesperiod') == 'Years and Months') {archivesyearsandmonths();}
				}
				// 'Links' option
				if ($set[0] == 'links') {
					if (get_option('suckerfish_linkscategorized') == 'on' AND get_option('suckerfish_linksdropdown') == 'on') {blogrollcategoriesdropdown();}
					if (get_option('suckerfish_linkscategorized') == 'on' AND get_option('suckerfish_linksdropdown') != 'on') {blogrollcategories();}
					if (get_option('suckerfish_linkscategorized') != 'on' AND get_option('suckerfish_linksdropdown') == 'on') {blogrolldropdown();}
					if (get_option('suckerfish_linkscategorized') != 'on' AND get_option('suckerfish_linksdropdown') != 'on') {blogroll();}
				}
				// 'Custom Code 1' option
				if ($set[0] == 'customcode1') {custom();}
				// 'Custom Code 21' option
				if ($set[0] == 'customcode2') {custom2();}
				// 'Custom Code 3' option
				if ($set[0] == 'customcode3') {custom3();}
				// 'Custom Code 4' option
				if ($set[0] == 'customcode4') {custom4();}
			}
		}
	}

	// Sorting buffering from earlier
	if ((get_option('suckerfish_titletags') == 'on') || (get_option('suckerfish_pagesnoparentlinks') != '')) {
		$pixo_menucontents = ob_get_contents();
		ob_end_clean();

		// Removing unwanted URLs (set by user in admin panel)

		if (get_option('suckerfish_pagesnoparentlinks') != '') {
			$suckerfish_pagesnoparentlinks = get_option('suckerfish_pagesnoparentlinks');
			$suckerfish_pagesnoparentlinks = explode(',', $suckerfish_pagesnoparentlinks);
			// Process each page ID individually (to remove URLs where specified)
			foreach($suckerfish_pagesnoparentlinks as $key => $value){
				ob_start();
				query_posts('page_id='.$value);
				global $more;
				$more = 0;// set $more to 0 in order to only get the first part of the post
				while (have_posts()) : the_post();
				the_permalink(); // prints the loop on screen (doesn't display coz being buffered)
				endwhile;
				wp_reset_query(); // Reset query so that another one can be made
				$pageurlstoberemoved = ob_get_contents(); // Grabs URL from buffer
				$pixo_menucontents = str_replace($pageurlstoberemoved.'"', '#"', $pixo_menucontents); // Removes URL from variable containing the menu contents
				ob_end_clean();
//																										echo $pixo_menucontents.'|';
			}
		}
		// Removing title tags (set by user in admin panel)
		if (get_option('suckerfish_titletags') == 'on') {
			$pixo_menucontents = preg_replace('/title=\"(.*?)\"/','',$pixo_menucontents);
			$pixo_menucontents = preg_replace('/title=\'(.*?)\'/','',$pixo_menucontents);
		}

		echo $pixo_menucontents; // Finally echo the contents of the menu
	}

	// Add the closing tags
	echo '</ul>
	</div>
</div>
';
}
} // Closes "onlyload if second menu turned on"


/*************************************************************
 ****** Backwards support for 'Ryans Suckerfish Plugin' ******
 ******* This needs to stay as we promised to maintain *******
 ******* long term support for this function to some of ******
 ***************** our premium support members ***************
*************************************************************/
function suckerfish() {pixopoint_menu(1);}



