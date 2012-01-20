<?php
/*
	This file loads the style sheet

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
header('Content-Type: text/css; charset='.get_option('blog_charset').'');


echo '
/*********************************************************
 ****** CSS generated via the PixoPoint Menu Plugin ******
 ********** http://pixopoint.com/pixopoint-menu/ *********
 *********************************************************/



'.wp_kses( get_option('suckerfish_css'), '', '' );

if (get_option('suckerfish_2_css') != '') {echo wp_kses( get_option('suckerfish_2_css'), '', '' );}
if (get_option('suckerfish_css_extra') != '') {echo '

/*********************************
*********** Extra CSS ************
**********************************/

'.wp_kses( get_option('suckerfish_css_extra'), '', '' );}

?>