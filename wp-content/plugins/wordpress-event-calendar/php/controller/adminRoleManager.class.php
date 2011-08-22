<?php
class adminRoleManager
{
	function userIsAdminLevel(){
		return current_user_can('manage_options');
	}
	
	function userIsAuthorLevel(){
		return current_user_can('publish_posts');
	}
	
	function userIsEditorLevel(){
		//return current_user_can('edit_others_pages');
		return true;
	}
}

?>