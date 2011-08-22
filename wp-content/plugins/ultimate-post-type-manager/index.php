<?php
/*
Plugin Name: Ultimate Post Type Manager
Plugin URI: http://posttypemanager.wordpress.com/
Description: Manage All your Custom Post Type with ease using this plugin.
Author: XYDAC
Version: 1.6.9
Author URI: http://xydac.wordpress.com/
License: GPL2
Text Domain: xydac_cpt
*/
/*  Copyright 2011  deepak.seth  (email : indk@ymail.com)

    This program is free software; you can redistribute it and/or modify
    it under the terms of the GNU General Public License, version 2, as
    published by the Free Software Foundation.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with this program; if not, write to the Free Software
    Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
*/
/*
@TODO :Seems there is some problem with accordian and form
*/
global $xydac_fields;
if ( !defined( 'XYDAC_CPT_NAME' ) )define('XYDAC_CPT_NAME',"ultimate-post-type-manager");
if ( !defined( 'XYDAC_CPT_VER' ) )define('XYDAC_CPT_VER',"1.6.9");
if ( !defined( 'XYDAC_CPT_HOME_PATH' ) )define('XYDAC_CPT_HOME_PATH',get_bloginfo('wpurl')."/wp-admin/options-general.php?page=".XYDAC_CPT_NAME."&sub=home");
if ( !defined( 'XYDAC_CPT_POST_PATH' ) )define('XYDAC_CPT_POST_PATH',get_bloginfo('wpurl')."/wp-admin/options-general.php?page=".XYDAC_CPT_NAME."&sub=custom-cpt");
if ( !defined( 'XYDAC_CPT_FIELDS_PATH' ) )define('XYDAC_CPT_FIELDS_PATH',get_bloginfo('wpurl')."/wp-admin/options-general.php?page=".XYDAC_CPT_NAME."&sub=custom-cpt-fields");
if ( !defined( 'XYDAC_CPT_CONTENT_PATH' ) )define('XYDAC_CPT_CONTENT_PATH',get_bloginfo('wpurl')."/wp-admin/options-general.php?page=".XYDAC_CPT_NAME."&sub=custom-cpt-content");

// loading plugin text domain.
load_plugin_textdomain( 'xydac_cpt', false, dirname( plugin_basename( __FILE__ ) ) );

//including required files
require_once('class-fieldType.php');
include "cptfields.php";
include "cptcontent.php";
include "cptcreate.php";
include "cptabout.php";

/**
 * xydac_cpt_heading()
 * This function is used for creating the tabs on the plugin page.
 * @param string $page :(cpt_home,cpt_post,cpt_field,cpt_content) Takes the input for page which is active.
 */
if ( !function_exists( 'xydac_cpt_heading' ) ) { function xydac_cpt_heading($page="cpt_home"){ 	 ?>
    <div id="icon-options-general" class="icon32"><br></div>
    <h2 style="border-bottom: 1px solid #CCC;padding-bottom:0px;">
        <a href="<?php echo XYDAC_CPT_HOME_PATH ?>" class="nav-tab <?php if($page=='cpt_home')  echo 'nav-tab-active' ?>"><?php _e('Home','xydac_cpt'); ?></a>
        <a href="<?php echo XYDAC_CPT_POST_PATH ?>" class="nav-tab <?php if($page=='cpt_post')  echo 'nav-tab-active' ?>"><?php _e('Ultimate Post Types','xydac_cpt'); ?></a>
        <a href="<?php echo XYDAC_CPT_FIELDS_PATH ?>" class="nav-tab <?php if($page=='cpt_fields')  echo 'nav-tab-active' ?>"><?php _e('Custom Fields','xydac_cpt'); ?></a>
        <!--<a href="<?php echo XYDAC_CPT_CONTENT_PATH ?>" class="nav-tab <?php if($page=='cpt_content')  echo 'nav-tab-active' ?>"><?php _e('Content','xydac_cpt'); ?></a>-->
    </h2> <br class="clear" />
    <?php
}}
/**
 * xydac_cpt_scripts()
 * This function is used to add the maine script file to WordPress Admin Head.
 * @return
 * Used in : xydac_cpt_menu()
 */
if ( !function_exists( 'xydac_cpt_scripts' ) ) { function xydac_cpt_scripts()
{
    wp_register_script('xydac_acc_js', WP_PLUGIN_URL.'/'.XYDAC_CPT_NAME.'/jquery-ui-1.8.5.custom.min.js', array('jquery'));
    wp_enqueue_script('xydac_acc_js'); 
}}
/**
 * xydac_cpt_menu()
 * This function adds the Post Type Manager admin Menu and adds a call to xydac_cpt_script on plugin page head.
 * @return
 * @Uses xydac_cpt_script
 */
if ( !function_exists( 'xydac_cpt_menu' ) ) { function xydac_cpt_menu() {
  $x_men = add_options_page(__('Post Type Manager','xydac_cpt'), __('Post Type Manager','xydac_cpt'), 'manage_options', XYDAC_CPT_NAME, 'xydac_cpt_menu_manager');
  add_action("admin_print_scripts-$x_men", 'xydac_cpt_scripts');
}}
/**
 * xydac_cpt_menu_manager()
 * Manages the various menu, Handles the page request and forward tit to respective menu function.
 * @return
 */
if ( !function_exists( 'xydac_cpt_menu_manager' ) ) { function xydac_cpt_menu_manager() {
	if (!current_user_can('manage_options'))  {
    wp_die( __('You do not have sufficient permissions to access this page.','xydac_cpt') );
	}
    if(isset($_GET['page']) || isset($_POST['page']))
	if($_GET['page']==XYDAC_CPT_NAME || $_POST['page']==XYDAC_CPT_NAME)
		{
			
            if(isset($_GET['sub']) || isset($_POST['sub']))
            {
                if((isset($_GET['sub']) && $_GET['sub']=='home') || (isset($_POST['sub']) && $_POST['sub']=='home'))
                {
					xydac_cpt_home();//cptabout.php
                }elseif((isset($_GET['sub']) && $_GET['sub']=='custom-cpt-fields') || (isset($_POST['sub']) && $_POST['sub']=='custom-cpt-fields'))
                {
					xydac_cpt();//cptfields.php
                }elseif((isset($_GET['sub']) && $_GET['sub']=='custom-cpt') || (isset($_POST['sub']) && $_POST['sub']=='custom-cpt'))
                {
					xydac_cpt_loader();//cptcreate.php
                }elseif((isset($_GET['sub']) && $_GET['sub']=='custom-cpt-content') || (isset($_POST['sub']) && $_POST['sub']=='custom-cpt-content'))
                {
					xydac_cpt_content();//cptcontent.php
                }
            }
            else
			{               
                xydac_cpt_home();
			}
		}
}}

/**
 * get_reg_cptName()
 * This function is used to find all registered Post types.
 * @return an array of registered Post types Names.
 */
if ( !function_exists( 'get_reg_cptName' ) ) { function get_reg_cptName(){
	
    $cpts=get_post_types('','objects');
    $a=array();
        foreach ($cpts  as $cpt=>$e ) {array_push($a,$e->name);}
    $cpts = get_option("xydac_cpt");
		if($cpts)
        foreach ($cpts  as $cpt ) {if(!in_array($cpt['name'],$a))  array_push($a,$cpt['name']);}
    return $a;
}}

/**
 * xydac_checkbool()
 * Converts string(false) to bool(false) and all other string to bool(true)
 * @param mixed $string
 * @return
 */
if ( !function_exists( 'xydac_checkbool' ) ) { function xydac_checkbool($string)
{
	if($string=='false')
		return false;
	else
		return true;
}}
/**
 * xydac_reg_cpt()
 * Used in Init call to Register all Custom Post Type in WordPress. After registering all Post Types it also flushes the rewrite rules.
 * @return
 */
if ( !function_exists( 'xydac_reg_cpt' ) ) { function xydac_reg_cpt(){
    $cpts = stripslashes_deep(get_option("xydac_cpt"));
    if (is_array($cpts) && !empty($cpts))
        foreach ($cpts  as $k=>$cpt )
        {
				$xy_cpt['name'] = $cpt['name'];
				$xy_cpt['args']['label'] = !empty($cpt['args']['label']) ? $cpt['args']['label'] : $xy_cpt['name'];
				$xy_cpt['args']['labels']['name'] = !empty($cpt['args']['labels']['name']) ? $cpt['args']['labels']['name'] : __($xy_cpt['args']['label']);
				$xy_cpt['args']['labels']['singular_name'] = !empty($cpt['args']['labels']['singular_name']) ? $cpt['args']['labels']['singular_name'] : __($xy_cpt['args']['labels']['name']);
				$xy_cpt['args']['labels']['add_new'] = !empty($cpt['args']['labels']['add_new']) ? $cpt['args']['labels']['add_new'] : __('Add New');
				$xy_cpt['args']['labels']['add_new_item'] = !empty($cpt['args']['labels']['add_new_item']) ? $cpt['args']['labels']['add_new_item'] : __('Add New '.$xy_cpt['args']['label']);
				$xy_cpt['args']['labels']['edit_item'] = !empty($cpt['args']['labels']['edit_item']) ? $cpt['args']['labels']['edit_item'] : __('Edit '.$xy_cpt['args']['label']);
				$xy_cpt['args']['labels']['new_item'] = !empty($cpt['args']['labels']['new_item']) ? $cpt['args']['labels']['new_item'] : __('New '.$xy_cpt['args']['label']);
				$xy_cpt['args']['labels']['view_item'] = !empty($cpt['args']['labels']['view_item']) ? $cpt['args']['labels']['view_item'] : __('View '.$xy_cpt['args']['label']);
				$xy_cpt['args']['labels']['search_item'] = !empty($cpt['args']['labels']['search_item']) ? $cpt['args']['labels']['search_item'] : __('Search '.$xy_cpt['args']['label']);
				$xy_cpt['args']['labels']['not_found'] = !empty($cpt['args']['labels']['not_found']) ? $cpt['args']['labels']['not_found'] : __('No '.$xy_cpt['args']['label'].' found');
				$xy_cpt['args']['labels']['not_found_in_trash'] = !empty($cpt['args']['labels']['not_found_in_trash']) ? $cpt['args']['labels']['not_found_in_trash'] : __('No '.$xy_cpt['args']['label'].' found in Thrash');
				$xy_cpt['args']['labels']['parent_item_colon'] = !empty($cpt['args']['labels']['parent_item_colon']) ? $cpt['args']['labels']['parent_item_colon'] : __('Parent '.$xy_cpt['args']['label']);
				@$xy_cpt['args']['labels']['menu_name'] = !empty($cpt['args']['labels']['menu_name']) ? $cpt['args']['labels']['menu_name'] : $xy_cpt['name'];
				$xy_cpt['args']['description'] = !empty($cpt['args']['description']) ? $cpt['args']['description'] : '';
			$xy_cpt['args']['public'] = xydac_checkbool($cpt['args']['public']);
			$xy_cpt['args']['publicly_queryable'] = xydac_checkbool($cpt['args']['publicly_queryable']);
			$xy_cpt['args']['exclude_from_search'] = xydac_checkbool($cpt['args']['exclude_from_search']);
			$xy_cpt['args']['show_ui'] = xydac_checkbool($cpt['args']['show_ui']);
				$xy_cpt['args']['capability_type'] =  !empty($cpt['args']['capability_type']) ? $cpt['args']['capability_type'] : 'post';
				$xy_cpt['args']['capabilities'] = array();
				if('post'!=$xy_cpt['args']['capability_type'])
				{
				
					$xy_cpt['args']['capabilities'] = array(
					'edit_post'=>'edit_'.$xy_cpt['args']['capability_type'],
					'read_post'=>'read_'.$xy_cpt['args']['capability_type'],
					'delete_post'=>'delete_'.$xy_cpt['args']['capability_type'],
					'edit_posts'=>'edit_'.$xy_cpt['args']['capability_type'].'s',
					'edit_others_posts'=>'edit_others_'.$xy_cpt['args']['capability_type'].'s',
					'publish_posts'=>'publish_'.$xy_cpt['args']['capability_type'].'s',
					'read_private_posts'=>'read_private_'.$xy_cpt['args']['capability_type'].'s'
					);
				}
				

			$xy_cpt['args']['hierarchical'] = xydac_checkbool($cpt['args']['hierarchical']);
			$xy_cpt['args']['supports'] = array();
			if(xydac_checkbool($cpt['args']['supports']['title'])) array_push($xy_cpt['args']['supports'],'title');
			if(xydac_checkbool($cpt['args']['supports']['editor'])) array_push($xy_cpt['args']['supports'],'editor');
			if(xydac_checkbool($cpt['args']['supports']['author'])) array_push($xy_cpt['args']['supports'],'author');
			if(xydac_checkbool($cpt['args']['supports']['thumbnail'])) array_push($xy_cpt['args']['supports'],'thumbnail');
			if(xydac_checkbool($cpt['args']['supports']['excerpt'])) array_push($xy_cpt['args']['supports'],'excerpt');
			if(xydac_checkbool($cpt['args']['supports']['trackbacks'])) array_push($xy_cpt['args']['supports'],'trackbacks');
			if(xydac_checkbool($cpt['args']['supports']['custom-fields'])) array_push($xy_cpt['args']['supports'],'custom-fields');
			if(xydac_checkbool($cpt['args']['supports']['comments'])) array_push($xy_cpt['args']['supports'],'comments');
			if(xydac_checkbool($cpt['args']['supports']['revisions'])) array_push($xy_cpt['args']['supports'],'revisions');
			if(xydac_checkbool($cpt['args']['supports']['page-attributes'])) array_push($xy_cpt['args']['supports'],'page-attributes');
				$xy_cpt['args']['register_meta_box_cb'] = !empty($cpt['args']['register_meta_box_cb']) ? $cpt['args']['register_meta_box_cb'] : '';
			$xy_cpt['args']['menu_position'] = intval($cpt['args']['menu_position']);
				$xy_cpt['args']['menu_icon'] = !empty($cpt['args']['menu_icon']) ? $cpt['args']['menu_icon'] : null;
				$xy_cpt['args']['permalink_epmask'] = !empty($cpt['args']['permalink_epmask']) ? $cpt['args']['permalink_epmask'] : 'EP_PERMALINK';
			$xy_cpt['args']['rewrite'] = xydac_checkbool($cpt['args']['rewrite']['val']);
			if(xydac_checkbool($cpt['args']['rewrite']['val'])){
				$xy_cpt['args']['rewrite'] =array();
				$xy_cpt['args']['rewrite']['slug'] = !empty($cpt['args']['rewrite']['slug']) ? $cpt['args']['rewrite']['slug'] :$xy_cpt['name'];
				$xy_cpt['args']['rewrite']['with_front'] = xydac_checkbool($cpt['args']['rewrite']['with_front']);
				$xy_cpt['args']['rewrite']['feeds'] = xydac_checkbool($cpt['args']['rewrite']['feeds']);
				$xy_cpt['args']['rewrite']['pages'] = xydac_checkbool($cpt['args']['rewrite']['pages']);
			}
			else
				$xy_cpt['args']['rewrite'] = xydac_checkbool($cpt['args']['rewrite']['val']);
			$xy_cpt['args']['query_var'] = xydac_checkbool($cpt['args']['query_var']);
			$xy_cpt['args']['can_export'] = xydac_checkbool($cpt['args']['can_export']);
			$xy_cpt['args']['show_in_nav_menus'] = xydac_checkbool($cpt['args']['show_in_nav_menus']);
			$xy_cpt['args']['show_in_menu'] = xydac_checkbool($cpt['args']['show_in_menu']);
			$xy_cpt['args']['has_archive'] = xydac_checkbool($cpt['args']['has_archive']);
			$xy_cpt['args']['map_meta_cap'] = xydac_checkbool($cpt['args']['map_meta_cap']);
			register_post_type( $xy_cpt['name'], $xy_cpt['args'] );
			//adding enter_text_here to keep the data in db
			@$xy_cpt['args']['labels']['enter_text_here'] =  $cpt['args']['labels']['enter_text_here'];
			if(!empty($cpt['def']['cat']) && xydac_checkbool($cpt['def']['cat']))
				register_taxonomy_for_object_type('category',  $xy_cpt['name']); 
			if(!empty($cpt['def']['cat']) && xydac_checkbool($cpt['def']['tag']))
				register_taxonomy_for_object_type('post_tag',  $xy_cpt['name']); 
			$cpts[$k]['args']['label'] = $xy_cpt['args']['label'];
			$cpts[$k]['args']['labels'] = $xy_cpt['args']['labels'];
		}
	update_option("xydac_cpt",$cpts);
	if(function_exists('flush_rewrite_rules'))
    flush_rewrite_rules();
	
	}}

/**
 * xydac_right_now()
 * function for modifying the Right Now box to show stats
 * @return
 */
if ( !function_exists( 'xydac_right_now' ) ) { function xydac_right_now() {
	$cpts = get_option("xydac_cpt");
    if (is_array($cpts) && !empty($cpts))
        foreach ($cpts  as $cpt )
        {
        $num_posts = wp_count_posts( $cpt['name'] );
        $num = number_format_i18n( $num_posts->publish );
		if(!empty($cpt['args']['label']))
			$text = _n( $cpt['args']['label'], $cpt['args']['label'], intval($num_posts->publish) );
		else
			$text = _n( $cpt['name'], $cpt['name'], intval($num_posts->publish) );
        if ( current_user_can( 'edit_posts' ) ) {
            $num = "<a href='edit.php?post_type=".$cpt['name']."'>$num</a>";
            $text = "<a href='edit.php?post_type=".$cpt['name']."'>$text</a>";
        }
        echo '<td class="first b b-'.$cpt['name'].'">' . $num . '</td>';
        echo '<td class="t '.$cpt['name'].'">' . $text . '</td>';
        echo '</tr>';

	}
}}



/**
 * xydac_posts_home()
 * function for adding all post types to homepage and feeds.
 * @param mixed $query
 * @return
 */
if ( !function_exists( 'xydac_posts_home' ) ) { function xydac_posts_home( $query ) {
  if ( !is_preview() && !is_admin() && !is_singular() && !is_404() ) {
    $args = array(
      'public' => true ,
      '_builtin' => false
    );
    $post_types = get_post_types( $args );
    $post_types = array_merge( $post_types , array( 'post' ) );
    $my_post_type = get_query_var( 'post_type' );
    if ( empty( $my_post_type ) )
        $query->set( 'post_type' , $post_types );
  }
}}
/**
 * custom_meta_admin()
 * Adds the XYDAC Custom Field Meta Box to Post Edit Page
 * @return
 */
if ( !function_exists( 'custom_meta_admin' ) ) { function custom_meta_admin(){
	//wp_enqueue_style('xydac_custom_field_css',  WP_PLUGIN_URL.'/'.XYDAC_CPT_NAME.'/customfield.css');
	add_thickbox();
	
	$cpt_names = get_reg_cptName();
	if(is_array($cpt_names))
		foreach($cpt_names as $cpt_name)
			{
				$opt = getCptFields($cpt_name);
				if($opt)
					add_meta_box('xydac-custom-meta-div', __('XYDAC Custom Fields','xydac_cpt'),  'xydac_custom_meta', $cpt_name, 'normal', 'high');
			}

}}

/**
 * xydac_cpt_shortcode()
 * Adds Shotcode xydac_field function.
 * @param mixed $atts : Different attributes supplied with [xydac_field] shortcode
 * @param mixed $text : The name of Custom Field
 * @return string $s  : The HTML output of the value of shortcode.
 */
if ( !function_exists( 'xydac_cpt_shortcode' ) ) { function xydac_cpt_shortcode($atts, $text) {
	global $post;
	$t=get_post_meta($post->ID, $text, true);
		$fields = getCptFields($post->post_type);
	if(!is_array($t))
		return $t;
	else
		{
		$s='';
		foreach($t as $k=>$v)//$k = field type
			{
				foreach($fields as $field)
				if(($field['field_type']==$k) && ($field['field_name']==$text))
		 		{
					$temp_field = new $k($field['field_name'],$field['field_label'],$field['field_desc'],$field['field_val']);
					$s.= $temp_field->output($v,$atts);
				}
			}
		return $s;
		}
}}
/**
 * xydac_loadfields()
 * This function is used to include all the fieldtypes.
 * @return
 */
if ( !function_exists( 'xydac_loadfields' ) ) { function xydac_loadfields() {
	global $xydac_fields;
	$xydac_active_field_types = get_option("xydac_active_field_types");
	$xydac_fields = array();
	$adminscript = "";
	$adminstyle = "";
	$sitescript = "";
	$sitestyle = "";
	$plugin_dir = basename(dirname(__FILE__));
    load_plugin_textdomain( 'xydac_cpt', false, $plugin_dir );

	foreach(glob(WP_PLUGIN_DIR.'/'.XYDAC_CPT_NAME.'/fieldTypes/*.php') as $file)
				{
					include_once($file);
					$filename = explode("-",basename($file,'.php'));
					$temp = new $filename[1]('t1');
					if(is_array($xydac_active_field_types))
					if(in_array($temp->ftype,$xydac_active_field_types))
					{
						$adminscript.= $temp->adminscript();
						$adminstyle.= $temp->adminstyle();
						$sitescript.= $temp->sitescript();
						$sitestyle.= $temp->sitestyle();
					}
					$xydac_fields['fieldtypes'][$temp->ftype] = $temp->flabel;
				}
	$xydac_fields['adminscript'] = $adminscript;
	$xydac_fields['adminstyle'] = $adminstyle;
	$xydac_fields['sitescript'] = $sitescript;
	$xydac_fields['sitestyle'] = $sitestyle;
	wp_enqueue_script('jquery');
}}

if ( !function_exists( 'xydac_enter_title_here_manager' ) ) {function xydac_enter_title_here_manager($content)
{
	global $post;
	$cpts = get_option("xydac_cpt");
	foreach($cpts as $cpt)
		if($cpt['name']==get_post_type($post))
			if(isset($cpt['args']['labels']['enter_text_here']))
				return $cpt['args']['labels']['enter_text_here'];
	return $content;
}}
/**
 * the_content_manager()
 * This function manages the replacement of Content, and can be used for styling of WordPress.
 * @param mixed $content
 * @return
 */
if ( !function_exists( 'the_content_manager' ) ) {function the_content_manager($content)
{
	global $post;
	$post_type = get_post_type($post);
	
	$xydac_cpts = get_option("xydac_cpt");
	$con ="";
	if(is_array($xydac_cpts))
	{
	foreach($xydac_cpts as $xydac_cpt)
		if($xydac_cpt['name']==$post_type)
		{
			
			$con = $xydac_cpt['content_html'];
			$val='';
			if(''==$con)
				$val = do_shortcode($content);
			else
				$val = preg_replace("/\[CONTENT]/", do_shortcode($content), $con);
			return $val;
		}
	}
	return $content;
	
}}

/**
 * __autoload()
 * Loads the class file name when required
 * @param mixed $class_name : name of class file to load
 * @return
 */
function __autoload($class_name) {
    $path = array(WP_PLUGIN_DIR.'/'.XYDAC_CPT_NAME.'/fieldTypes/');
    foreach ($path as $directory) {
        if (file_exists($directory . 'class-'.$class_name . '.php')) {
                require_once ($directory . 'class-'.$class_name . '.php');
                return;
        }
    }
}
/**
 * xydac_admin_head()
 * The main function that adds script and style to admin panel head
 * @return
 */
if ( !function_exists( 'xydac_admin_head' ) ) {function xydac_admin_head()
{
	global $xydac_fields;
	wp_tiny_mce();
	?><script type="text/javascript">/* <![CDATA[ */
		jQuery(document).ready(function() { jQuery('.xydac-custom-meta li a').each(function(i) { var thisTab = jQuery(this).parent().attr('class').replace(/active /, ''); 
if ( 'active' != jQuery(this).attr('class') ) jQuery('div.' + thisTab).hide(); 
jQuery('div.' + thisTab).addClass('tab-content'); jQuery(this).click(function(){ jQuery(this).parent().parent().parent().children('div').hide(); jQuery(this).parent().parent('ul').find('li.active').removeClass('active'); jQuery(this).parent().parent().parent().find('div.'+thisTab).show(); jQuery(this).parent().parent().parent().find('li.'+thisTab).addClass('active'); }); }); 
jQuery('.heading').hide(); jQuery('.xydac-custom-meta').show(); }); 
		<?php echo $xydac_fields['adminscript']; ?>
	/* ]]> */</script>
	<style type="text/css">
	ul.xydac-custom-meta { display: none; margin-top: 12px; margin-bottom: 3px; } .xydac-custom-meta-div ul { list-style: none; } .xydac-custom-meta li { display: inline;background-color: #F1F1F1;border-color: #DFDFDF #DFDFDF #CCCCCC;border-width:1px;border-style: solid;} ul.xydac-custom-meta li.active { background-color: #E9E9E9;border-style: solid solid none; border-width: 1px 1px 0; border-color: #CCCCCC #CCCCCC #E9E9E9; } ul.xydac-custom-meta li { padding: 5px; -moz-border-radius: 3px 3px 0 0; -webkit-border-top-left-radius: 3px; -webkit-border-top-right-radius: 3px; -khtml-border-top-left-radius: 3px; -khtml-border-top-right-radius: 3px; border-top-left-radius: 3px; border-top-right-radius: 3px; }  .xydac-custom-meta li a { text-decoration: none;color: #999999; } .xydac-custom-meta li.active a { text-decoration: none;color: #21759B;font-weight:bold; } .xydac-custom-meta-div div.tabs-panel { overflow: auto; padding: 0.5em 0.9em; border-style: solid; border-width: 1px; } .xydac-custom-meta .heading { padding-left:10px; } .xydac-custom-meta .tab-content{ overflow: auto; padding: 0.5em 0.9em;border: 1px solid #DFDFDF; } 
	.xydac-custom-meta .description { display:none; } .xydac-custom-meta label { display:block; font-weight:bold; margin:6px; margin-bottom:0; margin-top:12px; } .xydac-custom-meta label span { display:inline; font-weight:normal; } .xydac-custom-meta span { color:#999; display:block; } .xydac-custom-meta select, .xydac-custom-meta textarea, .xydac-custom-meta input[type='text'] { margin-bottom:0px; width:99%; } .xydac-custom-meta h4 { color:#999; font-size:1em; margin:15px 6px; text-transform:uppercase; } 
	.xydac-custom-meta label.radio { display:inline; font-weight:normal; margin-left:5px; } 
	.xydac-custom-meta p { padding-left:5px; } p.customEditor { padding-left:0px; } 
	div#accordion .ui-state-default{ cursor:pointer;background:#F6F6F6;border:1px solid #DDD;padding:5px; } div#accordion .ui-state-active{ cursor:pointer;background:#21759B;border:1px solid #FFF;padding:5px;margin:0px;color:#ff0;border-bottom:1px solid #000 } div#accordion .ui-accordion-content-active{ border:1px solid #21759B; } div#accordion .form-field{ border-top:1px solid #21759B; } /* ---------- */ .xydac-custom-meta .customEditor { margin:15px 6px; border:1px solid #ccc; background: none repeat scroll 0 0 #FFFFFF; } .xydac-custom-meta .customEditor textarea { border:0; } #post-body .xydac-custom-meta .customEditor .mceStatusbar a.mceResize { top:-2px; } .xydac-custom-meta span {display:inline;} .xydac-custom-meta .hrule {height:0px; color:#DFDFDF;border:1px solid;border-bottom-color: #DFDFDF;border-top-color: #FFFFFF; width:98%;} 
	<?php echo $xydac_fields['adminstyle']; ?>
	</style>
	<?php
}}
/**
 * xydac_site_head()
 * Adds the default CSS and Script to the head section of Website.
 * @return
 */

if ( !function_exists( 'xydac_site_head' ) ) {function xydac_site_head()
{
	global $xydac_fields;
	//wp_enqueue_script('jquery');
	?><script type="text/javascript">/* <![CDATA[ */
		<?php echo $xydac_fields['sitescript']; ?>
	/* ]]> */</script>
	<style type="text/css">
		<?php echo $xydac_fields['sitestyle']; ?>
	</style>
	<?php
}}

/**
 * xydac_custom_meta()
 * The main function to create the HTML content of EDIT POST Meta Box.
 * @param mixed $post
 * @return
 */
if ( !function_exists( 'xydac_custom_meta' ) ) { function xydac_custom_meta($post) {
	//$val = get_post_meta($post->ID, 'product-ver', TRUE);
	$fields = getCptFields($post->post_type);
	$notbasic = array();
	$inputfields=array();
	$t="";
	$e="";
	foreach($fields as $k=>$field)
		{
				$field_temp = new $field['field_type']($field['field_name'],$field['field_label'],$field['field_desc'],$field['field_val']);
				if($field_temp->isBasic())
					{
					$t.= $field_temp->input($post->ID);
					$t.= "<hr class='hrule clear'>";
					array_push($inputfields,$field['field_name']);
					}
				else
					array_push($notbasic,$field);
		}
	$e.= "<div class='xydac-custom-meta'>";
	$e.= '<ul class="xydac-custom-meta" id="xydac-custom-meta">
			<li class="active xydac-custom"><a class="active" href="javascript:void(null);">Basic</a></li>';
			foreach($notbasic as $k=>$field)
				{
					$e.='<li class="'.$field['field_name'].'"><a href="javascript:void(null);">'.$field['field_type'].'-'.$field['field_label'].'</a></li>';
				}
	$e.= '<li class="inputfields"><a href="javascript:void(null);">Shortcodes</a></li>';
	$e.='</ul>';
	$e.= "<div class='xydac-custom'>";
	$e.="<input type='hidden' name='xydac_custom_nonce' id='xydac_custom_nonce' value='".wp_create_nonce( plugin_basename(__FILE__) )."' />";
	$e.=$t;
	$e .="</div>";
	foreach($notbasic as $k=>$field)
		{
			$e.= "<div class='".$field['field_name']."'>";
			$field_temp = new $field['field_type']($field['field_name'],$field['field_label'],$field['field_desc']);
			$e.= $field_temp->input($post->ID);
			$e.= "</div>";
			array_push($inputfields,$field['field_name']);
		}
	$e.='<div class="inputfields">';
	$e.='<h4>'.__('Availaible Shortcodes For Use ','xydac_cpt').'</h4>';
	$e.= "<hr class='hrule clear'>";
	$e.='<p style="word-spacing:2px;letter-spacing:3px"><strong>'.__('You can use these shortcodes anywhere to get the values for them at used location.','xydac_cpt').'</strong></p>';
	foreach($inputfields as $inputfields)
		{
			
			$e.='<strong>'.__('Field Name','xydac_cpt').'</strong> : &nbsp;'.$inputfields;
			$e.='<p style="letter-spacing:2px">[xydac_field]'.$inputfields.'[/xydac_field]</p><br/>';
		}
	$e.='';
	$e.="</div>";
	$e.="</div>";
	echo $e;
}}

/**
 * xydac_custom_meta_save()
 * Handles the saving of menta box form
 * @param mixed $post_id
 * @return
 */
if ( !function_exists( 'xydac_custom_meta_save' ) ) { function xydac_custom_meta_save( $post_id ) { 
  if (isset($_POST['xydac_custom_nonce']) && wp_verify_nonce( $_POST['xydac_custom_nonce'], plugin_basename(__FILE__) )) 
  {
  if ( defined('DOING_AUTOSAVE') && DOING_AUTOSAVE )
    return $post_id;
  $post = get_post($post_id);
  $i=0;
  $temp = array();
  if(isset($_POST['xydac_custom']))
      if(is_array($_POST['xydac_custom']))
          foreach($_POST['xydac_custom'] as $a=>$t)
			{
				 $att = explode("-",$a);
				 $ft = $att[0];
				 unset($att[0]);
				 $fn = implode('-',$att);
				 $temp_field = new $ft($fn);
				 $temp_field->saving($temp,$post_id,$t);
				
			}
   return $temp;
   }
   else
   return $post_id;
}}
/**
 * xydac_export_cpt()
 * Handles the export of Custom Post Types.
 * @param mixed $cptname : Name of Custom Post Type
 * @return
 */
if ( !function_exists( 'xydac_export_cpt' ) ) {function xydac_export_cpt($cptname)
{
	$final = array();
	$cpts = get_option('xydac_cpt');
	foreach($cpts as $k=>$cpt)
		if($cpt['name']==$cptname)
			 $final['xydac_cpt']= $cpts[$k];
	if(isset($final['xydac_cpt']))
		$final['xydac_cpt_field'] = getCptFields($cptname);
	return maybe_serialize($final);
	
}}

/**
 * xydac_import_cpt()
 * Handles importing of Custom Post Types and Field
 * @param mixed $cpt_array
 * @return
 */
if ( !function_exists( 'xydac_import_cpt' ) ) {function xydac_import_cpt($cpt_array)
{
	$check = false;
	$cpt_array = maybe_unserialize($cpt_array);
	$xydac_cpts = get_option("xydac_cpt");
	if(is_array($cpt_array))
		{
		if(isset($cpt_array['xydac_cpt']))
			if(is_array($cpt_array['xydac_cpt']))
				{
				if(!in_array($cpt_array['xydac_cpt']['name'],get_reg_cptName()))
					{
						if(!$xydac_cpts)
						{
							$temp = array();
							array_push($temp,$cpt_array['xydac_cpt']);
							if(update_option('xydac_cpt',$temp));
								$check =true;
						}
						if(is_array($xydac_cpts))
						{
							array_push($xydac_cpts,$cpt_array['xydac_cpt']);
							if(update_option('xydac_cpt',$xydac_cpts));
								$check =true;
						}
					}
				else
					$check=false;
				}
		if(isset($cpt_array['xydac_cpt_field']))
			if(is_array($cpt_array['xydac_cpt_field']))
				{
				$check2 = update_option('xydac_cpt_'.$cpt_array['xydac_cpt']['name'],$cpt_array['xydac_cpt_field']);
				if($check && $check2)
					{	$message = __('Custom Post Type and Custom Field Imported Sucessfully.',"xydac_cpt");
						return $message;
					}
				elseif($check2 && !$check)
					{
					$message = __('Custom Field Imported Sucessfully.',"xydac_cpt");
						return $message;
					}
				}
		if($check)
		{	$message = __('Custom Post Type Imported Sucessfully.',"xydac_cpt");
			return $message;
		}
		else
		{
			$xydac_error= new WP_Error('err', __("Custom Post Type already in use !!!","xydac_cpt"));
			return $xydac_error;
		}
		
		}
	else
		{
		$xydac_error= new WP_Error('err', __("There seems to be some problem with your data !!!","xydac_cpt"));
		return $xydac_error;
		}
}}

/**
 * xydac_cpt_update1()
 * The Update Function for 1.6.4>1.6.5 transition.
 * @return
 */
if ( !function_exists( 'xydac_cpt_update1' ) ) {function xydac_cpt_update1()
{
global $wpdb;
$xydac_active_field_types = get_option("xydac_active_field_types");
if(!is_array($xydac_active_field_types))
	$xydac_active_field_types = array();
$check =0;
$cpts = get_option("xydac_cpt");
if(is_array($cpts))
	foreach($cpts as $cpt)
		{
			$fields = getCptFields($cpt['name']);
			if(is_array($fields))
			foreach($fields as $field)
				{	
					$metas = $wpdb->get_results("SELECT meta_id, meta_value FROM ".$wpdb->postmeta." WHERE meta_key ='".$field['field_name']."'");
					foreach($metas as $meta)
						{
							$meta->meta_value = maybe_unserialize($meta->meta_value);
							$r = false;
							if(is_array($meta->meta_value))
								{
								foreach($meta->meta_value as $k=>$v)
									if($k!=$field['field_type'])
									{
										$r =true;
									}
								}
							else
								$r = true;
							if($r)
								$meta->meta_value = array($field['field_type'] =>$meta->meta_value);
							$meta->meta_value = maybe_serialize($meta->meta_value);
							$wpdb->query("UPDATE ".$wpdb->postmeta." SET meta_value='".$meta->meta_value."' WHERE meta_id = ".$meta->meta_id);
						}
					if(!in_array($field['field_type'],$xydac_active_field_types))
						array_push($xydac_active_field_types,$field['field_type']);
				}
		}
	if(is_array($xydac_active_field_types))
		update_option('xydac_active_field_types',$xydac_active_field_types);
}}
/**
 * xydac_cpt_activate()
 * 
 * @return
 */
if ( !function_exists( 'xydac_cpt_activate' ) ) {function xydac_cpt_activate()
{
global $wpdb;
if (function_exists('is_multisite') && is_multisite()) {
		// check if it is a network activation - if so, run the activation function for each blog id
		if (isset($_GET['networkwide']) && ($_GET['networkwide'] == 1)) {
	                $old_blog = $wpdb->blogid;
			// Get all blog ids
			$blogids = $wpdb->get_col($wpdb->prepare("SELECT blog_id FROM $wpdb->blogs"));
			foreach ($blogids as $blog_id) {
				switch_to_blog($blog_id);
				xydac_cpt_update1();
			}
			switch_to_blog($old_blog);
			return;
		}	
	} 
	xydac_cpt_update1();	
}

}
if ( !function_exists( 'xydac_get_post_meta' ) ) {
function xydac_get_post_meta($post_id, $key, $single = false)
{
	global $xydac_fields;
	$fields = array();
	foreach($xydac_fields['fieldtypes'] as $k=>$v)
		array_push($fields,$k);
	$vals = get_post_meta($post_id,$key,$single);
	if($single)
		{
			if(is_array($vals))
				{
				foreach($vals as $k=>$v)
					if(in_array($k,$fields))
						return $v;
				}
			else
				return $vals;
		}
	else
		{
			
			foreach($vals as $l=>$val)
				{
					if(is_array($val))
					{
					foreach($val as $k=>$v)
						if(in_array($k,$fields))
							$vals[$l] = $v;
					}
				}
			return $vals;
		}
}}
///-----temp zone----
// --- All action and filters. :)
add_action( 'admin_menu', 'xydac_cpt_menu');
add_action( 'init', 'xydac_reg_cpt' , 1);
add_action( 'init', 'xydac_loadfields' , 10);
add_action( 'admin_init', 'custom_meta_admin');
add_action( 'save_post', 'xydac_custom_meta_save');
add_action( 'right_now_content_table_end', 'xydac_right_now');
add_filter( 'pre_get_posts', 'xydac_posts_home' );
add_shortcode('xydac_field','xydac_cpt_shortcode');
//add_action('admin_print_footer_scripts','xydac_admin_script',99);//implemented in cptfields.php
add_action('admin_head', 'xydac_admin_head');
add_action('wp_head', 'xydac_site_head');
add_filter ('the_content','the_content_manager');
add_filter ('enter_title_here','xydac_enter_title_here_manager');
register_activation_hook( __FILE__, 'xydac_cpt_activate' );
?>