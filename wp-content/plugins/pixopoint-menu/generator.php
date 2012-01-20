<?php
/*
	This file is used to control the CSS generating system/editing panel

	PixoPoint Menu Plugin
	Copyright (c) 2009 PixoPoint Web Development

	This program is free software; you can redistribute it and/or modify
	it under the terms of the GNU General Public License as
	published by the Free Software Foundation.

	This program is distributed in the hope that it will be useful,
	but WITHOUT ANY WARRANTY; without even the implied warranty of
	MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.
*/


require_once(ABSPATH . '/wp-includes/pluggable.php'); // Needed to add this to get the nonce to work (via @anthonycole)
// Sets a bunch of stuff before editing panel is loaded. Some of this needs to be at the start to ensure that the initial page loads with data in it rather than blank the first time ... this was the worlds most annoying bug to fix - took me flipping ages to find it !!!
// @Ryan - Need better code comments for the next four lines. You can barely understand it so how the hell is anyone else going to?

// Save the current setup to the database
if (isset($_POST['save']) && wp_verify_nonce($_REQUEST['_wpnonce'], 'pxp_form')) {
	if ($_REQUEST['pixopointidentification'] == get_option('suckerfish_identification')) {
		require('save.php');
	}
}
if ($_REQUEST['saved'] != '') {update_option('pixo_saved', $_REQUEST['saved']);} // REQUEST specifies new saved value, then reset database
add_option('suckerfish_save', 'menu1_height=35|menu1_background_image=../images/dazzle_red.png|menu1_background_colour=#B41520|menu1_wrapperwidth=100|menu1_percent_wrapperwidth=%|menu1_containerwidth=100|menu1_percent_containerwidth=%|menu1_alignment=left|menu1_background_buttoncolour=#B41520|menu1_background_buttonimage=../images/dazzle_red.png|menu1_backgroundhovercolour=#D43843|menu1_graphicalhover=on|menu1_button_betweenpadding=0|menu1_button_withinpadding=12|menu1_fontfamily=tahoma,sans-serif|menu1_fontsize=14|menu1_fontweight=on|menu1_fontitalics=off|menu1_links_underline=Never underlined|menu1_texttransform=|menu1_letter_spacing_spacing=0|menu1_colour=#FFFFFF|menu1_hovercolour=#FFFFFF|menu1_dropdown_fontfamily=helvetica,arial,sans-serif|menu1_dropdown_textcolour=#444444|menu1_dropdown_texthovercolour=#FFFFFF|menu1_dropdown_backgroundcolour=#FFFFFF|menu1_dropdown_backgroundhovercolour=#B41520|menu1_dropdown_width=130|menu1_dropdown_opacity=100|menu1_dropdown_paddingvertical=6|menu1_dropdown_paddinghorizontal=8|menu1_shadow_width=12|menu1_dropdown_fontsize=11|menu1_dropdown_bold=off|menu1_dropdown_italics=off|menu1_dropdown_texttransform=|menu1_letter-spacing=0|menu1_dropdown_underline=Never underlined|menu1_dropdown_borderwidth=1|menu1_dropdown_bordercolour=#999999|menu2_height=25|menu2_background_image=../images/smoothfade_palered.png|menu2_background_colour=#FF5050|menu2_wrapperwidth=100|menu2_percent_wrapperwidth=%|menu2_containerwidth=100|menu2_percent_containerwidth=%|menu2_alignment=left|menu2_background_buttoncolour=#FF5050|menu2_background_buttonimage=../images/smoothfade_palered.png|menu2_backgroundhovercolour=#e92020|menu2_graphicalhover=off|menu2_button_betweenpadding=0|menu2_button_withinpadding=8|menu2_fontfamily=helvetica,arial,sans-serif|menu2_fontsize=12|menu2_fontweight=off|menu2_fontitalics=off|menu2_links_underline=Never underlined|menu2_texttransform=uppercase|menu2_letter_spacing_spacing=0|menu2_colour=#FFFFFF|menu2_hovercolour=#FFFFFF|menu2_dropdown_fontfamily=helvetica,arial,sans-serif|menu2_dropdown_textcolour=#444444|menu2_dropdown_texthovercolour=#444444|menu2_dropdown_backgroundcolour=#fcfcfc|menu2_dropdown_backgroundhovercolour=#dedede|menu2_dropdown_width=130|menu2_dropdown_opacity=100|menu2_dropdown_paddingvertical=6|menu2_dropdown_paddinghorizontal=8|menu2_shadow_width=12|menu2_dropdown_fontsize=11|menu2_dropdown_bold=off|menu2_dropdown_italics=off|menu2_dropdown_texttransform=|menu2_letter-spacing=0|menu2_dropdown_underline=Never underlined|menu2_dropdown_borderwidth=1|menu2_dropdown_bordercolour=#999999|'); // Adds saved data to option
add_option('pixo_saved', 'new'); // Sets the entry number to 'new' so that pixopoint.com knows to load a new setup for this site


// Load scripts via enqueue
wp_register_script('tabber-init', $javascript_location.'tabber-init.js','', '1.0'); // Tabber settings
wp_register_script('tabber', $javascript_location.'tabber-minimized.js', array('tabber-init'), '1.9'); // Tabber script
wp_register_script('jquery_farbtastic', $javascript_location.'farbtastic.js',array('jquery'), '1.2'); // Farbatastic - colour wheel
wp_register_script('simpletip', $javascript_location.'jquery.simpletip-1.3.1.pack.js', array('jquery'), '1.3.1'); // Tooltip
wp_register_script('init_pixopoint_menu', $javascript_location.'init_pixopoint_menu.js',array('simpletip','jquery_farbtastic'), '1.0'); // Init settings
wp_register_script('styleswitcher', $javascript_location.'styleswitcher.js','', '1.0'); // Stylesheet switcher - for Basic/Premium button


// Print scripts plus CSS files to header
add_action('wp_print_scripts', 'pixopoint_menu_header');
function pixopoint_menu_header() {global $pixopoint_codingengine;
	if (!is_admin() AND current_user_can('manage_options')) {
		wp_enqueue_script('styleswitcher');
		wp_enqueue_script('tabber');
		wp_enqueue_script('simpletip');
		wp_enqueue_script('init_pixopoint_menu');
		wp_enqueue_script('jquery-ui-core');
		wp_enqueue_script('jquery-ui-dialog');

		// Loads the jQuery stylesheet - temporary solution. Custom CSS will eventually be written but needed this up ASAP as was running out of time.
		echo '<link rel="stylesheet" href="http://jqueryui.com/latest/themes/base/ui.all.css" />';
		// Loads regular stylesheet when first loaded (when pixo_saved is 'new') but loads from pixopoint.com the rest of the time.
		if (get_option('pixo_saved') == 'new') {echo '<link rel="stylesheet" type="text/css" href="'.WP_PLUGIN_URL.'/pixopoint-menu/css/style.php" />';}
		else {echo '<link rel="stylesheet" href="'.$pixopoint_codingengine.'style.php?id='.wp_kses( get_option('pixo_saved'), '', '' ).'" media="screen" />';}
		?>
		<link rel="stylesheet" type="text/css" href="<?php echo WP_PLUGIN_URL; ?>/pixopoint-menu/css/editor.css" />
		<link rel="<?php if (get_option('pixo_password') == 'correct') { ?>alternate <?php } ?>stylesheet" type="text/css" href="<?php echo WP_PLUGIN_URL; ?>/pixopoint-menu/css/editor_premium.css" title="premium" />
		<?php if (get_option('pixo_password') == 'correct') { ?><style type="text/css">.premium input, .premium option, .premium {background:#fff} .basicoff {display:none;}</style><?php }
	}
}


// Adds content to header
add_action('wp_head', 'pixopoint_menu_head');
function pixopoint_menu_head() {global $variable,$pixopoint_menu_version,$pixopoint_codingengine;


	// Buffer the data chunks
	ob_start();
	if (isset($_POST['open'])&& wp_verify_nonce($_REQUEST['_wpnonce'], 'pxp_form')) {echo wp_kses( get_option('suckerfish_save'), '', '' );} // load saved design

	// Loads the correct data when using the 'save' tool
	elseif ($variable['designsaved'] == 'yes') {echo wp_kses( get_option('suckerfish_save'), '', '' );} // Load first menu



	//  NEED TO USE THE FOLLOWING FUNCTION I NHERE, WILL BE ADDED TO FUTURE VERSIONS http://us.php.net/manual/en/function.is-readable.php          is_readable


	// Load Nature
	elseif (isset($_POST['nature'])&& wp_verify_nonce($_REQUEST['_wpnonce'], 'pxp_form')) {$variable['confirmloading'] = 'Nature';readfile($pixopoint_codingengine.'data.php?id='.wp_kses( get_option('pixo_saved'), '', '' ));require('designs/nature.php');} // Load first menu
	elseif (isset($_POST['nature2'])&& wp_verify_nonce($_REQUEST['_wpnonce'], 'pxp_form')) {$variable['confirmloading'] = 'Nature';readfile($pixopoint_codingengine.'data.php?id='.wp_kses( get_option('pixo_saved'), '', '' ));require('designs/nature2.php');} // Load second menu

	// Load Bland grey
	elseif (isset($_POST['blandgrey'])&& wp_verify_nonce($_REQUEST['_wpnonce'], 'pxp_form')) {$variable['confirmloading'] = 'Bland Grey';readfile($pixopoint_codingengine.'data.php?id='.wp_kses( get_option('pixo_saved'), '', '' ));require('designs/blandgrey.php');} // Load first menu
	elseif (isset($_POST['blandgrey2'])&& wp_verify_nonce($_REQUEST['_wpnonce'], 'pxp_form')) {$variable['confirmloading'] = 'Bland Grey';readfile($pixopoint_codingengine.'data.php?id='.wp_kses( get_option('pixo_saved'), '', '' ));require('designs/blandgrey2.php');} // Load second menu

	// Load Blue berry
	elseif (isset($_POST['blueberry'])&& wp_verify_nonce($_REQUEST['_wpnonce'], 'pxp_form')) {$variable['confirmloading'] = 'Blue berry';readfile($pixopoint_codingengine.'data.php?id='.wp_kses( get_option('pixo_saved'), '', '' ));require('designs/blueberry.php');} // Load first menu
	elseif (isset($_POST['blueberry2'])&& wp_verify_nonce($_REQUEST['_wpnonce'], 'pxp_form')) {$variable['confirmloading'] = 'Blue berry';readfile($pixopoint_codingengine.'data.php?id='.wp_kses( get_option('pixo_saved'), '', '' ));require('designs/blueberry2.php');} // Load second menu

	// Load Bland Red
	elseif (isset($_POST['blandred'])&& wp_verify_nonce($_REQUEST['_wpnonce'], 'pxp_form')) {$variable['confirmloading'] = 'Bland Red';readfile($pixopoint_codingengine.'data.php?id='.wp_kses( get_option('pixo_saved'), '', '' ));require('designs/blandred.php');} // Load first menu
	elseif (isset($_POST['blandred2'])&& wp_verify_nonce($_REQUEST['_wpnonce'], 'pxp_form')) {$variable['confirmloading'] = 'Bland Red';readfile($pixopoint_codingengine.'data.php?id='.wp_kses( get_option('pixo_saved'), '', '' ));require('designs/blandred2.php');} // Load second menu

	// Load Red Dazzle
	elseif (isset($_POST['reddazzle'])&& wp_verify_nonce($_REQUEST['_wpnonce'], 'pxp_form')) {$variable['confirmloading'] = 'Red Dazzle';readfile($pixopoint_codingengine.'data.php?id='.wp_kses( get_option('pixo_saved'), '', '' ));require('designs/reddazzle.php');} // Load first menu
	elseif (isset($_POST['reddazzle2'])&& wp_verify_nonce($_REQUEST['_wpnonce'], 'pxp_form')) {$variable['confirmloading'] = 'Red Dazzle';readfile($pixopoint_codingengine.'data.php?id='.wp_kses( get_option('pixo_saved'), '', '' ));require('designs/reddazzle2.php');} // Load second menu

	// Load Corporate Black
	elseif (isset($_POST['corporateblack'])&& wp_verify_nonce($_REQUEST['_wpnonce'], 'pxp_form')) {$variable['confirmloading'] = 'Corporate Black';readfile($pixopoint_codingengine.'data.php?id='.wp_kses( get_option('pixo_saved'), '', ''));require('designs/corporateblack.php');} // Load first menu
	elseif (isset($_POST['corporateblack2'])&& wp_verify_nonce($_REQUEST['_wpnonce'], 'pxp_form')) {$variable['confirmloading'] = 'Corporate Black';readfile($pixopoint_codingengine.'data.php?id='.wp_kses( get_option('pixo_saved'), '', ''));require('designs/corporateblack2.php');} // Load second menu

	elseif (get_option('pixo_saved') == 'new') {echo wp_kses( get_option('suckerfish_save'), '', '' );} // If new then load default template
	elseif (wp_verify_nonce($_REQUEST['_wpnonce'], 'pxp_form')) {readfile($pixopoint_codingengine.'data.php?id='.wp_kses( get_option('pixo_saved'), '', '' ));} // else load from external server
	$chunks = ob_get_contents(); // Add data into variable
	$chunks = str_replace('../images/', WP_PLUGIN_URL.'/pixopoint-menu/images/', $chunks); // Converts ../ to the full URL (so the images don't need to be hosted on PixoPoint.com)
	ob_end_clean();

	// Process the data chunks
	$chunks = explode("|", $chunks); // Split data into chunks
	foreach ($chunks as $key => $value) { // Process each chunk
		$data = explode("=", $value); // Seperate chunks into variables and results
		foreach ($data as $key2 => $value2) {
			if ($a == 1) { // only process every second one (coz they come in two's)
				$temp2 = $data[$key2-1]; // coz can't stick array inside another array
				$variable[$temp2] = $data[$key2]; // Set variables
			}
			$a = $a + 1;if ($a == 2) {$a = 0;} // so only process every second one
		}
	}

	// If no number is set, then specify one in the WP database
	if (get_option('pixo_saved') == '' AND $variable['saved'] == '') {add_option('pixo_saved', 'new');}
	if ($variable['saved'] != '') {update_option('pixo_saved', $variable['saved']);}
	$variable['saved'] = wp_kses( get_option('pixo_saved'), '', '' );

	// If pass was correct, then marks this in database so it doesn't need to be sent every time (PixoPoint will just check the username and some other specs first)
	if ($variable['password'] == 'correct') {update_option('pixo_password', 'correct');}
	else {update_option('pixo_password', '');}

	// Get current URL (minus 'saved' sent via $_REQUEST)
	$variable['currenturl'] = 'http' . ((!empty($_SERVER['HTTPS'])) ? 's' : '') . '://'.$_SERVER['SERVER_NAME'].$_SERVER['REQUEST_URI'];
	$variable['currenturl'] = str_replace('?saved='.$_REQUEST['saved'], '', $variable['currenturl']);
}


// Adds editor to footer
add_action('wp_footer', 'pixopoint_menu_editor');
function pixopoint_menu_editor() {global $variable,$pixopoint_menu_version,$pixopoint_codingengine,$pixopoint_menu_images;
	if (current_user_can('manage_options')) {require('editor.php');} // only load for admins
}


?>
