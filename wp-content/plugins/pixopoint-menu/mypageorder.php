<?php
/*
	This file loads an in built version of the 'My Page Order' plugin
	http://www.geekyweekly.com/mypageorder
	Original author:
		froman118
		http://www.geekyweekly.com
		froman118@gmail.com


	All code modified/removed by PixoPoint has been marked with comments accordingly


	This program is free software; you can redistribute it and/or modify
	it under the terms of the GNU General Public License as
	published by the Free Software Foundation.

	This program is distributed in the hope that it will be useful,
	but WITHOUT ANY WARRANTY; without even the implied warranty of
	MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.
*/

// All translations changed from 'mypageorder' to 'pixopoint_theme' so that they use the PixoPoint Menu plugins translation file

/* REMOVED BY PIXOPOINT
function mypageorder_menu()
{   if (function_exists('add_submenu_page')) {
        add_submenu_page(mypageorder_getTarget(), 'My Page Order', 'My Page Order', 5,"mypageorder",'mypageorder');
    }
}
*/

function mypageorder_js_libs() {
	if ( $_GET['page'] == "mypageorder" ) {
/* REMOVED BY PIXOPOINT
		wp_enqueue_script('jquery');
		wp_enqueue_script('jquery-ui-core');
		wp_enqueue_script('jquery-ui-sortable');*/
	}
}

//Switch page target depending on version
function mypageorder_getTarget() {
	global $wp_version;
	if (version_compare($wp_version, '2.6.5', '>'))
		return "page-new.php";
	else
		return "edit.php";
}

/* REMOVED BY PIXPOINT
add_action('admin_menu', 'mypageorder_menu');
*/
add_action('admin_menu', 'mypageorder_js_libs');

function mypageorder()
{
global $wpdb;
$mode = "";
$mode = $_GET['mode'];
$parentID = 0;
if (isset($_GET['parentID']))
	$parentID = $_GET['parentID'];
$success = "";

if($mode == "act_OrderPages")
{
	$idString = $_GET['idString'];
	$IDs = explode(",", $idString);
	$result = count($IDs);

	for($i = 0; $i < $result; $i++)
	{
		$wpdb->query("UPDATE $wpdb->posts SET menu_order = '$i' WHERE id ='$IDs[$i]'");
    }
	$success = '<div id="message" class="updated fade"><p>'. __('Page order updated successfully.', 'pixopoint_theme').'</p></div>';
}

	$subPageStr = "";
	$results=$wpdb->get_results("SELECT * FROM $wpdb->posts WHERE post_parent = $parentID and post_type = 'page' ORDER BY menu_order ASC");
	foreach($results as $row)
	{
		$postCount=$wpdb->get_row("SELECT count(*) as postsCount FROM $wpdb->posts WHERE post_parent = $row->ID and post_type = 'page' ", ARRAY_N);
		if($postCount[0] > 0)
	    	$subPageStr .= "<option value='$row->ID'>$row->post_title</option>";
	}
?>
<?php /* Removed by PixoPoint <div class='wrap'>
	<h2><?php _e('My Page Order', 'pixopoint_theme') ?></h2>*/ ?>
<?php echo $success; ?>
	<p><?php _e('Choose a page from the drop down to order its subpages or order the pages on this level by dragging and dropping them into the desired order.', 'pixopoint_theme') ?></p>

<?php
	if($parentID != 0)
	{
		$parentsParent = $wpdb->get_row("SELECT post_parent FROM $wpdb->posts WHERE ID = $parentID ", ARRAY_N);
		echo "<a href='options-general.php?page=pixopointmenuoptions&parentID=$parentsParent[0]'>" . __('Return to parent page', 'mypageorder') . "</a>";
	}
 if($subPageStr != "") { ?>
	<h3><?php _e('Order Subpages', 'pixopoint_theme') ?></h3>
	<select id="pages" name="pages"><?php
		echo $subPageStr;
	?>
	</select>
	&nbsp;<input type="button" name="edit" Value="<?php _e('Order Subpages', 'mypageorder') ?>" onClick="javascript:goEdit();">
<?php } ?>

	<h3><?php _e('Order Pages', 'pixopoint_theme') ?></h3>
	<?php /* Start: Add by PixoPoint */ ?>
	<br /><br />
	<?php /* End: Add by PixoPoint */ ?>
	<ul id="order"<?php /* REMOVED BY PIXOPOINT style="width: 500px; margin:10px 10px 10px 0px; padding:10px; border:1px solid #B2B2B2; list-style:none;"*/ ?>><?php
	foreach($results as $row)
	{
		echo "<li id='$row->ID' class='lineitem'>$row->post_title</li>";
	}?>
	</ul>
	<?php /* Start: Add by PixoPoint */ ?>
	<br />
	<div style="width:100%;float:left;clear:left;">
	<?php /* End: Add by PixoPoint */ ?>
	<input type="button" id="orderButton" Value="<?php _e('Click to Order Pages', 'pixopoint_theme') ?>" onclick="javascript:orderPages();">&nbsp;&nbsp;<strong id="updateText"></strong>

<?php /* Removed by PixoPoint </div> */ ?>

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

	function orderPages() {
		jQuery("#orderButton").css("display", "none");
		jQuery("#updateText").html("<?php _e('Updating Page Order...', 'pixopoint_theme') ?>");

		idList = jQuery("#order").sortable("toArray");
		location.href = 'options-general.php?page=pixopointmenuoptions&mode=act_OrderPages&parentID=<?php echo $parentID; ?>&idString='+idList;
	}

	function goEdit () {
		if(jQuery("#pages").val() != "")
			location.href = "options-general.php?page=pixopointmenuoptions&mode=dsp_OrderPages&parentID="+jQuery("#pages").val();
	}
</script>
<?php
}
?>
