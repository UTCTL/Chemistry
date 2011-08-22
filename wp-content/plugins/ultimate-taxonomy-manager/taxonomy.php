<?php
/*
 *Finds if $name exists in $arr
 */
if ( !function_exists( 'xy_check_object' ) ) { function xy_check_object($arr,$name)
{
    if(is_array($arr))
    {
        for($j=0;$j<count($arr['object_type']);$j++)
            if($arr['object_type'][$j]==$name)
                return true;
    }
    return false;
}}
/*
 * Gets name of all taxonomies.
 * Returns: An array containing all taxonomies name.
 */
if ( !function_exists( 'get_reg_taxonomyName' ) ) { function get_reg_taxonomyName(){
    $output = 'objects';
    $taxonomies=get_taxonomies('',$output);
    $a=array();
        foreach ($taxonomies  as $taxonomy=>$e ) {array_push($a,$e->name);}
    $taxonomies = get_option("xydac_taxonomies");
        foreach ($taxonomies  as $taxonomy ) {if(!in_array($taxonomy['name'],$a))  array_push($a,$taxonomy['name']);}
    return $a;
}}
/*
 * Gets the label of post type whose name is $name.
 * Returns label.
 */
if ( !function_exists( 'getPostTypeName' ) ) { function getPostTypeName($name)
{
    $args=array('public'   => true);
	$output = 'objects';
	$post_types=get_post_types($args,$output);
    foreach($post_types as $post_type)
        if($post_type->name == $name)
            return $post_type->label;
}}
/*
 * Main if ( !function_exists( 'xydac_path' ) ) { functions that handles creation of taxonomy and display of various section of page.
 */
if ( !function_exists( 'xy_wrapper' ) ) { function xy_wrapper(){
$xydac_edit=array();
$editmode = false;
    //handles create taxonomy
	if(isset($_POST['xydac_create_taxonomy']))
    {
        if((isset($_POST["xy_tax"]['name']) && empty($_POST["xy_tax"]['name'])) || (isset($_POST["xy_tax"]['object_type']) && empty($_POST["xy_tax"]['object_type'])))
            $xydac_error= new WP_Error('err', __("Taxonomy Name and Object Type are required to create Taxonomy"));
        elseif(in_array($_POST["xy_tax"]['name'],get_reg_taxonomyName())){
            $xydac_error= new WP_Error('err', __("Taxonomy Name already registered !!!"));
        }
        else{
            if(isset($_POST["xy_tax"]['name']))
            $_POST["xy_tax"]['name'] = sanitize_title_with_dashes($_POST["xy_tax"]['name']);
            $xydac_taxes = get_option("xydac_taxonomies");
            
            if(!$xydac_taxes)
            {
                $temp = array();
                array_push($temp,$_POST["xy_tax"]);
                update_option('xydac_taxonomies',$temp);
            }
            if(is_array($xydac_taxes))
            {

                array_push($xydac_taxes,$_POST["xy_tax"]);
                update_option('xydac_taxonomies',$xydac_taxes);
            }
            $message = __('Taxonomy Added.');
        $editmode = true;
        }
    }
	//handles update taxonomy
    if(isset($_POST['xydac_update_taxonomy']) && $_POST['t_name'])
    {
        $editmode = false;
        if(empty($_POST["xy_tax"]['name']) || empty($_POST["xy_tax"]['object_type']))
            $xydac_error= new WP_Error('err', __("Taxonomy Name and Object Type are required to create Taxonomy"));
        elseif($_POST["xy_tax"]['name']!=$_POST['t_name']){
            $xydac_error= new WP_Error('err', __("Changing Taxonomy Name is not allowed !!!"));
        }
        else{
            $_POST["xy_tax"]['name'] = sanitize_title_with_dashes($_POST["xy_tax"]['name']);
            $xydac_taxes = get_option("xydac_taxonomies");
            if(is_array($xydac_taxes))
            {
                foreach($xydac_taxes as $k=>$xydac_tax)
                     if($xydac_tax['name']==$_POST['t_name'])
                     {unset($xydac_taxes[$k]);break;}
                array_push($xydac_taxes,$_POST["xy_tax"]);
                update_option('xydac_taxonomies',$xydac_taxes);
                $message = __('Taxonomy Updated.');
            }
        $editmode = true;
        }
    }
	//handles delete taxonomy
    if((isset($_POST['xydac_doaction_submit']) && isset($_POST['action'])) || (isset($_GET['delete-single']) && isset($_GET['d_name'])))
    { $i=0;
         if($_POST['action']=='delete' || $_GET['delete-single']=='delete')
         {
            $xydac_taxes = get_option("xydac_taxonomies");
            if(isset($_POST['delete_taxonomy']))
            {
                foreach($_POST['delete_taxonomy'] as $k=>$v)
                {
                    if(is_array($xydac_taxes))
                    {
                        foreach($xydac_taxes as $k=>$xydac_tax)
                             if($xydac_tax['name']==$v)
                             {unset($xydac_taxes[$k]);$i=1;}
                    }
                }
            }
            elseif(isset($_GET['d_name']) && !empty($_GET['d_name']))
            {
                foreach($xydac_taxes as $k=>$xydac_tax)
                         if($xydac_tax['name']==$_GET['d_name'])
                         {unset($xydac_taxes[$k]);$i=1;}
            }
            if($i)
            {update_option('xydac_taxonomies',$xydac_taxes);
             $message = __('Taxonomy Deleted.');}
             else
             {
                 $message = __('Taxonomy Not Deleted.');}
         }
         $editmode = true;
    }
    if(isset($editmode) && !$editmode)
    {
        if(isset( $_POST["xy_tax"]))
            $xydac_edit = $_POST["xy_tax"];
    }
    if((isset($_GET['edit-taxonomy']) && isset($_GET['tname'])) && !isset($_POST["xy_tax"]))
    {
        $xydac_taxes = get_option("xydac_taxonomies");
        if(is_array($xydac_taxes))
            {
                foreach($xydac_taxes as $xydac_tax)
                    if(isset($_GET['tname']))
                    if($xydac_tax['name']==$_GET['tname'])
                    {
                        $xydac_edit = $xydac_tax;break;
                    }
            }
    }
    ?>
<div class="wrap" id="page_content">
 <?php
    xydac_heading("taxonomy");
    if (isset($xydac_error) && is_wp_error($xydac_error) )
        echo "<div class='error below-h2'><p>".$xydac_error->get_error_message()."</p></div>";//updated ?>
    <?php if(isset($message)) { ?>
    <div id="message" class="updated below-h2"><p><?php echo $message; ?></p></div>
    <?php } ?>
  <br class="clear" />
    <a href="<?php _e(XYDAC_TAXONOMY_PATH,'xydac'); ?>">Create New Taxonomy</a>
  <div id="col-container">
  <?php
	col_right();
    if((isset($_GET['edit-taxonomy']) && isset($_GET['tname']))&&  (!$editmode))
        col_left($xydac_edit);
    else
    {
        col_left();
    }
	echo '</div></div>';
}}
/*
 * Main if ( !function_exists( 'xydac_path' ) ) { function for displaying left column form.
 * param :$xydac_edit : is array containing values if taxonomy is being edited.
 */
if ( !function_exists( 'col_left' ) ) { function col_left($xydac_edit=false){
	$xy_arrs = array(
	'label' => array( 'arr_label' => 'Label of Taxonomy ' , 'name' => 'xy_tax[args][label]', 'type'=>'string', 'desc'=>'A plural descriptive name for the taxonomy marked for translation.', 'default'=>''),
	'showascombobox' => array( 'arr_label' => 'Show as ComboBox ' , 'name' => 'xy_tax[showascombobox]', 'type'=>'boolean', 'desc'=>'Show the Terms in Combo-box on the Add/Edit Post/Custom Post Page', 'default'=>'false'),
	'public' => array( 'arr_label' => 'Public ' , 'name' => 'xy_tax[args][public]', 'type'=>'boolean', 'desc'=>'Should this taxonomy be exposed in the admin UI.', 'default'=>'true'),
	'show_in_nav_menus' => array( 'arr_label' => 'Show in Navigation Menu ' , 'name' => 'xy_tax[args][show_in_nav_menus]', 'type'=>'boolean', 'desc'=>'Selecting TRUE makes this Taxonomy available for selection in navigation menus.', 'default'=>'true'),
	'show_ui' => array( 'arr_label' => 'Show UI ' , 'name' => 'xy_tax[args][show_ui]', 'type'=>'boolean', 'desc'=>'Whether to generate a default User Interface for managing this taxonomy.', 'default'=>'true'),
	'show_tagcloud' => array( 'arr_label' => 'Show Tag Cloud ' , 'name' => 'xy_tax[args][show_tagcloud]', 'type'=>'boolean', 'desc'=>'Whether to show a tag cloud in the admin UI for this Taxonomy Name', 'default'=>'true'),
	'hierarchical' => array( 'arr_label' => 'Hierarchical ' , 'name' => 'xy_tax[args][hierarchical]', 'type'=>'boolean', 'desc'=>'Is this taxonomy hierarchical (have descendants) like categories or not hierarchical like tags.', 'default'=>'false'),
	'rewrite' => array( 'arr_label' => 'Rewrite ', 'name' => 'xy_tax[args][rewrite][val]', 'type'=>'boolean', 'desc'=>'Set to false to prevent rewrite, or array to customize customize query var. Default will use Taxonomy Name as query var', 'default'=>'true'),
	'rewrite_slug' => array( 'arr_label' => 'Slug ', 'name' => 'xy_tax[args][rewrite][slug]', 'type'=>'string', 'desc'=>' prepend posts with this slug', 'default'=>'true'),
	'rewrite_with_front' => array( 'arr_label' => 'With-Front ' , 'name' => 'xy_tax[args][rewrite][with_front]', 'type'=>'boolean', 'desc'=>'allowing permalinks to be prepended with front base', 'default'=>'true'),
	'rewrite_hierarchical' => array( 'arr_label' => 'Hierarchical' , 'name' => 'xy_tax[args][rewrite][hierarchical]', 'type'=>'boolean', 'desc'=>'Allows permalinks to be rewritten hierarchically(Works with WP-3.1)', 'default'=>'false'),
	'query_var' => array( 'arr_label' => 'Query var ' , 'name' => 'xy_tax[args][query_var]', 'type'=>'string', 'desc'=>'False to prevent queries, or string to customize query var. Default will use Taxonomy Name as query var', 'default'=>''),
	'name' => array( 'arr_label' => 'Plural Name ', 'name' => 'xy_tax[args][labels][name]' ,  'type' => 'string'  , 'desc' => 'general name for the taxonomy, usually plural.' ),
	'singular_name' => array( 'arr_label' => 'Singular Name ', 'name' => 'xy_tax[args][labels][singular_name]' ,  'type' => 'string'  , 'desc' => 'name for one object of this taxonomy.' ),
	'search_items' => array( 'arr_label' => 'Search Item Label ', 'name' => 'xy_tax[args][labels][search_items]' ,  'type' => 'string'  , 'desc' => 'the search items text.' ),
	'popular_items' => array( 'arr_label' => 'Popular Item Label ', 'name' => 'xy_tax[args][labels][popular_items]' , 'type' => 'string'  , 'desc' => 'the popular items text.' ),
	'all_items' => array( 'arr_label' => 'All Item Label ', 'name' => 'xy_tax[args][labels][all_items]' ,  'type' => 'string'  , 'desc' => 'the all items text.' ),
	'parent_item' => array( 'arr_label' => 'Parent Item Label ', 'name' => 'xy_tax[args][labels][parent_item]' ,  'type' => 'string'  , 'desc' => 'the parent item text. This string is not used on non-hierarchical taxonomies such as post tags.' ),
	'parent_item_colon' => array( 'arr_label' => 'Parent Item Label with colon ', 'name' => 'xy_tax[args][labels][parent_item_colon]',  'type' => 'string'  , 'desc' => 'The same as parent_item, but with colon : in the end.' ),
	'edit_item' => array( 'arr_label' => 'Edit Item Label ', 'name' => 'xy_tax[args][labels][edit_item]' ,  'type' => 'string'  , 'desc' => 'the edit item text.' ),
	'update_item' => array( 'arr_label' => 'Update Item Label ', 'name' => 'xy_tax[args][labels][update_item]' ,  'type' => 'string'  , 'desc' => 'the update item text.' ),
	'add_new_item' => array( 'arr_label' => 'Add New Item Label ', 'name' => 'xy_tax[args][labels][add_new_item]' ,  'type' => 'string'  , 'desc' => 'the add new item text.' ),
	'new_item_name' => array( 'arr_label' => 'New Item Label ', 'name' => 'xy_tax[args][labels][new_item_name]' ,  'type' => 'string'  , 'desc' => 'the new item name text.' ),
	'separate_items_with_commas' => array( 'arr_label' => 'Seperate Item With Commas Label ', 'name' => 'xy_tax[args][labels][separate_items_with_commas]',  'type' => 'string'  , 'desc' => 'the separate item with commas text used in the taxonomy meta box. This string isn\'t used on hierarchical taxonomies.' ),
	'add_or_remove_items' => array( 'arr_label' => 'Add or Remove Items Label ', 'name' => 'xy_tax[args][labels][add_or_remove_items]',  'type' => 'string'  , 'desc' => 'the add or remove items text and used in the meta box when JavaScript is disabled. This string isn\'t used on hierarchical taxonomies.' ),
	'choose_from_most_used' => array( 'arr_label' => 'Choose From Most Used Label ', 'name' => 'xy_tax[args][labels][choose_from_most_used]',  'type' => 'string'  , 'desc' => 'the choose from most used text used in the taxonomy meta box. This string isn\'t used on hierarchical taxonomies.' ),
	'view_item' => array( 'arr_label' => 'View Item Label ', 'name' => 'xy_tax[args][labels][view_item]',  'type' => 'string'  , 'desc' => 'The View Item Label used in Admin Panel,Admin Menu.' ),
	'manage_terms' => array( 'arr_label' => 'Manage Terms ' , 'name' => 'xy_tax[args][capabilities][manage_terms]', 'type'=>'array', 'desc'=>'Assign the permissions. who can manage the Taxonomy Terms', 'default' => 'manage_categories', 'values'=>array('manage_options' => 'Administrator', 'manage_categories' => 'Editor', 'publish_posts' => 'Author', 'edit_posts' => 'Contributor', 'read' => 'Subscriber')),
	'edit_terms' => array( 'arr_label' => 'Edit Terms ' , 'name' => 'xy_tax[args][capabilities][edit_terms]', 'type'=>'array', 'desc'=>'Assign the permissions. who can edit the Taxonomy Terms', 'default' => 'manage_categories', 'values'=>array('manage_options' => 'Administrator', 'manage_categories' => 'Editor', 'publish_posts' => 'Author', 'edit_posts' => 'Contributor', 'read' => 'Subscriber')),
	'delete_terms' => array( 'arr_label' => 'Delete Terms ' , 'name' => 'xy_tax[args][capabilities][delete_terms]', 'type'=>'array', 'desc'=>'Assign the permissions. who can delete the Taxonomy Terms', 'default' => 'manage_categories', 'values'=>array('manage_options' => 'Administrator', 'manage_categories' => 'Editor', 'publish_posts' => 'Author', 'edit_posts' => 'Contributor', 'read' => 'Subscriber')),
	'assign_terms' => array( 'arr_label' => 'Assign Terms ' , 'name' => 'xy_tax[args][capabilities][assign_terms]', 'type'=>'array', 'desc'=>'Assign the permissions. who can assign the Taxonomy Terms', 'default' => 'edit_posts', 'values'=>array('manage_options' => 'Administrator', 'manage_categories' => 'Editor', 'publish_posts' => 'Author', 'edit_posts' => 'Contributor', 'read' => 'Subscriber')),
	'update_count_callback' => array( 'arr_label' => 'Update Count Callback function Name ' , 'name' => 'xy_tax[args][update_count_callback]', 'type'=>'string', 'desc'=>'<strong>For Advanced Users only</strong> A function name that will be called to update the count of an associated $object_type, such as post, is updated.')
	);
?>
	<div id='col-left'><div class='col-wrap'>
	<div class='form-wrap'>
	<h3><?php if(is_array($xydac_edit)) _e('Edit Taxynomy','xydac'); else _e('Add a New Taxynomy','xydac'); ?></h3>
	<form <?php if(is_array($xydac_edit)) _e("id='form_edit_taxonomy'",'xydac');else _e("id='form_create_taxonomy'",'xydac'); ?> action='<?php _e(XYDAC_TAXONOMY_PATH,'xydac'); ?>' method='post'>
	<div class="form-field form-required <?php if(isset($_POST['xydac_create_taxonomy']) || isset($_POST['xydac_edit_taxonomy'])) if(isset($_POST["xy_tax"]['name']) && empty($_POST["xy_tax"]['name'])) _e('form-invalid','xydac');?>"  >
        <label for='xy_tax[name]'>The Name of the taxonomy</label>
        <input type='text' name='xy_tax[name]' <?php if(is_array($xydac_edit)) echo "readonly"; ?> class='name' id='xy_tax[name]' value="<?php if(is_array($xydac_edit)) _e($xydac_edit['name'],'xydac'); ?>" />
        <p>Taxonomy Name identifies your Taxonomy among others. It is usually all lowercase and contains only letters, numbers, and hyphens.</p>
    </div>
    <?php
	$args=array('public'   => true);
	$output = 'objects';
	$post_types=get_post_types($args,$output); ?>
	<div class="form-field form-required <?php if(isset($_POST['xydac_create_taxonomy']) || isset($_POST['xydac_edit_taxonomy'])) if(isset($_POST["xy_tax"]['object_type']) && empty($_POST["xy_tax"]['object_type'])) _e('form-invalid','xydac');?>">
        <label>Select the Types You want to associate the Taxonomy to.</label>
		<?php foreach ($post_types  as $post_type ) if($post_type->name!='attachment') {  ?>
            <input type='checkbox' style="width:15px;margin-left:20px" name="xy_tax[object_type][]" id="xy_tax[object_type]" value="<?php _e($post_type->name,'xydac'); ?>" <?php if(xy_check_object($xydac_edit,$post_type->name)) _e("checked='checked'",'xydac') ?>  />&nbsp;<?php _e($post_type->label,'xydac'); ?><br /><?php }  ?>
	    <p>Select all those Post Types where you want to use your Taxonomy.</p>
    </div>
        <input type="button" class="button" value="Hide More Options" style="display: none;float:right" id="xydac_temp" />
        <input type="button" class="button" value="Show More Options" style="float:right" id="xydac_temp" />
        <br/>
        <br/>
<div id="xydac_panel_notice" style="color:red;background:yellow;padding:4px;font-weight:bold;border:1px solid #333;"><p style="font-style: normal;color:red">Following Options are all optional and you should edit them only if you know what you are doing,<br/> Okey forget the theory do what you want, and if you are messed up Come back here and set the values to default or blank and save them else just <a href="http://taxonomymanager.wordpress.com/" >  Let me know I'll sort you out, and do send me your suggestions.</a> </p></div>
    <?php
	foreach ($xy_arrs as $k=>$xy_arr)
	{$atemp = explode('[',substr($xy_arr['name'],6)); ?>
	<div class='form-field' id="xydac_panel_<?php _e($xy_arr['name'],'xydac') ?>"  >
    <?php if($xy_arr['type']=='boolean')
	{?><label for='<?php _e($xy_arr['name'],'xydac') ?>' style="display:inline"><?php _e($xy_arr['arr_label'],'xydac') ?></label>
		<select id='<?php _e($xy_arr['name'],'xydac'); ?>' name='<?php _e($xy_arr['name'],'xydac') ?>' class='postform' style="float:right;width:100px;margin-right:5%">
			<option value='true' <?php if($xy_arr['default']=='true' && !is_array($xydac_edit)) {_e(' Selected','xydac');}elseif(is_array($xydac_edit)) { if(count($atemp)==2) {if($xydac_edit[substr($atemp[1],0,-1)]=='true')_e(' Selected','xydac');}elseif(count($atemp)==3) {if($xydac_edit[substr($atemp[1],0,-1)][substr($atemp[2],0,-1)]=='true')_e(' Selected','xydac');} elseif(count($atemp)==4) {if($xydac_edit[substr($atemp[1],0,-1)][substr($atemp[2],0,-1)][substr($atemp[3],0,-1)]=='true') _e(' Selected','xydac'); }}  ?>>True</option>
			<option value='false' <?php if($xy_arr['default']=='false' && !is_array($xydac_edit)){ _e('Selected','xydac');}elseif(is_array($xydac_edit)) { if(count($atemp)==2) {if($xydac_edit[substr($atemp[1],0,-1)]=='false')_e(' Selected','xydac');}elseif(count($atemp)==3) {if($xydac_edit[substr($atemp[1],0,-1)][substr($atemp[2],0,-1)]=='false')_e(' Selected','xydac');} elseif(count($atemp)==4) {if($xydac_edit[substr($atemp[1],0,-1)][substr($atemp[2],0,-1)][substr($atemp[3],0,-1)]=='false') _e(' Selected','xydac');} } ?>>False</option>
		</select>
	<?php } elseif($xy_arr['type']=='array') { ?>
        <label for='<?php _e($xy_arr['name'],'xydac') ?>' style="display:inline"><?php _e($xy_arr['arr_label'],'xydac') ?></label>
        <select id='<?php _e($xy_arr['name'],'xydac'); ?>' name='<?php _e($xy_arr['name'],'xydac') ?>' class='postform' style="float:right;width:150px;margin-right:5%">
            <?php  foreach($xy_arr['values'] as $n=>$c) {   ?>
                <option value='<?php _e($n,'xydac'); ?>' <?php if($xy_arr['default']==$n && !is_array($xydac_edit)) {_e(' Selected','xydac');}elseif(is_array($xydac_edit)) { if(count($atemp)==2) {if($xydac_edit[substr($atemp[1],0,-1)]==$n)_e(' Selected','xydac');}elseif(count($atemp)==3) {if($xydac_edit[substr($atemp[1],0,-1)][substr($atemp[2],0,-1)]==$n)_e(' Selected','xydac');} elseif(count($atemp)==4) {if($xydac_edit[substr($atemp[1],0,-1)][substr($atemp[2],0,-1)][substr($atemp[3],0,-1)]==$n) _e(' Selected','xydac'); }}  ?>><?php _e($c,'xydac') ?></option>
                <?php } ?>
        </select>
	<?php } else { ?><label for='<?php _e($xy_arr['name'],'xydac') ?>'><?php _e($xy_arr['arr_label'],'xydac') ?></label>
		<input type='text' name='<?php _e($xy_arr['name'],'xydac') ?>' class='name' id='<?php _e($xy_arr['name'],'xydac') ?>' value="<?php if(is_array($xydac_edit)) { if(count($atemp)==3) _e($xydac_edit[substr($atemp[1],0,-1)][substr($atemp[2],0,-1)],'xydac'); elseif(count($atemp)==4) _e($xydac_edit[substr($atemp[1],0,-1)][substr($atemp[2],0,-1)][substr($atemp[3],0,-1)],'xydac'); } ?>"/>
	<?php } ?>
	<p><?php _e($xy_arr['desc'],'xydac') ?></p>
    </div>
	<?php } if(is_array($xydac_edit)) {?>
            <input type="hidden" name="t_name" value="<?php if(isset($_GET['tname'])) _e($_GET['tname'],'xydac'); ?>">
        <?php } ?>
    <p class='submit'>
    <input type="submit"  name="<?php if(!is_array($xydac_edit)) _e('xydac_create_taxonomy','xydac'); else  _e('xydac_update_taxonomy','xydac'); ?>" class="button-primary" value="<?php if(!is_array($xydac_edit)) _e('Add Taxonomy','xydac'); else  _e('Update Taxonomy','xydac'); ?>"></p>
	</form>
	</div>
	</div>
	</div>
	<?php }} ?>
<?php
/*
 * Main if ( !function_exists( 'xydac_path' ) ) { function for displaying Right column.
 * requires constant XYDAC_TAXONOMY_PATH. 
 */
if ( !function_exists( 'col_right' ) ) { function col_right(){
    ?>
 <div id="col-right">
      <div class="form-wrap">
          <form id="form_edit" action="<?php _e(XYDAC_TAXONOMY_PATH,'xydac'); ?>" method="post"  >
          <div class="tablenav">
            <select name="action">
              <option value=""><?php _e('Bulk Actions','xydac'); ?></option>
              <option value="delete"><?php _e('Delete','xydac'); ?></option>
            </select>
            <input type="submit" class="button-secondary action"  id="xydac_doaction_submit" name="xydac_doaction_submit" value="Apply"/>
          </div><br class="clear">
          <table class="widefat tag fixed" cellspacing="0">
            <thead class="content-types-list">
              <tr>
                <th style="" class="manage-column column-cb check-column" id="cb" scope="col"><input type="checkbox"></th>
                <th style="" class="manage-column column-name" id="name" scope="col"><?php _e('Name','xydac'); ?></th>
                <th style="" class="manage-column column-fields" id="fields" scope="col"><?php _e('Object Type','xydac'); ?></th>
                <th style="" class="manage-column column-categories" id="categories" scope="col"><?php _e('Label','xydac'); ?></th>
              </tr>
            </thead>
            <tbody id="the-list">
            <?php
            $xydac_taxes = get_option("xydac_taxonomies");
            if(is_array($xydac_taxes))
                foreach($xydac_taxes as $xydac_tax)
                { 
                ?>
            <tr id="content-type-<?php _e($xydac_tax['name'],'xydac'); ?>" class="">
                <th class="check-column" scope="row">
                  <input type="checkbox" value="<?php _e($xydac_tax['name'],'xydac'); ?>" name="delete_taxonomy[]"/>
                </th>
                <td class="name column-name">
                  <strong>
                      <a class="row-title" title="Edit &ldquo;<?php _e($xydac_tax['name'],'xydac'); ?>&rdquo;" href="<?php echo XYDAC_TAXONOMY_PATH."&edit-taxonomy=true&tname=".$xydac_tax['name']; ?>"><?php _e($xydac_tax['name'],'xydac'); ?></a></strong><br />
                    <div class="row-actions">
                    <span class="edit"><a href="<?php echo XYDAC_TAXONOMY_PATH."&edit-taxonomy=true&tname=".$xydac_tax['name']; ?>">Edit</a> | </span>
                    <span class="inline"><a href="<?php echo XYDAC_FIELDS_PATH."&manage_fields_submit=Manage&manage_fields_select=".$xydac_tax['name']; ?>">Manage Custom Fields</a> | </span>
                    
                    <span class="delete"><a href="<?php echo XYDAC_TAXONOMY_PATH."&delete-single=delete&d_name=".$xydac_tax['name']; ?>">Delete</a></span>
                  </div>
                </td>
                <td class="fields column-fields">
                 <?php if(is_array($xydac_tax['object_type']))foreach($xydac_tax['object_type'] as $k=>$v) _e(getPostTypeName($v).'<br/>','xydac');  ?>
                </td>
                <td class="categories column-categories">
                    <?php _e($xydac_tax['args']['label'],'xydac'); ?>
                </td>
            </tr>
           <?php //echo $row->field_name;
            }   ?>
            </tbody>
            <tfoot>
              <tr>
                <th style="" class="manage-column column-cb check-column"  scope="col"><input type="checkbox"></th>
                <th style="" class="manage-column column-name" scope="col"><?php _e('Name','xydac'); ?></th>
                <th style="" class="manage-column column-fields" scope="col"><?php _e('Object Type','xydac'); ?></th>
                <th style="" class="manage-column column-categories" scope="col"><?php _e('Label','xydac'); ?></th>
              </tr>
            </tfoot>
          </table>
        </form>
          <br class="clear">
          <br class="clear">
          <div class="form-wrap">
            <p><strong>Note:</strong><br>Deleting a field does not deletes the value in database<br/>
            Its always good to Give a label to a Taxonomy.
            </p>
			
            </div>
      </div>
    </div>
<?php }}
if ( !function_exists( 'xydac_cloud' ) ) {
function xydac_cloud($taxonomy,$termslug='',$field=''){
	$result=array();
	$terms  = get_terms($taxonomy);
	if(is_array($terms))
	foreach($terms as $k=>$term)
	{
		if($termslug!='' && $termslug==$term->slug)
		{
			unset($result);
			$result = array();
			if($field!='')
				$result = get_metadata("taxonomy", $term->term_id, $field , TRUE);
			else{
				$result['name']=$term->name;
				$result['description']=$term->description;
				foreach(getFields($taxonomy) as $k=>$v)
					$result[$v->field_name] = get_metadata("taxonomy", $term->term_id, $v->field_name , TRUE);
				}
			break;
		}
		else 
		{
			if($field!='')
				$result[$term->slug][$field] = get_metadata("taxonomy", $term->term_id, $field , TRUE);
			else{
				$result[$term->slug]['name']=$term->name;
				$result[$term->slug]['description']=$term->description;
				foreach(getFields($taxonomy) as $k=>$v)
					$result[$term->slug][$v->field_name] = get_metadata("taxonomy", $term->term_id, $v->field_name , TRUE);
				}
		}
	}
	return $result;
}}
 ?>