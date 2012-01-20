<?php
/*
	This file loads the admin page

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
 ************************************************************
 *** Adds a new submenu under Options in the admin panel ****
 ************************************************************
 ************************************************************/
add_action('admin_menu', 'show_suckerfish_options');
function show_suckerfish_options() {

	// Add various options for admin page
	$page = add_options_page('PixoPoint Menu Plugin Options', 'PixoPoint Menu', 8, 'pixopointmenuoptions', 'suckerfish_options');
	add_action( "admin_print_scripts-$page", 'suckerfish_adminhead' );
	add_option('suckerfish_css', '#pixopoint_menu1 {
	width:100%;
	height:35px;
	background:#B41520 url("../images/dazzle_red.png") repeat-x;
	background-position:50% 0;
	margin:0;}
#pixopoint_menu1 ul {
	width:100%;
	border:none;
	background:none;
	margin:0;
	padding:0;
	list-style:none;
	}
#pixopoint_menu1 li {
	border:none;
	background:none;
	background:#B41520 url("../images/dazzle_red.png");
	color:#FFFFFF;
	line-height:35px;
	z-index:20;
	letter-spacing:0px;
	background:;
	font-weight:bold;
	font-size:14px;
	padding:0;
	margin:0 0px;
	;float:left;
	font-family:tahoma,sans-serif;
	position:relative;
	}
#pixopoint_menu1 li:hover,#pixopoint_menu1 li.sfhover {
	background:#D43843 url("../images/dazzle_red.png");
	background-position:0 60px;
	}
#pixopoint_menu1 li a {
	border:none;
	background:none;
	text-decoration:none;
	display:block;
	padding:0 12px;
	color:#FFFFFF;
	}
#pixopoint_menu1 li a:hover {
	border:none;
	background:none;
	text-decoration:none;
	color:#FFFFFF;
	background-position:100% -120px;
	}
#pixopoint_menu1 ul ul {
	position:absolute;
	left:-999em;
	top:35px;
	width:120px;
	}
#pixopoint_menu1 li:hover ul,#pixopoint_menu1 li.sfhover ul {
	left:auto;
	}
#pixopoint_menu1 ul ul li a {
	padding:4px 10px;
	text-transform:normal;
	font-variant:normal;
	}
#pixopoint_menu1 ul ul li {
	letter-spacing:0px;
	color:#444444;
	z-index:20;
	width:120px;
	font-family:helvetica,arial,sans-serif;
	font-size:11px;
	font-weight:normal;
	font-style:normal;
	background:#FFFFFF;
	border-bottom:1px solid #cccccc;
	border-left:1px solid #cccccc;
	border-right:1px solid #cccccc;
	margin:0;
	}
#pixopoint_menu1 ul ul li a {
	line-height:22px;
	color:#444444;
	text-decoration:none;
	}
#pixopoint_menu1 ul ul li:hover a,#pixopoint_menu1 ul ul li.sfhover a {
	color:#FFFFFF;
	text-decoration:none;
	}
#pixopoint_menu1 ul ul li:hover li a,#pixopoint_menu1 ul ul li.sfhover li a {
	color:#444444;
	}
#pixopoint_menu1 ul ul li:hover li a:hover,#pixopoint_menu1 ul ul li.sfhover li a:hover {
	color:#FFFFFF;
	}
#pixopoint_menu1 ul ul li:hover,#pixopoint_menu1 ul ul li.sfhover {
	color:#FFFFFF;
	background:#B41520;
	}
#pixopoint_menu1 ul ul ul li {
	font-size:1em;}#pixopoint_menu1 ul ul ul, #pixopoint_menu1 ul ul ul ul {
	position:absolute;
	margin-left:-999em;
	top:0;
	width:120px;
	}
#pixopoint_menu1 li li:hover ul,#pixopoint_menu1 li li.sfhover ul,#pixopoint_menu1 li li li:hover ul,#pixopoint_menu1 li li li.sfhover ul {
	margin-left:120px;
	}
#pixopoint_menu1 ul ul li:hover li a,#pixopoint_menu1 ul ul li.sfhover li a {
	text-decoration:none;
	}
#pixopoint_menu1 ul ul li li:hover a,#pixopoint_menu1 ul ul li li.sfhover a {
	color:#FFFFFF;
	text-decoration:none;
	}
#pixopoint_menu1 li.pixo_search:hover {
	background:none;
	}
#pixopoint_menu1 li.pixo_search form {
	margin:0;
	padding:0;
	}
#pixopoint_menu1 li.pixo_search input {
	font-family:tahoma,sans-serif;}
#pixopoint_menu1 li.pixo_search input.pixo_inputsearch {
	width:100px;
	}
#pixopoint_menu1 li.pixo_right {
	float:right;
	}');

 // Adds second menu CSS to database
	add_option('suckerfish_2_css', '#pixopoint_menu2 {
	width:100%;
	height:25px;
	background:#FF5050 url("../images/smoothfade_palered.png") repeat-x;
	background-position:50% 0;
	margin:0;}
#pixopoint_menu2 ul {
	width:100%;
	border:none;
	background:none;
	margin:0;
	padding:0;
	list-style:none;
	}
#pixopoint_menu2 li {
	border:none;
	background:none;
	background:#FF5050 url("../images/smoothfade_palered.png");
	color:#FFFFFF;
	line-height:25px;
	text-transform:uppercase;
	z-index:10;
	letter-spacing:0px;
	background:;
	font-weight:normal;
	font-size:12px;
	padding:0;
	margin:0 0px;
	;float:left;
	font-family:helvetica,arial,sans-serif;
	position:relative;
	}
#pixopoint_menu2 li:hover,#pixopoint_menu2 li.sfhover {
	background:#e92020
	}
#pixopoint_menu2 li a {
	border:none;
	background:none;
	text-decoration:none;
	display:block;
	padding:0 8px;
	color:#FFFFFF;
	}
#pixopoint_menu2 li a:hover {
	border:none;
	background:none;
	text-decoration:none;
	color:#FFFFFF;
	background-position:100% -120px;
	}
#pixopoint_menu2 ul ul {
	position:absolute;
	left:-999em;
	top:25px;
	width:120px;
	}
#pixopoint_menu2 li:hover ul,#pixopoint_menu2 li.sfhover ul {
	left:auto;
	}
#pixopoint_menu2 ul ul li a {
	padding:4px 10px;
	text-transform:normal;
	font-variant:normal;
	}
#pixopoint_menu2 ul ul li {
	letter-spacing:0px;
	color:#444444;
	z-index:10;
	width:120px;
	font-family:helvetica,arial,sans-serif;
	font-size:11px;
	font-weight:normal;
	font-style:normal;
	background:#fcfcfc;
	border-bottom:1px solid #cccccc;
	border-left:1px solid #cccccc;
	border-right:1px solid #cccccc;
	margin:0;
	}
#pixopoint_menu2 ul ul li a {
	line-height:22px;
	color:#444444;
	text-decoration:none;
	}
#pixopoint_menu2 ul ul li:hover a,#pixopoint_menu2 ul ul li.sfhover a {
	color:#444444;
	text-decoration:none;
	}
#pixopoint_menu2 ul ul li:hover li a,#pixopoint_menu2 ul ul li.sfhover li a {
	color:#444444;
	}
#pixopoint_menu2 ul ul li:hover li a:hover,#pixopoint_menu2 ul ul li.sfhover li a:hover {
	color:#444444;
	}
#pixopoint_menu2 ul ul li:hover,#pixopoint_menu2 ul ul li.sfhover {
	color:#444444;
	background:#dedede;
	}
#pixopoint_menu2 ul ul ul li {
	font-size:1em;}#pixopoint_menu2 ul ul ul, #pixopoint_menu2 ul ul ul ul {
	position:absolute;
	margin-left:-999em;
	top:0;
	width:120px;
	}
#pixopoint_menu2 li li:hover ul,#pixopoint_menu2 li li.sfhover ul,#pixopoint_menu2 li li li:hover ul,#pixopoint_menu2 li li li.sfhover ul {
	margin-left:120px;
	}
#pixopoint_menu2 ul ul li:hover li a,#pixopoint_menu2 ul ul li.sfhover li a {
	text-decoration:none;
	}
#pixopoint_menu2 ul ul li li:hover a,#pixopoint_menu2 ul ul li li.sfhover a {
	color:#444444;
	text-decoration:none;
	}
#pixopoint_menu2 li.pixo_search:hover {
	background:none;
	}
#pixopoint_menu2 li.pixo_search form {
	margin:0;
	padding:0;
	}
#pixopoint_menu2 li.pixo_search input {
	font-family:helvetica,arial,sans-serif;}
#pixopoint_menu2 li.pixo_search input.pixo_inputsearch {
	width:100px;
	}
#pixopoint_menu2 li.pixo_right {
	float:right;
	}');

	add_option('suckerfish_superfish', '');
	add_option('suckerfish_superfish_speed', 'normal');
	add_option('suckerfish_superfish_time', '800');
	add_option('suckerfish_superfish_timeout', '100');
	add_option('suckerfish_hometitle', 'Home');
	add_option('suckerfish_pagestitle', 'Pages');
	add_option('suckerfish_categoriestitle', 'Categories');
	add_option('suckerfish_archivestitle', 'Archives');
	add_option('suckerfish_blogrolltitle', 'Links');
	add_option('suckerfish_recentcommentstitle', 'Recent Comments');
	add_option('suckerfish_recentpoststitle', 'Recent Posts');
//	add_option('suckerfish_keyboard', '');	REMOVED SINCE HAS BUG
	if (get_option('suckerfish_keyboard') != '') {delete_option('suckerfish_keyboard');}; // Needed to be removed since has bug
	add_option('suckerfish_disablecss', '');
	add_option('suckerfish_inlinecss', '');
	add_option('suckerfish_superfish_delaymouseover', '200');
	add_option('suckerfish_superfish_sensitivity', 'high');
	add_option('pixopoint_menu_maintenance', '');
	add_option('suckerfish_categoryorder', 'Ascending Name');
	add_option('suckerfish_pageorder', 'Normal');
//	if (get_option('suckerfish_pageorder', 'Ascending Name')) {update_option('suckerfish_pageorder', 'Normal');} // Temporary fix for bug introduced to beta 0.5.8. Should be removed in later versions as shouldn't be necessary.
	add_option('suckerfish_categorycount', '');
	add_option('suckerfish_titletags', '');
	add_option('suckerfish_menucontents', 'home=1|pages=2|search=4|XXX=5|categories=3|recentcomments=6|recentposts=7|archives=8|ZZZ=5|links=9|customcode1=10|customcode2=11|customcode3=12|customcode4=13|'); // NEEDS MORE OPTIONS ADDED TO IT
	add_option('suckerfish_pages_singledropdown', '');
	add_option('suckerfish_categories_singledropdown', '');
	add_option('suckerfish_identification', rand(0, 99999999999));
	add_option('suckerfish_archivesdropdown','on');
	add_option('suckerfish_archivesperiod','Years');
	add_option('suckerfish_linkscategorized', 'off');
	add_option('suckerfish_linksdropdown','on');
	add_option('suckerfish_categories_showchildposts', '');
	add_option('suckerfish_editingpane', '');
	add_option('suckerfish_css_extra', '');
	add_option('suckerfish_searchalignment', 'on');
	add_option('suckerfish_themesupport', 'on');
	add_option('suckerfish_compatibilitymode', '');
	add_option('suckerfish_customfields', '');
	add_option('suckerfish_pagesnoparentlinks','');
	add_option('pixo_password', '');
	add_option('enableeditingpane', '');
	if (get_option('suckerfish_includeexcludecategories') == 'Exclude') {update_option('suckerfish_includeexcludecategories','exclude');}
	if (get_option('suckerfish_delay') == 'on') {update_option('suckerfish_delay','600');}
	if (get_option('suckerfish_delay') == '') {update_option('suckerfish_delay','0');}
	if (get_option('suckerfish_compatibilitymode') == 'on') {
		update_option('suckerfish_superfish','');
		update_option('suckerfish_superfish_speed','instant');
		update_option('suckerfish_superfish_delaymouseover','0');
		update_option('suckerfish_delay','0');
		update_option('suckerfish_superfish_sensitivity','high');
		update_option('suckerfish_superfish_arrows','');
	}
	update_option( 'suckerfish_custommenu', wp_kses( get_option('suckerfish_custommenu'), pixopoint_allowed_html(), '' ) );
	update_option( 'suckerfish_custommenu2', wp_kses( get_option('suckerfish_custommenu2'), pixopoint_allowed_html(), '' ) );
	update_option( 'suckerfish_custommenu3', wp_kses( get_option('suckerfish_custommenu3'), pixopoint_allowed_html(), '' ) );
	update_option( 'suckerfish_custommenu4', wp_kses( get_option('suckerfish_custommenu4'), pixopoint_allowed_html(), '' ) );

	update_option('enableeditingpane','');

	// Register Settings - needed for WP Mu support
	$settings_list = array('suckerfish_css', 'suckerfish_superfish', 'suckerfish_superfish_speed', 'suckerfish_superfish_time', 'suckerfish_superfish_timeout', 'suckerfish_pagestitle', 'suckerfish_excludepages', 'suckerfish_excludecategories', 'suckerfish_hometitle', 'suckerfish_pagesnoparentlinks', 'suckerfish_categoriestitle', 'suckerfish_archivestitle', 'suckerfish_blogrolltitle', 'suckerfish_recentcommentstitle', 'suckerfish_recentpoststitle', 'suckerfish_disablecss', 'suckerfish_custommenu', 'suckerfish_custommenu2', 'suckerfish_custommenu3', 'suckerfish_custommenu4', 'suckerfish_inlinecss', 'suckerfish_includeexcludepages', 'suckerfish_2_css', 'suckerfish_2_pagestitle', 'suckerfish_2_excludepages', 'suckerfish_2_excludecategories', 'suckerfish_2_hometitle', 'suckerfish_2_pagestitle', 'suckerfish_2_categoriestitle', 'suckerfish_2_archivestitle', 'suckerfish_2_blogrolltitle', 'suckerfish_2_recentcommentstitle', 'suckerfish_2_disablecss', 'suckerfish_2_custommenu', 'suckerfish_2_custommenu2', 'suckerfish_2_inlinecss', 'suckerfish_2_includeexcludepages', 'suckerfish_generator', 'suckerfish_delay', 'suckerfish_superfish_arrows', 'suckerfish_showdelay', 'suckerfish_displaycss', 'suckerfish_secondmenu', 'suckerfish_superfish_delaymouseover', 'suckerfish_superfish_hoverintent', 'suckerfish_superfish_sensitivity', 'pixopoint_menu_maintenance', 'suckerfish_themesupport', 'suckerfish_compatibilitymode', 'suckerfish_categoryorder', 'suckerfish_pageorder', 'suckerfish_includeexcludecategories', 'suckerfish_homeurl', 'suckerfish_pagesurl', 'suckerfish_categoriesurl', 'suckerfish_archivesurl', 'suckerfish_blogrollurl', 'suckerfish_recentcommentsurl', 'suckerfish_recentpostsurl', 'suckerfish_depthcategories', 'suckerfish_depthpages', 'suckerfish_categorycount', 'suckerfish_categoryshowempty', 'suckerfish_titletags', 'suckerfish_recentpostsnumber', 'suckerfish_recentcommentsnumber','suckerfish_customfields', 'suckerfish_menucontents', 'suckerfish_categories_showchildposts', 'suckerfish_categories_singledropdown', 'suckerfish_searchalignment', 'suckerfish_pages_singledropdown', 'pixo_password', 'suckerfish_categories_singledropdown', 'suckerfish_archivesdropdown', 'suckerfish_archivesperiod', 'suckerfish_linkscategorized', 'suckerfish_linksdropdown', 'suckerfish_categories_showchildposts', 'suckerfish_css_extra', 'suckerfish_searchalignment', 'suckerfish_customfields', 'enableeditingpane');
	foreach ( $settings_list as $setting_item ) {
		register_setting('pixopoint-menu', $setting_item );
	}
}


/************************************************************
 ***************** Sets up enqueue scripts ******************
 *********** enqueue prevents clashes between ***************
 ********** plugins which use the same script ***************
 ************************************************************/
wp_register_script('tabber-init', $javascript_location.'tabber-init.js','', '1.0');
wp_register_script('tabber', $javascript_location.'tabber-minimized.js', array('tabber-init'), '1.9');




/************************************************************
 ************************************************************
 **************** Creating the admin page *******************
 ************************************************************
 ************************************************************/
function suckerfish_options() {global $pixo_developmental;

?>

<div class="wrap">
	<form method="post" action="options.php" id="options">
		<?php settings_fields('pixopoint-menu'); ?>
		<h2>PixoPoint Menu Plugin</h2>
		<div style="clear:both;padding-top:5px;"></div>
		<div class="tabber" id="mytabber1">


			<?php /* Home */ ?>
			<div class="tabbertab">
				<h2><?php _e('Home','pixopoint_menu_lang'); ?></h2>
				<div class="clear"></div>
				<table class="widefat" cellspacing="0" id="active-plugins-table">
					<thead>
						<tr>
							<th scope="col"><?php _e('Menu contents','pixopoint_menu_lang'); ?></th>
						</tr>
					</thead>
					<tfoot>
						<tr>
							<th scope="col"><?php _e('Drag and drop the menu items to control what appears in your menu.','pixopoint_menu_lang'); ?></th>
						</tr>
					</tfoot>
					<tbody class="plugins">
						<tr class="inactive">
							<td class="desc">
								<h4 style="width:auto;padding-top:20px;margin-bottom:0;clear:left;">Main menu items</h4>
								<script type="text/javascript" src="<?php echo WP_PLUGIN_URL; ?>/pixopoint-menu/scripts/jqanimatedcollapse.js"></script>
								<div id="widgetbox">
								<?php
									if (get_option('suckerfish_menucontents') != '') {
										$temp = explode('|', wp_kses( get_option('suckerfish_menucontents'), '', '' ));
										foreach ($temp as $set) {
											if ($XXX != 1) {
												$set = explode('=', $set);



// 'Pages' option
if ($set[0] == 'pages') { ?>
<div id="listItem_pages" class="pixo_widget">
	<a class="close" href="javascript:collapse2.slideit()"></a>
	<span class="handle"><?php _e('Pages','pixopoint_menu_lang'); ?></span>
	<div id="pulldown_pages2" class="dropdown">
		<p>
			<label id="dropdownlabel">Dropdowns</label>
			<select id="dropdownselect" name="suckerfish_depthpages">
				<?php
				$suckerfish_depthpages = wp_kses( get_option('suckerfish_depthpages'), '', '' );
				switch ($suckerfish_depthpages){
					case "Top level only":echo '<option>Top level only</option><option>No nesting</option><option>1 level of children</option><option>2 levels of children</option><option>Infinite</option>';break;
					case "No nesting":echo '<option>No nesting</option><option>Top level only</option><option>1 level of children</option><option>2 levels of children</option><option>Infinite</option>';break;
					case "1 level of children":echo '<option>1 level of children</option><option>Top level only</option><option>No nesting</option><option>2 levels of children</option><option>Infinite</option>';break;
					case "2 levels of children":echo '<option>2 levels of children</option><option>Top level only</option><option>No nesting</option><option>1 level of children</option><option>Infinite</option>';break;
					case "Infinite":echo '<option>Infinite</option><option>Top level only</option><option>No nesting</option><option>1 level of children</option><option>2 levels of children</option>';break;
					case "":echo '<option>Infinite</option><option>Top level only</option><option>No nesting</option><option>1 level of children</option><option>2 levels of children</option>';break;
				}
				?>
			</select>
			<br />
			<label style="width:95px;margin-right:0;padding-right:0;"><?php _e('Single dropdown?','pixopoint_menu_lang'); ?></label>
			<?php
				if (get_option('suckerfish_pages_singledropdown') == 'on') {echo '<input class="widgetcheckbox" type="checkbox" name="suckerfish_pages_singledropdown" checked="yes" />';}
				else {echo '<input class="widgetcheckbox" type="checkbox" name="suckerfish_pages_singledropdown" />';}
			?>
			<br /><br />
			<label id="titlewidthlabel"><?php _e('Title','pixopoint_menu_lang'); ?></label>
			<input class="titlewidthinput" type="text" name="suckerfish_pagestitle" value="<?php echo wp_kses( get_option('suckerfish_pagestitle'), '', '' ); ?>" />
			<br />
			<label id="titlewidthlabel"><?php _e('URL','pixopoint_menu_lang'); ?></label>
			<input class="titlewidthinput" type="text" name="suckerfish_pagesurl" value="<?php echo wp_kses( get_option('suckerfish_pagesurl'), '', '' ); ?>" />
			<label><?php _e('IDs to include or exclude','pixopoint_menu_lang'); ?></label>
			<input class="shortwidthwidget" type="text" name="suckerfish_excludepages" value="<?php echo wp_kses( get_option('suckerfish_excludepages'), '', '' ); ?>" />
			&nbsp; &nbsp; &nbsp;
			<select id="selectboxright" name="suckerfish_includeexcludepages">
				<?php
				$suckerfish_includeexcludepages = wp_kses( get_option('suckerfish_includeexcludepages'), '', '' );
				switch ($suckerfish_includeexcludepages){
					case "include":echo '<option>include</option><option>exclude</option>';break;
					case "exclude":echo '<option>exclude</option><option>include</option>';break;
					case "":echo '<option>include</option><option>exclude</option>';break;
				}
				?>
			</select>
			<br />
			<label id="orderwidthlabel">Order</label>
			<select style="float:left" id="orderwidthselect" name="suckerfish_pageorder">
				<?php
				$suckerfish_pageorder = wp_kses( get_option('suckerfish_pageorder'), '', '' );
				switch ($suckerfish_pageorder){
					case "Normal":echo '<option>Normal</option><option>Ascending Name</option><option>Descending Name</option>';break;
					case "Ascending Name":echo '<option>Ascending Name</option><option>Descending Name</option><option>Normal</option>';break;
					case "Descending Name":echo '<option>Descending Name</option><option>Ascending Name</option><option>Normal</option>';break;
					case "":echo '<option>Normal</option><option>Ascending Name</option><option>Descending Name</option>';break;
				}
				?>
			</select>
			<br />
			<label><?php _e('IDs of URLs to exclude','pixopoint_menu_lang'); ?></label><br />
			<input class="titlewidthinput" style="width:140px;" type="text" name="suckerfish_pagesnoparentlinks" value="<?php echo wp_kses( get_option('suckerfish_pagesnoparentlinks'), '', '' ); ?>" />
		</p>
	</div>
</div>
<script type="text/javascript">
	//Syntax: var uniquevar=new animatedcollapse("DIV_id", animatetime_milisec, enablepersist(true/fase), [initialstate] )
	var collapse2=new animatedcollapse("pulldown_pages2", 800, true)
</script>
<?php }



// 'Categories' option
if ($set[0] == 'categories') { ?>
<div id="listItem_categories" class="pixo_widget">
	<a class="close" href="javascript:collapse1.slideit()"></a>
	<span class="handle"><?php _e('Categories','pixopoint_menu_lang'); ?></span>
	<div id="pulldown_pages" class="dropdown">
		<p>
			<label id="dropdownlabel">Dropdowns</label>
			<select id="dropdownselect" name="suckerfish_depthcategories">
			<?php
				$suckerfish_depthecategories = wp_kses( get_option('suckerfish_depthcategories'), '', '' );
				switch ($suckerfish_depthecategories){
					case "Top level only":echo '<option>Top level only</option><option>No nesting</option><option>1 level of children</option><option>2 levels of children</option><option>Infinite</option>';break;
					case "No nesting":echo '<option>No nesting</option><option>Top level only</option><option>1 level of children</option><option>2 levels of children</option><option>Infinite</option>';break;
					case "1 level of children":echo '<option>1 level of children</option><option>Top level only</option><option>No nesting</option><option>2 levels of children</option><option>Infinite</option>';break;
					case "2 levels of children":echo '<option>2 levels of children</option><option>Top level only</option><option>No nesting</option><option>1 level of children</option><option>Infinite</option>';break;
					case "Infinite":echo '<option>Infinite</option><option>Top level only</option><option>No nesting</option><option>1 level of children</option><option>2 levels of children</option>';break;
					case "":echo '<option>Infinite</option><option>Top level only</option><option>No nesting</option><option>1 level of children</option><option>2 levels of children</option>';break;
					}
			?>
			</select>
			<br />
			<label style="width:95px;margin-right:0;padding-right:0;">Empty categories?</label>
			<?php
				if (get_option('suckerfish_categoryshowempty') == 'on') {echo '<input class="widgetcheckbox" type="checkbox" name="suckerfish_categoryshowempty" checked="yes" />';}
				else {echo '<input class="widgetcheckbox" type="checkbox" name="suckerfish_categoryshowempty" />';}
			?>
			<br />
			<label style="width:95px;margin-right:0;padding-right:0;">Single dropdown?</label>
			<?php
				if (get_option('suckerfish_categories_singledropdown') == 'on') {echo '<input class="widgetcheckbox" type="checkbox" name="suckerfish_categories_singledropdown" checked="yes" />';}
				else {echo '<input class="widgetcheckbox" type="checkbox" name="suckerfish_categories_singledropdown" />';}
			?>
			<label style="width:95px;margin-right:0;padding-right:0;">Show child posts?</label>
			<?php
				if (get_option('suckerfish_categories_showchildposts') == 'on') {echo '<input class="widgetcheckbox" type="checkbox" name="suckerfish_categories_showchildposts" checked="yes" />';}
				else {echo '<input class="widgetcheckbox" type="checkbox" name="suckerfish_categories_showchildposts" />';}
			?>
			<!--<br /><br /><br /><br /><br />-->
			<label style="clear:left" id="titlewidthlabel">Title</label>
			<input class="titlewidthinput" type="text" name="suckerfish_categoriestitle" name="suckerfish_categoriestitle" value="<?php echo wp_kses( get_option('suckerfish_categoriestitle'), '', '' ); ?>" />
			<br />
			<label id="titlewidthlabel">URL</label>
			<input class="titlewidthinput" type="text" name="suckerfish_categoriesurl" value="<?php echo wp_kses( get_option('suckerfish_categoriesurl'), '', '' ); ?>" />
			<label style="clear:left">IDs to include or exclude</label>
			<input class="shortwidthwidget" type="text" name="suckerfish_excludecategories" value="<?php echo wp_kses( get_option('suckerfish_excludecategories'), '', '' ); ?>" />
			&nbsp; &nbsp; &nbsp;
			<select style="float:right" id="selectboxright" name="suckerfish_includeexcludecategories">
			<?php
				$suckerfish_includeexcludecategories = wp_kses( get_option('suckerfish_includeexcludecategories'), '', '' );
				switch ($suckerfish_includeexcludecategories){
					case "include":echo '<option>include</option><option>exclude</option>';break;
					case "exclude":echo '<option>exclude</option><option>include</option>';break;
					case "":echo '<option>include</option><option>exclude</option>';break;
					}
			?>
			</select>
			<br />
			<label style="float:left" id="orderwidthlabel">Order</label>
			<select style="float:left" id="orderwidthselect" name="suckerfish_categoryorder">
				<?php
				$suckerfish_categoryorder = wp_kses( get_option('suckerfish_categoryorder'), '', '' );
				switch ($suckerfish_categoryorder){
					case "Ascending ID #":echo '<option>Ascending ID #</option><option>Descending ID #</option><option>Ascending Name</option><option>Descending Name</option><option>My Category Order plugin</option>';break;
					case "Descending ID #":echo '<option>Descending ID #</option><option>Ascending ID #</option><option>Ascending Name</option><option>Descending Name</option><option>My Category Order plugin</option>';break;
					case "Ascending Name":echo '<option>Ascending Name</option><option>Descending Name</option><option>Descending ID #</option><option>Ascending ID #</option><option>My Category Order plugin</option>';break;
					case "Descending Name":echo '<option>Descending Name</option><option>Ascending Name</option><option>Descending ID #</option><option>Ascending ID #</option><option>My Category Order plugin</option>';break;
					case "My Category Order plugin":echo '<option>My Category Order plugin</option><option>Ascending ID #</option><option>Descending ID #</option><option>Ascending Name</option><option>Descending Name</option>';break;
					case "":echo '<option>Ascending Name</option><option>Descending Name</option><option>Descending ID #</option><option>Ascending ID #</option><option>My Category Order plugin</option>';break;
				}
				?>
			</select>
		</p>
	</div>
</div>
<script type="text/javascript">
	//Syntax: var uniquevar=new animatedcollapse("DIV_id", animatetime_milisec, enablepersist(true/fase), [initialstate] )
	var collapse1=new animatedcollapse("pulldown_pages", 800, true)
</script>
<?php }




// 'Recent Comments' option
if ($set[0] == 'recentcomments') { ?>
<div id="listItem_recentcomments" class="pixo_widget">
	<a class="close" href="javascript:collapse5.slideit()"></a>
	<span class="handle"><?php _e('Recent Comments','pixopoint_menu_lang'); ?></span>
	<div id="pulldown_pages5" class="dropdown">
		<p>
			<label id="titlewidthlabel">Title</label>
			<input class="titlewidthinput" type="text" name="suckerfish_recentcommentstitle" value="<?php echo wp_kses( get_option('suckerfish_recentcommentstitle'), '', '' ); ?>" />
			<br />
			<label id="titlewidthlabel">URL</label>
			<input class="titlewidthinput" type="text" name="suckerfish_recentcommentsurl" value="<?php echo wp_kses( get_option('suckerfish_recentcommentsurl'), '', '' ); ?>" />
		</p>
	</div>
</div>
<script type="text/javascript">
	//Syntax: var uniquevar=new animatedcollapse("DIV_id", animatetime_milisec, enablepersist(true/fase), [initialstate] )
	var collapse5=new animatedcollapse("pulldown_pages5", 800, true)
</script>
<?php }



// 'Recent Posts' option
if ($set[0] == 'recentposts') { ?>
<div id="listItem_recentposts" class="pixo_widget">
	<a class="close" href="javascript:collapse6.slideit()"></a>
	<span class="handle"><?php _e('Recent Posts','pixopoint_menu_lang'); ?></span>
	<div id="pulldown_pages6" class="dropdown">
		<p>
			<label id="titlewidthlabel">Title</label>
			<input class="titlewidthinput" type="text" name="suckerfish_recentpoststitle" value="<?php echo get_option('suckerfish_recentpoststitle'); ?>" />
			<br />
			<label id="titlewidthlabel">URL</label>
			<input class="titlewidthinput" type="text" name="suckerfish_recentpostsurl" value="<?php echo get_option('suckerfish_recentpostsurl'); ?>" />
		</p>
	</div>
</div>
<script type="text/javascript">
	//Syntax: var uniquevar=new animatedcollapse("DIV_id", animatetime_milisec, enablepersist(true/fase), [initialstate] )
	var collapse6=new animatedcollapse("pulldown_pages6", 800, true)
</script>
<?php }


// 'Search' option
if ($set[0] == 'search') { ?>
<div id="listItem_search" class="pixo_widget">
	<a class="close" href="javascript:collapse4.slideit()"></a>
	<span class="handle">Search</span>
	<div id="pulldown_pages4" class="dropdown">
		<p>
			<label style="width:95px;margin-right:0;padding-right:0;">Right aligned</label>
			<?php
				if (get_option('suckerfish_searchalignment') == 'on') {echo '<input class="widgetcheckbox" type="checkbox" name="suckerfish_searchalignment" checked="yes" />';}
				else {echo '<input class="widgetcheckbox" type="checkbox" name="suckerfish_searchalignment" />';}
			?>
		</p>
	</div>
</div>
<script type="text/javascript">
	//Syntax: var uniquevar=new animatedcollapse("DIV_id", animatetime_milisec, enablepersist(true/fase), [initialstate] )
	var collapse4=new animatedcollapse("pulldown_pages4", 800, true)
</script>
<?php }



// 'Home' option
if ($set[0] == 'home') { ?>
<div id="listItem_home" class="pixo_widget">
	<a class="close" href="javascript:collapse3.slideit()"></a>
	<span class="handle"><?php _e('Home','pixopoint_menu_lang'); ?></span>
	<div id="pulldown_pages3" class="dropdown">
		<p>
			<label id="titlewidthlabel">Title</label>
			<input class="titlewidthinput" type="text" name="suckerfish_hometitle" value="<?php echo get_option('suckerfish_hometitle'); ?>" />
			<br />
			<label id="titlewidthlabel">URL</label>
			<input class="titlewidthinput" type="text" name="suckerfish_homeurl" value="<?php echo get_option('suckerfish_homeurl'); ?>" />
		</p>
	</div>
</div>
<script type="text/javascript">
	//Syntax: var uniquevar=new animatedcollapse("DIV_id", animatetime_milisec, enablepersist(true/fase), [initialstate] )
	var collapse3=new animatedcollapse("pulldown_pages3", 800, true)
</script>
<?php }



// 'Archives' option
if ($set[0] == 'archives') { ?>
<div id="listItem_archives" class="pixo_widget">
	<a class="close" href="javascript:collapse7.slideit()"></a>
	<span class="handle"><?php _e('Archives','pixopoint_menu_lang'); ?></span>
	<div id="pulldown_pages7" class="dropdown">
		<p>
			<label style="width:95px;margin-right:0;padding-right:0;">Dropdown?</label>
			<?php
				if (get_option('suckerfish_archivesdropdown') == 'on') {echo '<input class="widgetcheckbox" type="checkbox" name="suckerfish_archivesdropdown" checked="yes" />';}
				else {echo '<input class="widgetcheckbox" type="checkbox" name="suckerfish_archivesdropdown" />';}
			?>
			<br /><br />
			<label id="titlewidthlabel">Title</label>
			<input class="titlewidthinput" type="text" name="suckerfish_archivestitle" value="<?php echo get_option('suckerfish_archivestitle'); ?>" />
			<br />
			<label id="titlewidthlabel">URL</label>
			<input class="titlewidthinput" type="text" name="suckerfish_archivesurl" value="<?php echo get_option('suckerfish_archivesurl'); ?>" />
			<br />
			<label style="float:left;">Time period</label>
			<select style="float:left;" id="dropdownselect" name="suckerfish_archivesperiod">
				<?php
				$suckerfish_archivesperiod = get_option('suckerfish_archivesperiod');
				switch ($suckerfish_archivesperiod){
					case "Years":echo '<option>Years</option><option>Months</option><option>Years and Months</option>';break;
					case "Months":echo '<option>Months</option><option>Years</option><option>Years and Months</option>';break;
					case "Years and Months":echo '<option>Years and Months</option><option>Years</option><option>Months</option>';break;
					case "":echo '<option>Months</option><option>Years</option><option>Years and Months</option>';break;
				}
				?>
			</select>
		</p>
	</div>
</div>
<script type="text/javascript">
	//Syntax: var uniquevar=new animatedcollapse("DIV_id", animatetime_milisec, enablepersist(true/fase), [initialstate] )
	var collapse7=new animatedcollapse("pulldown_pages7", 800, true)
</script>
<?php }



// 'Links' option
if ($set[0] == 'links') { ?>
<div id="listItem_links" class="pixo_widget">
	<a class="close" href="javascript:collapse8.slideit()"></a>
	<span class="handle"><?php _e('Links','pixopoint_menu_lang'); ?></span>
	<div id="pulldown_pages8" class="dropdown">
		<p>
			<label style="width:95px;margin-right:0;padding-right:0;">Categories?</label>
			<?php
				if (get_option('suckerfish_linksdropdown') == 'on') {echo '<input class="widgetcheckbox" type="checkbox" name="suckerfish_linkscategorized" checked="yes" />';}
				else {echo '<input class="widgetcheckbox" type="checkbox" name="suckerfish_linksdropdown" />';}
			?>
			<br />
			<label style="width:95px;margin-right:0;padding-right:0;">Dropdown?</label>
			<?php
				if (get_option('suckerfish_linksdropdown') == 'on') {echo '<input class="widgetcheckbox" type="checkbox" name="suckerfish_linksdropdown" checked="yes" />';}
				else {echo '<input class="widgetcheckbox" type="checkbox" name="suckerfish_linksdropdown" />';}
			?>
			<br /><br /><br />
			<label id="titlewidthlabel">Title</label>
			<input class="titlewidthinput" type="text" name="suckerfish_blogrolltitle" value="<?php echo get_option('suckerfish_blogrolltitle'); ?>" />
			<br />
			<label id="titlewidthlabel">URL</label>
			<input class="titlewidthinput" type="text" name="suckerfish_blogrollurl" value="<?php echo get_option('suckerfish_blogrollurl'); ?>" />
		</p>
	</div>
</div>
<script type="text/javascript">
	//Syntax: var uniquevar=new animatedcollapse("DIV_id", animatetime_milisec, enablepersist(true/fase), [initialstate] )
	var collapse8=new animatedcollapse("pulldown_pages8", 800, true)
</script>
<?php }




// 'Custom Code 1' option
if ($set[0] == 'customcode1') { ?>
<div id="listItem_customcode1" class="pixo_widget">
	<a class="close" href="javascript:collapse9.slideit()"></a>
	<span class="handle">Custom code 1</span>
	<div id="pulldown_pages9" class="dropdown customcodebox">
		<p>
			<label>Custom code</label>
			<textarea name="suckerfish_custommenu" style="border:1px solid #ddd" value=""><?php echo get_option('suckerfish_custommenu'); ?></textarea>
		</p>
	</div>
</div>
<script type="text/javascript">
	//Syntax: var uniquevar=new animatedcollapse("DIV_id", animatetime_milisec, enablepersist(true/fase), [initialstate] )
	var collapse9=new animatedcollapse("pulldown_pages9", 800, true)
</script>
<?php }




// 'Custom Code 2' option
if ($set[0] == 'customcode2') { ?>
<div id="listItem_customcode2" class="pixo_widget">
	<a class="close" href="javascript:collapse10.slideit()"></a>
	<span class="handle">Custom code 2</span>
	<div id="pulldown_pages10" class="dropdown customcodebox">
		<p>
			<label>Custom code</label>
			<textarea name="suckerfish_custommenu2" style="border:1px solid #ddd" value=""><?php echo get_option('suckerfish_custommenu2'); ?></textarea>
		</p>
	</div>
</div>
<script type="text/javascript">
	//Syntax: var uniquevar=new animatedcollapse("DIV_id", animatetime_milisec, enablepersist(true/fase), [initialstate] )
	var collapse10=new animatedcollapse("pulldown_pages10", 800, true)
</script>
<?php }




// 'Custom Code 3' option
if ($set[0] == 'customcode3') { ?>
<div id="listItem_customcode3" class="pixo_widget">
	<a class="close" href="javascript:collapse11.slideit()"></a>
	<span class="handle">Custom code 3</span>
	<div id="pulldown_pages11" class="dropdown customcodebox">
		<p>
			<label>Custom code</label>
			<textarea name="suckerfish_custommenu3" style="border:1px solid #ddd" value=""><?php echo get_option('suckerfish_custommenu3'); ?></textarea>
		</p>
	</div>
</div>
<script type="text/javascript">
	//Syntax: var uniquevar=new animatedcollapse("DIV_id", animatetime_milisec, enablepersist(true/fase), [initialstate] )
	var collapse11=new animatedcollapse("pulldown_pages11", 800, true)
</script>
<?php }




// 'Custom Code 4' option
if ($set[0] == 'customcode4') { ?>
<div id="listItem_customcode4" class="pixo_widget">
	<a class="close" href="javascript:collapse12.slideit()"></a>
	<span class="handle">Custom code 4</span>
	<div id="pulldown_pages12" class="dropdown customcodebox">
		<p>
			<label>Custom code</label>
			<textarea name="suckerfish_custommenu4" style="border:1px solid #ddd" value=""><?php echo get_option('suckerfish_custommenu4'); ?></textarea>
		</p>
	</div>
</div>
<script type="text/javascript">
	//Syntax: var uniquevar=new animatedcollapse("DIV_id", animatetime_milisec, enablepersist(true/fase), [initialstate] )
	var collapse12=new animatedcollapse("pulldown_pages12", 800, true)
</script>
<?php }




												// This adds a block to sort the various drag n drop options into a seperate section for the second menu items
												if ($set[0] == 'XXX') {
													echo '<h4 id="listItem_XXX" style="width:auto;padding-top:20px;margin-bottom:0;clear:left;">Second menu items</h4>';
												}
												// This adds a block to sort the various drag n drop options into a seperate section for the inactive menu items
												if ($set[0] == 'ZZZ') {
													echo '<h4 id="listItem_ZZZ" style="width:auto;padding-top:20px;margin-bottom:0;clear:left;">Inactive menu items</h4>';
												}
											}
										}
									}
?>
								</div>
								<div style="clear:both;padding-top:20px;"></div>
								<div id="info">
									<input name="suckerfish_menucontents" type="hidden" value="<?php echo get_option('suckerfish_menucontents'); ?>" />
								</div>
							</td>
						</tr>
					</tbody>
				</table>

				<div class="clear"></div>

			</div>





			<?php /* Settings tab */ ?>
			<div class="tabbertab">
				<h2><?php _e('Settings','pixopoint_menu_lang'); ?></h2>
				<div class="clear"></div>
				<h3 class="yup">General Settings</h3>
				<table class="widefat" cellspacing="0" id="active-plugins-table">
					<thead>
						<tr>
							<th scope="col" colspan="2"><?php _e('Setting','pixopoint_menu_lang'); ?></th>
							<th scope="col"><?php _e('Description','pixopoint_menu_lang'); ?></th>
						</tr>
					</thead>
					<tfoot>
						<tr>
							<th scope="col" colspan="3"><?php _e('You may modify your menus behaviour via the following settings','pixopoint_menu_lang'); ?></th>
						</tr>
					</tfoot>
					<tbody class="plugins">
						<?php
							// Adds a comment about choosing between the built in theme CSS and the plugins CSS
							if (function_exists('pixopoint_mainmenu') || function_exists('pixopoint_secondmenu')) { ?>
							<tr class="active">
								<th scope='row' class='check-column'>
					      	<select name="suckerfish_generator">
									<?php
										$suckerfish_generator = get_option('suckerfish_generator');
										switch ($suckerfish_generator){
											case "Theme CSS":echo '<option>Theme CSS</option><option>Plugin CSS</option>';break;
											case "Plugin CSS":echo '<option>Plugin CSS</option><option>Theme CSS</option>';break;
											case "":echo '<option>Theme CSS</option><option>Plugin CSS</option>';break;
										}
									?>
									</select>
								</th>
								<td class='name'><?php _e('Use theme or plugins CSS?','pixopoint_menu_lang'); ?></td>
								<td class='desc'>
									<p><?php _e('You are currently using a theme designed to integrate directly with the PixoPoint Menu Plugin. You can either keep the existing menu design by using the themes CSS, or change to the plugins CSS to override the theme styling.','pixopoint_menu_lang'); ?></p>
								</td>
							</tr>
						<?php } ?>
						<tr class="inactive">
							<th scope='row' class='check-column'>
								<?php
									if (get_option('suckerfish_secondmenu') == 'on') {echo '<input type="checkbox" name="suckerfish_secondmenu" checked="yes" />';}
									else {echo '<input type="checkbox" name="suckerfish_secondmenu" />';}
								?>
							</th>
							<td class='name'><?php _e('Add a second menu?','pixopoint_menu_lang'); ?></td>
							<td class='desc'>
								<p><?php _e('You may add a second menu to your site. This is particularly common with magazine style layouts. For a second menu, add the following code to your theme <br /><code>&lt;?php if (function_exists(\'pixopoint_menu\')) {pixopoint_menu(2);} ?&gt;</code>.','pixopoint_menu_lang'); ?></p>
							</td>
						</tr>
						<tr class="inactive">
							<th scope='row' class='check-column'>
								<?php
									if (get_option('suckerfish_titletags') == 'on') {echo '<input type="checkbox" name="suckerfish_titletags" checked="yes" />';}
									else {echo '<input type="checkbox" name="suckerfish_titletags" />';}
								?>
							</th>
							<td class='name'><?php _e('Remove title attribute?','pixopoint_menu_lang'); ?></td>
							<td class='desc'>
								<p><?php _e('This removes the title attributes from the links in the menu. The title attributes display in most browsers as a small tool tip on hover over the links.','pixopoint_menu_lang'); ?></p>
							</td>
						</tr>
						<tr class="inactive">
							<th scope='row' class='check-column'>
								<?php
									if (get_option('pixopoint_menu_maintenance') == 'on') {echo '<input type="checkbox" name="pixopoint_menu_maintenance" checked="yes" />';}
									else {echo '<input type="checkbox" name="pixopoint_menu_maintenance" />';}
								?>
							</th>
							<td class='name'><?php _e('Maintenance mode?','pixopoint_menu_lang'); ?></td>
							<td class='desc'>
								<p><?php _e('When in maintenance mode, the plugin can only be seen when the user adds ?pixopoint-menu=on to the site URL (ie: http://domain.com/?pixopoint-menu=on). This is useful for when testing the menu. If the menu does not look correct on your site, you may place the menu into maintenance mode so that your regular site visitors can not see it.','pixopoint_menu_lang'); ?></p>
							</td>
						</tr>
						<tr class='inactive'>
							<th scope='row' class='check-column'>
								<select name="suckerfish_displaycss">
								<?php
									$suckerfish_displaycss = get_option('suckerfish_displaycss');
									switch ($suckerfish_displaycss){
										case "Disable":echo '<option>Disable</option>menu2<option>Normal</option>';break;
										case "Normal":echo '<option>Normal</option>menu2<option>Disable</option>';break;
										case "":echo '<option>Normal</option>menu2<option>Disable</option>';break;
										}
								?>
								</select>
							</th>
							<td class='name'><?php _e('Style sheet','pixopoint_menu_lang'); ?></td>
							<td class='desc'>
								<p><?php _e('The plugin includes it\'s own built in stylesheet. However many site owners wish to use their themes built in stylesheet (good idea if you want to reduce your page size).','pixopoint_menu_lang'); ?></p>
							</td>
						</tr>
						<tr class='inactive'>
							<th scope='row' class='check-column'>
								<?php
									if (get_option('suckerfish_themesupport') == 'on') {echo '<input type="checkbox" name="suckerfish_themesupport" checked="yes" />';}
									else {echo '<input type="checkbox" name="suckerfish_themesupport" />';}
								?>
							</th>
							<td class='name'><?php _e('Auto theme support','pixopoint_menu_lang'); ?></td>
							<td class='desc'>
								<p><?php _e('This option allows some themes, including <a href="http://themehybrid.com/">Theme Hybrid</a>, <a href="http://themeshaper.com/">Thematic</a> and Thesis to work automatically (no theme modifications necessary). It also works with many other themes we can\' guarantee it will work (it uses the wp_page_menu() function for most themes).','pixopoint_menu_lang'); ?></p>
							</td>
						</tr>
						<tr class='inactive'>
							<th scope='row' class='check-column'>
								<?php
									if (get_option('suckerfish_compatibilitymode') == 'on') {echo '<input type="checkbox" name="suckerfish_compatibilitymode" checked="yes" />';}
									else {echo '<input type="checkbox" name="suckerfish_compatibilitymode" />';}
								?>
							</th>
							<td class='name'><?php _e('Compatibility mode','pixopoint_menu_lang'); ?></td>
							<td class='desc'>
								<p><?php _e('This option disables a series of settings which can potentially cause conflicts with poorly coded themes or plugins.','pixopoint_menu_lang'); ?></p>
							</td>
						</tr>
					</tbody>
				</table>

				<h3 class="yup">Dropdown Menu Settings</h3>
				<table class="widefat" cellspacing="0" id="active-plugins-table">
					<thead>
						<tr>
							<th scope="col" colspan="2"><?php _e('Setting','pixopoint_menu_lang'); ?></th>
							<th scope="col"><?php _e('Description','pixopoint_menu_lang'); ?></th>
						</tr>
					</thead>
					<tfoot>
						<tr>
							<th scope="col" colspan="3"><?php _e('The following settings allow you to modify the behaviour of your dropdown menus (if you have any)','pixopoint_menu_lang'); ?></th>
						</tr>
					</tfoot>
					<tbody class="plugins">
						<tr class='inactive'>
							<th scope='row' class='check-column'>
								<select name="suckerfish_superfish_speed">
								<?php
									$suckerfish_superfish_speed = get_option('suckerfish_superfish_speed');
									switch ($suckerfish_superfish_speed){
										case "slow":echo '<option>slow</option><option>normal</option><option>fast</option><option>instant</option>';break;
										case "normal":echo '<option>normal</option><option>slow</option><option>fast</option><option>instant</option>';break;
										case "fast":echo '<option>fast</option><option>slow</option><option>normal</option><option>instant</option>';break;
										case "instant":echo '<option>instant</option><option>normal</option><option>slow</option><option>fast</option>';break;
										case "":echo '<option>instant</option><option>normal</option><option>slow</option><option>fast</option>';break;
										}
								?>
								</select>
							</th>
							<td class='name'><?php _e('Speed of fade-in effect','pixopoint_menu_lang'); ?></td>
							<td class='desc'>
								<p><?php _e('This option enhances the behaviour of the dropdown by creating an animated fade-in effect. This option is controlled by the <a href="http://users.tpg.com.au/j_birch/plugins/superfish/">\'Superfish plugin\'</a> for <a href="http://jquery.com/">jQuery</a>.','pixopoint_menu_lang'); ?></p>
							</td>
						</tr>
						<tr class='inactive'>
							<th scope='row' class='check-column'>
								<input style="width:60px" name="suckerfish_superfish_delaymouseover" type="text" value="<?php echo get_option('suckerfish_superfish_delaymouseover'); ?>" />
							</th>
							<td class='name'><?php _e('Mouseover delay (milliseconds)','pixopoint_menu_lang'); ?></td>
							<td class='desc'>
								<p><?php _e('This option adds a delay time before the dropdown appears. This option is controlled by the <a href="http://users.tpg.com.au/j_birch/plugins/superfish/">\'Superfish plugin\'</a> for jQuery.','pixopoint_menu_lang'); ?></p>
							</td>
						</tr>
						<tr class='inactive'>
							<th scope='row' class='check-column'>
								<input style="width:60px" name="suckerfish_delay" type="text" value="<?php echo get_option('suckerfish_delay'); ?>" />
							</th>
							<td class='name'><?php _e('Hide delay time (milliseconds)','pixopoint_menu_lang'); ?></td>
							<td class='desc'>
								<p><?php _e('This option adds a delay before the dropdown disappears. This option is particularly suitable for small menus where users may accidentally hover off of the menu. This option is controlled by the <a href="http://users.tpg.com.au/j_birch/plugins/superfish/">\'Superfish plugin\'</a> for <a href="http://jquery.com/">jQuery</a>','pixopoint_menu_lang'); ?></p>
							</td>
						</tr>
						<tr class='inactive'>
							<th scope='row' class='check-column'>
								<select name="suckerfish_superfish_sensitivity">
								<?php
									$suckerfish_superfish_sensitivity = get_option('suckerfish_superfish_sensitivity');
									switch ($suckerfish_superfish_sensitivity){
										case "high":echo '<option>high</option><option>average</option><option>low</option>';break;
										case "average":echo '<option>average</option><option>high</option><option>low</option>';break;
										case "low":echo '<option>low</option><option>high</option><option>average</option>';break;
										case "":echo '<option>high</option><option>average</option><option>low</option>';break;
										}
								?>
								</select>
							</th>
							<td class='name'><?php _e('Sensitivity','pixopoint_menu_lang'); ?></td>
							<td class='desc'>
								<p><?php _e('When this option is enabled, the menu will attempt to determine the user\'s intent. On low sensitivity, instead of immediately displaying the dropdown/flyout menu on mouseover, the menu will wait until the user\'s mouse slows down before displaying it.','pixopoint_menu_lang'); ?></p>
							</td>
						</tr>
<?php /*	Needed to be removed as contained bug
						<tr class='inactive'>
							<th scope='row' class='check-column'>
								<?php
									if (get_option('suckerfish_keyboard') == 'on') {echo '<input type="checkbox" name="suckerfish_keyboard" checked="yes" />';}
									else {echo '<input type="checkbox" name="suckerfish_keyboard" />';}
								?>
							</th>
							<td class='name'><?php _e('Enable keyboard accessible menu?','pixopoint_menu_lang'); ?></td>
							<td class='desc'>
								<p><?php _e('This option enables users to access your menu via the tab key on their keyboard rather than the mouse. Thanks to <a href="http://www.transientmonkey.com/">malcalevak</a> for writing the script. This option utilizes <a href="http://jquery.com/">jQuery</a>.','pixopoint_menu_lang'); ?></p>
							</td>
						</tr>
*/ ?>
						<tr class='inactive'>
							<th scope='row' class='check-column'>
									<?php
									if (get_option('suckerfish_superfish_arrows') == 'on') {echo '<input type="checkbox" name="suckerfish_superfish_arrows" checked="yes" />';}
									else {echo '<input type="checkbox" name="suckerfish_superfish_arrows" />';}
								?>
							</th>
							<td class='name'><?php _e('Enable arrow mark-up?','pixopoint_menu_lang'); ?></td>
							<td class='desc'>
								<p><?php _e('This option adds a small arrow to any menu option which contains children. Thanks to <a href="http://transientmonkey.com/">malcalevak</a> for help with implementing this feature. This option is controlled by the <a href="http://users.tpg.com.au/j_birch/plugins/superfish/">\'Superfish plugin\'</a> for <a href="http://jquery.com/">jQuery</a>.','pixopoint_menu_lang'); ?></p>
							</td>
						</tr>
					</tbody>
				</table>
			</div>





			<?php /* Advanced tab */ ?>
			<div class="tabbertab">
				<h2><?php _e('Advanced','pixopoint_menu_lang'); ?></h2>

				<?php // Load the My Page Order plugin stuff.
				if (!function_exists('mypageorder')){ // Only load the My Page Order stuff if the original plugin isn't enabled
				?>
				<div class="clear"></div>
				<table class="widefat" cellspacing="0" id="active-plugins-table">
					<thead>
					<tr>
						<th scope="col"><?php _e('Order your WordPress pages here','pixopoint_menu_lang'); ?>
					</tr>
					</thead>
					<tfoot>
						<tr>
							<th scope="col"><?php _e('Special thanks to <a href="http://www.geekyweekly.com">froman118</a> for creating the <a href="http://www.geekyweekly.com/mypageorder">My Page Order plugin</a> which this part of the PixoPoint Menu plugin is based on.','pixopoint_menu_lang'); ?></th>
						</tr>
					</tfoot>
					<tbody class="plugins">
						<tr class="inactive">
							<td class="desc">
								<p><?php _e('You may modify the order of your WordPress pages here. Note: This only controls \'Pages\' and not the other various options in the plugin such as \'Categories\' and \'Recent Comments\'.','pixopoint_menu_lang'); ?></p>
								<?php
									require('mypageorder.php');
									mypageorder();
								?>
								<p><br /><?php _e('To order your WordPress Categories, try installing the <a href="http://wordpress.org/extend/plugins/my-category-order/">My Category Order Plugin</a> which is able to do this.','pixopoint_menu_lang'); ?><br /></p>
							</td>
						</tr>
					</tbody>
				</table>
				<?php }

				// If My Page Order plugin is loaded then displays a message
				else { ?>
<script language="javascript">

	jQuery(document).ready(function(){
		jQuery("#order").sortable({
			placeholder: "ui-selected",
			revert: false,
			tolerance: "pointer"
		});
        jQuery("#widgetbox").sortable({
		  handle : '.handle',
		  update : function () {
              var order = jQuery('#widgetbox').sortable('serialize');
              jQuery("#info").load("<?php echo WP_PLUGIN_URL ?>/pixopoint-menu/process-sortable.php?"+order);
		  }
		});
	});
</script>
				<div class="clear"></div>
				<table class="widefat" cellspacing="0" id="active-plugins-table">
					<thead>
					<tr>
						<th scope="col"><?php _e('My Page Order plugin','pixopoint_menu_lang'); ?></th>
					</tr>
					</thead>
					<tfoot>
						<tr>
							<th scope="col"><?php _e('Special thanks to <a href="http://www.geekyweekly.com">froman118</a> for creating the <a href="http://www.geekyweekly.com/mypageorder">My Page Order plugin</a> which this part of the PixoPoint Menu plugin is based on.','pixopoint_menu_lang'); ?></th>
						</tr>
					</tfoot>
					<tbody class="plugins">
						<tr class="inactive">
							<td class="desc">
								<p><?php _e('You have the <a href="http://www.geekyweekly.com/mypageorder">My Page Order plugin</a> installed. Since that plugin has exactly the same functionality as this section of the PixoPoint Menu plugin we have deactivated that functionality for you. If you deactivate the My Page Order plugin, a drag and drop interface for controlling your WordPress Pages will appear here.','pixopoint_menu_lang'); ?></p>
								<p><?php _e('To order your WordPress Categories, try installing the <a href="http://wordpress.org/extend/plugins/my-category-order/">My Category Order Plugin</a> which is able to do this.','pixopoint_menu_lang'); ?></p>
							</td>
						</tr>
					</tbody>
				</table>
				<?php } ?>


				<div class="clear"></div>
				<table class="widefat" cellspacing="0" id="active-plugins-table">
					<thead>
					<tr>
						<th scope="col"><?php _e('You can manually modify your CSS for the main menu here.','pixopoint_menu_lang'); ?></th>
					</tr>
					</thead>
					<tfoot>
					<tr>
						<th scope="col"><?php _e('Note that when you save the CSS in the editing pane it will overwrite your changes here','pixopoint_menu_lang'); ?></th>
					</tr>
					</tfoot>
					<tbody class="plugins">
						<tr class="inactive">
							<td class="desc"><p><textarea name="suckerfish_css" style="width:100%;border:none" value="" rows="10"><?php echo get_option('suckerfish_css'); ?></textarea></p></td>
						</tr>
					</tbody>
				</table>

				<div class="clear"></div>
				<table class="widefat" cellspacing="0" id="active-plugins-table">
					<thead>
					<tr>
						<th scope="col"><?php _e('You can manually modify your CSS for the second menu here. Note that when you save the CSS in the editing pane it will overwrite your changes here.','pixopoint_menu_lang'); ?></th>
					</tr>
					</thead>
					<tfoot>
					<tr>
						<th scope="col"><?php _e('Note that when you save the CSS in the editing pane it will overwrite your changes here','pixopoint_menu_lang'); ?></th>
					</tr>
					</tfoot>
					<tbody class="plugins">
						<tr class="inactive">
							<td class="desc">
								<p><textarea name="suckerfish_2_css" style="width:100%;border:none" value="" rows="10"><?php echo get_option('suckerfish_2_css'); ?></textarea></p>
							</td>
						</tr>
					</tbody>
				</table>

				<div class="clear"></div>
				<table class="widefat" cellspacing="0" id="active-plugins-table">
					<thead>
					<tr>
						<th scope="col"><?php _e('Use this option to add extra CSS to the plugin.This CSS will <strong>not</strong> be modified when using the editing panel.','pixopoint_menu_lang'); ?></th>
					</tr>
					</thead>
					<tfoot>
					<tr>
						<th scope="col"><?php _e('This CSS will <strong>not</strong> be modified when using the editing panel','pixopoint_menu_lang'); ?></th>
					</tr>
					</tfoot>
					<tbody class="plugins">
						<tr class="inactive">
							<td class="desc"><p><textarea name="suckerfish_css_extra" style="width:100%;border:none" value="" rows="10"><?php echo get_option('suckerfish_css_extra'); ?></textarea></p></td>
						</tr>
					</tbody>
				</table>

				<?php
				// This is used by Gregs 'Custom fields' mod - I have no idea what the point of this is
				if (function_exists('pixopoint_menu_lang_advanced_customfields')) { ?>
				<div class="clear"></div>
				<table class="widefat" cellspacing="0" id="active-plugins-table">
					<thead>
					<tr>
						<th scope="col"><?php _e('This section is under development and is part of the advanced addon module.','pixopoint_menu_lang'); ?></th>
					</tr>
					</thead>
					<tfoot>
					<tr>
						<th scope="col"><?php _e('text goes here','pixopoint_menu_lang'); ?></th>
					</tr>
					</tfoot>
					<tbody class="plugins">
						<tr class="inactive">
							<td class="desc">
								<p><?php pixopoint_menu_lang_advanced_customfields(); ?></p>
							</td>
						</tr>
					</tbody>
				</table>
				<?php } ?>
			</div>






			<?php /* Help tab */ ?>
			<div class="tabbertab">
				<h2><?php _e('Help','pixopoint_menu_lang'); ?></h2>
				<div class="clear"></div>
				<table class="widefat" cellspacing="0" id="active-plugins-table">
					<thead>
					<tr>
						<th scope="col"><?php _e('Installation','pixopoint_menu_lang'); ?></th>
					</tr>
					</thead>
					<tfoot>
					<tr>
						<th scope="col"><?php _e('Thanks for using our plugin :)','pixopoint_menu_lang'); ?></th>
					</tr>
					</tfoot>
					<tbody class="plugins">
						<tr class="inactive">
							<td class="desc">
								<p><?php _e('Add the following code wherever you want the menu to appear in your theme (usually header.php)','pixopoint_menu_lang'); ?></p>
								<p><code><?php _e('&lt;?php if (function_exists(\'pixopoint_menu\')) {pixopoint_menu();}; ?&gt;','pixopoint_menu_lang'); ?></code></p>

								<h4><?php _e('Getting it working with your theme','pixopoint_menu_lang'); ?></h4>
								<p>
									<?php _e('Some of the more popular themes such as <a href="http://themehybrid.com/">Theme Hybrid</a>, <a href="http://themeshaper.com/">Thematic</a> and Thesis will work automatically when the \'Auto theme support\' option is chosen under the settings tab.','pixopoint_menu_lang'); ?>
								</p>
								<p><?php _e('The following is an example of the code modified in the WordPress Default (Kubrick) theme:','pixopoint_menu_lang'); ?><br />
								<code>
								&lt;div id="header" role="banner"&gt;<br />
									&lt;div id="headerimg"&gt;<br />
										&lt;h1&gt;&lt;a href="&lt;?php echo get_option('home'); ?&gt;/"&gt;&lt;?php bloginfo('name'); ?&gt;&lt;/a&gt;&lt;/h1&gt;<br />
										&lt;div class="description"&gt;&lt;?php bloginfo('description'); ?&gt;&lt;/div&gt;<br />
									&lt;/div&gt;<br />
								&lt;/div&gt;<br />
								&lt;?php if (function_exists('pixopoint_menu')) {pixopoint_menu();} ?&gt;<br />
								&lt;hr /&gt;
								</code>
								</p>
							</td>
						</tr>
					</tbody>
				</table>

				<div class="clear"></div>
				<table class="widefat" cellspacing="0" id="active-plugins-table">
					<thead>
					<tr>
						<th scope="col"><?php _e('Support','pixopoint_menu_lang'); ?></th>
					</tr>
					</thead>
					<tfoot>
					<tr>
						<th scope="col"><?php _e('Please do not email us directly or via our <a href="http://pixopoint.com/contact/">contact form</a> for unpaid support. We prefer to offer support in our <a href="http://pixopoint.com/forum/">forum</a> so that others may learn from the advice','pixopoint_menu_lang'); ?></th>
					</tr>
					</tfoot>
					<tbody class="plugins">
						<tr class="inactive">
							<td class="desc">
								<?php
								// Only added if main menu isn't already specified in theme - no point telling them to do something they're already doing
								if (!function_exists('pixopoint_mainmenu')) {?>
								<h4><?php _e('The easy way ... ','pixopoint_menu_lang'); ?></h4>
								<p><?php _e('The easiest way to setup the PixoPoint Menu Plugin is to use it with a theme specifically designed to support the plugin. All themes exported from the <a href="http://pixopoint.com/generator/">PixoPoint Template Generator</a> (which have dropdown menus) support this by default. Simply activate your theme, then activate the plugin and the new menu will appear instantly. Visit the <a href="http://pixopoint.com/generator/">PixoPoint Template Generator</a> to get your own pre-supported theme.','pixopoint_menu_lang'); ?></p>
								<p><?php _e('If you don\'t take this route then read on for simple instructions on how to integrate it into other themes ...','pixopoint_menu_lang'); ?></p>
								<?php } ?>
								<h4><?php _e('Paid support','pixopoint_menu_lang'); ?></h4>
								<p><?php _e('For direct help via the plugin author, please sign up for our Premium Support service ... <strong><a href="http://pixopoint.com/premium-support/">http://pixopoint.com/premium-support/</a></strong>','pixopoint_menu_lang'); ?></p>
								<p><?php _e('Our Premium Support option is ideal if you have insufficient time to fix any problems you may have or simply don\'t know much about coding, we not only offer techinical support and access to our latest betas but we will also install the plugin and set it up on your site if needed. We also do customisations of the plugin for some premium members, although we recommend contacting us via our <a href="http://pixopoint.com/contact/">contact form</a> for such requests as some customisations may require extra payment depending on their complexity.','pixopoint_menu_lang'); ?></p>
								<p><?php _e('If you have any questions about our premium services or are looking for other help with WordPress or (X)HTML/CSS projects including theme development please do not hesitate to contact us via our <a href="http://pixopoint.com/contact/">contact form</a>. More information about our premium services is available on our site ... <strong><a href="http://pixopoint.com/premium-support/">http://pixopoint.com/premium-support/</a></strong>','pixopoint_menu_lang'); ?></p>
								<h4><?php _e('FAQ','pixopoint_menu_lang'); ?></h4>
								<p><?php _e('<strong>Q:</strong><em> Your plugin doesn\'t work in IE, why don\'t you fix it?</em> <br /><strong>A:</strong> The plugin does work with IE, you just haven\'t integrated it correctly. See \'Free support\' below for some tips on how to get it working with IE.','pixopoint_menu_lang'); ?></p>
								<p><?php _e('<strong>Q:</strong><em> How do I change the menu contents?</em> <br /><strong>A:</strong> See the big tab at the top of the screen right now which says "Menu Contents"? Click that ...','pixopoint_menu_lang'); ?></p>
								<p><?php _e('<strong>Q:</strong><em> How do I change the colour/font/whatever in my menu?</em> <br /><strong>A:</strong> Click the \'home\' tab above and click the \'Enable Editing Panel\' button, then visit one of the main pages of your site which should now show an editing panel at the bottom of the screen.','pixopoint_menu_lang'); ?></p>
								<p><?php _e('<strong>Q:</strong><em> How do I get a fully customised version?</em> <br /><strong>A:</strong> Leave a message on the <a href="http://pixopoint.com/contact/">PixoPoint Contact Page</a> with your requirements and we will get back to you ASAP with pricing information. Alternatively you can sign up for our <a href="http://pixopoint.com/premium-support/">Premium Support</a> option which gives you access to our dropdown, flyout and slider menu CSS generator, plus access to our premium support forum.','pixopoint_menu_lang'); ?></p>
								<p><?php _e('<strong>Q:</strong><em> Why can\'t the plugin do X, Y or Z?</em> <br /><strong>A:</strong> It probably can, we just haven\'t supplied instructions on how to do it. If you have any requests, then please leave them in the <a href="http://pixopoint.com/forum/index.php?board=4.0">PixoPoint menu support board</a>. We often update the plugin with new functionality and we\'re far more likely to include the functionality you want if we know there is a demand for it already.','pixopoint_menu_lang'); ?></p>
								<h4><?php _e('Free support','pixopoint_menu_lang'); ?></h4>
								<p><?php _e('If you follow all of the instructions here, activate the plugin and find the menu is appearing on your site but looks all messed up, then the problem is probably caused by a clash between your themes CSS and plugins CSS. These problems can usually be remedied by removing the wrapper tags which surround the menu in your theme. For example, most themes will have some HTML such as <code>&lt;div id="nav"&gt;&lt;ul&gt;&lt;?php wp_list_pages(); ?&gt;&lt;/ul&gt;&lt;/div&gt;</code> which contains the existing themes menu. By placing the <code>wp_page_menu()</code> code between those DIV tags, the menu will often interact with that DIV tag. The solution is to either remove the DIV tag or to alter it\'s CSS so that it doesn\'t interact with the menu.','pixopoint_menu_lang'); ?></p>
								<p><?php _e('If you require further help with the plugin, please visit the <a href="http://pixopoint.com/pixopoint-menu/">PixoPoint Menu Plugin page</a> or the <a href="http://pixopoint.com/forum/index.php?board=4.0">PixoPoint menu support board</a>.','pixopoint_menu_lang'); ?></p>
								<p><?php _e('We are happy to answer questions but we\'ve been noticing lately that more time is being spent teaching people what to ask rather than actually answering anything. So before posting questions on the PixoPoint support forum, please read the following tips to help us answer your questions faster.','pixopoint_menu_lang'); ?></p>
								<ul>
									<li><?php _e('Where is your CSS?','pixopoint_menu_lang'); ?></li>
									<li><?php _e('What modifications have you made to the CSS?','pixopoint_menu_lang'); ?></li>
									<li><?php _e('What browsers are you having problems with?','pixopoint_menu_lang'); ?></li>
									<li><?php _e('What is the URL for your site?','pixopoint_menu_lang'); ?></li>
									<li><?php _e('Provide a link to the problem. Most problems can not be answered without actually seeing your site. If you don\'t want to install the plugin on your live site and don\'t have a test site to show us, then view the source code in your browser when you do have the plugin installed, save it to an HTML file and upload that somewhere so that we can see what the page looks like.','pixopoint_menu_lang'); ?></li>
									<li><?php _e('Do not bother providing us with HTML and/or CSS code snippets (without a link). There is very little we can do without seeing the entire page as most problems are caused by an obscure piece of CSS somewhere else on the page.','pixopoint_menu_lang'); ?></li>
									<li><?php _e('Let us know if you have modified the CSS. If it is modified we are unlikely to offer support for free. Rummaging through other peoples code is too time consuming sorry.','pixopoint_menu_lang'); ?></li>
									<li><?php _e('If you are not storing your CSS in the WP plugins settings page, let us know which <strong>exact</strong> file it is in. Searching through a dozen CSS files in your theme trying to find your menu code is not fun.','pixopoint_menu_lang'); ?></li>
								</ul>
								<h4><?php _e('Other plugins we recommend','pixopoint_menu_lang'); ?></h4>
								<p><?php _e('The <a href="http://wordpress.org/extend/plugins/my-category-order/">My Category Order Plugin</a> by <a href="http://www.geekyweekly.com/">froman118</a> allows you to set the order of \'WordPress Categories\' through a drag and drop interface. This replaces the need to use the clumsy default method of setting category orders built into WordPress.','pixopoint_menu_lang'); ?></p>
								<p><?php _e('If you know of any other plugins which work well with the \'PixoPoint Menu plugin\' then please us know about them.','pixopoint_menu_lang'); ?></p>
							</td>
						</tr>
					</tbody>
				</table>
				<div style="clear:both"></div>
			</div>





			<?php /* Credits tab */ ?>
			<div class="tabbertab">
				<h2><?php _e('Credits','pixopoint_menu_lang'); ?></h2>
				<div class="clear"></div>
				<table class="widefat" cellspacing="0" id="active-plugins-table">
					<thead>
						<tr>
							<th style="width:120px" scope="col"><?php _e('Credits','pixopoint_menu_lang'); ?></th>
							<th scope="col"><?php _e('Description','pixopoint_menu_lang'); ?></th>
						</tr>
					</thead>
					<tfoot>
						<tr>
							<th scope="col" colspan="2"><?php _e('Thank you to everyone who has helped with the development of the PixoPoint Menu Plugin.','pixopoint_menu_lang'); ?></th>
						</tr>
					</tfoot>
					<tbody class="plugins">
						<tr class='inactive'>
							<td class='name'><a href="http://transientmonkey.com/"><?php _e('Greg Yingling','pixopoint_menu_lang'); ?></a></td>
							<td class='desc'>
								<p><?php _e('Greg Yingling is the author of the WP SlimBox2 plugin and contributed a significant proportion of the code in the PixoPoint Menu plugin. Greg also contributed heavily to the <a href="http://pixopoint.com/multi-level-navigation-plugin/">Multi-level Navigation plugin</a> which the PixoPoint Menu plugin was based on.','pixopoint_menu_lang'); ?></p>
							</td>
						</tr>
						<tr class='inactive'>
							<td class='name'><a href="http://blog.mortia.org.uk/index.php/2009/07/16/pixopoint-menu-widget/"><?php _e('Andy Mortia','pixopoint_menu_lang'); ?></a></td>
							<td class='desc'>
								<p><?php _e('Andy Mortia created the <a href="http://blog.mortia.org.uk/index.php/2009/07/16/pixopoint-menu-widget/">PixoPoint Menu Widget</a> which can add the menu for the PixoPoint Menu plugin via a widget.','pixopoint_menu_lang'); ?></p>
							</td>
						</tr>
						<tr class='inactive'>
							<td class='name'><a href="http://www.geekyweekly.com/"><?php _e('froman118','pixopoint_menu_lang'); ?></a></td>
							<td class='desc'>
								<p><?php _e('The <a href="http://geekyweekly.com/mypageorder">My Page Order Plugin</a> created by <a href="http://www.geekyweekly.com/">froman118</a> was used to provide the code necessary for the drag and drop page ordering interface. <a href="http://www.geekyweekly.com/">froman118</a> is also the developer of the <a href="http://geekyweekly.com/mycategoryorder">My Category Order plugin</a> which is ideally suited for use with the PixoPoint Menu plugin. If you appreciate these features we recommend sending a donation to <a href="http://geekyweekly.com/mycategoryorder">froman118\'s beer fund</a>.','pixopoint_menu_lang'); ?></p>
							</td>
						</tr>
						<tr class='inactive'>
							<td class='name'><a href="http://wptavern.com/"><?php _e('Jeff Chandler','pixopoint_menu_lang'); ?></a></td>
							<td class='desc'>
								<p><?php _e('Jeff Chandler (aka WordPress Community Superstar) is the man behind <a href="http://wptavern.com/">WPTavern.com</a>, a small but busy site frequented by some of the most talented WordPress developers around. If you would like to learn more about WordPress and how it can be modified to suit your needs, you should head over to the tavern to see what the latest news is in the WordPress world. The tavern also features an active forum for discussing various WordPress related issues.','pixopoint_menu_lang'); ?></p>
							</td>
						</tr>
						<tr class='inactive'>
							<td class='name'><a href="http://pmob.co.uk/"><?php _e('Paul O\'Brien','pixopoint_menu_lang'); ?></a></td>
							<td class='desc'>
								<p><?php _e('Paul O\'Brien is an absolute master of HTML/CSS coding. He is the co-author of the <a href="">Ultimate CSS Reference</a> and can be found posting in the CSS board at <a href="http://sitepoint.com/">SitePoint.com</a> as well as at his personal site <a href="http://pmob.co.uk/">pmob.co.uk</a>. Paul was instrumental in ironing out the bugs in the CSS coding engine which provides the PixoPoint Menu plugin with it\s easy to use design editing capabilities.','pixopoint_menu_lang'); ?></p>
							</td>
						</tr>
						<tr class='inactive'>
							<td class='name'><a href="http://themehybrid.com/"><?php _e('Justin Tadlock','pixopoint_menu_lang'); ?></a></td>
							<td class='desc'>
								<p><?php _e('Justin Tadlock\'s Theme Hybrid framework is one of the most popular WordPress theme frameworks and is ideally suited to use with the PixoPoint Menu plugin. Simply install the Hybrid theme and the PixoPoint Menu plugin will automatically be displayed on your site (no theme editing necessary),','pixopoint_menu_lang'); ?></p>
							</td>
						</tr>
					</tbody>
				</table>

				<div class="clear"></div>
				<table class="widefat" cellspacing="0" id="active-plugins-table">
					<thead>
						<tr>
							<th style="width:120px" scope="col"><?php _e('Recommended plugins','pixopoint_menu_lang'); ?></th>
							<th scope="col"><?php _e('Description','pixopoint_menu_lang'); ?></th>
						</tr>
					</thead>
					<tfoot>
						<tr>
							<th scope="col" colspan="2"><?php _e('Here are selection of plugins we recommend using on your site. Note: These plugins were developed by friends of PixoPoint, they are not paid advertisements.','pixopoint_menu_lang'); ?></th>
						</tr>
					</tfoot>
					<tbody class="plugins">
						<tr class='inactive'>
							<td class='name'><a href="http://pixopoint.com/wp-slimbox2-plugin/"><?php _e('WP Slimbox2 plugin','pixopoint_menu_lang'); ?></a></td>
							<td class='desc'>
								<p><?php _e('Creates animated Javascript powered overlay popups of your images. Includes a plethora of options to allow you to modify it\'s behaviour. The use of jQuery allows for better integration with other plugins and a smaller size and therefore faster page loads.','pixopoint_menu_lang'); ?></p>
							</td>
						</tr>
						<tr class='inactive'>
							<td class='name'><a href="http://www.instinct.co.nz/wordpress-wiki-plugin/"><?php _e('WordPress Wiki','pixopoint_menu_lang'); ?></a></td>
							<td class='desc'>
								<p><?php _e('Tired of using Media Wiki? Sick of fighting with WordPress to get your own documentation project happening? If so then WordPress Wiki Plugin is the answer for you. Adds Wiki functionality to your WordPress powered website.','pixopoint_menu_lang'); ?></p>
							</td>
						</tr>
						<tr class='inactive'>
							<td class='name'><a href="http://www.instinct.co.nz/e-commerce/"><?php _e('WP e-Commerce','pixopoint_menu_lang'); ?></a></td>
							<td class='desc'>
								<p><?php _e('An elegant easy to use fully featured shopping cart application suitable for selling your products, services, and or fees online. Perfect for: Bands & Record Labels, Clothing Companies, Crafters & Artists, Books, DVDs & MP3 files.','pixopoint_menu_lang'); ?></p>
							</td>
						</tr>
					</tbody>
				</table>
				<div style="clear:both"></div>
			</div>

		<?php
		// Closing up the HTML for the admin page, including adding the list of options to be saved
		?>

		</div>
		<input type="hidden" name="action" value="update" />
		<input type="hidden" name="page_options" value="suckerfish_css, suckerfish_superfish, suckerfish_superfish_speed, suckerfish_superfish_time, suckerfish_superfish_timeout, suckerfish_pagestitle, suckerfish_excludepages, suckerfish_excludecategories, suckerfish_hometitle, suckerfish_pagesnoparentlinks, suckerfish_categoriestitle, suckerfish_archivestitle, suckerfish_blogrolltitle, suckerfish_recentcommentstitle, suckerfish_recentpoststitle, suckerfish_disablecss, suckerfish_custommenu, suckerfish_custommenu2, suckerfish_custommenu3, suckerfish_custommenu4,suckerfish_custommenu5, suckerfish_inlinecss, suckerfish_includeexcludepages, suckerfish_2_css, suckerfish_2_pagestitle, suckerfish_2_excludepages, suckerfish_2_excludecategories, suckerfish_2_hometitle, suckerfish_2_pagestitle, suckerfish_2_categoriestitle, suckerfish_2_archivestitle, suckerfish_2_blogrolltitle, suckerfish_2_recentcommentstitle, suckerfish_2_disablecss, suckerfish_2_custommenu, suckerfish_2_custommenu2, suckerfish_2_inlinecss, suckerfish_2_includeexcludepages, suckerfish_generator, suckerfish_delay, suckerfish_superfish_arrows, suckerfish_showdelay, suckerfish_displaycss, suckerfish_secondmenu, suckerfish_superfish_delaymouseover,	suckerfish_superfish_hoverintent, suckerfish_superfish_sensitivity, pixopoint_menu_maintenance, suckerfish_themesupport, suckerfish_compatibilitymode, suckerfish_categoryorder, suckerfish_pageorder, suckerfish_includeexcludecategories, suckerfish_homeurl, suckerfish_pagesurl, suckerfish_categoriesurl, suckerfish_archivesurl, suckerfish_blogrollurl, suckerfish_recentcommentsurl, suckerfish_recentpostsurl, suckerfish_depthcategories, suckerfish_depthpages, suckerfish_categorycount, suckerfish_categoryshowempty, suckerfish_titletags, suckerfish_customfields, suckerfish_menucontents, suckerfish_categories_showchildposts, suckerfish_categories_singledropdown, suckerfish_searchalignment, suckerfish_pages_singledropdown, enableeditingpane" />
		<div style="clear:both;padding-top:20px;"></div>
		<p class="submit"><input type="submit" name="Submit" value="<?php _e('Update Options') ?>" /></p>
		<div style="clear:both;padding-top:20px;"></div>
		<input type="hidden" name="option_page" value="pxp_editor" />
		<?php wp_nonce_field('pxp_editor-options'); ?>
	</form>
</div>
<?php }





/************************************************************
 ************************************************************
 ******* Adds content to HEAD section for admin pages *******
 ************************************************************
 ************************************************************/
function suckerfish_adminhead() {global $pixo_developmental;
	// Adds the enqueue'd scripts
	wp_enqueue_script('jquery-ui-sortable');
	wp_enqueue_script('tabber');
	// Loads the admin panel CSS file
	echo '<link rel="stylesheet" href="'.WP_PLUGIN_URL.'/pixopoint-menu/css/admin.css" type="text/css" media="screen" />';

}

/**
 * Whitelist the options for options.php's checks
 */
function pmp_whitelist($whitelist) {
	$whitelist['pxp_editor'] = array(
		'suckerfish_css',
		'suckerfish_superfish',
		'suckerfish_superfish_speed',
		'suckerfish_superfish_time',
		'suckerfish_superfish_timeout',
		'suckerfish_pagestitle',
		'suckerfish_excludepages',
		'suckerfish_excludecategories',
		'suckerfish_hometitle',
		'suckerfish_pagesnoparentlinks',
		'suckerfish_categoriestitle',
		'suckerfish_archivestitle',
		'suckerfish_blogrolltitle',
		'suckerfish_recentcommentstitle',
		'suckerfish_recentpoststitle',
		'suckerfish_disablecss',
		'suckerfish_custommenu',
		'suckerfish_custommenu2',
		'suckerfish_custommenu3',
		'suckerfish_custommenu4',
		'suckerfish_custommenu5',
		'suckerfish_inlinecss',
		'suckerfish_includeexcludepages',
		'suckerfish_2_css',
		'suckerfish_2_pagestitle',
		'suckerfish_2_excludepages',
		'suckerfish_2_excludecategories',
		'suckerfish_2_hometitle',
		'suckerfish_2_pagestitle',
		'suckerfish_2_categoriestitle',
		'suckerfish_2_archivestitle',
		'suckerfish_2_blogrolltitle',
		'suckerfish_2_recentcommentstitle',
		'suckerfish_2_disablecss',
		'suckerfish_2_custommenu',
		'suckerfish_2_custommenu2',
		'suckerfish_2_inlinecss',
		'suckerfish_2_includeexcludepages',
		'suckerfish_generator',
		'suckerfish_delay',
		'suckerfish_superfish_arrows',
		'suckerfish_showdelay',
		'suckerfish_displaycss',
		'suckerfish_secondmenu',
		'suckerfish_superfish_delaymouseover',
		'suckerfish_superfish_hoverintent',
		'suckerfish_superfish_sensitivity',
		'pixopoint_menu_maintenance',
		'suckerfish_themesupport',
		'suckerfish_compatibilitymode',
		'suckerfish_categoryorder',
		'suckerfish_pageorder',
		'suckerfish_includeexcludecategories',
		'suckerfish_homeurl',
		'suckerfish_pagesurl',
		'suckerfish_categoriesurl',
		'suckerfish_archivesurl',
		'suckerfish_blogrollurl',
		'suckerfish_recentcommentsurl',
		'suckerfish_recentpostsurl',
		'suckerfish_depthcategories',
		'suckerfish_depthpages',
		'suckerfish_categorycount',
		'suckerfish_categoryshowempty',
		'suckerfish_titletags',
		'suckerfish_customfields',
		'suckerfish_menucontents',
		'suckerfish_categories_showchildposts',
		'suckerfish_categories_singledropdown',
		'suckerfish_searchalignment',
		'suckerfish_pages_singledropdown',
		'enableeditingpane',
	);
	return $whitelist;
}
add_filter('whitelist_options', 'pmp_whitelist');
?>