<?php
/*
 Plugin Name: Chem 301
 Plugin URI: http://mondaybynoon.com/wordpress-attachments/
 Description: Chem 301 Plugin
 Version: 0.1
 Author: Tucker Bickler
 Author URI: http://tuckbick.com/
*/

/*  Copyright 2011 Tucker Bickler  (email : tuckersworld@gmail.com)

 This program is free software; you can redistribute it and/or modify
 it under the terms of the GNU General Public License as published by
 the Free Software Foundation; either version 2 of the License, or
 (at your option) any later version.

 This program is distributed in the hope that it will be useful,
 but WITHOUT ANY WARRANTY; without even the implied warranty of
 MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 GNU General Public License for more details.

 You should have received a copy of the GNU General Public License
 along with this program; if not, write to the Free Software
 Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
 */


// =========
// = HOOKS =
// =========
if( is_admin() )
{
    add_action( 'admin_menu', 'chem301_admin_init' );
    add_action( 'save_post',  'chem301_save' );
    add_action( 'admin_menu', 'chem301_menu' );
}
add_action( 'template_redirect',  'init_template_files' );

function chem301_option()
{
    include 'chem301.options.php';
}

function chem301_menu()
{
    add_dashboard_page('Chem 301 Map', 'Site Map', 'manage_options', 'chem301', 'chem301_option');
}


// =============
// = FUNCTIONS =
// =============

/**
 * Inserts HTML for meta box, including all existing attachments
 *
 * @return void
 * @author Tucker Bickler
 */

function chem301_enable_module() { 
    
	$post = get_post_custom($_GET['post']);
	$enable = $post['enable_module'][0] == '1';
    ?>
    
    <select name="enable_module">
        <option <?php if ($enable) echo 'selected="selected"'; ?> value="1">Enable</option>
        <option <?php if (!$enable) echo 'selected="selected"'; ?> value="0">Disable</option>
    </select>

<?php    
}


function chem301_enable_box()
{
    add_meta_box( 'module_enable', 'Enable Module', 'chem301_enable_module', 'module', 'side' );
	add_meta_box( 'module_enable', 'Enable Unit', 'chem301_enable_module', 'unit', 'side' );
}



/**
 * Fired when Post or Page is saved. Serializes all attachment data and saves to post_meta
 *
 * @param int $post_id The ID of the current post
 * @return void
 * @author Tucker Bickler
 */
function chem301_save($post_id)
{
	
    update_post_meta( $post_id, 'enable_module', $_POST['enable_module']         );
    update_post_meta( $post_id, 'html-pages'   , implode(',',$_POST['htmlpage']) );
    //var_dump(implode(',',$_POST['htmlpage']));
    //exit();
}



/**
 * This is the main initialization function, it will invoke the necessary meta_box
 *
 * @return void
 * @author Tucker Bickler
 */
function chem301_admin_init()
{
    //wp_enqueue_script('editor');
    //wp_enqueue_script('tiny-mce');
    wp_enqueue_style( 'chem301-admin', WP_PLUGIN_URL . '/chem301/css/chem301-admin.css' );
    //wp_enqueue_script( 'jquery-ui-core' );
    //wp_enqueue_script( 'chem301-calendar', WP_PLUGIN_URL . '/chem301/js/chem301-calendar.js', array( 'jquery' ), false, false );
    wp_enqueue_script( 'jquery-ui-1.8.11.custom.min', WP_PLUGIN_URL . '/chem301/js/jquery-ui-1.8.11.custom.min.js', array( 'jquery' ), false, true);
    wp_enqueue_script( 'jquery.ui.nestedSortable', WP_PLUGIN_URL . '/chem301/js/jquery.ui.nestedSortable.js', array( 'jquery' ), false, true);
    wp_enqueue_script( 'chem301-admin', WP_PLUGIN_URL . '/chem301/js/chem301-admin.js', array( 'jquery','jquery-ui-core', 'jquery-ui-1.8.11.custom.min', 'jquery.ui.nestedSortable' ), false, true );
    chem301_enable_box();
    
    //add_editor_style(WP_PLUGIN_URL . '/chem301/css/tinymce-editor-style.css');
}




function init_template_files() {
    
    wp_enqueue_style( 'chem301', WP_PLUGIN_URL . '/chem301/css/chem301.css', false, false, 'screen,handheld' );
    wp_enqueue_style( 'chem301_print', WP_PLUGIN_URL . '/chem301/css/chem301_print.css', false, false, 'print' );
    wp_enqueue_style( 'shadowbox', WP_PLUGIN_URL.'/chem301/js/shadowbox/shadowbox.css', false, false, 'all' );
    
    //wp_enqueue_script( 'jquery.embedly.min', WP_PLUGIN_URL.'/chem301/js/jquery.embedly.min.js', array( 'jquery' ), false, true );
    wp_enqueue_script( 'shadowbox', WP_PLUGIN_URL.'/chem301/js/shadowbox/shadowbox.js', array( 'jquery' ), false, true );
    wp_enqueue_script( 'chem301', WP_PLUGIN_URL . '/chem301/js/chem301.js', array( 'jquery', 'shadowbox' ), false, true );
}





///////////////////


/*
Plugin Name: Disable Autosave
*/
function disable_autosave() {
  wp_deregister_script('autosave');
}
add_action( 'wp_print_scripts', 'disable_autosave' );



add_action('admin_menu', function() { remove_meta_box('pageparentdiv', 'module', 'normal');});
add_action('add_meta_boxes', function() { add_meta_box('module-parent', 'Unit', 'module_attributes_meta_box', 'module', 'side', 'high');});
function module_attributes_meta_box($post) {
    $post_type_object = get_post_type_object($post->post_type);
    if ( $post_type_object->hierarchical ) {
        $pages = wp_dropdown_pages(array('post_type' => 'unit', 'selected' => $post->post_parent, 'name' => 'parent_id', 'show_option_none' => __('(no unit)'), 'sort_column'=> 'menu_order, post_title', 'echo' => 0));
        if ( ! empty($pages) ) {
            echo $pages;
        } // end empty pages check
    } // end hierarchical check.
}

add_action('admin_menu', function() { remove_meta_box('pageparentdiv', 'submodule', 'normal');});
add_action('add_meta_boxes', function() { add_meta_box('submodule-parent', 'Module', 'submodule_attributes_meta_box', 'submodule', 'side', 'high');});
function submodule_attributes_meta_box($post) {
    $post_type_object = get_post_type_object($post->post_type);
    if ( $post_type_object->hierarchical ) {
        $pages = ordered_dropdown_pages($post);
        if ( ! empty($pages) ) {
            echo $pages;
        } // end empty pages check
    } // end hierarchical check.
}

/*
add_action('admin_menu', function() { remove_meta_box('pageparentdiv', 'announcement', 'normal');});
add_action('add_meta_boxes', function() { add_meta_box('announcement-parent', 'Section', 'announcement_attributes_meta_box', 'announcement', 'side', 'high');});
function announcement_attributes_meta_box($post) {
    $post_type_object = get_post_type_object($post->post_type);
    if ( $post_type_object->hierarchical ) {
        $pages = wp_dropdown_pages(array('post_type' => 'section', 'hierarchical' => 0, 'selected' => $post->post_parent, 'name' => 'parent_id', 'show_option_none' => __('(no section)'), 'sort_column'=> 'menu_order, post_title', 'echo' => 0));
        if ( ! empty($pages) ) {
            echo $pages;
        } // end empty pages check
    } // end hierarchical check.
}
*/

add_action( 'add_meta_boxes', 'hide_categories_metabox' );
function hide_categories_metabox() { remove_meta_box('categorydiv','module','side');}



add_filter('manage_module_posts_columns', 'module_columns');
function module_columns($columns) {
    $columns['unit'] = 'Unit';
    unset($columns['date']);
    return $columns;
}
add_filter('manage_submodule_posts_columns', 'submodule_columns');
function submodule_columns($columns) {
    $columns['unit'] = 'Unit';
    $columns['module'] = 'Module';
    unset($columns['date']);
    return $columns;
}
add_action('manage_module_posts_custom_column',  'module_columns_pop');
function module_columns_pop($name) {
    global $post;
    switch ($name) {
        case 'unit':
            $unit = get_post($post->post_parent);
            echo $unit->post_title;
    }
}
add_action('manage_submodule_posts_custom_column',  'submodule_columns_pop');
function submodule_columns_pop($name) {
    global $post;
    switch ($name) {
        case 'module':
            $module = get_post($post->post_parent);
            echo $module->post_title;
            break;
        case 'unit':
            $module = get_post(get_post($post->post_parent)->post_parent);
            echo $module->post_title;
    }
}

add_action('wp_ajax_update_module_ordering', 'update_ordering');
function update_ordering($stuff) {
	global $wpdb; // this is how you get access to the database

    $posts = $_POST['posts'];
    $k = 0;
    for ($i = 1; $i <= count($posts); $i += 1) {
        $post = $posts[$i];
        if (empty($post['item_id']) || empty($post['parent_id'])) continue;
        if ($post['parent_id'] == 'root') {
            $wpdb->update( $wpdb->base_prefix.'posts', array('menu_order'=>$i), array('ID'=>$post['item_id']) )."\n";
            //echo "UPDATE wpv2_posts VALUES (menu_order=$i) WHERE ID={$post['item_id']}\n";
        } else {
            $wpdb->update( $wpdb->base_prefix.'posts', array('post_parent'=>$post['parent_id'],'menu_order'=>$i), array('ID'=>$post['item_id']) )."\n";
            //echo "UPDATE wpv2_posts VALUES (post_parent={$post['parent_id']}, menu_order=$i) WHERE ID={$post['item_id']}\n";
        }
    }
    
    // response output
    //header( "Content-Type: application/json" );
    //echo json_encode( array('success' => true) );
    //echo json_encode($posts);
	exit; // this is required to return a proper result
}



////// TINYMCE STYLES

add_filter( 'tiny_mce_before_init', 'atg_mce_before_init' );

function atg_mce_before_init( $settings ) {

    $style_formats = array(
        array(
        	'title' => 'Accent 1',
        	'inline' => 'span',
        	'styles' => array(
        		'color' => '#f15e0d'
        	)
        ),
        array(
        	'title' => 'Accent 2',
        	'inline' => 'span',
        	'styles' => array(
        		'color' => '#EBA711'
        	)
        ),
        array(
        	'title' => 'Formula',
        	'inline' => 'span',
        	'styles' => array(
        		'color' => '#EBA711',
        		'fontSize' => '20px'
        	)
        )
    );

    $settings['style_formats'] = json_encode( $style_formats );

    return $settings;

}

/* Style Format Options

title [required]              label for this dropdown item

selector|block|inline         selector limits the style to a specific HTML
[required]                    tag, and will apply the style to an existing tag
                              instead of creating one
                              
                              block creates a new block-level element with the
                              style applied, and will replace the existing block
                              element around the cursor
                              
                              inline creates a new inline element with the style
                              applied, and will wrap whatever is selected in the
                              editor, not replacing any tags

classes [optional]            space-separated list of classes to apply to the
                              element

styles [optional]             array of inline styles to apply to the element
                              (two-word attributes, like font-weight, are written
                              in Javascript-friendly camel case: fontWeight)

attributes [optional]         assigns attributes to the element (same syntax as styles)

wrapper [optional,            if set to true, creates a new block-level element
default = false]              around any selected block-level elements

exact [optional,              disables the “merge similar styles” feature, needed
default = false]              for some CSS inheritance issues

*/




add_action('add_meta_boxes', function() { add_meta_box('attached-html-pages', 'Attached HTML Pages', 'select_html_pages', 'section'     , 'side', 'high');});
add_action('add_meta_boxes', function() { add_meta_box('attached-html-pages', 'Attached HTML Pages', 'select_html_pages', 'unit'        , 'side', 'high');});
add_action('add_meta_boxes', function() { add_meta_box('attached-html-pages', 'Attached HTML Pages', 'select_html_pages', 'module'      , 'side', 'high');});
add_action('add_meta_boxes', function() { add_meta_box('attached-html-pages', 'Attached HTML Pages', 'select_html_pages', 'submodule'   , 'side', 'high');});
add_action('add_meta_boxes', function() { add_meta_box('attached-html-pages', 'Attached HTML Pages', 'select_html_pages', 'announcement', 'side', 'high');});
function select_html_pages($post) {
    $selected_html_page_ids = get_post_meta($post->ID, 'html-pages');
    $selected_html_page_ids = explode(',',$selected_html_page_ids[0]);
    $html_pages = get_pages(array('post_type'=>'html-page'));
    $output = '<ul id="htmlpages">';
    for ($i=0; $i < count($html_pages); $i+=1) {
        $html_page = $html_pages[$i];
        $checked = '';
        if (in_array($html_page->ID, $selected_html_page_ids)) {
            $checked = 'checked="checked"';
        }
        $output .= '<li><label><input type="checkbox" name="htmlpage[]" '.$checked.' value="'.$html_page->ID.'" />'.$html_page->post_title.'</label></li>';
    }
    echo $output . '</ul>';
}

function ordered_dropdown_pages($post) {
		 $units = get_posts( array('post_type' => 'unit','orderby'=>'menu_order','order'=>'ASC') );
		 $output = '<select name="parent_id">';
		    $output .= "<option value=\"\">(no module)</option>";
    		foreach ($units as $unit) :
					$output .= "\t<optgroup label = \"$unit->post_title\">\n";
					$modules = get_children( array('post_parent' => $unit->ID, 'post_type' => 'module','orderby'=>'menu_order','order'=>'ASC') );
					foreach ($modules as $module) :
						if ($post->post_parent == $module->ID) {
							$output .= "\t<option selected=\"selected\" value = \"$module->ID\">$module->post_title</option>\n";
						} else {
							$output .= "\t<option value = \"$module->ID\">$module->post_title</option>\n";
						}
					endforeach;
					$output .= "</optgroup>";
				endforeach;
				$output .= "</select>";
		return $output;
		?>
		</select>
		<?php
}