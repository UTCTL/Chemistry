<?php
/*
	This file loads the menu content order for admin_page.php using Ajax. This should probably be done with basic javascript rather than javascript.

	PixoPoint Menu Plugin
	Copyright (c) 2009 PixoPoint Web Development

	This program is free software; you can redistribute it and/or modify
	it under the terms of the GNU General Public License as
	published by the Free Software Foundation.

	This program is distributed in the hope that it will be useful,
	but WITHOUT ANY WARRANTY; without even the implied warranty of
	MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.
*/

foreach ($_GET['listItem'] as $position => $item) :
	$temp = $temp.$item.'='.$position.'|';
endforeach;

$temp = '<input type="hidden" name="suckerfish_menucontents" type="text" value="'.$temp.'" />';

print_r ($temp);

?>