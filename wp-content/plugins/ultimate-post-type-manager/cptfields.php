<?php

if ( !function_exists( 'update_active_field_type' ) ) { function update_active_field_type(){
$xydac_active_field_types = get_option('xydac_active_field_types');
if(!is_array($xydac_active_field_types))
	$xydac_active_field_types = array();
$cpts = get_option("xydac_cpt");
if(is_array($cpts))
	foreach($cpts as $cpt)
		{
			$fields = getCptFields($cpt['name']);
			if(is_array($fields))
			foreach($fields as $field)
				{
				if(!in_array($field['field_type'],$xydac_active_field_types))
						array_push($xydac_active_field_types,$field['field_type']);
				}
		}
update_option('xydac_active_field_types',$xydac_active_field_types);
}}

/**
 * getCptFieldrow()
 * Checks if field with name $fname is availaible for use in CPT with name $tname
 * @param mixed $fname : Name of Field
 * @param mixed $tname : Name of CPT
 * @return
 */
if ( !function_exists( 'getCptFieldrow' ) ) { function getCptFieldrow($fname,$tname){
    $a = get_option('xydac_cpt_'.$tname);
	
	if(is_array($a))
		{foreach($a as $k=>$v)
			if($v['field_name']==$fname)
				{$v['cpt_name'] = $tname;return $v;}
		}
	else
		return false;//changed 0 to false
}	}
//used in index.php
/**
 * getCptFields()
 * 
 * @param mixed $name
 * @return
 */
if ( !function_exists( 'getCptFields' ) ) { function getCptFields($name) {
	return get_option('xydac_cpt_'.$name);
}
}
/**
 * xy_cmp()
 * 
 * @param mixed $a
 * @param mixed $b
 * @return
 */
if ( !function_exists( 'xy_cmp' ) ) { function xy_cmp($a, $b)
{
   
	if($a['field_order']> $b['field_order'])
		return 1;
	elseif($a['field_order']< $b['field_order'])
		return -1;
	else
		return 0;
}

}
// uses xy_cmp()
/**
 * insertCptField()
 * 
 * @param mixed $cpt_name
 * @param mixed $fname
 * @param mixed $flabel
 * @param mixed $ftype
 * @param mixed $fdesc
 * @param mixed $fval
 * @param mixed $forder
 * @return true on insertion/false if not inserted
 */
if ( !function_exists( 'insertCptField' ) ) { function insertCptField($cpt_name,$fname,$flabel,$ftype,$fdesc,$fval=NULL,$forder)
{
	//var_dump($fname	);
    $sa = array();
	$sa['field_name'] = $fname;
	$sa['field_label'] = $flabel;
	$sa['field_type'] = $ftype;
	$sa['field_desc'] = $fdesc;
	$sa['field_val'] = $fval;
	$sa['field_order'] = $forder;
	
	$getopt = get_option('xydac_cpt_'.$cpt_name);
	if(is_array($getopt))
		array_push($getopt,$sa);
	else
		{$getopt = array();array_push($getopt,$sa);}
	usort($getopt, 'xy_cmp'); 
	
	if(update_option('xydac_cpt_'.$cpt_name,$getopt))
		return true;
	else
		return false;
	
}}
/**
 * updateCptField()
 * 
 * @param mixed $cpt_name
 * @param mixed $fname
 * @param mixed $flabel
 * @param mixed $ftype
 * @param mixed $fdesc
 * @param mixed $fval
 * @param mixed $forder
 * @return -0 :error 1:-updated
 */
if ( !function_exists( 'updateCptField' ) ) { function updateCptField($cpt_name,$fname,$flabel,$ftype,$fdesc,$fval=NULL,$forder)
{
	$sa = array();
	$sa['field_name'] = $fname;
	$sa['field_label'] = $flabel;
	$sa['field_type'] = $ftype;
	$sa['field_desc'] = $fdesc;
	$sa['field_val'] = $fval;
	$sa['field_order'] = $forder;
	$xydac_cpt_fields = get_option('xydac_cpt_'.$cpt_name);
	foreach($xydac_cpt_fields as $k=>$xydac_cpt_field)
        if($xydac_cpt_field['field_name']==$sa['field_name'])
			{unset($xydac_cpt_fields[$k]);
			array_push($xydac_cpt_fields,$sa);
			usort($xydac_cpt_fields, 'xy_cmp'); 
			if(update_option('xydac_cpt_'.$cpt_name,$xydac_cpt_fields))
				return true;
			else
				return false;
			break;}
	return false;
}}
/**
 * deleteCptField()
 * 
 * @param mixed $field_name
 * @param mixed $cpt_name
 * @return
 */
if ( !function_exists( 'deleteCptField' ) ) { function deleteCptField($field_name,$cpt_name)
{
	$xydac_cpt_fields = get_option('xydac_cpt_'.$cpt_name);
	if(is_array($xydac_cpt_fields))
	foreach($xydac_cpt_fields as $k=>$xydac_cpt_field)
        if($xydac_cpt_field['field_name']==$field_name)
			{unset($xydac_cpt_fields[$k]);break;}
	usort($xydac_cpt_fields, 'xy_cmp'); 
	update_option('xydac_cpt_'.$cpt_name,$xydac_cpt_fields);
	
}}
/**
 * xydac_Cpt_field_avail()
 * 
 * @param mixed $fname
 * @param mixed $tname
 * @return
 */
if ( !function_exists( 'xydac_Cpt_field_avail' ) ) { function xydac_Cpt_field_avail($fname,$tname){

	$l_row = getCptFieldrow($fname,$tname);
	
	if(!$l_row)
		return 1;
	else 
		return 0;
}}
//main if ( !function_exists( 'xydac_setup' ) ) { function that handles everything.handlede everthing below;
/**
 * xydac_cpt()
 * 
 * @return
 */
if ( !function_exists( 'xydac_cpt' ) ) { function xydac_cpt(){
global $xydac_fieldtypes;
if((isset($_GET['manage_cpt_fields_submit']) || isset($_POST['add_cpt_field_submit']) || isset($_GET['cpt_field']) || isset($_POST['cpt_doaction_submit'])) && (isset($_GET['manage_cpt_fields_select']) || isset($_POST['cpt_name'])))
{
	
    $not_inserted= false;
     if(isset($_GET['manage_cpt_fields_select'])) 
		$t_name =$_GET['manage_cpt_fields_select'];
	 elseif (isset($_POST['cpt_name'])) 
		$t_name = $_POST['cpt_name'];

    $p_tname ="";
    $p_fname ="";
    $p_flabel="";
    $p_ftype ="";
    $p_fdesc ="";
	//deletion
    if(isset($_POST['cpt_doaction_submit']))
    {
		
        if(isset($_POST['action']) && $_POST['action']=='delete')
            if(isset($_POST['delete_content_type']))
            foreach($_POST['delete_content_type'] as $k=>$v)
            {
				
                deleteCptField($v,$_POST['cpt_name']);
                $cpt_message = __('Item Deleted.','xydac_cpt');
            }
    }
    if(isset($_GET['field']) || isset($_POST['field_name']))
    {
         if(isset($_GET['field'])) $frow = getCptFieldrow($_GET['field'],$t_name); else $frow =getCptFieldrow($_POST['field_name'],$t_name) ;
		
		if($frow){
        $t_name =   $frow['cpt_name'];
        $p_tname =  $frow['cpt_name'];
        $p_fname =  $frow['field_name'];
        $p_flabel = $frow['field_label'];
        $p_ftype =  $frow['field_type'];
        $p_fdesc =  $frow['field_desc'];
        $p_fval = $frow['field_val'];
        $p_forder = $frow['field_order'];
        $not_inserted = true;}
    }
	
    if(isset($_POST['edit_cpt_field_submit']))
    {
        if(isset($_POST["field_name"]) && empty($_POST["field_name"]) )
            $xydac_cpt_error= new WP_Error('err', __("You need to give field name",'xydac_cpt'));
        elseif(isset($_POST['field_name']) && $_POST['field_name'] !=$p_fname){
            $xydac_cpt_error= new WP_Error('err', __("Changing Field Name is not allowed !!!",'xydac_cpt'));
        }
        else{ 
        
        $p_tname = $_POST['cpt_name'];
        $p_fname = sanitize_title_with_dashes($_POST['field_name']);
        $p_flabel = (!empty($_POST['field_label'])) ? $_POST['field_label']: $_POST['field_name'];
        $p_ftype = $_POST['field_type'];
        $p_fdesc = $_POST['field_desc'];
        $p_fval = $_POST['field_val'];
		$p_forder = $_POST['field_order'];
        if($p_tname!='' && $p_fname!='' && $p_flabel!='' && $p_ftype!='')
        {    if(!updateCptField($p_tname,$p_fname,$p_flabel,$p_ftype,$p_fdesc,$p_fval,$p_forder)) $not_inserted=true;else {$cpt_message = __('Item Updated.','xydac_cpt');$not_inserted = false;}
		}
        else
            $not_inserted = true;
        }
    }
    if(isset($_POST['add_cpt_field_submit']))
    {	
        if(isset($_POST["field_name"]) && empty($_POST["field_name"]) )
            $xydac_cpt_error= new WP_Error('err', __("You need to give field name",'xydac_cpt'));
		elseif(!xydac_Cpt_field_avail(sanitize_title_with_dashes($_POST['field_name']),$t_name))
			$xydac_cpt_error= new WP_Error('err', __("Field name not available",'xydac_cpt'));
        else{
		
        $t_name = $_POST['cpt_name'];
        //@TODO: check empty post
        $p_tname = $_POST['cpt_name'];
        $p_fname = sanitize_title_with_dashes($_POST['field_name']);
        $p_flabel = (!empty($_POST['field_label'])) ? $_POST['field_label']: $_POST['field_name'];
        $p_ftype = $_POST['field_type'];
        $p_fdesc = $_POST['field_desc'];
        $p_fval = $_POST['field_val'];
		$p_forder = $_POST['field_order'];
        if($p_tname!='' && $p_fname!='' && $p_flabel!='' && $p_ftype!='')
        { if(!insertCptField($p_tname,$p_fname,$p_flabel,$p_ftype,$p_fdesc,$p_fval,$p_forder)) $not_inserted = true; else {$cpt_message = __('Item Added.','xydac_cpt');$not_inserted = false;}
		}
        else
            $not_inserted = true;
        }
    }
     $rows = getCptFields($t_name);
    ?>

<div class="wrap" id="page_content">
    <?php xydac_cpt_heading("cpt_fields"); ?>
    <?php if(isset($xydac_cpt_error) && is_wp_error($xydac_cpt_error)) { ?>
    <div id="message" class="error below-h2"><p><?php echo $xydac_cpt_error->get_error_message(); ?></p></div>
    <?php } ?>
    <?php if(isset($cpt_message)) { ?>
    <div id="message" class="updated below-h2"><p><?php echo $cpt_message; ?></p></div>
    <?php } ?>
        <br class="clear" />
  <div id="col-container">
    <div id="col-right">
        <p><?php _e('Custom Post Type Name','xydac_cpt'); ?> <span style="color:red;"><strong><?php echo $t_name; ?></strong></span>&nbsp;&nbsp;<a href="<?php echo XYDAC_CPT_FIELDS_PATH; ?>"><?php _e('[Select Another cpt]','xydac_cpt'); ?></a></p>
      <div class="form-wrap">
          <form id="form_field_edit" action="<?php echo XYDAC_CPT_FIELDS_PATH; ?>&manage_cpt_fields_submit=true&manage_cpt_fields_select=<?php echo $t_name; ?>" method="post"  >
         <input type="hidden"  name="page" value="ultimate-post-type-manager"/>
            <input type="hidden"  name="sub" value="custom-cpt-fields"/>
			<input type="hidden" value="<?php echo $t_name; ?>" name="cpt_name" />
          <div class="tablenav">
            <select name="action">
              <option value=""><?php _e('Bulk Actions','xydac_cpt'); ?></option>
              <option value="delete"><?php _e('Delete','xydac_cpt'); ?></option>
            </select>
            <input type="submit" class="button-secondary action"  id="cpt_doaction_submit" name="cpt_doaction_submit" value="Apply"/>
          </div><br class="clear">
          <table class="widefat tag fixed" cellspacing="0">
            <thead class="content-types-list">
              <tr>
                <th class="manage-column column-cb check-column" id="cb" scope="col"><input type="checkbox"></th>
                <th class="manage-column column-name" id="name" scope="col"><?php _e('Name','xydac_cpt'); ?></th>
                <th class="manage-column column-fields" id="fields" scope="col"><?php _e('Label','xydac_cpt'); ?></th>
                <th class="manage-column column-categories" id="categories" scope="col"><?php _e('Type','xydac_cpt'); ?></th>
				<th class="manage-column column-field-order" id="field-order" scope="col" width="50px"><?php _e('Order','xydac_cpt'); ?></th>
              </tr>
            </thead>
            <tbody id="the-list">
            <?php
            //field_id,field_name,field_label,field_type
			if($rows)
            foreach ($rows as $row) {?>
            <tr id="content-type-<?php echo $row['field_name']; ?>" class="">
                <th class="check-column" scope="row">
                  <input type="checkbox" value="<?php echo $row['field_name']; ?>" name="delete_content_type[]"/>
				  
                </th>
				
                <td class="name column-name">
                  <strong>
                      <a class="row-title" title="Edit &ldquo;<?php echo $row['field_name']; ?>&rdquo;" href="<?php echo XYDAC_CPT_FIELDS_PATH; ?>&manage_cpt_fields_submit=true&manage_cpt_fields_select=<?php echo $t_name; ?>&field=<?php echo $row['field_name']; ?>"><?php echo $row['field_name']; ?></a></strong><br />
                </td>
                <td class="fields column-fields">
                 <?php echo $row['field_label']; ?>
                </td>
                <td class="categories column-categories">
                    <?php echo $row['field_type']; ?>
                </td>
				<td class="categories column-categories" >
                    <?php if(!empty($row['field_order'])) echo $row['field_order']; else echo '0'; ?>
                </td>
            </tr>
           <?php //echo $row->field_name;
            }   ?>
            </tbody>
            <tfoot>
              <tr>
                <th class="manage-column column-cb check-column"  scope="col"><input type="checkbox"></th>
                <th class="manage-column column-name" scope="col"><?php _e('Name','xydac_cpt'); ?></th>
                <th class="manage-column column-fields"  scope="col"><?php _e('Label','xydac_cpt'); ?></th>
                <th class="manage-column column-categories"  scope="col"><?php _e('Type','xydac_cpt'); ?></th>
				<th class="manage-column column-field-order" id="field-order" scope="col"><?php _e('Order','xydac_cpt'); ?></th>
              </tr>
            </tfoot>
          </table>
        </form>
          <br class="clear">
          <br class="clear">
          <div class="form-wrap">
            <p><?php _e('<strong>Note:</strong><br>Deleting a field does not deletes the value in database','xydac'); ?></p><br/>
			<p><?php _e('For those who had  been using other plugin to create or use custom field for post types can switch to this plugin by using the same custom field names. The values remain the same if using the Text Input type.','xydac'); ?></p><br/>
            </div>
      </div>
    </div>
    <div id="col-left"><div class="col-wrap">
        <div class="form-wrap">
        <h3><?php if($not_inserted) _e('Edit Custom Field','xydac_cpt'); else _e('Add a New Custom Field','xydac_cpt'); ?></h3>
        <form id="form_create_field" action="<?php echo XYDAC_CPT_FIELDS_PATH."&manage_cpt_fields_submit=true&manage_cpt_fields_select=".$t_name; ?>" method="post">
          <div class="form-field form-required">
            <label for="field_name"><?php _e('Field Name','xydac_cpt'); ?></label>
            <input type="text" name="field_name" <?php if($not_inserted) echo "readonly";?> class="name" id="field_name" value="<?php if($not_inserted) {if(isset($_POST['field_name'])) echo $p_fname; else if(isset($_GET['field'])) echo $p_fname;} ?>">
            <p><?php _e('The name of the Field.','xydac_cpt'); ?></p>
          </div>
          <div class="form-field form-required">
            <label for="field_label"><?php _e('Field Label','xydac_cpt'); ?></label>
            <input type="text" name="field_label" class="name" id="field_label" value="<?php if($not_inserted) {if(isset($_POST['field_label']) ) echo $p_flabel; else if(isset($_GET['field'])) echo $p_flabel;} ?>">
            <p><?php _e('The Label of the Field.','xydac_cpt'); ?></p>
          </div>
          <div class="form-field">
            <label for="field_type"><?php _e('Field Type','xydac_cpt'); ?></label>
              <select id="field_type" name="field_type" class="postform">
			  <?php 
			  global $xydac_fields;
			  foreach($xydac_fields['fieldtypes'] as $type=>$label)
				{
					$temp = new $type('t1');
					echo $temp->option($p_ftype);
				}?>
              </select>
            <p><?php _e('Input type of the field.','xydac_cpt'); ?></p>
          </div>
          <div class="form-field">
            <label for="field_desc"><?php _e('Field Description','xydac_cpt'); ?></label>
            <input type="text" name="field_desc" id="field_desc" class="name" value="<?php if($not_inserted) {if(isset($_POST['field_desc']) ) echo $p_fdesc; else if(isset($_GET['field'])) echo $p_fdesc;} ?>">
            <p><?php _e('Description for The Field','xydac_cpt'); ?></p>
          </div>
            <div class="form-field"><?php //@TODO:make values disabled when text is selected ?>
            <label for="field_val"><?php _e('Field Value','xydac_cpt'); ?></label>
            <input type="text" name="field_val" id="field_val" class="name" value="<?php if($not_inserted) {if(isset($_POST['field_val']) ) echo $p_fval; else if(isset($_GET['field'])) echo $p_fval;} ?>">
            <p><?php _e('Enter a comma seperated values to be used for Combo-box, Checkbox, Radio Buttons.For Gallery Enter Width,height as 300px,400px','xydac_cpt'); ?></p>
          </div>
		  <div class="form-field">
            <label for="field_order"><?php _e('Field Order','xydac_cpt'); ?></label>
            <input type="text" name="field_order" id="field_order" class="name" value="<?php if($not_inserted) {if(isset($_POST['field_order']) ) echo $p_fval; else if(isset($_GET['field'])) echo $p_forder;} ?>">
            <p><?php _e('Enter 1,2,3.. order in which you want the Custom Field to appear.','xydac_cpt'); ?></p>
          </div>
            <input type="hidden" name="cpt_name" value="<?php echo $t_name; ?>"/>
          <?php if(isset($_GET['cpt_field'])) { ?><input type="hidden" name="field_name" value="<?php echo $_GET['cpt_field']; ?>"/><?php } ?>

          <p class="submit">
            <input type="submit"  name="<?php if(isset($_GET['field'])) echo 'edit_cpt_field_submit'; else echo 'add_cpt_field_submit';?>" id="<?php if(isset($_GET['field'])) echo 'edit_cpt_field_submit'; else echo 'add_cpt_field_submit';?>" class="button-primary" value="<?php if(isset($_GET['field'])) _e('Update Custom Field','xydac_cpt'); else _e('Add Custom Field','xydac_cpt'); ?>">
          </p>
        </form>		
      </div>
    </div>
</div>
  </div>
</div>
	<?php }
else {
    xydac_cpt_heading("cpt_fields");
    $output = 'objects'; // or objects
    $cpts=get_post_types('',$output);
    ?>
    <div class="wrap">
        <form name='manage_cpt_fields' action='<?php echo XYDAC_CPT_FIELDS_PATH; ?>' method='get' >
            <h3><?php _e('Select the Custom Post Type To manage ','xydac_cpt'); ?></h3>
            <select name='manage_cpt_fields_select' id='manage_cpt_fields_select'  style="margin:20px;">
               <?php foreach ($cpts  as $cpt=>$e) 
			   if($e->name!='attachment' && $e->name!='revision' && $e->name!='nav_menu_item' ){ ?>
                    <option value="<?php echo $e->name; ?>"><?php echo !empty($e->label) ?  $e->label : $e->name; ?></option>
               <?php } ?>
            </select>
            <input type="hidden"  name="page" value="ultimate-post-type-manager"/>
            <input type="hidden"  name="sub" value="custom-cpt-fields"/>
            <input type="submit"  name="manage_cpt_fields_submit" id="manage_cpt_fields_submit" class="button" value="Manage">
        </form>
    <br class="clear" />
        <p><?php _e('The fields that you create here will be visible on the Custom Post Type Page.','xydac_cpt'); ?></p><br class="clear" /><br class="clear" />
    <div id="poststuff" class="ui-sortable">
    <?php xydac_cpt_aboutus(); ?>
        </div>
    </div>
    <?php
}
}}
?>