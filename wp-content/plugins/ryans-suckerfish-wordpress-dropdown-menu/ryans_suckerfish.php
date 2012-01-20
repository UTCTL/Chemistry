<?php
/*
Plugin Name: Ryans Suckerfish WordPress Dropdown Menu
Plugin URI: http://ryanhellyer.net/2008/01/14/suckerfish-wordpress-plugin/
Description: A WordPress plugin which adds a Suckerfish dropdown menu to your WordPress blog. Visit the <a href="http://ryanhellyer.net/2008/01/14/suckerfish-wordpress-plugin/">Suckerfish WordPress Plugin page</a> for instructions on how to add a dropdown menu to your theme or for help with this plugin.
Author: Ryan Hellyer
Version: 1.6.2
Author URI: http://ryanhellyer.net/
*/
/*
Copyright 2008 Ryan Hellyer

This program is free software; you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation; either version 3 of the License, or
(at your option) any later version.

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with this program.  If not, see <http://www.gnu.org/licenses/>.
*/

add_action('wp_head', 'suckerfishhead');


function suckerfishhead() {?>
	<!-- Suckerfish WordPress plugin by Ryan Hellyer ... http://ryanhellyer.net/ -->
	<!--[if lte IE 6]><script language="JavaScript" src="<?php bloginfo('wpurl'); ?>/wp-content/plugins/ryans-suckerfish-wordpress-dropdown-menu/suckerfish_ie.js"></script><![endif]-->
<?php	if (get_option('suckerfish_keyboard') == 'on') {echo '<script language="JavaScript" src="' , bloginfo('wpurl') , '/wp-content/plugins/ryans-suckerfish-wordpress-dropdown-menu/suckerfish_keyboard.js"></script>';} ?>
	<link rel="stylesheet" type="text/css" href="<?php bloginfo('wpurl'); ?>/wp-content/plugins/ryans-suckerfish-wordpress-dropdown-menu/style.php" />
	<?php }

	$suckerfish_css = get_option('suckerfish_css');
	$suckerfish_menuitem1 = get_option('suckerfish_menuitem1');
	$suckerfish_menuitem2 = get_option('suckerfish_menuitem2');
	$suckerfish_menuitem3 = get_option('suckerfish_menuitem3');
	$suckerfish_menuitem4 = get_option('suckerfish_menuitem4');
	$suckerfish_menuitem5 = get_option('suckerfish_menuitem5');
	$suckerfish_menuitem6 = get_option('suckerfish_menuitem6');

function suckerfish() {
	echo '<!-- Suckerfish WordPress Plugin by Ryan Hellyer ... http://ryanhellyer.net/ -->
	<ul id="suckerfishnav">';

	if (get_option('suckerfish_menuitem1') == 'Pages') {wp_list_pages('title_li=');}
	if (get_option('suckerfish_menuitem1') == 'Pages Dropdown') {echo '<li><a href="#">Pages</a><ul>' , wp_list_pages('title_li=') , '</ul>';}
	if (get_option('suckerfish_menuitem1') == 'Category') {wp_list_categories('title_li=');}
	if (get_option('suckerfish_menuitem1') == 'Categories Dropdown') {echo '<li><a href="#">Categories</a><ul>' , wp_list_categories('title_li=') , '</ul></li>';}
	if (get_option('suckerfish_menuitem1') == 'Home') {echo '<li><a href="' , bloginfo('url') , '/">Home</a></li>';}
	if (get_option('suckerfish_menuitem1') == 'Blogroll') {wp_list_bookmarks('title_li=&categorize=0');}
	if (get_option('suckerfish_menuitem1') == 'Blogroll Dropdown') {echo '<li><a href="#">Blogroll</a> <ul>' , wp_list_bookmarks('title_li=&categorize=0') , '</ul></li>';}
	if (get_option('suckerfish_menuitem1') == 'Archives (months)') {wp_get_archives('type=monthly');}
	if (get_option('suckerfish_menuitem1') == 'Archives (years)') {wp_get_archives('type=yearly');}
	if (get_option('suckerfish_menuitem1') == 'Archives (months) Dropdown') {echo '<li><a href="#">Archives</a><ul>' , wp_get_archives('type=monthly') , '</ul></li>';}
	if (get_option('suckerfish_menuitem1') == 'Archives (years) Dropdown') {echo '<li><a href="#">Archives</a><ul>' , wp_get_archives('type=yearly') , '</ul></li>';}

	if (get_option('suckerfish_menuitem2') == 'Pages') {wp_list_pages('title_li=');}
	if (get_option('suckerfish_menuitem2') == 'Pages Dropdown') {echo '<li><a href="#">Pages</a><ul>' , wp_list_pages('title_li=') , '</ul>';}
	if (get_option('suckerfish_menuitem2') == 'Category') {wp_list_categories('title_li=');}
	if (get_option('suckerfish_menuitem2') == 'Categories Dropdown') {echo '<li><a href="#">Categories</a><ul>' , wp_list_categories('title_li=') , '</ul></li>';}
	if (get_option('suckerfish_menuitem2') == 'Home') {echo '<li><a href="' , bloginfo('url') , '/">Home</a></li>';}
	if (get_option('suckerfish_menuitem2') == 'Blogroll') {wp_list_bookmarks('title_li=&categorize=0');}
	if (get_option('suckerfish_menuitem2') == 'Blogroll Dropdown') {echo '<li><a href="#">Blogroll</a> <ul>' , wp_list_bookmarks('title_li=&categorize=0') , '</ul></li>';}
	if (get_option('suckerfish_menuitem2') == 'Archives (months)') {wp_get_archives('type=monthly');}
	if (get_option('suckerfish_menuitem2') == 'Archives (years)') {wp_get_archives('type=yearly');}
	if (get_option('suckerfish_menuitem2') == 'Archives (months) Dropdown') {echo '<li><a href="#">Archives</a><ul>' , wp_get_archives('type=monthly') , '</ul></li>';}
	if (get_option('suckerfish_menuitem2') == 'Archives (years) Dropdown') {echo '<li><a href="#">Archives</a><ul>' , wp_get_archives('type=yearly') , '</ul></li>';}

	if (get_option('suckerfish_menuitem3') == 'Pages') {wp_list_pages('title_li=');}
	if (get_option('suckerfish_menuitem3') == 'Pages Dropdown') {echo '<li><a href="#">Pages</a><ul>' , wp_list_pages('title_li=') , '</ul>';}
	if (get_option('suckerfish_menuitem3') == 'Category') {wp_list_categories('title_li=');}
	if (get_option('suckerfish_menuitem3') == 'Categories Dropdown') {echo '<li><a href="#">Categories</a><ul>' , wp_list_categories('title_li=') , '</ul></li>';}
	if (get_option('suckerfish_menuitem3') == 'Home') {echo '<li><a href="' , bloginfo('url') , '/">Home</a></li>';}
	if (get_option('suckerfish_menuitem3') == 'Blogroll') {wp_list_bookmarks('title_li=&categorize=0');}
	if (get_option('suckerfish_menuitem3') == 'Blogroll Dropdown') {echo '<li><a href="#">Blogroll</a> <ul>' , wp_list_bookmarks('title_li=&categorize=0') , '</ul></li>';}
	if (get_option('suckerfish_menuitem3') == 'Archives (months)') {wp_get_archives('type=monthly');}
	if (get_option('suckerfish_menuitem3') == 'Archives (years)') {wp_get_archives('type=yearly');}
	if (get_option('suckerfish_menuitem3') == 'Archives (months) Dropdown') {echo '<li><a href="#">Archives</a><ul>' , wp_get_archives('type=monthly') , '</ul></li>';}
	if (get_option('suckerfish_menuitem3') == 'Archives (years) Dropdown') {echo '<li><a href="#">Archives</a><ul>' , wp_get_archives('type=yearly') , '</ul></li>';}

	if (get_option('suckerfish_menuitem4') == 'Pages') {wp_list_pages('title_li=');}
	if (get_option('suckerfish_menuitem4') == 'Pages Dropdown') {echo '<li><a href="#">Pages</a><ul>' , wp_list_pages('title_li=') , '</ul>';}
	if (get_option('suckerfish_menuitem4') == 'Category') {wp_list_categories('title_li=');}
	if (get_option('suckerfish_menuitem4') == 'Categories Dropdown') {echo '<li><a href="#">Categories</a><ul>' , wp_list_categories('title_li=') , '</ul></li>';}
	if (get_option('suckerfish_menuitem4') == 'Home') {echo '<li><a href="' , bloginfo('url') , '/">Home</a></li>';}
	if (get_option('suckerfish_menuitem4') == 'Blogroll') {wp_list_bookmarks('title_li=&categorize=0');}
	if (get_option('suckerfish_menuitem4') == 'Blogroll Dropdown') {echo '<li><a href="#">Blogroll</a> <ul>' , wp_list_bookmarks('title_li=&categorize=0') , '</ul></li>';}
	if (get_option('suckerfish_menuitem4') == 'Archives (months)') {wp_get_archives('type=monthly');}
	if (get_option('suckerfish_menuitem4') == 'Archives (years)') {wp_get_archives('type=yearly');}
	if (get_option('suckerfish_menuitem4') == 'Archives (months) Dropdown') {echo '<li><a href="#">Archives</a><ul>' , wp_get_archives('type=monthly') , '</ul></li>';}
	if (get_option('suckerfish_menuitem4') == 'Archives (years) Dropdown') {echo '<li><a href="#">Archives</a><ul>' , wp_get_archives('type=yearly') , '</ul></li>';}

	if (get_option('suckerfish_menuitem5') == 'Pages') {wp_list_pages('title_li=');}
	if (get_option('suckerfish_menuitem5') == 'Pages Dropdown') {echo '<li><a href="#">Pages</a><ul>' , wp_list_pages('title_li=') , '</ul>';}
	if (get_option('suckerfish_menuitem5') == 'Category') {wp_list_categories('title_li=');}
	if (get_option('suckerfish_menuitem5') == 'Categories Dropdown') {echo '<li><a href="#">Categories</a><ul>' , wp_list_categories('title_li=') , '</ul></li>';}
	if (get_option('suckerfish_menuitem5') == 'Home') {echo '<li><a href="' , bloginfo('url') , '/">Home</a></li>';}
	if (get_option('suckerfish_menuitem5') == 'Blogroll') {wp_list_bookmarks('title_li=&categorize=0');}
	if (get_option('suckerfish_menuitem5') == 'Blogroll Dropdown') {echo '<li><a href="#">Blogroll</a> <ul>' , wp_list_bookmarks('title_li=&categorize=0') , '</ul></li>';}
	if (get_option('suckerfish_menuitem5') == 'Archives (months)') {wp_get_archives('type=monthly');}
	if (get_option('suckerfish_menuitem5') == 'Archives (years)') {wp_get_archives('type=yearly');}
	if (get_option('suckerfish_menuitem5') == 'Archives (months) Dropdown') {echo '<li><a href="#">Archives</a><ul>' , wp_get_archives('type=monthly') , '</ul></li>';}
	if (get_option('suckerfish_menuitem5') == 'Archives (years) Dropdown') {echo '<li><a href="#">Archives</a><ul>' , wp_get_archives('type=yearly') , '</ul></li>';}

	if (get_option('suckerfish_menuitem6') == 'Pages') {wp_list_pages('title_li=');}
	if (get_option('suckerfish_menuitem6') == 'Pages Dropdown') {echo '<li><a href="#">Pages</a><ul>' , wp_list_pages('title_li=') , '</ul>';}
	if (get_option('suckerfish_menuitem6') == 'Category') {wp_list_categories('title_li=');}
	if (get_option('suckerfish_menuitem6') == 'Categories Dropdown') {echo '<li><a href="#">Categories</a><ul>' , wp_list_categories('title_li=') , '</ul></li>';}
	if (get_option('suckerfish_menuitem6') == 'Home') {echo '<li><a href="' , bloginfo('url') , '/">Home</a></li>';}
	if (get_option('suckerfish_menuitem6') == 'Blogroll') {wp_list_bookmarks('title_li=&categorize=0');}
	if (get_option('suckerfish_menuitem6') == 'Blogroll Dropdown') {echo '<li><a href="#">Blogroll</a> <ul>' , wp_list_bookmarks('title_li=&categorize=0') , '</ul></li>';}
	if (get_option('suckerfish_menuitem6') == 'Archives (months)') {wp_get_archives('type=monthly');}
	if (get_option('suckerfish_menuitem6') == 'Archives (years)') {wp_get_archives('type=yearly');}
	if (get_option('suckerfish_menuitem6') == 'Archives (months) Dropdown') {echo '<li><a href="#">Archives</a><ul>' , wp_get_archives('type=monthly') , '</ul></li>';}
	if (get_option('suckerfish_menuitem6') == 'Archives (years) Dropdown') {echo '<li><a href="#">Archives</a><ul>' , wp_get_archives('type=yearly') , '</ul></li>';}

	echo '</ul>';
}

// OLD FUNCTIONS FOR PREVIOUS VERSIONS OF THE PLUGIN
function suckerfish1() {echo '<ul id="suckerfishnav">' , wp_list_pages('title_li=') , '</ul>';}
function suckerfish2() {echo '<ul id="suckerfishnav"><li><a href="' , bloginfo('url') , '/">Home</a></li>' , wp_list_pages('title_li=') , '</ul>';}
function suckerfish3() {echo '<ul id="suckerfishnav"><li><a href="#">Pages</a><ul>' , wp_list_pages('title_li=') , '</ul></li><li><a href="#">Archives</a><ul>' , wp_get_archives() , '</ul></li><li><a href="#">Categories</a><ul>' , wp_list_categories('title_li=') , '</ul></li><li><a href="#">Blogroll</a> <ul>' , wp_list_bookmarks('title_li=&categorize=0') , '</ul></li></ul>';}
function suckerfish4() {echo '<ul id="suckerfishnav">' , wp_list_pages('title_li=') , '<li><a href="#">Archives</a><ul>' , wp_get_archives() , '</ul></li><li><a href="#">Categories</a><ul>' , wp_list_categories('title_li=') , '</ul></li></ul>';}
function suckerfish5() {echo '<ul id="suckerfishnav"><li><a href="' , bloginfo('url') , '/">Home</a></li>' , wp_list_pages('title_li=') , '<li><a href="#">Archives</a><ul>' , wp_get_archives() , '</ul></li><li><a href="#">Categories</a><ul>' , wp_list_categories('title_li=') , '</ul></li></ul>';}


// adds options menu
add_action('admin_menu', 'show_suckerfish_options');

function show_suckerfish_options() {
    // Add a new submenu under Options:
    add_options_page('Ryans Suckerfish Plugin Options', 'Suckerfish', 8, 'suckerfishoptions', 'suckerfish_options');

add_option('suckerfish_css', '#222');
add_option('suckerfish_menuitem1', 'Home');
add_option('suckerfish_menuitem2', 'Pages Dropdown');
add_option('suckerfish_menuitem3', 'Categories Dropdown');
add_option('suckerfish_menuitem4', 'Archives (years) Dropdown');
add_option('suckerfish_menuitem5', 'Blogroll Dropdown');
add_option('suckerfish_menuitem6', 'None');
add_option('suckerfish_keyboard', '');
}

function suckerfish_options() { ?>

<style type="text/css">
#options h3 { margin-bottom: -10px; }
#options label { width: 200px; float: left; margin-right: 25px; font-weight: bold; }
#options input { float: left; }
#options p { clear: both; }
.menuitems {float:left;width:300px;height:70px}
</style>

<div class="wrap">
	<form method="post" action="options.php" id="options">
		<?php wp_nonce_field('update-options') ?>
		<h2>Suckerfish WordPress Plugin</h2>
		<p>
			This plugin creates a dropdown navigation for your WordPress blog based on the
			<a href="http://www.htmldog.com/articles/suckerfish/ target="_blank">Son of Suckerfish Dropdown</a>.
			If you have any comments, questions or suggestions about this plugin, please visit the
			<a href="http://ryanhellyer.net/2008/01/14/suckerfish-wordpress-plugin/">Suckerfish WordPress Plugin Beta page</a>.
		</p>
		<p>
			To style your dropdown, please visit the <a href="http://ryanhellyer.net/dropdowns/">Suckerfish Dropdown Generator</a>
			page to obtain your CSS and enter it below.
		</p>
		<div style="clear:both;padding-top:5px;"></div>

		<h3>Enter your CSS here</h3>
		<p>
			<textarea name="suckerfish_css" value="" cols="100%" rows="10" tabindex="4"><?php echo get_option('suckerfish_css'); ?></textarea>
		</p>

		<h2>Menu Contents</h2>
		<p>
			<div class="menuitems">
				<label>Menu Item #1</label>
				<select name="suckerfish_menuitem1">
					<?php
						if (get_option('suckerfish_menuitem1') == 'None') {echo '<option>None</option><option>Home</option><option>Pages</option><option>Pages Dropdown</option><option>Categories</option><option>Categories Dropdown</option><option>Archives (months)</option><option>Archives (months) Dropdown</option><option>Archives (years)</option><option>Archives (years) Dropdown</option><option>Blogroll</option><option>Blogroll Dropdown</option>';}
						if (get_option('suckerfish_menuitem1') == 'Home') {echo '<option>Home</option><option>None</option><option>Pages</option><option>Pages Dropdown</option><option>Categories</option><option>Categories Dropdown</option><option>Archives (months)</option><option>Archives (months) Dropdown</option><option>Archives (years)</option><option>Archives (years) Dropdown</option><option>Blogroll</option><option>Blogroll Dropdown</option>';}
						if (get_option('suckerfish_menuitem1') == 'Pages') {echo '<option>Pages</option><option>None</option><option>Home</option><option>Pages Dropdown</option><option>Categories</option><option>Categories Dropdown</option><option>Archives (months)</option><option>Archives (months) Dropdown</option><option>Archives (years)</option><option>Archives (years) Dropdown</option><option>Blogroll</option><option>Blogroll Dropdown</option>';}
						if (get_option('suckerfish_menuitem1') == 'Pages Dropdown') {echo '<option>Pages Dropdown</option><option>None</option><option>Home</option><option>Pages</option><option>Categories</option><option>Categories Dropdown</option><option>Archives (months)</option><option>Archives (months) Dropdown</option><option>Archives (years)</option><option>Archives (years) Dropdown</option><option>Blogroll</option><option>Blogroll Dropdown</option>';}
						if (get_option('suckerfish_menuitem1') == 'Categories') {echo '<option>Categories</option><option>None</option><option>Home</option><option>Pages</option><option>Pages Dropdown</option><option>Categories Dropdown</option><option>Archives (months)</option><option>Archives (months) Dropdown</option><option>Archives (years)</option><option>Archives (years) Dropdown</option><option>Blogroll</option><option>Blogroll Dropdown</option>';}
						if (get_option('suckerfish_menuitem1') == 'Categories Dropdown') {echo '<option>Categories Dropdown</option><option>None</option><option>Home</option><option>Pages</option><option>Pages Dropdown</option><option>Categories</option><option>Archives (months)</option><option>Archives (months) Dropdown</option><option>Archives (years)</option><option>Archives (years) Dropdown</option><option>Blogroll</option><option>Blogroll Dropdown</option>';}
						if (get_option('suckerfish_menuitem1') == 'Archives (months)') {echo '<option>Archives (months)</option><option>None</option><option>Home</option><option>Pages</option><option>Pages Dropdown</option><option>Categories</option><option>Categories Dropdown</option><option>Archives (years)</option><option>Archives (months) Dropdown</option><option>Archives (years) Dropdown</option><option>Blogroll</option><option>Blogroll Dropdown</option>';}
						if (get_option('suckerfish_menuitem1') == 'Archives (years)') {echo '<option>Archives (years)</option><option>None</option><option>Home</option><option>Pages</option><option>Pages Dropdown</option><option>Categories</option><option>Categories Dropdown</option><option>Archives (months)</option><option>Archives (months) Dropdown</option><option>Archives (years) Dropdown</option><option>Blogroll</option><option>Blogroll Dropdown</option>';}
						if (get_option('suckerfish_menuitem1') == 'Archives (months) Dropdown') {echo '<option>Archives (months) Dropdown</option><option>None</option><option>Home</option><option>Pages</option><option>Pages Dropdown</option><option>Categories</option><option>Categories Dropdown</option><option>Archives (months)</option><option>Archives (years)</option><option>Archives (years) Dropdown</option><option>Blogroll</option><option>Blogroll Dropdown</option>';}
						if (get_option('suckerfish_menuitem1') == 'Archives (years) Dropdown') {echo '<option>Archives (years) Dropdown</option><option>None</option><option>Home</option><option>Pages</option><option>Pages Dropdown</option><option>Categories</option><option>Categories Dropdown</option><option>Archives (months)</option><option>Archives (months) Dropdown</option><option>Archives (years)</option><option>Blogroll</option><option>Blogroll Dropdown</option>';}
						if (get_option('suckerfish_menuitem1') == 'Blogroll') {echo '<option>Blogroll</option><option>None</option><option>Home</option><option>Pages</option><option>Pages Dropdown</option><option>Categories</option><option>Categories Dropdown</option><option>Archives (months)</option><option>Archives (months) Dropdown</option><option>Archives (years)</option><option>Archives (years) Dropdown</option><option>Blogroll Dropdown</option>';}
						if (get_option('suckerfish_menuitem1') == 'Blogroll Dropdown') {echo '<option>Blogroll Dropdown</option><option>None</option><option>Home</option><option>Pages</option><option>Pages Dropdown</option><option>Categories</option><option>Categories Dropdown</option><option>Archives (months)</option><option>Archives (months) Dropdown</option><option>Archives (years)</option><option>Archives (years) Dropdown</option><option>Blogroll</option>';}
					 ?>
				</select>
			</div>
			<div class="menuitems">
				<label>Menu Item #2</label>
				<select name="suckerfish_menuitem2">
					<?php
						if (get_option('suckerfish_menuitem2') == 'None') {echo '<option>None</option><option>Home</option><option>Pages</option><option>Pages Dropdown</option><option>Categories</option><option>Categories Dropdown</option><option>Archives (months)</option><option>Archives (months) Dropdown</option><option>Archives (years)</option><option>Archives (years) Dropdown</option><option>Blogroll</option><option>Blogroll Dropdown</option>';}
						if (get_option('suckerfish_menuitem2') == 'Home') {echo '<option>Home</option><option>None</option><option>Pages</option><option>Pages Dropdown</option><option>Categories</option><option>Categories Dropdown</option><option>Archives (months)</option><option>Archives (months) Dropdown</option><option>Archives (years)</option><option>Archives (years) Dropdown</option><option>Blogroll</option><option>Blogroll Dropdown</option>';}
						if (get_option('suckerfish_menuitem2') == 'Pages') {echo '<option>Pages</option><option>None</option><option>Home</option><option>Pages Dropdown</option><option>Categories</option><option>Categories Dropdown</option><option>Archives (months)</option><option>Archives (months) Dropdown</option><option>Archives (years)</option><option>Archives (years) Dropdown</option><option>Blogroll</option><option>Blogroll Dropdown</option>';}
						if (get_option('suckerfish_menuitem2') == 'Pages Dropdown') {echo '<option>Pages Dropdown</option><option>None</option><option>Home</option><option>Pages</option><option>Categories</option><option>Categories Dropdown</option><option>Archives (months)</option><option>Archives (months) Dropdown</option><option>Archives (years)</option><option>Archives (years) Dropdown</option><option>Blogroll</option><option>Blogroll Dropdown</option>';}
						if (get_option('suckerfish_menuitem2') == 'Categories') {echo '<option>Categories</option><option>None</option><option>Home</option><option>Pages</option><option>Pages Dropdown</option><option>Categories Dropdown</option><option>Archives (months)</option><option>Archives (months) Dropdown</option><option>Archives (years)</option><option>Archives (years) Dropdown</option><option>Blogroll</option><option>Blogroll Dropdown</option>';}
						if (get_option('suckerfish_menuitem2') == 'Categories Dropdown') {echo '<option>Categories Dropdown</option><option>None</option><option>Home</option><option>Pages</option><option>Pages Dropdown</option><option>Categories</option><option>Archives (months)</option><option>Archives (months) Dropdown</option><option>Archives (years)</option><option>Archives (years) Dropdown</option><option>Blogroll</option><option>Blogroll Dropdown</option>';}
						if (get_option('suckerfish_menuitem2') == 'Archives (months)') {echo '<option>Archives (months)</option><option>None</option><option>Home</option><option>Pages</option><option>Pages Dropdown</option><option>Categories</option><option>Categories Dropdown</option><option>Archives (years)</option><option>Archives (months) Dropdown</option><option>Archives (years) Dropdown</option><option>Blogroll</option><option>Blogroll Dropdown</option>';}
						if (get_option('suckerfish_menuitem2') == 'Archives (years)') {echo '<option>Archives (years)</option><option>None</option><option>Home</option><option>Pages</option><option>Pages Dropdown</option><option>Categories</option><option>Categories Dropdown</option><option>Archives (months)</option><option>Archives (months) Dropdown</option><option>Archives (years) Dropdown</option><option>Blogroll</option><option>Blogroll Dropdown</option>';}
						if (get_option('suckerfish_menuitem2') == 'Archives (months) Dropdown') {echo '<option>Archives (months) Dropdown</option><option>None</option><option>Home</option><option>Pages</option><option>Pages Dropdown</option><option>Categories</option><option>Categories Dropdown</option><option>Archives (months)</option><option>Archives (years)</option><option>Archives (years) Dropdown</option><option>Blogroll</option><option>Blogroll Dropdown</option>';}
						if (get_option('suckerfish_menuitem2') == 'Archives (years) Dropdown') {echo '<option>Archives (years) Dropdown</option><option>None</option><option>Home</option><option>Pages</option><option>Pages Dropdown</option><option>Categories</option><option>Categories Dropdown</option><option>Archives (months)</option><option>Archives (months) Dropdown</option><option>Archives (years)</option><option>Blogroll</option><option>Blogroll Dropdown</option>';}
						if (get_option('suckerfish_menuitem2') == 'Blogroll') {echo '<option>Blogroll</option><option>None</option><option>Home</option><option>Pages</option><option>Pages Dropdown</option><option>Categories</option><option>Categories Dropdown</option><option>Archives (months)</option><option>Archives (months) Dropdown</option><option>Archives (years)</option><option>Archives (years) Dropdown</option><option>Blogroll Dropdown</option>';}
						if (get_option('suckerfish_menuitem2') == 'Blogroll Dropdown') {echo '<option>Blogroll Dropdown</option><option>None</option><option>Home</option><option>Pages</option><option>Pages Dropdown</option><option>Categories</option><option>Categories Dropdown</option><option>Archives (months)</option><option>Archives (months) Dropdown</option><option>Archives (years)</option><option>Archives (years) Dropdown</option><option>Blogroll</option>';}
					 ?>
				</select>
			</div>
			<div class="menuitems">
				<label>Menu Item #3</label>
				<select name="suckerfish_menuitem3">
					<?php
						if (get_option('suckerfish_menuitem3') == 'None') {echo '<option>None</option><option>Home</option><option>Pages</option><option>Pages Dropdown</option><option>Categories</option><option>Categories Dropdown</option><option>Archives (months)</option><option>Archives (months) Dropdown</option><option>Archives (years)</option><option>Archives (years) Dropdown</option><option>Blogroll</option><option>Blogroll Dropdown</option>';}
						if (get_option('suckerfish_menuitem3') == 'Home') {echo '<option>Home</option><option>None</option><option>Pages</option><option>Pages Dropdown</option><option>Categories</option><option>Categories Dropdown</option><option>Archives (months)</option><option>Archives (months) Dropdown</option><option>Archives (years)</option><option>Archives (years) Dropdown</option><option>Blogroll</option><option>Blogroll Dropdown</option>';}
						if (get_option('suckerfish_menuitem3') == 'Pages') {echo '<option>Pages</option><option>None</option><option>Home</option><option>Pages Dropdown</option><option>Categories</option><option>Categories Dropdown</option><option>Archives (months)</option><option>Archives (months) Dropdown</option><option>Archives (years)</option><option>Archives (years) Dropdown</option><option>Blogroll</option><option>Blogroll Dropdown</option>';}
						if (get_option('suckerfish_menuitem3') == 'Pages Dropdown') {echo '<option>Pages Dropdown</option><option>None</option><option>Home</option><option>Pages</option><option>Categories</option><option>Categories Dropdown</option><option>Archives (months)</option><option>Archives (months) Dropdown</option><option>Archives (years)</option><option>Archives (years) Dropdown</option><option>Blogroll</option><option>Blogroll Dropdown</option>';}
						if (get_option('suckerfish_menuitem3') == 'Categories') {echo '<option>Categories</option><option>None</option><option>Home</option><option>Pages</option><option>Pages Dropdown</option><option>Categories Dropdown</option><option>Archives (months)</option><option>Archives (months) Dropdown</option><option>Archives (years)</option><option>Archives (years) Dropdown</option><option>Blogroll</option><option>Blogroll Dropdown</option>';}
						if (get_option('suckerfish_menuitem3') == 'Categories Dropdown') {echo '<option>Categories Dropdown</option><option>None</option><option>Home</option><option>Pages</option><option>Pages Dropdown</option><option>Categories</option><option>Archives (months)</option><option>Archives (months) Dropdown</option><option>Archives (years)</option><option>Archives (years) Dropdown</option><option>Blogroll</option><option>Blogroll Dropdown</option>';}
						if (get_option('suckerfish_menuitem3') == 'Archives (months)') {echo '<option>Archives (months)</option><option>None</option><option>Home</option><option>Pages</option><option>Pages Dropdown</option><option>Categories</option><option>Categories Dropdown</option><option>Archives (years)</option><option>Archives (months) Dropdown</option><option>Archives (years) Dropdown</option><option>Blogroll</option><option>Blogroll Dropdown</option>';}
						if (get_option('suckerfish_menuitem3') == 'Archives (years)') {echo '<option>Archives (years)</option><option>None</option><option>Home</option><option>Pages</option><option>Pages Dropdown</option><option>Categories</option><option>Categories Dropdown</option><option>Archives (months)</option><option>Archives (months) Dropdown</option><option>Archives (years) Dropdown</option><option>Blogroll</option><option>Blogroll Dropdown</option>';}
						if (get_option('suckerfish_menuitem3') == 'Archives (months) Dropdown') {echo '<option>Archives (months) Dropdown</option><option>None</option><option>Home</option><option>Pages</option><option>Pages Dropdown</option><option>Categories</option><option>Categories Dropdown</option><option>Archives (months)</option><option>Archives (years)</option><option>Archives (years) Dropdown</option><option>Blogroll</option><option>Blogroll Dropdown</option>';}
						if (get_option('suckerfish_menuitem3') == 'Archives (years) Dropdown') {echo '<option>Archives (years) Dropdown</option><option>None</option><option>Home</option><option>Pages</option><option>Pages Dropdown</option><option>Categories</option><option>Categories Dropdown</option><option>Archives (months)</option><option>Archives (months) Dropdown</option><option>Archives (years)</option><option>Blogroll</option><option>Blogroll Dropdown</option>';}
						if (get_option('suckerfish_menuitem3') == 'Blogroll') {echo '<option>Blogroll</option><option>None</option><option>Home</option><option>Pages</option><option>Pages Dropdown</option><option>Categories</option><option>Categories Dropdown</option><option>Archives (months)</option><option>Archives (months) Dropdown</option><option>Archives (years)</option><option>Archives (years) Dropdown</option><option>Blogroll Dropdown</option>';}
						if (get_option('suckerfish_menuitem3') == 'Blogroll Dropdown') {echo '<option>Blogroll Dropdown</option><option>None</option><option>Home</option><option>Pages</option><option>Pages Dropdown</option><option>Categories</option><option>Categories Dropdown</option><option>Archives (months)</option><option>Archives (months) Dropdown</option><option>Archives (years)</option><option>Archives (years) Dropdown</option><option>Blogroll</option>';}
					 ?>
				</select>
			</div>
			<div class="menuitems">
				<label>Menu Item #4</label>
				<select name="suckerfish_menuitem4">
					<?php
						if (get_option('suckerfish_menuitem4') == 'None') {echo '<option>None</option><option>Home</option><option>Pages</option><option>Pages Dropdown</option><option>Categories</option><option>Categories Dropdown</option><option>Archives (months)</option><option>Archives (months) Dropdown</option><option>Archives (years)</option><option>Archives (years) Dropdown</option><option>Blogroll</option><option>Blogroll Dropdown</option>';}
						if (get_option('suckerfish_menuitem4') == 'Home') {echo '<option>Home</option><option>None</option><option>Pages</option><option>Pages Dropdown</option><option>Categories</option><option>Categories Dropdown</option><option>Archives (months)</option><option>Archives (months) Dropdown</option><option>Archives (years)</option><option>Archives (years) Dropdown</option><option>Blogroll</option><option>Blogroll Dropdown</option>';}
						if (get_option('suckerfish_menuitem4') == 'Pages') {echo '<option>Pages</option><option>None</option><option>Home</option><option>Pages Dropdown</option><option>Categories</option><option>Categories Dropdown</option><option>Archives (months)</option><option>Archives (months) Dropdown</option><option>Archives (years)</option><option>Archives (years) Dropdown</option><option>Blogroll</option><option>Blogroll Dropdown</option>';}
						if (get_option('suckerfish_menuitem4') == 'Pages Dropdown') {echo '<option>Pages Dropdown</option><option>None</option><option>Home</option><option>Pages</option><option>Categories</option><option>Categories Dropdown</option><option>Archives (months)</option><option>Archives (months) Dropdown</option><option>Archives (years)</option><option>Archives (years) Dropdown</option><option>Blogroll</option><option>Blogroll Dropdown</option>';}
						if (get_option('suckerfish_menuitem4') == 'Categories') {echo '<option>Categories</option><option>None</option><option>Home</option><option>Pages</option><option>Pages Dropdown</option><option>Categories Dropdown</option><option>Archives (months)</option><option>Archives (months) Dropdown</option><option>Archives (years)</option><option>Archives (years) Dropdown</option><option>Blogroll</option><option>Blogroll Dropdown</option>';}
						if (get_option('suckerfish_menuitem4') == 'Categories Dropdown') {echo '<option>Categories Dropdown</option><option>None</option><option>Home</option><option>Pages</option><option>Pages Dropdown</option><option>Categories</option><option>Archives (months)</option><option>Archives (months) Dropdown</option><option>Archives (years)</option><option>Archives (years) Dropdown</option><option>Blogroll</option><option>Blogroll Dropdown</option>';}
						if (get_option('suckerfish_menuitem4') == 'Archives (months)') {echo '<option>Archives (months)</option><option>None</option><option>Home</option><option>Pages</option><option>Pages Dropdown</option><option>Categories</option><option>Categories Dropdown</option><option>Archives (years)</option><option>Archives (months) Dropdown</option><option>Archives (years) Dropdown</option><option>Blogroll</option><option>Blogroll Dropdown</option>';}
						if (get_option('suckerfish_menuitem4') == 'Archives (years)') {echo '<option>Archives (years)</option><option>None</option><option>Home</option><option>Pages</option><option>Pages Dropdown</option><option>Categories</option><option>Categories Dropdown</option><option>Archives (months)</option><option>Archives (months) Dropdown</option><option>Archives (years) Dropdown</option><option>Blogroll</option><option>Blogroll Dropdown</option>';}
						if (get_option('suckerfish_menuitem4') == 'Archives (months) Dropdown') {echo '<option>Archives (months) Dropdown</option><option>None</option><option>Home</option><option>Pages</option><option>Pages Dropdown</option><option>Categories</option><option>Categories Dropdown</option><option>Archives (months)</option><option>Archives (years)</option><option>Archives (years) Dropdown</option><option>Blogroll</option><option>Blogroll Dropdown</option>';}
						if (get_option('suckerfish_menuitem4') == 'Archives (years) Dropdown') {echo '<option>Archives (years) Dropdown</option><option>None</option><option>Home</option><option>Pages</option><option>Pages Dropdown</option><option>Categories</option><option>Categories Dropdown</option><option>Archives (months)</option><option>Archives (months) Dropdown</option><option>Archives (years)</option><option>Blogroll</option><option>Blogroll Dropdown</option>';}
						if (get_option('suckerfish_menuitem4') == 'Blogroll') {echo '<option>Blogroll</option><option>None</option><option>Home</option><option>Pages</option><option>Pages Dropdown</option><option>Categories</option><option>Categories Dropdown</option><option>Archives (months)</option><option>Archives (months) Dropdown</option><option>Archives (years)</option><option>Archives (years) Dropdown</option><option>Blogroll Dropdown</option>';}
						if (get_option('suckerfish_menuitem4') == 'Blogroll Dropdown') {echo '<option>Blogroll Dropdown</option><option>None</option><option>Home</option><option>Pages</option><option>Pages Dropdown</option><option>Categories</option><option>Categories Dropdown</option><option>Archives (months)</option><option>Archives (months) Dropdown</option><option>Archives (years)</option><option>Archives (years) Dropdown</option><option>Blogroll</option>';}
					 ?>
				</select>
			</div>
			<div class="menuitems">
				<label>Menu Item #5</label>
				<select name="suckerfish_menuitem5">
					<?php
						if (get_option('suckerfish_menuitem5') == 'None') {echo '<option>None</option><option>Home</option><option>Pages</option><option>Pages Dropdown</option><option>Categories</option><option>Categories Dropdown</option><option>Archives (months)</option><option>Archives (months) Dropdown</option><option>Archives (years)</option><option>Archives (years) Dropdown</option><option>Blogroll</option><option>Blogroll Dropdown</option>';}
						if (get_option('suckerfish_menuitem5') == 'Home') {echo '<option>Home</option><option>None</option><option>Pages</option><option>Pages Dropdown</option><option>Categories</option><option>Categories Dropdown</option><option>Archives (months)</option><option>Archives (months) Dropdown</option><option>Archives (years)</option><option>Archives (years) Dropdown</option><option>Blogroll</option><option>Blogroll Dropdown</option>';}
						if (get_option('suckerfish_menuitem5') == 'Pages') {echo '<option>Pages</option><option>None</option><option>Home</option><option>Pages Dropdown</option><option>Categories</option><option>Categories Dropdown</option><option>Archives (months)</option><option>Archives (months) Dropdown</option><option>Archives (years)</option><option>Archives (years) Dropdown</option><option>Blogroll</option><option>Blogroll Dropdown</option>';}
						if (get_option('suckerfish_menuitem5') == 'Pages Dropdown') {echo '<option>Pages Dropdown</option><option>None</option><option>Home</option><option>Pages</option><option>Categories</option><option>Categories Dropdown</option><option>Archives (months)</option><option>Archives (months) Dropdown</option><option>Archives (years)</option><option>Archives (years) Dropdown</option><option>Blogroll</option><option>Blogroll Dropdown</option>';}
						if (get_option('suckerfish_menuitem5') == 'Categories') {echo '<option>Categories</option><option>None</option><option>Home</option><option>Pages</option><option>Pages Dropdown</option><option>Categories Dropdown</option><option>Archives (months)</option><option>Archives (months) Dropdown</option><option>Archives (years)</option><option>Archives (years) Dropdown</option><option>Blogroll</option><option>Blogroll Dropdown</option>';}
						if (get_option('suckerfish_menuitem5') == 'Categories Dropdown') {echo '<option>Categories Dropdown</option><option>None</option><option>Home</option><option>Pages</option><option>Pages Dropdown</option><option>Categories</option><option>Archives (months)</option><option>Archives (months) Dropdown</option><option>Archives (years)</option><option>Archives (years) Dropdown</option><option>Blogroll</option><option>Blogroll Dropdown</option>';}
						if (get_option('suckerfish_menuitem5') == 'Archives (months)') {echo '<option>Archives (months)</option><option>None</option><option>Home</option><option>Pages</option><option>Pages Dropdown</option><option>Categories</option><option>Categories Dropdown</option><option>Archives (years)</option><option>Archives (months) Dropdown</option><option>Archives (years) Dropdown</option><option>Blogroll</option><option>Blogroll Dropdown</option>';}
						if (get_option('suckerfish_menuitem5') == 'Archives (years)') {echo '<option>Archives (years)</option><option>None</option><option>Home</option><option>Pages</option><option>Pages Dropdown</option><option>Categories</option><option>Categories Dropdown</option><option>Archives (months)</option><option>Archives (months) Dropdown</option><option>Archives (years) Dropdown</option><option>Blogroll</option><option>Blogroll Dropdown</option>';}
						if (get_option('suckerfish_menuitem5') == 'Archives (months) Dropdown') {echo '<option>Archives (months) Dropdown</option><option>None</option><option>Home</option><option>Pages</option><option>Pages Dropdown</option><option>Categories</option><option>Categories Dropdown</option><option>Archives (months)</option><option>Archives (years)</option><option>Archives (years) Dropdown</option><option>Blogroll</option><option>Blogroll Dropdown</option>';}
						if (get_option('suckerfish_menuitem5') == 'Archives (years) Dropdown') {echo '<option>Archives (years) Dropdown</option><option>None</option><option>Home</option><option>Pages</option><option>Pages Dropdown</option><option>Categories</option><option>Categories Dropdown</option><option>Archives (months)</option><option>Archives (months) Dropdown</option><option>Archives (years)</option><option>Blogroll</option><option>Blogroll Dropdown</option>';}
						if (get_option('suckerfish_menuitem5') == 'Blogroll') {echo '<option>Blogroll</option><option>None</option><option>Home</option><option>Pages</option><option>Pages Dropdown</option><option>Categories</option><option>Categories Dropdown</option><option>Archives (months)</option><option>Archives (months) Dropdown</option><option>Archives (years)</option><option>Archives (years) Dropdown</option><option>Blogroll Dropdown</option>';}
						if (get_option('suckerfish_menuitem5') == 'Blogroll Dropdown') {echo '<option>Blogroll Dropdown</option><option>None</option><option>Home</option><option>Pages</option><option>Pages Dropdown</option><option>Categories</option><option>Categories Dropdown</option><option>Archives (months)</option><option>Archives (months) Dropdown</option><option>Archives (years)</option><option>Archives (years) Dropdown</option><option>Blogroll</option>';}
					 ?>
				</select>
			</div>
			<div class="menuitems">
				<label>Menu Item #6</label>
				<select name="suckerfish_menuitem6">
					<?php
						if (get_option('suckerfish_menuitem6') == 'None') {echo '<option>None</option><option>Home</option><option>Pages</option><option>Pages Dropdown</option><option>Categories</option><option>Categories Dropdown</option><option>Archives (months)</option><option>Archives (months) Dropdown</option><option>Archives (years)</option><option>Archives (years) Dropdown</option><option>Blogroll</option><option>Blogroll Dropdown</option>';}
						if (get_option('suckerfish_menuitem6') == 'Home') {echo '<option>Home</option><option>None</option><option>Pages</option><option>Pages Dropdown</option><option>Categories</option><option>Categories Dropdown</option><option>Archives (months)</option><option>Archives (months) Dropdown</option><option>Archives (years)</option><option>Archives (years) Dropdown</option><option>Blogroll</option><option>Blogroll Dropdown</option>';}
						if (get_option('suckerfish_menuitem6') == 'Pages') {echo '<option>Pages</option><option>None</option><option>Home</option><option>Pages Dropdown</option><option>Categories</option><option>Categories Dropdown</option><option>Archives (months)</option><option>Archives (months) Dropdown</option><option>Archives (years)</option><option>Archives (years) Dropdown</option><option>Blogroll</option><option>Blogroll Dropdown</option>';}
						if (get_option('suckerfish_menuitem6') == 'Pages Dropdown') {echo '<option>Pages Dropdown</option><option>None</option><option>Home</option><option>Pages</option><option>Categories</option><option>Categories Dropdown</option><option>Archives (months)</option><option>Archives (months) Dropdown</option><option>Archives (years)</option><option>Archives (years) Dropdown</option><option>Blogroll</option><option>Blogroll Dropdown</option>';}
						if (get_option('suckerfish_menuitem6') == 'Categories') {echo '<option>Categories</option><option>None</option><option>Home</option><option>Pages</option><option>Pages Dropdown</option><option>Categories Dropdown</option><option>Archives (months)</option><option>Archives (months) Dropdown</option><option>Archives (years)</option><option>Archives (years) Dropdown</option><option>Blogroll</option><option>Blogroll Dropdown</option>';}
						if (get_option('suckerfish_menuitem6') == 'Categories Dropdown') {echo '<option>Categories Dropdown</option><option>None</option><option>Home</option><option>Pages</option><option>Pages Dropdown</option><option>Categories</option><option>Archives (months)</option><option>Archives (months) Dropdown</option><option>Archives (years)</option><option>Archives (years) Dropdown</option><option>Blogroll</option><option>Blogroll Dropdown</option>';}
						if (get_option('suckerfish_menuitem6') == 'Archives (months)') {echo '<option>Archives (months)</option><option>None</option><option>Home</option><option>Pages</option><option>Pages Dropdown</option><option>Categories</option><option>Categories Dropdown</option><option>Archives (years)</option><option>Archives (months) Dropdown</option><option>Archives (years) Dropdown</option><option>Blogroll</option><option>Blogroll Dropdown</option>';}
						if (get_option('suckerfish_menuitem6') == 'Archives (years)') {echo '<option>Archives (years)</option><option>None</option><option>Home</option><option>Pages</option><option>Pages Dropdown</option><option>Categories</option><option>Categories Dropdown</option><option>Archives (months)</option><option>Archives (months) Dropdown</option><option>Archives (years) Dropdown</option><option>Blogroll</option><option>Blogroll Dropdown</option>';}
						if (get_option('suckerfish_menuitem6') == 'Archives (months) Dropdown') {echo '<option>Archives (months) Dropdown</option><option>None</option><option>Home</option><option>Pages</option><option>Pages Dropdown</option><option>Categories</option><option>Categories Dropdown</option><option>Archives (months)</option><option>Archives (years)</option><option>Archives (years) Dropdown</option><option>Blogroll</option><option>Blogroll Dropdown</option>';}
						if (get_option('suckerfish_menuitem6') == 'Archives (years) Dropdown') {echo '<option>Archives (years) Dropdown</option><option>None</option><option>Home</option><option>Pages</option><option>Pages Dropdown</option><option>Categories</option><option>Categories Dropdown</option><option>Archives (months)</option><option>Archives (months) Dropdown</option><option>Archives (years)</option><option>Blogroll</option><option>Blogroll Dropdown</option>';}
						if (get_option('suckerfish_menuitem6') == 'Blogroll') {echo '<option>Blogroll</option><option>None</option><option>Home</option><option>Pages</option><option>Pages Dropdown</option><option>Categories</option><option>Categories Dropdown</option><option>Archives (months)</option><option>Archives (months) Dropdown</option><option>Archives (years)</option><option>Archives (years) Dropdown</option><option>Blogroll Dropdown</option>';}
						if (get_option('suckerfish_menuitem6') == 'Blogroll Dropdown') {echo '<option>Blogroll Dropdown</option><option>None</option><option>Home</option><option>Pages</option><option>Pages Dropdown</option><option>Categories</option><option>Categories Dropdown</option><option>Archives (months)</option><option>Archives (months) Dropdown</option><option>Archives (years)</option><option>Archives (years) Dropdown</option><option>Blogroll</option>';}
					 ?>
				</select>
			</div>
		</p>

		<h2>Keyboard Accessibility</h2>
		<p>
			This option enables users to access your menu via the tab key on their keyboard rather than the mouse.
			This works in all modern browsers, plus IE 6 and 7. Choosing this option will add ~3 kB to each page download.
		</p>
		<p>
			<label>Enable keyboard accessible menu?</label>
			<?php
				if (get_option('suckerfish_keyboard') == 'on') {echo '<input type="checkbox" name="suckerfish_keyboard" checked="yes" />';}
				else {echo '<input type="checkbox" name="suckerfish_keyboard" />';}
			?>
		</p>

		<input type="hidden" name="action" value="update" />
		<input type="hidden" name="page_options" value="suckerfish_css, suckerfish_menuitem1, suckerfish_menuitem2, suckerfish_menuitem3, suckerfish_menuitem4, suckerfish_menuitem5, suckerfish_menuitem6, suckerfish_keyboard" />
		<div style="clear:both;padding-top:20px;"></div>
		<p class="submit"><input type="submit" name="Submit" value="<?php _e('Update Options') ?>" /></p>
		<div style="clear:both;padding-top:20px;"></div>

		<h2>Installation</h2>
		<p>Add the following code wherever you want the dropdown to appear in your theme (usually header.php)</p>
		<p><code>&lt;?php suckerfish(); ?&gt;</code></p>
		<p>
			Note, that the functions which were implemented in previous version of this plugin still work. But you can not
			modify them via this admin panel. To change the menu contents, you must change your suckerfish1(), suckerfish(2),
			suckerfish(3), suckerfish(4) or suckerfish(5) function in your theme to suckerfish().
		</p>
		<h2>Help</h2>
		<p>
			For help with the plugin, please visit the <a href="http://ryanhellyer.net/2008/01/14/suckerfish-wordpress-plugin/">Suckerfish WordPress Plugin page</a>.
		</p>
	</form>
</div>
<?php } ?>
