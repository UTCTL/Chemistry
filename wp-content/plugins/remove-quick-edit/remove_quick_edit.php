<?
/*
Plugin Name: Remove quick edit
Plugin URI: http://www.sebastianbarria.com/plugins/remove-quick-edit/
Description: This plugin removes the "quick edit" button located in the pages and posts list by CSS. Ideal to use with qTranslate
Author: Sebastián Barría
Version: 1.1
Author URI: http://www.sebastianbarria.com/
*/

function remove_quick_edit(){
	?>
	<style type="text/css">
	#the-list .hide-if-no-js,a.editinline{display:none;}
	</style>
	<?
}
add_action('admin_print_styles-edit.php', 'remove_quick_edit');
?>