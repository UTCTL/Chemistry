<?php
/*
Plugin Name: Ultimate Taxonomy Manager
Plugin URI: http://taxonomymanager.wordpress.com/
Description: Manage All your Taxonomy and Custom Taxonomy fields with ease using this plugin.
Author: XYDAC
Version: 1.2
Author URI: http://xydac.wordpress.com/
License: GPL2
*/
/*  Copyright 2010  deepak.seth  (email : indk@ymail.com)

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
global $wpdb;
if ( !defined( 'XYDAC_HOME_PATH' ) )define('XYDAC_HOME_PATH',get_bloginfo('wpurl')."/wp-admin/options-general.php?page=ultimate-taxonomy-manager&sub=home");
if ( !defined( 'XYDAC_TAXONOMY_PATH' ) )define('XYDAC_TAXONOMY_PATH',get_bloginfo('wpurl')."/wp-admin/options-general.php?page=ultimate-taxonomy-manager&sub=custom-taxonomy");
if ( !defined( 'XYDAC_FIELDS_PATH' ) )define('XYDAC_FIELDS_PATH',get_bloginfo('wpurl')."/wp-admin/options-general.php?page=ultimate-taxonomy-manager&sub=custom-taxonomy-fields");
if ( !defined( 'XYDAC_FIELDTABLE' ) )define('XYDAC_FIELDTABLE',$wpdb->prefix.'taxonomyfield');
if ( !defined( 'XYDAC_VER' ) )define('XYDAC_VER','1.2');
include "ct.class.php";
include 'field.php';
include "taxonomy.php";
//---action,filter etc
register_activation_hook(__FILE__,'xydac_setup');
add_action( 'init', 'xydac_init' , 1);
add_action( 'admin_menu', 'xydac_menu');
add_action( 'admin_menu', 'xydac_meta_boxes');
add_action( 'save_post', 'xydac_save_tax');
add_filter( 'plugin_action_links', 'xydac_settings', 10, 2);
add_filter( 'manage_posts_columns', 'xydac_taxonomy_cols',10,2 );
add_action( 'manage_posts_custom_column', 'xydac_taxonomy_custom_cols', 10, 2);
add_action( 'restrict_manage_posts','xydac_restrict_manage_posts');
//----functions
if ( !function_exists( 'xydac_setup' ) ) {
function xydac_setup() {
global $wpdb;
if (function_exists('is_multisite') && is_multisite()) {
		// check if it is a network activation - if so, run the activation function for each blog id
		if (isset($_GET['networkwide']) && ($_GET['networkwide'] == 1)) {
	                $old_blog = $wpdb->blogid;
			// Get all blog ids
			$blogids = $wpdb->get_col($wpdb->prepare("SELECT blog_id FROM $wpdb->blogs"));
			foreach ($blogids as $blog_id) {
				switch_to_blog($blog_id);
				_xydac_setup();
			}
			switch_to_blog($old_blog);
			return;
		}	
	} 
	_xydac_setup();	
}
}
if ( !function_exists( '_xydac_setup' ) ) {
function _xydac_setup() {
	global $wpdb;
	require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
    $charset_collate = '';  
	if (!empty ($wpdb->charset))
		$charset_collate = "DEFAULT CHARACTER SET {$wpdb->charset}";
	if (!empty ($wpdb->collate))
		$charset_collate .= " COLLATE {$wpdb->collate}";
		$sql = "CREATE TABLE IF NOT EXISTS {$wpdb->prefix}taxonomyfield (
			field_id bigint(20) NOT NULL AUTO_INCREMENT,
			tax_name varchar(255) NOT NULL,
			field_name varchar(255) DEFAULT NULL,
			field_label varchar(255) DEFAULT NULL,
			field_type varchar(255) DEFAULT NULL,
			field_desc longtext DEFAULT NULL,
			field_val longtext DEFAULT NULL,
			PRIMARY KEY (field_id)
		) $charset_collate;";
	$wpdb->query($sql);$sql='';
		$sql = "CREATE TABLE IF NOT EXISTS {$wpdb->prefix}taxonomymeta (
		  meta_id bigint(20) unsigned NOT NULL auto_increment,
		  taxonomy_id bigint(20) unsigned NOT NULL default '0',
		  meta_key varchar(255) default NULL,
		  meta_value longtext,
		  PRIMARY KEY  (meta_id),
		  KEY taxonomy_id (taxonomy_id),
		  KEY meta_key (meta_key)
		) $charset_collate;";
	$wpdb->query($sql);
}
}
if ( !function_exists( 'xydac_init' ) ) {
function xydac_init()
{
global $wpdb;
$wpdb->taxonomymeta = "{$wpdb->prefix}taxonomymeta";
//Register Taxonomies 
xydac_reg_taxonomies();
//Register all fields
$ct_rows = $wpdb->get_results("SELECT * FROM {$wpdb->prefix}taxonomyfield ");
    foreach($ct_rows as $ct_row)//for each field
	{
		$ss = new ct_fields($ct_row->tax_name,$ct_row->field_name,$ct_row->field_label,$ct_row->field_type,$ct_row->field_desc,$ct_row->field_val);
	}
if(get_option('xydac_taxonomies_cat'))
    register_taxonomy_for_object_type('category', 'page');

}
}
if ( !function_exists( 'xydac_path' ) ) {
function xydac_path( $file ) {
    return trailingslashit( dirname( $file ) );
}}
if ( !function_exists( 'xydac_settings' ) ) {
function xydac_settings($links, $file) {
            static $this_plugin;
            if (!$this_plugin) $this_plugin = plugin_basename(__FILE__);
            if ($file == $this_plugin){
                $settings_link = "<a href='options-general.php?page=ultimate-taxonomy-manager'>" . __("Settings") . "</a>";
                array_unshift($links, $settings_link);
            }
            return $links;
        }}
//---xydac_taxonomy page
/*
 * Creates the tab for main page
 * param $page=home :if home is active tab
 * param $page=taxonomy :if custom taxonomies is active tab
 * param $page=fields :if Custom Taxonomy Fields is active tab
 */
 if ( !function_exists( 'xydac_heading' ) ) {
function xydac_heading($page="home"){ 	 ?>
    <div id="icon-options-general" class="icon32"><br></div>
    <h2 style="border-bottom: 1px solid #CCC;padding-bottom:0px;">
        <a href="<?php _e(XYDAC_HOME_PATH,'xydac') ?>" class="nav-tab <?php if($page=='home')  _e('nav-tab-active','xydac') ?>">Home</a>
        <a href="<?php _e(XYDAC_TAXONOMY_PATH,'xydac') ?>" class="nav-tab <?php if($page=='taxonomy')  _e('nav-tab-active','xydac') ?>">Custom Taxonomies</a>
        <a href="<?php _e(XYDAC_FIELDS_PATH,'xydac') ?>" class="nav-tab <?php if($page=='fields')  _e('nav-tab-active','xydac') ?>">Custom Taxonomy Fields</a>
    </h2> <br class="clear" />
<?php
}}
if ( !function_exists( 'xydac_home_aboutus' ) ) {
function xydac_home_aboutus(){
    ?>
    <div class="postbox opened" style="background:lightyellow">
                    <h3>About This Plugin</h3>
                    <div class="inside" >
                       <table class="form-table">
                           <tbody>
                            <tr>
                               <th scope="row" valign="top"><b>Plugin Version</b></th>
                               <td><?php _e(XYDAC_VER,'xydac'); ?></td>
                           </tr>
                            <tr>
                               <th scope="row" valign="top"><b>Author</b></th>
                               <td> <a href="http://xydac.wordpress.com/" style="padding:4px;font-weight:bold;text-decoration:none">XYDAC</a></td>
                           </tr>
                           <tr>
                               <th scope="row" valign="top"><b>Like this plugin?</b></th>
                               <td>
								<a href="http://taxonomymanager.wordpress.com/" style="color:red;background:yellow;padding:4px;font-weight:bold;">[Plugin Home Page]</a> | <a href="http://wordpress.org/tags/ultimate-taxonomy-manager?forum_id=10">[Create Support Ticket]</a> | <a href="http://taxonomymanager.wordpress.com/" style="color:red;background:yellow;padding:4px;font-weight:bold;">[Request Feature]</a> | <a href="http://wordpress.org/extend/plugins/ultimate-taxonomy-manager/">[Rate Plugin]</a> | <a href="https://www.paypal.com/cgi-bin/webscr?cmd=_donations&business=nikhilseth1989%40gmail%2ecom&item_name=WordPress%20Plugin%20(Ultimate%20Taxonomy%20Manager)&no_shipping=0&no_note=1&tax=0&currency_code=USD&lc=US&bn=PP%2dDonationsBF&charset=UTF%2d8" style="color:red;background:yellow;padding:4px;font-weight:bold;">[Make Donation]</a>
							   </td>
                           </tr>
                           
                           </tbody>
                       </table>
                        <form name="_xclick" action="https://www.paypal.com/cgi-bin/webscr" method="post">
                        <input type="hidden" name="cmd" value="_donations">
                        <input type="hidden" name="business" value="nikhilseth1989@gmail.com">
                        <input type="hidden" name="item_name" value="Taxonomy Manager">
                        <input type="hidden" name="currency_code" value="USD">
                        <input type="image" src="http://www.paypal.com/en_US/i/btn/btn_donate_LG.gif" border="0" name="submit" alt="Donate for Taxonomy Manager!">
                        </form>
                    </div>
				</div>
<?php
}}
if ( !function_exists( 'xydac_home' ) ) {
function xydac_home()
{
    if(isset($_POST['xydac-tweak-form-submit']))
    {
        if(isset($_POST['cat-in-pages']))
        {if((bool)$_POST['cat-in-pages']==1)
                update_option('xydac_taxonomies_cat','1');}
        else
            update_option('xydac_taxonomies_cat','0');        
    }
    ?>
        <div class="wrap" ><?php xydac_heading(); ?>
        <div id="poststuff" class="ui-sortable">
			<div class="postbox-container" style="width:69%">
                <div class="postbox opened">
                    <h3>Information</h3>
                    <div class="inside">
                       <p>This plugin is an Easy to use Taxonomy Manager to Customize Taxonomies and its Custom Fields.</p>
                        <p>You can use the above menus to create <strong>Custom Taxonomies</strong> as well as Create <strong>Custom Fields</strong> to store more information
                           about your Taxonomies.</p>
                        <h4>Custom Taxonomies : </h4>
                            <p>&bull;&nbsp;All fields except name and post types are optional in Create Taxonomy form.<br/>
                            &bull;&nbsp;When you delete a Taxonomy then the data Taxonomy has saved does not get removed, So if you want to use the Taxonomy again just recreate it again with same name.<br/>
                            </p>
                        <h4>Custom Fields : </h4>
                            <p>&bull;&nbsp;You can create custom fields for any taxonomy except Media types.<br/>
                               &bull;&nbsp;<strong>You can now add Images to Taxonomy Go to Custom Fields to add.</strong><br/>
                            &bull;&nbsp;To display Custom Fields in the posts you can use shortcode <strong>[xy_<em>{name of taxonomy}</em>]</strong> where {name of taxonomy} is the Name of Taxonomy.<br/>
                                &bull;&nbsp;Advanced use of Short Code : <strong>[xy_<em>{name of taxonomy}</em> field="<em>{field name}</em>"]</strong> can be used to display value of Custom Field of Taxonomy.<br/>
                            </p>
                        <h4>Bonus Tweaks</h4>
                            <form action="" method="POST" name="xydac-tweak-form" style="margin-left:10px;">
                                <label for="cat-in-pages" style="font-weight:bold">Show Default Category in Pages</label>
                                <input type="checkbox" name="cat-in-pages" id="cat-in-pages" <?php if(get_option('xydac_taxonomies_cat')) _e('checked=checked','xydac') ?> style="margin-left:20px" />
                                <input type="submit"  name="xydac-tweak-form-submit" class="button" value="Update" style="margin-left:20px">
                            </form>
                    </div>
                </div>
			</div>
			<div class="postbox-container" style="width:29%">
                <div class="postbox opened">
                    <h3>Want More...</h3>
                    <div class="inside">
                       <?php if(!defined('XYDAC_CPT_VER')) { ?>
					   So, You want more..!!!<br/>
					   Check out the plugin to create Custom Post Type<br/><br/>
					   Custom Post Types are simply different types of Post such as Pages,Post etc.<br/>
                        <h4><a href="http://wordpress.org/extend/plugins/ultimate-post-type-manager/" >Ultimate Post Type Manager</a><br/></h4>
                        <a href="http://posttypemanager.wordpress.com/" >-Plugin Home Page</a><br/>
                        <a href="http://downloads.wordpress.org/plugin/ultimate-post-type-manager.zip">-Download Latest Version Now</a>
                        <br/><br/> Hope You like that Plugin Also.
                    <?php } else { ?>
                        <h4>Thank You</h4> For Installing Ultimate Post Type Manager and Ultimate Taxonomy Manager.<br/><br/> As you know creating good plugins require lot of time so, Support Further Development with you Esteemed Donation<br/><br/>
                        <span style="color:red;background:yellow;padding:4px;font-weight:bold;"><a href="https://www.paypal.com/cgi-bin/webscr?cmd=_donations&business=nikhilseth1989%40gmail%2ecom&item_name=WordPress%20Plugin%20(Ultimate%20Taxonomy%20Manager)&no_shipping=0&no_note=1&tax=0&currency_code=USD&lc=US&bn=PP%2dDonationsBF&charset=UTF%2d8">>>&nbsp;Click Here To Donate&nbsp;<<</a></span>
						<br/><br/>
					<?php } ?>
					   
                    </div>
                </div>
			</div>
			<div class="clear"></div>
			<div class="postbox-container" style="width:100%">
				<?php xydac_home_aboutus(); ?>
			</div>
		</div>
	</div>
        
<?php
}}
if ( !function_exists( 'xydac_menu' ) ) {
function xydac_menu() {
  $x_menu = add_options_page('Taxonomy Manager', 'Taxonomy Manager', 'manage_options', 'ultimate-taxonomy-manager', 'xydac_menu_manager');
  //add_action( "admin_footer-$x_menu", 'xydac_jquery' );//not reqd now
  add_action("admin_print_scripts-$x_menu", 'xydac_scripts');
  add_action("admin_print_scripts-edit-tags.php", 'xydac_scripts');
  add_action("admin_print_styles-$x_menu", 'xydac_styles');
  add_action("admin_print_styles-edit-tags.php", 'xydac_styles');
}}
if ( !function_exists( 'xydac_menu_manager' ) ) {
function xydac_menu_manager() {
	if (!current_user_can('manage_options'))  {
    wp_die( __('You do not have sufficient permissions to access this page.') );
	}
    if(isset($_GET['page']) || isset($_POST['page']))
	if($_GET['page']=='ultimate-taxonomy-manager' || $_POST['page']=='ultimate-taxonomy-manager')
		{
            if(isset($_GET['sub']) || isset($_POST['sub']))
            {
                if((isset($_GET['sub']) && $_GET['sub']=='custom-taxonomy') || (isset($_POST['sub']) && $_POST['sub']=='custom-taxonomy'))
                {
                    xy_wrapper();

                }elseif((isset($_GET['sub']) && $_GET['sub']=='custom-taxonomy-fields') || (isset($_POST['sub']) && $_POST['sub']=='custom-taxonomy-fields'))
                {
                    xydac_tax();
                }elseif((isset($_GET['sub']) && $_GET['sub']=='xydac'))
                {
                    echo "You shouldn't be here.";
                    //list_hooked_functions('wp_head');
                }elseif((isset($_GET['sub']) && $_GET['sub']=='home'))
                {
                    xydac_home();
                }
            }
            else
			{               
                xydac_home();
				//home
			}
		}
}}
if ( !function_exists( 'xydac_scripts' ) ) {
function xydac_scripts()
{
    wp_register_script('xydac_js', WP_PLUGIN_URL.'/ultimate-taxonomy-manager/my-script.js', array('jquery','media-upload','thickbox'));
    wp_enqueue_script('xydac_js');
}}
if ( !function_exists( 'xydac_styles' ) ) {
function xydac_styles() { wp_enqueue_style('thickbox'); }}
/* temp function */
if ( !function_exists( 'list_hooked_functions' ) ) {
function list_hooked_functions($tag=false){
 global $wp_filter;
 if ($tag) {
  $hook[$tag]=$wp_filter[$tag];
  if (!is_array($hook[$tag])) {
  trigger_error("Nothing found for '$tag' hook", E_USER_WARNING);
  return;
  }
 }
 else {
  $hook=$wp_filter;
  ksort($hook);
 }
 echo '<pre>';
 foreach($hook as $tag => $priority){
  echo "<br />&gt;&gt;&gt;&gt;&gt;\t<strong>$tag</strong><br />";
  ksort($priority);
  foreach($priority as $priority => $function){
  echo $priority;
  foreach($function as $name => $properties) echo "\t$name<br />";
  }
 }
 echo '</pre>';
 return;
}}
/*-------------------------*/
//---create-taxonomies page
if ( !function_exists( 'xydac_singular' ) ) {
function xydac_singular($name)
{return ((substr($name,-1)=='s') ? substr($name,0,-1) : $name);}}
if ( !function_exists( 'xydac_meta_handler' ) ) {
function xydac_meta_handler($post,$tax) {
    $xy_terms = get_terms($tax['args'], 'hide_empty=0');
    $val = wp_get_object_terms($post->ID, $tax['args']);
    wp_nonce_field( plugin_basename(__FILE__), 'xydac_field_nonce' );
    ?>
    <input type="hidden" name="xydac_taxonomy_hidden[]" value="<?php _e($tax['args'],'xydac'); ?>" />
    <select name='<?php _e($tax['args'],'xydac'); ?>' id='<?php _e($tax['args'],'xydac'); ?>' style="width:95% ">
            <option class='<?php _e($tax['args'],'xydac'); ?>-option' value='' <?php if (!count($val)) echo "selected";?>>None</option>
            <?php
        foreach ($xy_terms as $xy_term) {
            if (!is_wp_error($val) && !strcmp($xy_term->slug, $val[0]->slug) && !empty($val) )
                echo "<option class='"._e($tax['args'],'xydac')."-options' value='" . $xy_term->slug . "' selected>" . $xy_term->name . "</option>\n";
            else
                echo "<option class='"._e($tax['args'],'xydac')."-options' value='" . $xy_term->slug . "'>" . $xy_term->name . "</option>\n";
        }
    ?>
    </select>
<?php
}}
if ( !function_exists( 'xydac_meta_boxes' ) ) {
function xydac_meta_boxes(){
    
    $taxonomies = get_option("xydac_taxonomies");
        if (is_array($taxonomies) && !empty($taxonomies))
        foreach ($taxonomies  as $taxonomy )
        {

            if($taxonomy['showascombobox']=='true')
            {
                if(xydac_tcheckbool($taxonomy['args']['hierarchical']))
                    {
                        foreach($taxonomy['object_type'] as $a)
                            remove_meta_box($taxonomy['name'].'div',$a,'core');
                    }
                else
                    {
                        foreach($taxonomy['object_type'] as $a)
                            remove_meta_box('tagsdiv-'.$taxonomy['name'],$a,'core');
                            
                    }
                    foreach($taxonomy['object_type'] as $a)
                    {add_meta_box($taxonomy['name'].'_box', __($taxonomy['args']['label']), 'xydac_meta_handler', $a, 'side', 'low', $taxonomy['name']);}
            }
        }
}}
if ( !function_exists( 'xydac_save_tax' ) ) {
function xydac_save_tax( $post_id ) {
  // verify this came from the our screen and with proper authorization,
  // because save_post can be triggered at other times
  if (isset($_POST['xydac_field_nonce']) && wp_verify_nonce( $_POST['xydac_field_nonce'], plugin_basename(__FILE__) )) {
    
  
  // verify if this is an auto save routine. If it is our form has not been submitted, so we dont want
  // to do anything
  if ( defined('DOING_AUTOSAVE') && DOING_AUTOSAVE )
    return $post_id;
  // Check permissions
  if (isset($_POST['post_type']) && 'page' == $_POST['post_type'] ) {
    if ( !current_user_can( 'edit_page', $post_id ) )
      return $post_id;
  } else {
    if ( !current_user_can( 'edit_post', $post_id ) )
      return $post_id;
  }
  $post = get_post($post_id);
  if(isset($_POST['xydac_taxonomy_hidden']))
      if(is_array($_POST['xydac_taxonomy_hidden']))
          foreach($_POST['xydac_taxonomy_hidden'] as $a=>$t)
          {
              $temp = $_POST[$t];
              if($post->post_type != 'revision')
                wp_set_object_terms( $post_id, $temp , $_POST['xydac_taxonomy_hidden'][$a] );
          }
   return $temp;
   }
   else
   return $post_id;
}}
if ( !function_exists( 'xydac_tcheckbool' ) ) { function xydac_tcheckbool($string)
{
	if($string=='false')
		return false;
	else
		return true;
}}
if ( !function_exists( 'xydac_reg_taxonomies' ) ) {
function xydac_reg_taxonomies(){
global $wp_version;
    $taxonomies = get_option("xydac_taxonomies");
    if (is_array($taxonomies) && !empty($taxonomies))
        foreach ($taxonomies  as $k=>$taxonomy )
        {
            $xy_tax['name']= $taxonomy['name'];
            $xy_tax['object_type']= $taxonomy['object_type'];
            $xy_tax['args']['labels']['name'] =  (!empty($taxonomy['args']['labels']['name'])  ? $taxonomy['args']['labels']['name'] : ( !empty($taxonomy['args']['label']) ? $taxonomy['args']['label'] : $taxonomy['name']));
                $xy_sname = xydac_singular($xy_tax['name']);
                $xy_slabel = xydac_singular($xy_tax['args']['labels']['name']);
            $xy_tax['args']['labels']['singular_name'] = ( !empty($taxonomy['args']['labels']["singular_label"]) ? $taxonomy['args']['labels']["singular_label"] : $xy_sname);
            $xy_tax['args']['labels']['search_items'] = ( !empty($taxonomy['args']['labels']["search_items"]) ) ? $taxonomy['args']['labels']["search_items"] : 'Search ' .$taxonomy['args']['label'];
            $xy_tax['args']['labels']['popular_items'] = ( !empty($taxonomy['args']['labels']["popular_items"]) ) ? $taxonomy['args']['labels']["popular_items"] : 'Popular ' .$taxonomy['args']['label'];
            $xy_tax['args']['labels']['all_items'] = ( !empty($taxonomy['args']['labels']["all_items"]) ) ? $taxonomy['args']['labels']["all_items"] : 'All ' .$taxonomy['args']['label'];
            $xy_tax['args']['labels']['parent_item'] = ( !empty($taxonomy['args']['labels']["parent_item"]) ) ? $taxonomy['args']['labels']["parent_item"] : 'Parent ' .$xy_slabel;
            $xy_tax['args']['labels']['parent_item_colon'] = ( !empty($taxonomy['args']['labels']["parent_item_colon"]) ) ? $taxonomy['args']['labels']["parent_item_colon"] : 'Parent '.$xy_slabel.':';
            $xy_tax['args']['labels']['edit_item'] = ( !empty($taxonomy['args']['labels']["edit_item"]) ) ? $taxonomy['args']['labels']["edit_item"] : 'Edit ' .$xy_slabel;
            $xy_tax['args']['labels']['update_item'] = ( !empty($taxonomy['args']['labels']["update_item"]) ) ? $taxonomy['args']['labels']["update_item"] : 'Update ' .$xy_slabel;
            $xy_tax['args']['labels']['add_new_item'] = ( !empty($taxonomy['args']['labels']["add_new_item"]) ) ? $taxonomy['args']['labels']["add_new_item"] : 'Add New ' .$xy_slabel;
            $xy_tax['args']['labels']['new_item_name'] = ( !empty($taxonomy['args']['labels']["new_item_name"]) ) ? $taxonomy['args']['labels']["new_item_name"] : 'New ' .$xy_slabel. ' Name';
            $xy_tax['args']['labels']['separate_items_with_commas'] = ( !empty($taxonomy['args']['labels']["separate_items_with_commas"]) ) ? $taxonomy['args']['labels']["separate_items_with_commas"] : 'Separate ' .$taxonomy['args']['label']. ' with commas';
            $xy_tax['args']['labels']['add_or_remove_items'] = ( !empty($taxonomy['args']['labels']["add_or_remove_items"]) ) ? $taxonomy['args']['labels']["add_or_remove_items"] : 'Add or remove ' .$taxonomy['args']['label'];
            $xy_tax['args']['labels']['choose_from_most_used'] = ( !empty($taxonomy['args']['labels']["choose_from_most_used"]) ) ? $taxonomy['args']['labels']["choose_from_most_used"] : 'Choose from the most used ' .$taxonomy['args']['label'];
            $xy_tax['args']['labels']['view_item'] = ( !empty($taxonomy['args']['labels']["view_item"]) ) ? $taxonomy['args']['labels']["view_item"] : 'View ' .$taxonomy['args']['label'];			
            $xy_tax['args']['label'] = $xy_tax['args']['labels']['name'];
            $xy_tax['args']['public']= xydac_tcheckbool($taxonomy['args']['public']);
            $xy_tax['args']['show_in_nav_menus']=xydac_tcheckbool($taxonomy['args']['show_in_nav_menus']);
            $xy_tax['args']['show_ui']= xydac_tcheckbool($taxonomy['args']['show_ui']);
            $xy_tax['args']['show_tagcloud']= xydac_tcheckbool($taxonomy['args']['show_tagcloud']);
            $xy_tax['args']['hierarchical']= xydac_tcheckbool($taxonomy['args']['hierarchical']);
            $xy_tax['args']['rewrite']= xydac_tcheckbool($taxonomy['args']['rewrite']['val']);
            if($xy_tax['args']['rewrite']){
			$xy_tax['args']['rewrite'] = array();
            $xy_tax['args']['rewrite']['slug']= (!empty($taxonomy['args']['rewrite']['slug']) ? $taxonomy['args']['rewrite']['slug'] : $xy_tax['name']);
            $xy_tax['args']['rewrite']['with_front']= xydac_tcheckbool($taxonomy['args']['rewrite']['with_front']);
            if(substr($wp_version,0,3)>3)
				@$xy_tax['args']['rewrite']['hierarchical']= xydac_tcheckbool($taxonomy['args']['rewrite']['hierarchical']);
			}
            $xy_tax['args']['query_var'] = ( !empty($taxonomy['args']['query_var']) ? $taxonomy['args']['query_var'] : $taxonomy['name']);
            if(isset($taxonomy['args']['capabilities']))
            $xy_tax['args']['capabilities'] =  $taxonomy['args']['capabilities'];
            if(isset($taxonomy['args']['update_count_callback']) && !empty($taxonomy['args']['update_count_callback']))
            $xy_tax['args']['update_count_callback'] =  $taxonomy['args']['update_count_callback'];
            register_taxonomy($xy_tax['name'],$xy_tax['object_type'],$xy_tax['args']);
			$taxonomies[$k]['args']['labels'] = $xy_tax['args']['labels'];
			$taxonomies[$k]['args']['query_var'] = $xy_tax['args']['query_var'];
			$taxonomies[$k]['args']['rewrite']['slug'] = $xy_tax['args']['rewrite']['slug'];
			
            //----
        }
	update_option("xydac_taxonomies",$taxonomies);
	global $wp_rewrite;
	$wp_rewrite->flush_rules();
}
}

if ( !function_exists( 'array_insert' ) ) {
function array_insert(&$array, $insert, $position) {
settype($array, "array");
settype($insert, "array");
settype($position, "int");

if($position==0) {
    $array = array_merge($insert, $array);
} else {
    if($position >= (count($array)-1)) {
        $array = array_merge($array, $insert);
    } else {
        $head = array_slice($array, 0, $position);
        $tail = array_slice($array, $position);
        $array = array_merge($head, $insert, $tail);
    }
}
}}
if ( !function_exists( 'xydac_taxonomy_cols' ) ) {
function xydac_taxonomy_cols($columns,$post_type) {
	$taxonomies = get_option("xydac_taxonomies");
	
    if (is_array($taxonomies) && !empty($taxonomies))
        foreach ($taxonomies  as $taxonomy )
        {
			if(in_array($post_type,$taxonomy['object_type']))
			{
				$label = (!empty($taxonomy['args']['labels']['name'])  ? $taxonomy['args']['labels']['name'] : ( !empty($taxonomy['args']['label']) ? $taxonomy['args']['label'] : $taxonomy['name']));
				array_insert($columns,array($taxonomy['name'] => __($label)),2);
			}
		}
    return $columns;
}}
if ( !function_exists( 'xydac_taxonomy_custom_cols' ) ) {
function xydac_taxonomy_custom_cols($column_name, $post_id) {
    global $wpdb;
	$taxonomies = get_option("xydac_taxonomies");
	if (is_array($taxonomies) && !empty($taxonomies))
        foreach ($taxonomies  as $taxonomy )
        {
		if( $column_name == $taxonomy['name'] ) {
			if($terms = get_the_term_list( $post_id, $taxonomy['name'], '', ', ', '' )){
				echo $terms;
			 } else {
				echo '<i>'.__('None').'</i>';
				}
			}
		}
		
    }
}
//--code from DGB
if ( !function_exists( 'xydac_restrict_manage_posts' ) ) {
function xydac_restrict_manage_posts() {
	global $typenow;
	$taxonomies = get_option("xydac_taxonomies");
	if (is_array($taxonomies) && !empty($taxonomies))
        foreach ($taxonomies  as $taxonomy )
        {
			if (in_array($typenow,$taxonomy['object_type']))
				echo xydac_print_html($taxonomy['name']);
		}
	
}}
if ( !function_exists( 'xydac_print_html' ) ) {
function xydac_print_html($taxonomy_name) {
	$taxonomy = get_taxonomy($taxonomy_name);
	$terms = get_terms($taxonomy_name);
	$label = "Show All {$taxonomy->label}";
	$html = array();
	$html[] = "<select id=\"$taxonomy_name\" name=\"$taxonomy_name\">";
	$html[] = "<option value=\"0\">$label</option>";
	$this_term = get_query_var($taxonomy_name);
	foreach($terms as $term) {
		$default = ($this_term==$term->slug ? ' selected="selected"' : '');
		$value = esc_attr($term->name);
		$html[] = "<option value=\"{$term->slug}\"$default>$value</option>";
	}
	$html[] = "</select>";
	return implode("\n",$html);
}}
?>