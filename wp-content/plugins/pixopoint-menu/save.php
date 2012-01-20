<?php
/*
	This file is used to save the design from the editing panel into the database

	PixoPoint Menu Plugin
	Copyright (c) 2009 PixoPoint Web Development

	This program is free software; you can redistribute it and/or modify
	it under the terms of the GNU General Public License as
	published by the Free Software Foundation.

	This program is distributed in the hope that it will be useful,
	but WITHOUT ANY WARRANTY; without even the implied warranty of
	MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.
*/


// Buffer the data
ob_start();
readfile($pixopoint_codingengine.'/data.php?id='.wp_kses( get_option('pixo_saved'), '', '' )); // load from external server
$thedata = ob_get_contents(); // Add data into variable
ob_end_clean();


// Buffer the CSS
ob_start();
readfile($pixopoint_codingengine.'/style.php?id='.wp_kses( get_option('pixo_saved'), '', '' )); // load from external server
$css = ob_get_contents(); // Add data into variable
ob_end_clean();


// Update CSS in database
update_option('suckerfish_save', $thedata);
$css = explode("/*SEPERATOR BETWEEN CSS*/", $css); // Split css into chunks
update_option('suckerfish_css',$css[0]); // Adds main menu CSS to database
update_option('suckerfish_2_css',$css[1]); // Adds second menu CSS to database


// Used to make sure the data is loaded from the saved source
$variable['designsaved'] = 'yes';


?>
