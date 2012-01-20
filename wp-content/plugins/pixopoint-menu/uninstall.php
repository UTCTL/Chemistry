<?php
/*
	This file deletes all of the data stored in the database - used by uninstall script

	PixoPoint Menu Plugin
	Copyright (c) 2009 PixoPoint Web Development

	This program is free software; you can redistribute it and/or modify
	it under the terms of the GNU General Public License as
	published by the Free Software Foundation.

	This program is distributed in the hope that it will be useful,
	but WITHOUT ANY WARRANTY; without even the implied warranty of
	MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.
*/


// Following line of code is needed for security purposes. Prevents outsiders from running the script.
if (!defined('ABSPATH') && !defined('WP_UNINSTALL_PLUGIN')) {exit();}

// PixoPoint Menu Advanced Addon
delete_option('suckerfish_customfields');

// Everything else
delete_option('suckerfish_css');
delete_option('suckerfish_superfish');
delete_option('suckerfish_superfish_speed');
delete_option('suckerfish_superfish_time');
delete_option('suckerfish_superfish_timeout');
delete_option('suckerfish_pagestitle');
delete_option('suckerfish_keyboard');
delete_option('suckerfish_excludepages');
delete_option('suckerfish_excludecategories');
delete_option('suckerfish_hometitle');
delete_option('suckerfish_pagestitle');
delete_option('suckerfish_categoriestitle');
delete_option('suckerfish_archivestitle');
delete_option('suckerfish_blogrolltitle');
delete_option('suckerfish_recentcommentstitle');
delete_option('suckerfish_recentpoststitle');
delete_option('suckerfish_disablecss');
delete_option('suckerfish_custommenu');
delete_option('suckerfish_custommenu2');
delete_option('suckerfish_custommenu3');
delete_option('suckerfish_custommenu4');
delete_option('suckerfish_inlinecss');
delete_option('suckerfish_includeexcludepages');
delete_option('suckerfish_2_css');
delete_option('suckerfish_2_pagestitle');
delete_option('suckerfish_2_excludepages');
delete_option('suckerfish_2_excludecategories');
delete_option('suckerfish_2_hometitle');
delete_option('suckerfish_2_pagestitle');
delete_option('suckerfish_2_categoriestitle');
delete_option('suckerfish_2_archivestitle');
delete_option('suckerfish_2_blogrolltitle');
delete_option('suckerfish_2_recentcommentstitle');
delete_option('suckerfish_2_disablecss');
delete_option('suckerfish_2_custommenu');
delete_option('suckerfish_2_custommenu2');
delete_option('suckerfish_2_inlinecss');
delete_option('suckerfish_2_includeexcludepages');
delete_option('suckerfish_generator');
delete_option('suckerfish_delay');
delete_option('suckerfish_superfish_shadows');
delete_option('suckerfish_superfish_arrows');
delete_option('suckerfish_showdelay');
delete_option('suckerfish_displaycss');
delete_option('suckerfish_secondmenu');
delete_option('suckerfish_superfish_delaymouseover');
delete_option('suckerfish_superfish_hoverintent');
delete_option('suckerfish_superfish_sensitivity');
delete_option('pixopoint_menu_maintenance');
delete_option('suckerfish_categoryorder');
delete_option('suckerfish_pageorder');
delete_option('suckerfish_homeurl');
delete_option('suckerfish_pagesurl');
delete_option('suckerfish_categoriesurl');
delete_option('suckerfish_archivesurl');
delete_option('suckerfish_blogrollurl');
delete_option('suckerfish_recentcommentsurl');
delete_option('suckerfish_recentpostsurl');
delete_option('suckerfish_depthcategories');
delete_option('suckerfish_depthpages');
delete_option('suckerfish_categorycount');
delete_option('suckerfish_categoryshowempty');
delete_option('suckerfish_delay');
delete_option('suckerfish_titletags');
delete_option('suckerfish_recentpostsnumber');
delete_option('suckerfish_recentcommentsnumber');
delete_option('suckerfish_cache');
delete_option('suckerfish_menucontents');
delete_option('suckerfish_save');
delete_option('pixo_saved');
delete_option('suckerfish_pages_singledropdown');
delete_option('suckerfish_categories_singledropdown');
delete_option('suckerfish_identification');
delete_option('suckerfish_archivesdropdown');
delete_option('suckerfish_archivesperiod');
delete_option('suckerfish_linkscategorized');
delete_option('suckerfish_linksdropdown');
delete_option('suckerfish_categories_showchildposts');
delete_option('suckerfish_editingpane');
delete_option('suckerfish_css_extra');
delete_option('suckerfish_searchalignment');
delete_option('suckerfish_themesupport');
delete_option('suckerfish_customfields');
delete_option('pixo_password');
delete_option('suckerfish_includeexcludecategories');
delete_option('suckerfish_pagesnoparentlinks');

// Goodbye, I wonder why they uninstalled it?

?>