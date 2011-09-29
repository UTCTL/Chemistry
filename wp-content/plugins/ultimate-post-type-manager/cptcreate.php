<?php

if ( !function_exists( 'xydac_cpt_loader' ) ) { function xydac_cpt_loader()
{
$xydac_edit=array();
$editmode = false;
    //handles create Custom Post Types
	if(isset($_POST['xydac_create_cpt']))
    {
        if(isset($_POST["xy_post"]['name']) && empty($_POST["xy_post"]['name']))
            $xydac_error= new WP_Error('err', __("Custom Post Type Name is required to create New Custom Post Type","xydac_cpt"));
        elseif(in_array($_POST["xy_post"]['name'],get_reg_cptName())){
            $xydac_error= new WP_Error('err', __("Custom Post Type already registered !!!","xydac_cpt"));
        }
        else{
            if(isset($_POST["xy_post"]['name']))
            $_POST["xy_post"]['name'] = sanitize_title_with_dashes($_POST["xy_post"]['name']);
            $xydac_cpts = get_option("xydac_cpt");
            
            if(!$xydac_cpts)
            {
                $temp = array();
                array_push($temp,$_POST["xy_post"]);
                update_option('xydac_cpt',$temp);
            }
            if(is_array($xydac_cpts))
            {

                array_push($xydac_cpts,$_POST["xy_post"]);
                update_option('xydac_cpt',$xydac_cpts);
            }
            $message = __('Custom Post Type Added.',"xydac_cpt");
        $editmode = true;
        }
    }
	//handles update CPT
    if(isset($_POST['xydac_update_cpt']) && $_POST['cpt_name'])
    {
        $editmode = false;
        if(empty($_POST["xy_post"]['name']))
            $xydac_error= new WP_Error('err', __("Custom Post Type Name is required to create New Custom Post Type","xydac_cpt"));
        elseif($_POST["xy_post"]['name']!=$_POST['cpt_name']){
            $xydac_error= new WP_Error('err', __("Changing Name is not allowed !!!","xydac_cpt"));
        }
        else{
            $_POST["xy_post"]['name'] = sanitize_title_with_dashes($_POST["xy_post"]['name']);
            $xydac_cpts = get_option("xydac_cpt");
            if(is_array($xydac_cpts))
            {
                foreach($xydac_cpts as $k=>$xydac_cpt)
                     if($xydac_cpt['name']==$_POST['cpt_name'])
                     {unset($xydac_cpts[$k]);break;}
                array_push($xydac_cpts,$_POST["xy_post"]);
                update_option('xydac_cpt',$xydac_cpts);
                $message = __('Custom Post Type Updated.',"xydac_cpt");
            }
        $editmode = true;
        }
    }
	//handles delete CPT
    if((isset($_POST['xydac_cpt_doaction_submit']) && isset($_POST['action'])) || (isset($_GET['delete-single']) && isset($_GET['d_name'])))
    { $i=0;
         if((isset($_POST['action']) && $_POST['action']=='delete') || (isset($_GET['delete-single']) && $_GET['delete-single']=='delete'))
         {
            $xydac_cpts = get_option("xydac_cpt");
            if(isset($_POST['delete_cpt']))
            {
                foreach($_POST['delete_cpt'] as $k=>$v)
                {
                    if(is_array($xydac_cpts))
                    {
                        foreach($xydac_cpts as $k=>$xydac_cpt)
                             if($xydac_cpt['name']==$v)
                             {unset($xydac_cpts[$k]);$i=1;}
                    }
                }
            }
            elseif(isset($_GET['d_name']) && !empty($_GET['d_name']))
            {
                foreach($xydac_cpts as $k=>$xydac_cpt)
                         if($xydac_cpt['name']==$_GET['d_name'])
                         {unset($xydac_cpts[$k]);$i=1;}
            }
            if($i)
            {update_option('xydac_cpt',$xydac_cpts);
             $message = __('Custom Post Type Deleted.',"xydac_cpt");}
             else
             {
                 $message = __('Custom Post Type Not Deleted.',"xydac_cpt");}
         }
         $editmode = true;
    }
    if(isset($editmode) && !$editmode)
    {
        if(isset( $_POST["xy_post"]))
            $xydac_edit = $_POST["xy_post"];
    }
    if((isset($_GET['edit-cpt']) && isset($_GET['cptname'])) && !isset($_POST["xy_post"]))
    {
        $xydac_cpts = get_option("xydac_cpt");
        if(is_array($xydac_cpts))
            {
                foreach($xydac_cpts as $xydac_cpt)
                    if(isset($_GET['cptname']))
                    if($xydac_cpt['name']==$_GET['cptname'])
                    {
						
                        $xydac_edit = $xydac_cpt;break;
                    }
            }
    }
	if(isset($_POST['xydac_cpt_import_submit']) && isset($_POST['xydac_cpt_import']))
    {
			$m = xydac_import_cpt(stripslashes_deep($_POST['xydac_cpt_import']));
			if(is_wp_error($m))
				$xydac_error = $m;
			else
				$message = $m;
				
	}
    ?>
<div class="wrap" id="page_content">

 <?php
    xydac_cpt_heading("cpt_post");
    if (isset($xydac_error) && is_wp_error($xydac_error) )
        echo "<div class='error below-h2'><p>".$xydac_error->get_error_message()."</p></div>";//updated ?>
    <?php if(isset($message)) { ?>
    <div id="message" class="updated below-h2"><p><?php echo $message; ?></p></div>
    <?php } ?>
  <br class="clear" />
  <div id="col-container">
  <?php
	cpt_col_right();
    if((isset($_GET['edit-cpt']) && isset($_GET['cptname']))&&  (!$editmode))
        cpt_col_left($xydac_edit);
    else
    {
        cpt_col_left();
    }
	echo '</div></div>';

}}

if ( !function_exists( 'cpt_col_left' ) ) { function cpt_col_left($xydac_edit=false){
	$avl_types =__(":- NONE -:","xydac_cpt");
	if(is_array($xydac_edit))
		{		
		$c_fields = getCptFields($xydac_edit['name']);
		if(is_array($c_fields))
			{
			$avl_types ="";
			$avl_types.="<ul>";
			foreach($c_fields as $field)
				$avl_types.="<li><b>[xydac_field]".$field['field_name']."[/xydac_field]</b></li>"; 
			$avl_types.="</ul>";
			}
		}
	$xy_arrs = array(
	   'heading-1' => array('arr_label' => __('Labels','xydac_cpt') , 'name' => 'xydac_acc_label', 'type'=>'heading', 'initialclose'=>false),
	'label' =>  array( 'arr_label' => __('Label for Post Type ','xydac_cpt') , 'name' => 'xy_post[args][label]', 'type'=>'string', 'desc'=> __('A plural descriptive name for the post type marked for translation.','xydac_cpt') , 'default'=>' '),
	'name' => array( 'arr_label' => __('Name of Post Type','xydac_cpt') , 'name' => 'xy_post[args][labels][name]', 'type'=>'string', 'desc'=> __('general name for the post type, usually plural. The same as, and overridden by Label ','xydac_cpt') , 'default'=>' '),
	'singular_name' => array( 'arr_label' => __('Singular Name of Post Type','xydac_cpt') , 'name' => 'xy_post[args][labels][singular_name]', 'type'=>'string', 'desc'=> __('name for one object of this post type. Defaults to value of name ','xydac_cpt') , 'default'=>' '),
	'add_new' => array( 'arr_label' => __('Add New Label of Post Type','xydac_cpt') , 'name' => 'xy_post[args][labels][add_new]', 'type'=>'string', 'desc'=> __('the add new text. The default is Add New for both hierarchical and non-hierarchical types.','xydac_cpt') , 'default'=>' '), 
	'add_new_item' => array( 'arr_label' => __('Add New Item Label of Post Type','xydac_cpt') , 'name' => 'xy_post[args][labels][add_new_item]', 'type'=>'string', 'desc'=> __('the add new item text. Default is Add New Post/Add New Page','xydac_cpt') , 'default'=>' '), 
	'edit_item' => array( 'arr_label' => __('Edit Item Label of Post Type','xydac_cpt') , 'name' => 'xy_post[args][labels][edit_item]', 'type'=>'string', 'desc'=> __('the edit item text. Default is Edit Post/Edit Page','xydac_cpt') , 'default'=>' '),  
	'new_item' => array( 'arr_label' => __('New Item Label of Post Type','xydac_cpt') , 'name' => 'xy_post[args][labels][new_item]', 'type'=>'string', 'desc'=> __('the new item text. Default is New Post/New Page','xydac_cpt') , 'default'=>' '),
	'view_item' => array( 'arr_label' => __('View Item Label of Post Type','xydac_cpt') , 'name' => 'xy_post[args][labels][view_item]', 'type'=>'string', 'desc'=> __('the view item text. Default is View Post/View Page','xydac_cpt') , 'default'=>' '),
	'search_items' => array( 'arr_label' => __('Search Item Label of Post Type','xydac_cpt') , 'name' => 'xy_post[args][labels][search_item]', 'type'=>'string', 'desc'=> __('the search items text. Default is Search Posts/Search Pages','xydac_cpt') , 'default'=>' '),
	'not_found' => array( 'arr_label' => __('Not Found Item Label of Post Type','xydac_cpt') , 'name' => 'xy_post[args][labels][not_found]', 'type'=>'string', 'desc'=> __('the not found text. Default is No posts found/No pages found','xydac_cpt') , 'default'=>' '), 
	'not_found_in_trash' => array( 'arr_label' => __('Not Found in Thrash Label of Post Type','xydac_cpt') , 'name' => 'xy_post[args][labels][not_found_in_trash]', 'type'=>'string', 'desc'=> __('the not found in trash text. Default is No posts found in Trash/No pages found in Trash','xydac_cpt') , 'default'=>' '),  
	'parent_item_colon' => array( 'arr_label' => __('Parent Item with Colon Label of Post Type','xydac_cpt') , 'name' => 'xy_post[args][labels][parent_item_colon]', 'type'=>'string', 'desc'=> __('the parent text. This string isn\'t used on non-hierarchical types. In hierarchical ones the default is Parent Page:','xydac_cpt') , 'default'=>' '),
	'menu_name' => array( 'arr_label' => __('Menu Name','xydac_cpt') , 'name' => 'xy_post[args][labels][menu_name]', 'type'=>'string', 'desc'=> __('The menu name text. This string is the name to give menu items.','xydac_cpt') , 'default'=>' '),
	'enter_text_here' => array( 'arr_label' => __('Enter Text Here Label','xydac_cpt') , 'name' => 'xy_post[args][labels][enter_text_here]', 'type'=>'string', 'desc'=> __('The Enter Text Here title label for post type.','xydac_cpt') , 'default'=>' '),
		'heading-2' => array('arr_label' => __('Options','xydac_cpt') , 'name' => 'xydac_acc_options', 'type'=>'heading', 'initialclose'=>true),
	'public' => array( 'arr_label' => __('Public','xydac_cpt') , 'name' => 'xy_post[args][public]', 'type'=>'boolean', 'desc'=> __('This field is used to define default values for publicly_queriable, show_ui, show_in_nav_menus and exclude_from_search, But since the values for these fields is already present so I think this won\'t be used, Better leave this as it is.','xydac_cpt') , 'default'=>'true'),
	'publicly_queryable' => array( 'arr_label' => __('Publicly Queryable','xydac_cpt') , 'name' => 'xy_post[args][publicly_queryable]', 'type'=>'boolean', 'desc'=> __('Allows advanced query based operations from themes based on variable post_type.','xydac_cpt') , 'default'=>'true'),
	'exclude_from_search' => array( 'arr_label' => __('Exclude from search ','xydac_cpt') , 'name' => 'xy_post[args][exclude_from_search]', 'type'=>'boolean', 'desc'=> __('Whether to exclude posts with this post type from search results.','xydac_cpt') , 'default'=>'false'),
	'show_ui' => array( 'arr_label' => __('Show UI','xydac_cpt') , 'name' => 'xy_post[args][show_ui]', 'type'=>'boolean', 'desc'=> __('Whether use the default User Interface for the this Post Type.','xydac_cpt') , 'default'=>'true'),
	'query_var' => array( 'arr_label' => __('Query Var','xydac_cpt') , 'name' => 'xy_post[args][query_var]', 'type'=>'boolean', 'desc'=> __('Use False to disable Querying, True sets the query_var to the name of Post Type.','xydac_cpt') , 'default'=>'true'),
	'can_export' => array( 'arr_label' => __('Can Export','xydac_cpt') , 'name' => 'xy_post[args][can_export]', 'type'=>'boolean', 'desc'=> __('Allow Exporting of Post Types\'s Content from EXPORT option of WordPress.','xydac_cpt') , 'default'=>'true'),
	'show_in_nav_menus' => array( 'arr_label' => __('Show in Navigation Menu','xydac_cpt') , 'name' => 'xy_post[args][show_in_nav_menus]', 'type'=>'boolean', 'desc'=> __('Whether post_type is available for selection in navigation menus.','xydac_cpt') , 'default'=>'true'),
	'show_in_menu' => array( 'arr_label' => __('Show in Menu','xydac_cpt') , 'name' => 'xy_post[args][show_in_menu]', 'type'=>'boolean', 'desc'=> __('Whether to show the post type in the admin menu and where to show that menu. Note that show_ui must be true. ','xydac_cpt') , 'default'=>'true'),
	'has_archive' => array( 'arr_label' => __('Has Archive','xydac_cpt') , 'name' => 'xy_post[args][has_archive]', 'type'=>'boolean', 'desc'=> __('Enables post type archives. Will generate the proper rewrite rules if rewrite is enabled. ','xydac_cpt') , 'default'=>'true'),
	'map_meta_cap' => array( 'arr_label' => __('Map Meta Capabilities','xydac_cpt') , 'name' => 'xy_post[args][map_meta_cap]', 'type'=>'boolean', 'desc'=> __('Whether to use the internal default meta capability handling.This is used for default handling of Capabilities and should be set to TRUE for proper use ','xydac_cpt') , 'default'=>'true'),
	'hierarchical' => array( 'arr_label' => __('Hierarchical ','xydac_cpt') , 'name' => 'xy_post[args][hierarchical]', 'type'=>'boolean', 'desc'=> __('Whether the post type is hierarchical. Allows Parent to be specified.','xydac_cpt') , 'default'=>'false'),
	'menu_position' => array( 'arr_label' => __('Menu Position','xydac_cpt') , 'name' => 'xy_post[args][menu_position]', 'type'=>'array', 'desc'=> __('The position in the menu order the post type should appear.','xydac_cpt') , 'default'=>'5', 'values'=>array('null'=>'Below Comments','5'=>'Below Post','10'=>'Below Media','20'=>'Below Pages','60'=>'Below First Seperator','100'=>'Below Second Seperator')),
		'heading-3' => array('arr_label' => __('Features','xydac_cpt') , 'name' => 'xydac_acc_features', 'type'=>'heading', 'initialclose'=>true),
	'title' => array( 'arr_label' => __('Support for Title','xydac_cpt') , 'name' => 'xy_post[args][supports][title]', 'type'=>'boolean', 'desc'=> __(' ','xydac_cpt') , 'default'=>'true'),
	'editor' => array( 'arr_label' => __('Support for  Editor','xydac_cpt') , 'name' => 'xy_post[args][supports][editor]', 'type'=>'boolean', 'desc'=> __(' ','xydac_cpt') , 'default'=>'true'),
	'author' => array( 'arr_label' => __('Support for Author','xydac_cpt') , 'name' => 'xy_post[args][supports][author]', 'type'=>'boolean', 'desc'=> __(' ','xydac_cpt') , 'default'=>'false'),
	'thumbnail' => array( 'arr_label' => __('Support for Thumbnail','xydac_cpt') , 'name' => 'xy_post[args][supports][thumbnail]', 'type'=>'boolean', 'desc'=> __(' ','xydac_cpt') , 'default'=>'false'),
	'excerpt' => array( 'arr_label' => __('Support for  Excerpt','xydac_cpt') , 'name' => 'xy_post[args][supports][excerpt]', 'type'=>'boolean', 'desc'=> __(' ','xydac_cpt') , 'default'=>'false'),
	'trackbacks' => array( 'arr_label' => __('Support for Trackbacks','xydac_cpt') , 'name' => 'xy_post[args][supports][trackbacks]', 'type'=>'boolean', 'desc'=> __(' ','xydac_cpt') , 'default'=>'false'),
	'custom-fields' => array( 'arr_label' => __('Support for Custom Fields','xydac_cpt') , 'name' => 'xy_post[args][supports][custom-fields]', 'type'=>'boolean', 'desc'=> __(' ','xydac_cpt') , 'default'=>'false'),
	'comments' => array( 'arr_label' => __('Support for Comments','xydac_cpt') , 'name' => 'xy_post[args][supports][comments]', 'type'=>'boolean', 'desc'=> __(' ','xydac_cpt') , 'default'=>'false'),
	'revisions' => array( 'arr_label' => __('Support for Revisions','xydac_cpt') , 'name' => 'xy_post[args][supports][revisions]', 'type'=>'boolean', 'desc'=> __(' ','xydac_cpt') , 'default'=>'false'),
	'page-attributes' => array( 'arr_label' => __('Support for Page attributes','xydac_cpt') , 'name' => 'xy_post[args][supports][page-attributes]', 'type'=>'boolean', 'desc'=> __(' ','xydac_cpt') , 'default'=>'false'),
	'def-cats' => array( 'arr_label' => __('Show Default Category','xydac_cpt') , 'name' => 'xy_post[def][cat]', 'type'=>'boolean', 'desc'=> __('Show the Default Categories for this Custom Post Type ','xydac_cpt') , 'default'=>'false'),
	'def-tag' => array( 'arr_label' => __('Show Default Tags','xydac_cpt') , 'name' => 'xy_post[def][tag]', 'type'=>'boolean', 'desc'=> __('Show the Default Tags for this Custom Post Type ','xydac_cpt') , 'default'=>'false'),
		'heading-4' => array('arr_label' => __('Advanced Options','xydac_cpt') , 'name' => 'xydac_acc_ad_options', 'type'=>'heading', 'initialclose'=>true),
	'description' => array( 'arr_label' => __('Description','xydac_cpt') , 'name' => 'xy_post[args][description]', 'type'=>'string', 'desc'=> __('A short descriptive summary of what the post type is.','xydac_cpt') , 'default'=>' '),
	'capability_type' => array( 'arr_label' => __('Capability Type','xydac_cpt') , 'name' => 'xy_post[args][capability_type]', 'type'=>'string', 'desc'=> __('The post type to use for checking read, edit, and delete capabilities.The Capabilities will be automatically created.','xydac_cpt') , 'default'=>''),
	'register_meta_box_cb' => array( 'arr_label' => __('Register Meta Box CB','xydac_cpt') , 'name' => 'xy_post[args][register_meta_box_cb]', 'type'=>'string', 'desc'=> __('Provide a callback function that will be called when setting up the meta boxes for the edit form. Do remove_meta_box() and add_meta_box() calls in the callback.','xydac_cpt') , 'default'=>' '),
	'menu_icon' => array( 'arr_label' => __('Menu Icon','xydac_cpt') , 'name' => 'xy_post[args][menu_icon]', 'type'=>'string', 'desc'=> __('The url to the icon to be used for this menu.','xydac_cpt') , 'default'=>' '),
		'heading-41' => array('arr_label' => __('Rewrite Options','xydac_cpt') , 'name' => 'xydac_acc_rw_options', 'type'=>'heading', 'initialclose'=>true),
	'rewrite' => array( 'arr_label' => __('Rewrite','xydac_cpt') , 'name' => 'xy_post[args][rewrite][val]', 'type'=>'boolean', 'desc'=> __('Do you Want the Permalinks ceated for this post-type to be Rewritten.','xydac_cpt') , 'default'=>'true'),
	'slug' => array( 'arr_label' => __('Slug','xydac_cpt') , 'name' => 'xy_post[args][rewrite][slug]', 'type'=>'string', 'desc'=> __('Prepend posts with this slug. Uses Post-Type name if left blank.','xydac_cpt') , 'default'=>' '),
	'permalink_epmask' => array( 'arr_label' => __('Permalink_EPMASK','xydac_cpt') , 'name' => 'xy_post[args][permalink_epmask]', 'type'=>'string', 'desc'=> __('The default rewrite endpoint bitmasks.','xydac_cpt') , 'default'=>' '),
	'with_front' => array( 'arr_label' => __('With Front','xydac_cpt') , 'name' => 'xy_post[args][rewrite][with_front]', 'type'=>'boolean', 'desc'=> __('allowing permalinks to be prepended with front base','xydac_cpt') , 'default'=>'true'),
	'feeds' => array( 'arr_label' => __('Feeds','xydac_cpt') , 'name' => 'xy_post[args][rewrite][feeds]', 'type'=>'boolean', 'desc'=> __('','xydac_cpt') , 'default'=>'false'),
	'pages' => array( 'arr_label' => __('Pages','xydac_cpt') , 'name' => 'xy_post[args][rewrite][pages]', 'type'=>'boolean', 'desc'=> __('','xydac_cpt') , 'default'=>'true'),
		'heading-42' => array('arr_label' => __('Content Details','xydac_cpt') , 'name' => 'xydac_acc_con_details', 'type'=>'heading', 'initialclose'=>true),
	'content_html' => array( 'arr_label' => __('Content HTML','xydac_cpt') , 'name' => 'xy_post[content_html]', 'type'=>'textarea', 'desc'=> __('Please Enter the default template for the content.Use the litrel [CONTENT] wherever you want to show the default content.Else use the Shortcodes for display of other fields.<br/><b>Availaible Field Types :</b> <br/>'.$avl_types.' ','xydac_cpt'), 'default'=>''),
		'heading-5' => array('name'=>'finalheading','type'=>'heading','initialclose'=>true, 'finalclose'=>true),
	);
	?>

	<div id='col-left'><div class='col-wrap'>
		<div class='form-wrap'>
		<h3><?php if(is_array($xydac_edit)) _e('Edit Custom Post Type','xydac_cpt'); else _e('Add a New Custom Post Type','xydac_cpt'); ?></h3>
		<form <?php if(is_array($xydac_edit)) echo "id='form_edit_cpt'"; else echo "id='form_create_cpt'"; ?> action='<?php echo XYDAC_CPT_POST_PATH; ?>' method='post'>
		<div class="form-field form-required <?php if(isset($_POST['xydac_create_cpt']) || isset($_POST['xydac_edit_cpt'])) if(isset($_POST["xy_post"]['name']) && empty($_POST["xy_post"]['name'])) echo 'form-invalid';?>"  >
			<label for='xy_post[name]' style="font-weight:bold;"><?php _e('The Name of the Custom Post Type','xydac_cpt'); ?></label>
			<input type='text' name='xy_post[name]' class='name' <?php if(is_array($xydac_edit)) echo "readonly"; ?> id='xy_post[name]' value="<?php if(is_array($xydac_edit)) _e($xydac_edit['name'],'xydac'); ?>" />
			<p><?php _e('Custom Post Type Name identifies your Custom Post among others. It is usually all lowercase and contains only letters, numbers, and hyphens.','xydac_cpt');?></p><br/>
			
		</div>
		<?php if(is_array($xydac_edit)) { ?>
		<div id="accordion" >
		<?php
		foreach ($xy_arrs as $k=>$xy_arr)
		{$atemp = explode('[',substr($xy_arr['name'],6));
		if($xy_arr['type']=='heading'){ if($xy_arr['initialclose']) echo "</div>"; if(!isset($xy_arr['finalclose'])) { ?>
			<h3><?php echo $xy_arr['arr_label']; ?></h3><div>
			<?php  } } else {  ?>
		<div class='form-field' id="xydac_panel_<?php echo $xy_arr['name'] ?>"  >
		<?php if($xy_arr['type']=='boolean')
		{?><label for='<?php echo $xy_arr['name'] ?>' style="display:inline;font-weight:bold;"><?php echo $xy_arr['arr_label'] ?></label>
			<select id='<?php echo $xy_arr['name']; ?>' name='<?php echo $xy_arr['name'] ?>' class='postform' style="float:right;width:100px;margin-right:5%">
				<option value='true' <?php if($xy_arr['default']=='true' && !is_array($xydac_edit)) {echo 'selected';}elseif(is_array($xydac_edit)) { if(count($atemp)==2) {if($xydac_edit[substr($atemp[1],0,-1)]=='true')echo ' Selected';}elseif(count($atemp)==3) {if($xydac_edit[substr($atemp[1],0,-1)][substr($atemp[2],0,-1)]=='true')echo ' Selected';} elseif(count($atemp)==4) {if($xydac_edit[substr($atemp[1],0,-1)][substr($atemp[2],0,-1)][substr($atemp[3],0,-1)]=='true') echo 'selected'; }}  ?>><?php _e('True','xydac_cpt'); ?></option>
				<option value='false' <?php if($xy_arr['default']=='false' && !is_array($xydac_edit)){ echo 'selected';}elseif(is_array($xydac_edit)) { if(count($atemp)==2) {if($xydac_edit[substr($atemp[1],0,-1)]=='false')echo ' Selected';}elseif(count($atemp)==3) {if($xydac_edit[substr($atemp[1],0,-1)][substr($atemp[2],0,-1)]=='false')echo ' Selected';} elseif(count($atemp)==4) {if($xydac_edit[substr($atemp[1],0,-1)][substr($atemp[2],0,-1)][substr($atemp[3],0,-1)]=='false') echo 'selected';} } ?>><?php _e('False','xydac_cpt'); ?></option>
			</select>
		<?php } elseif($xy_arr['type']=='array') { ?>
			<label for='<?php echo $xy_arr['name'] ?>' style="display:inline;font-weight:bold;"><?php echo $xy_arr['arr_label'] ?></label>
			<select id='<?php echo $xy_arr['name']; ?>' name='<?php echo $xy_arr['name'] ?>' class='postform' style="float:right;width:150px;margin-right:5%">
				<?php  foreach($xy_arr['values'] as $n=>$c) {   ?>
					<option value='<?php echo $n; ?>' <?php if($xy_arr['default']==$n && !is_array($xydac_edit)) {echo 'selected';}elseif(is_array($xydac_edit)) { if(count($atemp)==2) {if($xydac_edit[substr($atemp[1],0,-1)]==$n)echo ' Selected';}elseif(count($atemp)==3) {if($xydac_edit[substr($atemp[1],0,-1)][substr($atemp[2],0,-1)]==$n)echo ' Selected';} elseif(count($atemp)==4) {if($xydac_edit[substr($atemp[1],0,-1)][substr($atemp[2],0,-1)][substr($atemp[3],0,-1)]==$n) echo 'selected'; }}  ?>><?php echo $c ?></option>
					<?php } ?>
			</select>
		<?php } elseif($xy_arr['type']=='string') { ?><label for='<?php echo $xy_arr['name'] ?>' style="font-weight:bold;"><?php echo $xy_arr['arr_label'] ?></label>
			<input type='text' name='<?php echo $xy_arr['name'] ?>' class='name' id='<?php echo $xy_arr['name'] ?>' value="<?php if(is_array($xydac_edit)) { if(count($atemp)==3) echo $xydac_edit[substr($atemp[1],0,-1)][substr($atemp[2],0,-1)]; elseif(count($atemp)==4) echo $xydac_edit[substr($atemp[1],0,-1)][substr($atemp[2],0,-1)][substr($atemp[3],0,-1)]; } ?>"/>
		<?php } elseif($xy_arr['type']=='textarea') { ?><label for='<?php echo $xy_arr['name'] ?>' style="font-weight:bold;"><?php echo $xy_arr['arr_label'] ?></label>
			<textarea style="height:300px" name='<?php echo $xy_arr['name'] ?>' class='name' id='<?php echo $xy_arr['name'] ?>'> <?php if(is_array($xydac_edit)) {echo $xydac_edit['content_html']; } ?></textarea>
		<?php } ?>
		<p><?php echo $xy_arr['desc'] ?></p>
		</div>
		<?php  } } if(is_array($xydac_edit)) {?>
				<input type="hidden" name="cpt_name" value="<?php if(isset($_GET['cptname'])) echo $_GET['cptname']; ?>">
			<?php } ?>
	</div>
		
		
		</div>
		<?php } ?>
		<p class='submit'>
		<input type="submit"  name="<?php if(!is_array($xydac_edit)) echo 'xydac_create_cpt'; else  echo 'xydac_update_cpt'; ?>" class="button-primary" value="<?php if(!is_array($xydac_edit)) _e('Add Custom Post Type','xydac_cpt'); else  _e('Update Custom Post Type','xydac_cpt'); ?>"></p>

		</form>
		</div>
		</div>
<?php }}

if ( !function_exists( 'cpt_col_right' ) ) { function cpt_col_right(){
    ?>
 <div id="col-right">
      <div class="form-wrap">
          <form id="form_edit" action="<?php echo XYDAC_CPT_POST_PATH; ?>" method="post"  >
          <div class="tablenav">
            <select name="action">
              <option value=""><?php _e('Bulk Actions','xydac_cpt'); ?></option>
              <option value="delete"><?php _e('Delete','xydac_cpt'); ?></option>
            </select>
            <input type="submit" class="button-secondary action"  id="xydac_cpt_doaction_submit" name="xydac_cpt_doaction_submit" value="Apply"/>
          </div><br class="clear">
          <table class="widefat tag fixed" cellspacing="0">
            <thead class="content-types-list">
              <tr>
                <th style="" class="manage-column column-cb check-column" id="cb" scope="col"><input type="checkbox"></th>
                <th style="" class="manage-column column-name" id="name" scope="col"><?php _e('Name','xydac_cpt'); ?></th>
                <th style="" class="manage-column column-fields" id="label" scope="col"><?php _e('Label','xydac_cpt'); ?></th>
              </tr>
            </thead>
            <tbody id="the-list">
            <?php
            $xydac_cpts = get_option("xydac_cpt");
			
			if(is_array($xydac_cpts))
                foreach($xydac_cpts as $xydac_cpt)
                { 
                ?>
            <tr id="content-type-<?php echo $xydac_cpt['name']; ?>" class="">
                <th class="check-column" scope="row">
                  <input type="checkbox" value="<?php echo $xydac_cpt['name']; ?>" name="delete_cpt[]"/>
                </th>
                <td class="name column-name">
                  <strong>
                      <a class="row-title" title="Edit &ldquo;<?php echo $xydac_cpt['name']; ?>&rdquo;" href="<?php echo XYDAC_CPT_POST_PATH."&edit-cpt=true&cptname=".$xydac_cpt['name']; ?>"><?php echo $xydac_cpt['name']; ?></a></strong><br />
                    <div class="row-actions">
                    <span class="edit"><a href="<?php echo XYDAC_CPT_POST_PATH."&edit-cpt=true&cptname=".$xydac_cpt['name']; ?>"><?php _e('Edit','xydac_cpt'); ?></a> | </span>
                    <span class="export"><a href="<?php echo XYDAC_CPT_POST_PATH."&export-cpt=true&cptname=".$xydac_cpt['name']; ?>"><?php _e('Export','xydac_cpt'); ?></a> | </span>
                    <span class="delete"><a href="<?php echo XYDAC_CPT_POST_PATH."&delete-single=delete&d_name=".$xydac_cpt['name']; ?>"><?php _e('Delete','xydac_cpt'); ?></a></span>
                  </div>
                </td>
                
                <td class="categories column-categories">
                    <?php echo $xydac_cpt['args']['label']; ?>
                </td>
            </tr>
           <?php //echo $row->field_name;
            }   ?>
            </tbody>
            <tfoot>
              <tr>
                <th style="" class="manage-column column-cb check-column"  scope="col"><input type="checkbox"></th>
                <th style="" class="manage-column column-name" id="name" scope="col"><?php _e('Name','xydac_cpt'); ?></th>
                <th style="" class="manage-column column-fields" id="label" scope="col"><?php _e('Label','xydac_cpt'); ?></th>
                
              </tr>
            </tfoot>
          </table>
        </form>
		<?php
		if((isset($_GET['export-cpt']) && isset($_GET['cptname'])) && !isset($_POST["xy_post"]))
		{
			echo "<h3>".__('Custom Post Type Export Data','xydac_cpt')."</h3>";
			echo "<a href='".XYDAC_CPT_POST_PATH."' >".__('Clear Data/ Import Form','xydac_cpt')."</a><br/><br/>";
			echo "<textarea style='height:200px;width:98%'>".xydac_export_cpt($_GET['cptname'])."</textarea>";
			_e("<em>NOTE: You can copy this data and paste it in the Import Post Type form and then click the Import Button to Import the Post Type as well as It's respective Custom Fields</em>",'xydac_custom');
		}
		else
		{ ?>
			<h3><?php _e('Custom Post Type Import Form','xydac_cpt'); ?></h3>
			<form id="form_import" action="<?php echo XYDAC_CPT_POST_PATH; ?>" method="post"  >
				<textarea style='height:200px;width:98%' name="xydac_cpt_import"></textarea>
				<input type="submit" class="button-secondary action"  id="xydac_cpt_import_submit" name="xydac_cpt_import_submit" value="Import"/>
			</form>
		<?php }
		?>
	
          <br class="clear">
          <br class="clear">
          <div class="form-wrap">
            

            </div>
      </div>
    </div>
<?php } }
?>