<?php
/*
	This file loads the Superfish Settings

	PixoPoint Menu Plugin
	Copyright (c) 2009 PixoPoint Web Development

	This program is free software; you can redistribute it and/or modify
	it under the terms of the GNU General Public License version 2 as
	published by the Free Software Foundation.

	This program is distributed in the hope that it will be useful,
	but WITHOUT ANY WARRANTY; without even the implied warranty of
	MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.
*/

// Thanks to Andrew Rickman for suggesting wp-load.php instead of wp-blog-header.php ... http://www.wp-fun.co.uk/fun-with-widget-structures-01-beta/
require_once("../../../../wp-load.php");
header("Cache-Control: public");
header("Pragma: cache");
header("Expires: ".gmdate("D, d M Y H:i:s", time() + 60*60*24*365)." GMT");// cache for one year
header("Last-Modified: ".gmdate("D, d M Y H:i:s", filemtime($_SERVER['SCRIPT_FILENAME']))." GMT");
header('Content-Type: text/javascript');

echo 'jQuery(document).ready(function() {
	jQuery("ul.sf-menu").superfish({
		animation:     {opacity:"show",height:"show"},  // fade-in and slide-down animation';

/*
if (get_option('suckerfish_delay') == 'on') {echo '
		delay:         1000,  // the delay in milliseconds that the mouse can remain outside a submenu without it closing';
}
*/

echo '
		delay:        ' . wp_kses( get_option('suckerfish_delay'), '', '' ) . ',                            // delay on mouseout
		speed:        ';

if (get_option('suckerfish_superfish_speed') == 'instant') {echo '1';}
else {echo '"'.wp_kses( get_option('suckerfish_superfish_speed'), '', '' ).'"';}

echo ',  // animation speed
		autoArrows:   "'.wp_kses( get_option('suckerfish_superfish_arrows'), '', '' ).'",  // enable generation of arrow mark-up
		dropShadows:  "'.wp_kses( get_option('suckerfish_superfish_shadows'), '', '' ).'"  // enable drop shadows
	});
});';
?>