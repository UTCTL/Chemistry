<?php
/*
 Plugin Name: Attachments
 Plugin URI: http://mondaybynoon.com/wordpress-attachments/
 Description: Attachments gives the ability to append any number of Media Library items to Pages, Posts, and Custom Post Types
 Version: 1.5.3.2
 Author: Jonathan Christopher
 Author URI: http://mondaybynoon.com/
*/

/*  Copyright 2009 Jonathan Christopher  (email : jonathandchr@gmail.com)

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


// ===========
// = GLOBALS =
// ===========

global $wpdb;



// =========
// = HOOKS =
// =========
if( is_admin() )
{
    add_action( 'admin_menu', 'attachments_init' );
    add_action( 'admin_head', 'attachments_init_js' );
    add_action( 'save_post',  'attachments_save' );
    add_action( 'admin_menu', 'attachments_menu' );
    add_action( 'admin_init', 'fix_async_upload_image' );
}



// =============
// = FUNCTIONS =
// =============

/**
 * Compares two array values with the same key "order"
 *
 * @param string $a First value
 * @param string $b Second value
 * @return int
 * @author Jonathan Christopher
 */
function attachments_cmp($a, $b)
{
    $a = intval( $a['order'] );
    $b = intval( $b['order'] );

    if( $a < $b )
    {
        return -1;
    }
    else if( $a > $b )
    {
        return 1;
    }
    else
    {
        return 0;
    }
}




/**
 * Creates the markup for the WordPress admin options page
 *
 * @return void
 * @author Jonathan Christopher
 */
function attachments_options()
{
    include 'attachments.options.php';
}




/**
 * Creates the entry for Attachments Options under Settings in the WordPress Admin
 *
 * @return void
 * @author Jonathan Christopher
 */
function attachments_menu()
{
    add_options_page('Settings', 'Attachments', 'manage_options', __FILE__, 'attachments_options');
}




/**
 * Inserts HTML for meta box, including all existing attachments
 *
 * @return void
 * @author Jonathan Christopher
 */
function attachments_add()
{?>

    <div id="attachments-inner">

        <?php
            $media_upload_iframe_src = "media-upload.php?type=image&TB_iframe=1";
            $image_upload_iframe_src = apply_filters( 'image_upload_iframe_src', "$media_upload_iframe_src" );
            ?>

                <ul id="attachments-actions">
                    <li>
                        <a id="attachments-thickbox" href="<?php echo $image_upload_iframe_src; ?>&attachments_thickbox=1" title="Attachments" class="button button-highlighted">
                            <?php _e( 'Attach', 'attachments' ) ?>
                        </a>
                    </li>
                </ul>

                <div id="attachments-list">
                    <input type="hidden" name="attachments_nonce" id="attachments_nonce" value="<?php echo wp_create_nonce( plugin_basename(__FILE__) ); ?>" />
                    <ul>
                        <?php
                    if( !empty($_GET['post']) )
                    {
                        // get all attachments
                        $existing_attachments = attachments_get_attachments( intval( $_GET['post'] ) );

                        if( is_array($existing_attachments) && !empty($existing_attachments) )
                        {
                            $attachment_index = 0;
                            foreach ($existing_attachments as $attachment) : $attachment_index++; ?>
                            <li class="attachments-file">
                                <h2>
                                    <a href="#" class="attachment-handle">
                                        <span class="attachment-handle-icon"><img src="<?php echo WP_PLUGIN_URL; ?>/attachments/images/handle.gif" alt="Drag" /></span>
                                    </a>
                                    <span class="attachment-name"><?php echo $attachment['name']; ?></span>
                                    <span class="attachment-delete"><a href="#"><?php _e("Delete", "attachments")?></a></span>
                                </h2>
                                <div class="attachments-fields">
                                    <div class="textfield" id="field_attachment_title_<?php echo $attachment_index ; ?>">
                                        <label for="attachment_title_<?php echo $attachment_index; ?>"><?php _e("Title", "attachments")?></label>
                                        <input type="text" id="attachment_title_<?php echo $attachment_index; ?>" name="attachment_title_<?php echo $attachment_index; ?>" value="<?php echo $attachment['title']; ?>" size="20" />
                                    </div>
                                    <div class="textfield" id="field_attachment_caption_<?php echo $attachment_index; ?>">
                                        <label for="attachment_caption_<?php echo $attachment_index; ?>"><?php _e("Caption", "attachments")?></label>
                                        <input type="text" id="attachment_caption_<?php echo $attachment_index; ?>" name="attachment_caption_<?php echo $attachment_index; ?>" value="<?php echo $attachment['caption']; ?>" size="20" />
                                    </div>
                                </div>
                                <div class="attachments-data">
                                    <input type="hidden" name="attachment_id_<?php echo $attachment_index; ?>" id="attachment_id_<?php echo $attachment_index; ?>" value="<?php echo $attachment['id']; ?>" />
                                    <input type="hidden" class="attachment_order" name="attachment_order_<?php echo $attachment_index; ?>" id="attachment_order_<?php echo $attachment_index; ?>" value="<?php echo $attachment['order']; ?>" />
                                </div>
                                <div class="attachment-thumbnail">
                                    <span class="attachments-thumbnail">
                                        <?php echo wp_get_attachment_image( $attachment['id'], array(80, 60), 1 ); ?>
                                    </span>
                                </div>
                            </li>
                        <?php endforeach;
                    }
                }
                ?>
            </ul>
        </div>
    </div>
<?php }



/**
 * Creates meta box on all Posts and Pages
 *
 * @return void
 * @author Jonathan Christopher
 */
function attachments_meta_box()
{
    // for custom post types
    if( function_exists( 'get_post_types' ) )
    {
        $args = array(
            'public'    => true,
            'show_ui'   => true
            ); 
        $output         = 'objects';
        $operator       = 'and';
        $post_types     = get_post_types( $args, $output, $operator );

        foreach($post_types as $post_type)
        {
            if (get_option('attachments_cpt_' . $post_type->name)=='true')
            {
                add_meta_box( 'attachments_list', __( 'Attachments', 'attachments' ), 'attachments_add', $post_type->name, 'normal' );
            }
        }
    }
}



/**
 * Echos JavaScript that sets some required global variables
 *
 * @return void
 * @author Jonathan Christopher
 */
function attachments_init_js()
{
    global $pagenow;

    echo '<script type="text/javascript" charset="utf-8">';
    echo '  var attachments_base = "' . WP_PLUGIN_URL . '/attachments"; ';
    echo '  var attachments_media = ""; ';
    if ( 'media-upload.php' == $pagenow || 'async-upload.php' == $pagenow )
    {
        echo '  var attachments_upload = true; ';
    }
    else
    {
        echo '  var attachments_upload = false; ';
    }
    if( ( 'media-upload.php' == $pagenow || 'async-upload.php' == $pagenow ) && is_attachments_context() )
    {
        echo '  var attachments_is_attachments_context = true; ';
    }
    else
    {
        echo '  var attachments_is_attachments_context = false; ';
    }
    echo '</script>';
}



/**
 * Fired when Post or Page is saved. Serializes all attachment data and saves to post_meta
 *
 * @param int $post_id The ID of the current post
 * @return void
 * @author Jonathan Christopher
 * @author JR Tashjian
 */
function attachments_save($post_id)
{
    // verify this came from the our screen and with proper authorization,
    // because save_post can be triggered at other times
    if( !isset( $_POST['attachments_nonce'] ) )
    {
        return $post_id;
    }

    if( !wp_verify_nonce( $_POST['attachments_nonce'], plugin_basename(__FILE__) ) )
    {
        return $post_id;
    }

    // verify if this is an auto save routine. If it is our form has not been submitted, so we dont want
    // to do anything
    if( defined('DOING_AUTOSAVE') && DOING_AUTOSAVE )
    {
        return $post_id;
    }

    // Check permissions
    if( 'page' == $_POST['post_type'] )
    {
        if( !current_user_can( 'edit_page', $post_id ) )
        {
            return $post_id;
        }
    }
    else
    {
        if( !current_user_can( 'edit_post', $post_id ) )
        {
            return $post_id;
        }
    }

    // OK, we're authenticated: we need to find and save the data

    // delete all current attachments meta
    // moved outside conditional, else we can never delete all attachments
    delete_post_meta( $post_id, '_attachments' );

    // Since we're allowing Attachments to be sortable, we can't simply increment a counter
    // we need to keep track of the IDs we're given
    $attachment_ids = array();

    // We'll build our array of attachments
    foreach( $_POST as $key => $data )
    {
        // Arbitrarily using the id
        if( substr($key, 0, 14) == 'attachment_id_' )
        {
            array_push( $attachment_ids, substr( $key, 14, strlen( $key ) ) );
        }

    }

    // If we have attachments, there's work to do
    if( !empty( $attachment_ids ) )
    {

        foreach ( $attachment_ids as $i )
        {
            if( !empty( $_POST['attachment_id_' . $i] ) )
            {
                $attachment_id      = intval( $_POST['attachment_id_' . $i] );

                $attachment_details = array(
                    'id'                => $attachment_id,
                    'title'             => str_replace( '"', '&quot;', $_POST['attachment_title_' . $i] ),
                    'caption'           => str_replace( '"', '&quot;', $_POST['attachment_caption_' . $i] ),
                    'order'             => intval( $_POST['attachment_order_' . $i] )
                    );

                // serialize data and encode
                $attachment_serialized = base64_encode( serialize( $attachment_details ) );

                // add individual attachment
                add_post_meta( $post_id, '_attachments', $attachment_serialized );

                // save native Attach
                if( get_option( 'attachments_store_native' ) == 'true' )
                {
                    // need to first check to make sure we're not overwriting a native Attach
                    $attach_post_ref                = get_post( $attachment_id ); 

                    if( $attach_post_ref->post_parent == 0 )
                    {
                        // no current Attach, we can add ours
                        $attach_post                    = array();
                        $attach_post['ID']              = $attachment_id;
                        $attach_post['post_parent']     = $post_id;

                        wp_update_post( $attach_post );
                    }
                }

            }
        }

    }

}



/**
 * Retrieves all Attachments for provided Post or Page
 *
 * @param int $post_id (optional) ID of target Post or Page, otherwise pulls from global $post
 * @return array $post_attachments
 * @author Jonathan Christopher
 * @author JR Tashjian
 */
function attachments_get_attachments( $post_id=null )
{
    global $post;

    if( $post_id==null )
    {
        $post_id = $post->ID;
    }

    // get all attachments
    $existing_attachments = get_post_meta( $post_id, '_attachments', false );

    if( !empty( $existing_attachments ) )
    {
        try
        {
            $legacy_existing_attachments = unserialize( $existing_attachments[0] );
        }
        catch( Exception $e )
        {
            // unserialization failed
        }
    }

    // Check for legacy attachments
    if( isset( $legacy_existing_attachments ) )
    {
        if( is_array( $legacy_existing_attachments ) )
        {
            $tmp_legacy_attachments = array();

            // Legacy attachments (single serialized record)
            foreach ( $legacy_existing_attachments as $legacy_attachment )
            {
                array_push( $tmp_legacy_attachments, base64_encode( serialize( $legacy_attachment ) ) );
            }

            $existing_attachments = $tmp_legacy_attachments;
        }
    }


    // We can now proceed as normal, all legacy data should now be upgraded

    $post_attachments = array();
    
    if( is_array( $existing_attachments ) && count( $existing_attachments ) > 0 )
    {

        foreach ($existing_attachments as $attachment)
        {
            // decode and unserialize the data
            $data = unserialize( base64_decode( $attachment ) );

            array_push( $post_attachments, array(
                'id' 			=> stripslashes( $data['id'] ),
                'name' 			=> stripslashes( get_the_title( $data['id'] ) ),
                'mime' 			=> stripslashes( get_post_mime_type( $data['id'] ) ),
                'title' 		=> stripslashes( $data['title'] ),
                'caption' 		=> stripslashes( $data['caption'] ),
                'location' 		=> stripslashes( wp_get_attachment_url( $data['id'] ) ),
                'order' 		=> stripslashes( $data['order'] )
                ));
        }

        // sort attachments
        if( count( $post_attachments ) > 1 )
        {
            usort( $post_attachments, "attachments_cmp" );
        }
    }

    return $post_attachments;
}


if( !function_exists( 'fix_async_upload_image' ) )
{
    function fix_async_upload_image() {
        if( isset( $_REQUEST['attachment_id'] ) )
        {
            $GLOBALS['post'] = get_post( $_REQUEST['attachment_id'] );
        }
    }
}

function is_attachments_context()
{
    global $pagenow;

    // if post_id is set, it's the editor upload...
    if ( !isset( $_REQUEST['post_id'] ) || ( 'media-upload.php' == $pagenow || 'async-upload.php' == $pagenow ) && ( empty( $_REQUEST['post_id'] ) && $_REQUEST['post_id'] != '0' ) )
    {
        return true;
    }
    return false;
}

function hijack_thickbox_text($translated_text, $source_text, $domain)
{
    if ( is_attachments_context() )
    {
        if ('Insert into Post' == $source_text) {
            return __('Attach', 'attachments' );
        }
    }
    return $translated_text;
}





/**
 * This is the main initialization function, it will invoke the necessary meta_box
 *
 * @return void
 * @author Jonathan Christopher
 */

function attachments_init()
{
    global $pagenow;

    wp_enqueue_script( 'jquery-ui-core' );
    wp_enqueue_style( 'thickbox' );

    if ( 'media-upload.php' == $pagenow || 'async-upload.php' == $pagenow )
    {
        add_filter( 'gettext', 'hijack_thickbox_text', 1, 3 );
    }

    wp_enqueue_style( 'attachments', WP_PLUGIN_URL . '/attachments/css/attachments.css' );
    wp_enqueue_script( 'attachments', WP_PLUGIN_URL . '/attachments/js/attachments.js', array( 'jquery', 'thickbox' ), false, false );

    if( function_exists( 'load_plugin_textdomain' ) )
    {
        if( !defined('WP_PLUGIN_DIR') )
        {
            load_plugin_textdomain( 'attachments', str_replace( ABSPATH, '', dirname( __FILE__ ) ) );
        }
        else
        {
            load_plugin_textdomain( 'attachments', false, dirname( plugin_basename( __FILE__ ) ) );
        }
    }

    attachments_meta_box();
}