<?php
/*
Part of WordPress Plugin: Page Restrict
Plugin URI: http://sivel.net/wordpress/
*/

//
$pr_version = '2.02';

// Full path and plugin basename of the main plugin file
$pr_plugin_file = dirname ( dirname ( __FILE__ ) ) . '/pagerestrict.php';
$pr_plugin_basename = plugin_basename ( $pr_plugin_file );

// Check the version in the options table and if less than this version perform update
function pr_ver_check () {
	global $pr_version;
	if ( ( pr_get_opt ( 'version' ) < $pr_version ) || ( ! pr_get_opt ( 'version' ) ) ) :
		$pr_options['version'] = $pr_version;
		if ( ! is_array ( pr_get_opt ( 'pages' ) ) )
			$pr_options['pages'] = explode ( ',' , pr_get_opt ( 'pages' ) );
		else
			$pr_options['pages'] = pr_get_opt ( 'pages' );
		$pr_options['method'] = pr_get_opt ( 'method' );
		$pr_options['message'] = 'You are required to login to view this page.';
		$pr_options['loginform'] = true;
		pr_delete ();
		add_option ( 'pr_options' , $pr_options );
	endif;
}

// Initialize the default options during plugin activation
function pr_init () {
	global $pr_version;
	if ( ! pr_get_opt( 'version' ) ) :
		$pr_options['version'] = $pr_version;
		$pr_options['pages'] = array ();
		$pr_options['method'] = 'selected';
		$pr_options['message'] = 'You are required to login to view this page.';
		$pr_options['loginform'] = true;
		add_option ( 'pr_options' , $pr_options ) ;
	else :
		pr_ver_check ();
	endif;
}

// Delete all options 
function pr_delete () {
	delete_option ( 'pr_options' );
}

// Add the options page
function pr_options_page () {
	global $pr_plugin_basename;
	if ( current_user_can ( 'edit_others_pages' ) && function_exists ( 'add_options_page' ) ) :
		add_options_page ( 'Page Restrict' , 'Page Restrict' , 'publish_pages' , 'pagerestrict' , 'pr_admin_page' );
		add_filter("plugin_action_links_$pr_plugin_basename", 'pr_filter_plugin_actions' );
	endif;

}

// Add the setting link to the plugin actions
function pr_filter_plugin_actions ( $links ) {
        $settings_link = '<a href="options-general.php?page=pagerestrict">' . __( 'Settings' ) . '</a>';
        array_unshift( $links, $settings_link );
        return $links;
}

// The options page
function pr_admin_page () {
	pr_ver_check ();
	if ( $_POST && $_POST['action'] == 'update' ) :
		if ( $_POST['update'] == 'pages' ) :
			$page_ids = $_POST['page_id'];
			$post_ids = $_POST['post_id'];
		else :
			$page_ids = pr_get_opt ( 'pages' );	
			$post_ids = pr_get_opt ( 'posts' );	
		endif;
		if ( ! is_array ( $page_ids ) ) 
		$page_ids = array ();
		$pr_options['pages'] = $page_ids;
		$pr_options['posts'] = $post_ids;
		$pr_method = $_POST['method'];
		$pr_options['method'] = $pr_method;
		$pr_options['version'] = pr_get_opt ( 'version' );
		$pr_message = stripslashes($_POST['message']);
		$pr_options['message'] = $pr_message;
		if ( $_POST['loginform'] == 'true' )
			$pr_options['loginform'] = true;
		else
			$pr_options['loginform'] = false;
		update_option ( 'pr_options' , $pr_options );
		echo '<div id="message" class="updated fade"><p><strong>Settings saved.</strong></p></div>';
	else :
		$page_ids = pr_get_opt ( 'pages' );
		$post_ids = pr_get_opt ( 'posts' );
                if ( ! is_array ( $page_ids ) )
                        $page_ids = array ();
		$pr_method = pr_get_opt ( 'method' );
		$pr_message = pr_get_opt ( 'message' );
	endif;
?>
	<div class="wrap">
		<h2>Page Restrict Options</h2>
		<form action="<?php echo $_SERVER['REQUEST_URI']; ?>" method="post">
                        <input type="hidden" name="action" value="update" />
			<h3>General Options</h3>
			<p>These options pertain to the gerneral operation of the plugin</p>
			<table class="form-table">
				<tr valign="top">
					<th scope="row">
						Restriction Message
					</th>
					<td>
						<textarea cols="64" rows="4" name="message"><?php echo $pr_message; ?></textarea>
						<br />
						This field can contain HTML.
					</td>
				</tr>
				<tr valign="top">
					<th scope="row">
						Show Login Form
					</th>
					<td>
						<select name="loginform">
							<option value="true"<?php selected ( true , pr_get_opt ( 'loginform' ) ); ?>>Yes</option>
							<option value="false"<?php selected ( false , pr_get_opt ( 'loginform' ) ); ?>>No</option>
						</select>
					</td>
				</tr>
				<tr valign="top">
					<th scope="row">
						Restriction Method
					</th>
					<td>
						<select name="method">
							<option value="all"<?php selected ( 'all' , pr_get_opt ( 'method' ) ); ?>>All</option>
							<option value="none"<?php selected ( 'none' , pr_get_opt ( 'method' ) ); ?>>None</option>
							<option value="selected"<?php selected ( 'selected' , pr_get_opt ( 'method' ) ); ?>>Selected</option>
						</select>
					</td>
				</tr>
			</table>
<?php
	if ( $pr_method == 'selected' ) :
?>
			<h3>Page List</h3>
			<p>Select the pages that you wish to restrict to logged in users.</p>
			<input type="hidden" name="update" value="pages" />
			<select name="page_id[]" id="the_pages" multiple="multiple" size="15" style="height: 150px;width:400px;">
<?php
		$avail_pages = get_pages ();
		foreach ( $avail_pages as $page ) :
?>
				<option value="<?php echo esc_attr($page->ID); ?>"<?php selected( true , in_array ( $page->ID , $page_ids ) ); ?>><?php echo wp_specialchars($page->post_title); ?></option>
<?php
		endforeach;
?>
			</select>
			
			
			<h3>Post List</h3>
			<p>Select the posts that you wish to restrict to logged in users.</p>
			<input type="hidden" name="update" value="pages" />
			<select name="post_id[]" id="the_posts" multiple="multiple" size="15" style="height: 150px;width:400px;">
<?php
		$avail_posts = get_posts('showposts=-1');
		foreach ( $avail_posts as $post ) :
?>
				<option value="<?php echo esc_attr($post->ID); ?>"<?php selected( true , in_array ( $post->ID , $post_ids ) ); ?>><?php echo wp_specialchars($post->post_title); ?></option>
<?php
		endforeach;
?>
			</select>
			
			
<?php
	endif;
?>
			<br />
			<p class="submit">
				<input type="submit" name="submit" class="button-primary" value="Save Changes" />
			</p>
		</form>
	</div>
<?php
}

/**
 * The meta box
 */
function page_restriction_status_meta_box ( $post ) {
	$post_ID = $post->ID;
	if ( $post->post_type == 'page' ) {
		$the_IDs = pr_get_opt ('pages');
	}
	else {
		$the_IDs = pr_get_opt ('posts');
	}
	if ( ! is_array ( $page_ids ) )
		$page_ids = array ();
?>
	<p>
		<input name="pr" type="hidden" value="update" />
		<label for="restriction_status" class="selectit">
			<input type="checkbox" name="restriction_status" id="restriction_status"<?php if ( in_array ( $post_ID , $the_IDs ) ) echo ' checked="checked"'; ?>/>
			Restrict <?php echo $post->post_type == 'post' ? 'Post' : 'Page'; ?>
		</label>
	</p>
	<p>These settings apply to this <?php echo $post->post_type == 'post' ? 'post' : 'page'; ?> only. For a full list of restriction statuses see the <a href="options-general.php?page=pagerestrict">global options page</a>.</p>
<?php
}

/**
 * Add meta box to create/edit page pages
 */
function pr_meta_box () {
	add_meta_box ( 'pagerestrictionstatusdiv' , 'Restriction' , 'page_restriction_status_meta_box' , 'page' , 'normal' , 'high' );
	add_meta_box ( 'pagerestrictionstatusdiv' , 'Restriction' , 'page_restriction_status_meta_box' , 'post' , 'normal' , 'high' );
}

/**
 * Get custom POST vars on edit/create page pages and update options accordingly
 */
function pr_meta_save () {
	if ( isset ( $_POST['pr'] ) && $_POST['pr'] == 'update' ) :
		$post_ID = $_POST['post_ID'];
		$post = get_post($post_ID);
		if ( $post->post_type == 'page' ) {
			$restrict_type = 'pages';
		}
		else {
			$restrict_type = 'posts';
		}
		$pr_options['pages'] = pr_get_opt('pages');
		$pr_options['posts'] = pr_get_opt('posts');
		$restricted = $pr_options[ $restrict_type ];
		if ( ! is_array ( $restricted ) )
			$restricted = array ();
		if ( ! empty ( $_POST['restriction_status'] ) && $_POST['restriction_status'] == 'on' ) :
			$restricted[] = $post_ID ;
			$pr_options[ $restrict_type ] = $restricted;
		else :
			$pr_options[ $restrict_type ] = array_filter ( $restricted , 'pr_array_delete' );
		endif;
		$pr_options['loginform'] = pr_get_opt ( 'loginform' );
		$pr_options['method'] = pr_get_opt ( 'method' );
		$pr_options['message'] = pr_get_opt ( 'message' );
		$pr_options['version'] = pr_get_opt ( 'version' );
		update_option ( 'pr_options' , $pr_options );
	endif;
}

/**
 * Remove item from array
 */
function pr_array_delete ( $item ) {
	return ( $item !== $_POST['post_ID'] );
}

/**
 * Activation hook
 */
register_activation_hook ( dirname ( dirname ( __FILE__ ) ) . '/pagerestrict.php' , 'pr_init' );

/**
 * Tell WordPress what to do.  Action hooks.
 */
add_action ( 'admin_menu' , 'pr_meta_box' );
add_action ( 'save_post' , 'pr_meta_save' );
add_action ( 'admin_menu' , 'pr_options_page' ) ;
?>
