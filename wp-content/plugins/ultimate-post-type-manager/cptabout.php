<?php
if ( !function_exists( 'xydac_cpt_aboutus' ) ) { function xydac_cpt_aboutus(){
    ?>
    <div class="postbox opened" style="background:lightyellow">
		<h3><?php _e('About This Plugin','xydac_cpt'); ?></h3>
		<div class="inside" >
		   <table class="form-table">
			   <tbody>
				<tr>
				   <th scope="row" valign="top"><b><?php _e('Plugin Name','xydac_cpt'); ?></b></th>
				   <td><?php _e("Ultimate Post Type Manager",'xydac_cpt'); ?></td>
			   </tr>
				<tr>
				   <th scope="row" valign="top"><b><?php _e('Plugin Version','xydac_cpt'); ?></b></th>
				   <td><?php _e(XYDAC_CPT_VER); ?></td>
			   </tr>
				<tr>
				   <th scope="row" valign="top"><b><?php _e('Author','xydac_cpt'); ?></b></th>
				   <td> <a href="http://xydac.wordpress.com/" style="padding:4px;font-weight:bold;text-decoration:none">XYDAC</a></td>
			   </tr>
			   <tr>
				   <th scope="row" valign="top"><b><?php _e('Like this plugin?','xydac_cpt'); ?></b></th>
				   <td>
					<p style="font-size:150%">Show your support to this plugin development by donating.</p><a href="http://posttypemanager.wordpress.com/" style="color:red;background:yellow;padding:4px;font-weight:bold;">[Plugin Home Page]</a> | <a href="http://wordpress.org/tags/ultimate-post-type-manager?forum_id=10">[Create Support Ticket]</a> | <a href="http://posttypemanager.wordpress.com/" style="color:red;background:yellow;padding:4px;font-weight:bold;">[Request Feature]</a> | <a href="http://wordpress.org/extend/plugins/ultimate-post-type-manager/">[Rate Plugin]</a> | <a href="https://www.paypal.com/cgi-bin/webscr?cmd=_donations&business=nikhilseth1989%40gmail%2ecom&item_name=WordPress%20Plugin%20(Ultimate%20Post%20Type%20Manager)&no_shipping=0&no_note=1&tax=0&currency_code=USD&lc=US&bn=PP%2dDonationsBF&charset=UTF%2d8" style="color:red;background:yellow;padding:4px;font-weight:bold;">[Make Donation]</a>
				   </td>
			   </tr>
			   
			   </tbody>
		   </table>
			<form name="_xclick" action="https://www.paypal.com/cgi-bin/webscr" method="post">
			<input type="hidden" name="cmd" value="_donations">
			<input type="hidden" name="business" value="nikhilseth1989@gmail.com">
			<input type="hidden" name="item_name" value="Post Type Manager">
			<input type="hidden" name="currency_code" value="USD">
			<input type="image" src="http://www.paypal.com/en_US/i/btn/btn_donate_LG.gif" border="0" name="submit" alt="Donate for Post Type Manager!">
			</form>
		</div>
	</div>
<?php
}}
/*
 * if ( !function_exists( 'xydac_setup' ) ) { function for Showing Home
 */
if ( !function_exists( 'xydac_cpt_home' ) ) { function xydac_cpt_home(){
	?>
	<div class="wrap" ><?php xydac_cpt_heading(); ?>
        <div id="poststuff" class="ui-sortable">
		<div class="postbox-container" style="width:100%">
				<?php xydac_cpt_aboutus(); ?>
			</div>
			<div id="normal-sortables" style="width:69%;float:left;">
			
			<div class="postbox-container" >
                <div class="postbox opened">
                    <h3><?php _e('Custom Post Type','xydac_cpt'); ?></h3>
                    <div class="inside">
                       
                            <p style="text-align:justify"><?php _e('<strong>Custom Post type</strong> is a way of storing different types of content under different names, and you can call these names as a Custom Post Type.WordPress supports Creating Custom Post types since ver 3.1, and you can use the above link to create unlimited number of custom post types.<br/>','xydac_cpt');?>
                            </p><h4><?php _e('Deleting Custom Post type','xydac_cpt'); ?></h4><p style="text-align:justify">
							<?php _e('When you delete a Post Type then the data Post Type has saved does not get removed, So if you want to use the same Post Type again just recreate it again with same name.<br/>','xydac_cpt');?>
                            </p><h4><?php _e('Transferring from other Custom Post type plugins','xydac_cpt'); ?></h4><p style="text-align:justify">
							<?php _e('If you have created Post types already with some other Plugin and want to move to this Plugin then just create the Post type with same name and configure it.Do deactivate the other plugin or remove the same post type from it. Also you need to deactivate and reactivate this plugin again.','xydac_cpt'); ?>
                            </p><h4><?php _e('Some important links relating to Custom Post Types','xydac_cpt'); ?></h4>
							<p style="text-align:justify">
							<?php _e('
							<ul>
								<li><a href="http://codex.wordpress.org/Post_Types">WordPress Codex : Post Type </a></li>
								<li><a href="http://codex.wordpress.org/Function_Reference/register_post_type">WordPress Codex : register post type info </a></li>
								<li><a href="http://posttypemanager.wordpress.com/">Plugin Website </a></li>
							</ul>
							','xydac_cpt'); ?>
							</p>
                        
                    </div>
                </div>
			</div>
			<div class="postbox-container" >
                <div class="postbox opened">
                    <h3><?php _e('Custom Fields','xydac_cpt'); ?></h3>
                    <div class="inside">
                            <p style="text-align:justify"><?php _e('Custom Fields are custom data associated with any post type.They are usually a key value pair but can provide a great aid to help you design you post page. With the help of the plugin you can create various types of custom fields for any Post Type including Post and Pages.<br/>
                            
                            ','xydac_cpt');?>
							</p style="text-align:justify"><h4><?php _e('Using Custom Field in between Post','xydac_cpt'); ?></h4><p>
							<?php
							_e('To display Custom Fields in the posts you can use shortcode <strong>[xydac_field]<em>{name of field}</em>[/xydac_field]</strong> where {name of field} is the Name of Custom Field.','xydac_cpt'); ?><br/>
                            </p><h4><?php _e('Availaible Field Types','xydac_cpt'); ?></h4>
							<p style="text-align:justify">
							<?php _e('
							<ul>
								<li>Text Box</li>
								<li>Text area</li>
								<li>Rich Text Area</li>
								<li>Checkbox</li>
								<li>Radio Button</li>
								<li>Combobox</li>
								<li>Link</li>
								<li>Gallery</li>
								<li>Image</li>							
							</ul>
							','xydac_cpt'); ?><br/>
                            </p>
                    </div>
                </div>
			</div>
			</div>
			<div id="side-sortables" style="width:29%;float:left;padding-left:15px;">
			<div class="postbox-container" >
                <div class="postbox opened">
                    <h3><?php _e('Information','xydac_cpt'); ?></h3>
                    <div class="inside">
                       <p><?php _e('This plugin is an Easy to use Custom Post Type Manager to Customize Post Types, and Custom Fields for all post types with great UI.','xydac_cpt'); ?></p>
                        <p><?php _e('You can use the above menus to create <strong>Custom Post Type</strong> as well as Create <strong>Custom Fields</strong> to store more information
                           in each Post.These Custom Field Create a new Form for inserting these values.Just Check it out.','xydac_cpt'); ?></p>
                        
                    </div>
                </div>
			</div>
			<div class="postbox-container">
                <div class="postbox opened">
                    <h3><?php _e('Want More...','xydac_cpt'); ?></h3>
                    <div class="inside">
                       <?php if(!defined('XYDAC_VER')) { ?>
					   <?php _e('So, You want more..!!!<br/>
					   Check out the plugin to create Custom Taxonomies<br/><br/>
					   Taxonomies are simply different ways of classifying and organising different areas of your website,In fact there are two predefined taxonomies which are Tags and Category.','xydac_cpt'); ?><br/>
                        <h4><a href="http://wordpress.org/extend/plugins/ultimate-taxonomy-manager/" >Ultimate Taxonomy Manager</a><br/></h4>
                        <a href="http://taxonomymanager.wordpress.com/" >-<?php _e('Plugin Home Page','xydac_cpt'); ?></a><br/>
                        <a href="http://downloads.wordpress.org/plugin/ultimate-taxonomy-manager.zip">-<?php _e('','xydac_cpt'); ?><?php _e('Download Latest Version Now','xydac_cpt'); ?></a>
                        <br/><br/> <?php _e('Hope You like that Plugin Also.','xydac_cpt'); ?>
                    <?php } else { ?>
                        <h4><?php _e('Thank You','xydac_cpt'); ?></h4> <?php _e('For Installing Ultimate Post Type Manager and Ultimate Taxonomy Manager.','xydac_cpt'); ?><br/><br/> <?php _e('As you know creating good plugins require lot of time so, Support Further Development with you Esteemed Donation','xydac_cpt'); ?><br/><br/>
                        <span style="color:red;background:yellow;padding:4px;font-weight:bold;"><a href="https://www.paypal.com/cgi-bin/webscr?cmd=_donations&business=nikhilseth1989%40gmail%2ecom&item_name=WordPress%20Plugin%20(Ultimate%20Post%20Type%20Manager)&no_shipping=0&no_note=1&tax=0&currency_code=USD&lc=US&bn=PP%2dDonationsBF&charset=UTF%2d8">>>&nbsp;<?php _e('Click Here To Donate','xydac_cpt'); ?>&nbsp;<<</a></span>
						<br/><br/>
					<?php } ?>
					   
                    </div>
                </div>
			</div>
			</div>
			<div class="clear"></div>
			
		</div>
	</div>
	<?php
}}
?>