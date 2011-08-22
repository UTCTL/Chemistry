<?php
if ( !function_exists( 'getFieldrow' ) ) { function getFieldrow($id){
    global $wpdb;
    return  $wpdb->get_row("SELECT * FROM ".XYDAC_FIELDTABLE." WHERE field_id = $id");
}}
if ( !function_exists( 'getFields' ) ) { function getFields($name) {
    global $wpdb;
    $name = stripslashes($name);
    $rows = $wpdb->get_results("SELECT field_id,field_name,field_label,field_type,field_val FROM ".XYDAC_FIELDTABLE." WHERE tax_name='$name'");
    return $rows;
}}
if ( !function_exists( 'insertField' ) ) { function insertField($tax_name,$fname,$flabel,$ftype,$fdesc,$fval=NULL)
{
    global $wpdb;
    $wpdb->insert( XYDAC_FIELDTABLE, array(
        'tax_name' => $tax_name,
        'field_name' => sanitize_title_with_dashes($fname),
        'field_label' =>$flabel,
        'field_type' => $ftype,
        'field_desc' => $fdesc,
        'field_val' => $fval ), array( '%s', '%s', '%s', '%s', '%s', '%s' ) );
    return $wpdb->insert_id;

}}
if ( !function_exists( 'updateField' ) ) { function updateField($field_id,$tax_name,$fname,$flabel,$ftype,$fdesc,$fval=NULL)
{
    global $wpdb;
    
    return $wpdb->update( XYDAC_FIELDTABLE, array(
        'tax_name' => $tax_name,
        'field_name' => sanitize_title_with_dashes($fname),
        'field_label' =>$flabel,
        'field_type' => $ftype,
        'field_desc' => $fdesc,
        'field_val' => $fval ), array( 'field_id' => $field_id ));
    
}}
if ( !function_exists( 'deleteField' ) ) { function deleteField($field_id)
{
    global $wpdb;

    $sql  = $wpdb->prepare( "DELETE FROM ".XYDAC_FIELDTABLE." WHERE field_id=%d",$field_id);
    $wpdb->query($sql);
}}
if ( !function_exists( 'xydac_field_avail' ) ) { function xydac_field_avail($name){
	global $wpdb;
	$l_row = $wpdb->get_row("SELECT * FROM ".XYDAC_FIELDTABLE." WHERE field_name = '".$name."'",ARRAY_A);
	
	if(is_array($l_row))
		return 0;
	else 
		return 1;
}}
if ( !function_exists( 'xydac_tax' ) ) { function xydac_tax(){
if(isset($_GET['manage_fields_submit']) || isset($_POST['add_field_submit']) || isset($_GET['field']) || isset($_POST['doaction_submit']))
{
    $not_inserted= false;
    $t_name = $_GET['manage_fields_select'];

    $p_tname ="";
    $p_fname ="";
    $p_flabel="";
    $p_ftype ="";
    $p_fdesc ="";
    if(isset($_POST['doaction_submit']) && isset($_POST['taxonomy']))
    {
        if(isset($_POST['action']) && $_POST['action']=='delete')
            if(isset($_POST['delete_content_type']))
            foreach($_POST['delete_content_type'] as $k=>$v)
            {
                deleteField($v);
                $message = __('Item Deleted.');
            }
		$t_name = $_POST['taxonomy'];
    }
    if(isset($_GET['field']) || isset($_POST['field_id']))
    {
        $frow = isset($_GET['field']) ? getFieldrow(intval($_GET['field'])) : getFieldrow(intval($_POST['field_id'])) ;
        $t_name =   $frow->tax_name;
        $p_tname =  $frow->tax_name;
        $p_fname =  $frow->field_name;
        $p_flabel = $frow->field_label;
        $p_ftype =  $frow->field_type;
        $p_fdesc =  $frow->field_desc;
        $p_fval = $frow->field_val;
        $not_inserted = true;
    }
    if(isset($_POST['edit_field_submit']))
    {
        if(isset($_POST["field_name"]) && empty($_POST["field_name"]) )
            $xydac_error= new WP_Error('err', __("You need to give field name"));
        elseif(isset($_POST['field_name']) && $_POST['field_name'] !=$p_fname){
            $xydac_error= new WP_Error('err', __("Changing Field Name is not allowed !!!"));
        }
        else{ 
        $p_fid = $_POST['field_id'];
        $p_tname = $_POST['tax_name'];
        $p_fname = sanitize_title_with_dashes($_POST['field_name']);
        $p_flabel = (!empty($_POST['field_label'])) ? $_POST['field_label']: $_POST['field_name'];
        $p_ftype = $_POST['field_type'];
        $p_fdesc = $_POST['field_desc'];
        $p_fval = $_POST['field_val'];
		
        if($p_tname!='' && $p_fname!='' && $p_flabel!='' && $p_ftype!='')
        {    //if(updateField($p_fid,$p_tname,$p_fname,$p_flabel,$p_ftype,$p_fdesc,$p_fval)!=1) $not_inserted=true;else {$message = __('Item Updated.');$not_inserted = false;}
			updateField($p_fid,$p_tname,$p_fname,$p_flabel,$p_ftype,$p_fdesc,$p_fval);$message = __('Item Updated.');$not_inserted = false;
		}
        else
            $not_inserted = true;
        }
    }
    if(isset($_POST['add_field_submit']))
    {
        if(isset($_POST["field_name"]) && empty($_POST["field_name"]) )
            $xydac_error= new WP_Error('err', __("You need to give field name"));
		elseif(!xydac_field_avail(sanitize_title_with_dashes($_POST['field_name'])))
			$xydac_error= new WP_Error('err', __("Field name not available"));
        else{
        $t_name = $_POST['tax_name'];
        //@TODO: check empty post
        $p_tname = $_POST['tax_name'];
        $p_fname = sanitize_title_with_dashes($_POST['field_name']);
        $p_flabel = (!empty($_POST['field_label'])) ? $_POST['field_label']: $_POST['field_name'];
        $p_ftype = $_POST['field_type'];
        $p_fdesc = $_POST['field_desc'];
        $p_fval = $_POST['field_val'];
        if($p_tname!='' && $p_fname!='' && $p_flabel!='' && $p_ftype!='')
        {    $check = insertField($p_tname,$p_fname,$p_flabel,$p_ftype,$p_fdesc,$p_fval);if($check=='')$not_inserted = true; else {$message = __('Item Added.');$not_inserted = false;}}
        else
            $not_inserted = true;
        }
    }
     $rows = getFields($t_name);
    ?>
<div class="wrap" id="page_content">
    <?php xydac_heading("fields"); ?>
    <?php if(isset($xydac_error) && is_wp_error($xydac_error)) { ?>
    <div id="message" class="error below-h2"><p><?php echo $xydac_error->get_error_message(); ?></p></div>
    <?php } ?>
    <?php if(isset($message)) { ?>
    <div id="message" class="updated below-h2"><p><?php echo $message; ?></p></div>
    <?php } ?>
        <br class="clear" />
  <div id="col-container">
    <div id="col-right">
        <p>Taxonomy Name <span style="color:red;"><strong><?php _e($t_name,'xydac'); ?></strong></span>&nbsp;&nbsp;<a href="<?php echo XYDAC_FIELDS_PATH; ?>">[Select Another Taxonomy]</a></p>
      <div class="form-wrap">
          <form id="form_field_edit" action="<?php _e(XYDAC_FIELDS_PATH,'xydac'); ?>" method="post"  >
         <input type="hidden"  name="page" value="ultimate-taxonomy-manager"/>
            <input type="hidden"  name="sub" value="custom-taxonomy-fields"/>
            <input type="hidden"  name="taxonomy" value="<?php _e($t_name,'xydac'); ?>"/>
			
          <div class="tablenav">
            <select name="action">
              <option value=""><?php _e('Bulk Actions','xydac'); ?></option>
              <option value="delete"><?php _e('Delete','xydac'); ?></option>
            </select>
            <input type="submit" class="button-secondary action"  id="doaction_submit" name="doaction_submit" value="Apply"/>
          </div><br class="clear">
          <table class="widefat tag fixed" cellspacing="0">
            <thead class="content-types-list">
              <tr>
                <th style="" class="manage-column column-cb check-column" id="cb" scope="col"><input type="checkbox"></th>
                <th style="" class="manage-column column-name" id="name" scope="col"><?php _e('Name','xydac'); ?></th>
                <th style="" class="manage-column column-fields" id="fields" scope="col"><?php _e('Label','xydac'); ?></th>
                <th style="" class="manage-column column-categories" id="categories" scope="col"><?php _e('Type','xydac'); ?></th>
              </tr>
            </thead>
            <tbody id="the-list">
            <?php
            //field_id,field_name,field_label,field_type
            foreach ($rows as $row) {?>
            <tr id="content-type-<?php _e($row->field_id,'xydac'); ?>" class="">
                <th class="check-column" scope="row">
                  <input type="checkbox" value="<?php _e($row->field_id,'xydac'); ?>" name="delete_content_type[]"/>
                </th>
                <td class="name column-name">
                  <strong>
                      <a class="row-title" title="Edit &ldquo;<?php _e($row->field_name,'xydac'); ?>&rdquo;" href="<?php echo XYDAC_FIELDS_PATH; ?>&manage_fields_select=<?php echo $t_name; ?>&field=<?php _e($row->field_id,'xydac'); ?>"><?php _e($row->field_name,'xydac'); ?></a></strong><br />
                </td>
                <td class="fields column-fields">
                 <?php _e($row->field_label,'xydac'); ?>
                </td>
                <td class="categories column-categories">
                    <?php _e($row->field_type,'xydac'); ?>
                </td>
            </tr>
           <?php //echo $row->field_name;
            }   ?>
            </tbody>
            <tfoot>
              <tr>
                <th style="" class="manage-column column-cb check-column"  scope="col"><input type="checkbox"></th>
                <th style="" class="manage-column column-name" scope="col"><?php _e('Name','xydac'); ?></th>
                <th style="" class="manage-column column-fields"  scope="col"><?php _e('Label','xydac'); ?></th>
                <th style="" class="manage-column column-categories"  scope="col"><?php _e('Type','xydac'); ?></th>
              </tr>
            </tfoot>
          </table>
        </form>
          <br class="clear">
          <br class="clear">
          <div class="form-wrap">
            <p><strong>Note:</strong><br>Deleting a field does not deletes the value in database</p>
            </div>
      </div>
    </div>
    <div id="col-left"><div class="col-wrap">
        <div class="form-wrap">
        <h3><?php if($not_inserted) _e('Edit Taxynomy Field','xydac'); else _e('Add a New Taxynomy Field','xydac'); ?></h3>
        <form id="form_create_field" action="<?php _e(XYDAC_FIELDS_PATH."&manage_fields_submit=true&manage_fields_select=".$t_name,'xydac'); ?>" method="post">
          <div class="form-field form-required">
            <label for="field_name"><?php _e('Field Name','xydac'); ?></label>
            <input type="text" name="field_name" class="name" <?php if($not_inserted) echo "readonly"; ?> id="field_name" value="<?php if($not_inserted) {if(isset($_POST['field_name'])) _e($p_fname,'xydac'); else if(isset($_GET['field'])) _e($p_fname,'xydac');} ?>">
            <p><?php _e('The name of the Field.','xydac'); ?></p>
          </div>
          <div class="form-field form-required">
            <label for="field_label"><?php _e('Field Label','xydac'); ?></label>
            <input type="text" name="field_label" class="name" id="field_label" value="<?php if($not_inserted) {if(isset($_POST['field_label']) ) _e($p_flabel,'xydac'); else if(isset($_GET['field'])) _e($p_flabel,'xydac');} ?>">
            <p><?php _e('The Label of the Field.','xydac'); ?></p>
          </div>
          <div class="form-field">
            <label for="field_type"><?php _e('Field Type','xydac'); ?></label>
              <select id="field_type" name="field_type" class="postform">
                  <option value="text" <?php if($p_ftype=='text') _e('Selected'); ?>>Text</option>
                  <option value="combobox" <?php if($p_ftype=='combobox') _e('Selected'); ?>>ComboBox</option>
                  <option value="image" <?php if($p_ftype=='image') _e('Selected'); ?>>Image</option>
                  <option value="textarea" <?php if($p_ftype=='textarea') _e('Selected'); ?>>Textarea</option>
              </select>
            <p><?php _e('Input type of the field.','xydac'); ?></p>
          </div>
          <div class="form-field">
            <label for="field_desc"><?php _e('Field Description','xydac'); ?></label>
            <input type="text" name="field_desc" id="field_desc" class="name" value="<?php if($not_inserted) {if(isset($_POST['field_desc']) ) _e($p_fdesc,'xydac'); else if(isset($_GET['field'])) _e($p_fdesc,'xydac');} ?>">
            <p><?php _e('Description for The Field','xydac'); ?></p>
          </div>
            <div class="form-field"><?php //@TODO:make values disabled when text is selected ?>
            <label for="field_val"><?php _e('Field Value','xydac'); ?></label>
            <input type="text" name="field_val" id="field_val" class="name" value="<?php if($not_inserted) {if(isset($_POST['field_val']) ) _e($p_fval,'xydac'); else if(isset($_GET['field'])) _e($p_fval,'xydac');} ?>">
            <p><?php _e('Enter a comma seperated values to be used for Combo-box.Provide it only for Combobox','xydac'); ?></p>
          </div>
            <input type="hidden" name="tax_name" value="<?php _e($t_name,'xydac'); ?>"/>
          <?php if(isset($_GET['field'])) { ?><input type="hidden" name="field_id" value="<?php _e($_GET['field'],'xydac'); ?>"/><?php } ?>

          <p class="submit">
            <input type="submit"  name="<?php if(isset($_GET['field'])) _e('edit_field_submit','xydac'); else _e('add_field_submit','xydac');?>" id="<?php if(isset($_GET['field'])) _e('edit_field_submit','xydac'); else _e('add_field_submit','xydac');?>" class="button-primary" value="<?php if(isset($_GET['field'])) _e('Update Custom Field','xydac'); else _e('Add Custom Field','xydac'); ?>">
          </p>
        </form>		
      </div>
    </div></div>
  </div>
</div>
	<?php }
else {
    xydac_heading("fields");
    $output = 'objects'; // or objects
    $taxonomies=get_taxonomies('',$output);
    ?>
    <div class="wrap">
        <form name='manage_fields' action='<?php _e(XYDAC_FIELDS_PATH,'xydac'); ?>' method='get' >
            <h3>Select the Taxonomy to manage </h3>
            <select name='manage_fields_select' id='manage_fields_select'  style="margin:20px;">
               <?php foreach ($taxonomies  as $taxonomy=>$e ) if($e->name!='link_category' && $e->name!='nav_menu' ){ ?>
                    <option value="<?php _e($e->name,'xydac')?>"><?php  !empty($e->label) ? _e($e->label,'xydac') : _e($e->name,'xydac'); ?></option>
               <?php } ?>
            </select>
            <input type="hidden"  name="page" value="ultimate-taxonomy-manager"/>
            <input type="hidden"  name="sub" value="custom-taxonomy-fields"/>
            <input type="submit"  name="manage_fields_submit" id="manage_fields_submit" class="button" value="Manage">
        </form>
    <br class="clear" />
        <p>The fields that you create here will be visible on the Taxonomy Page.</p><br class="clear" /><br class="clear" />
    <div id="poststuff" class="ui-sortable">
    <?php xydac_home_aboutus(); ?>
        </div>
    </div>
    <?php
}
}}
?>