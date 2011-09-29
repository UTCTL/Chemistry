<?php

define('SHOW_EDIT', 1);
define('SHOW_EDIT_FIELD', 2);

class FS_GroupsPage extends FS_PageManageBase
{
  private $fs_groups;
  private $show = 0;
  
  function think()
  {
    global $fs_action;
    parent::think();
    $this->fs_groups = FS_Groups::instance();
    switch ($fs_action)
    {
      case ACT_ADD_GROUP:
        $this->add_group();
        break;
      case ACT_EDIT_GROUP:
        $this->edit_group();
        break;
      case ACT_DELETE_GROUP:
        $this->delete_group();
        break;
      case ACT_ADD_FIELD:
        $this->add_field();
        break;
      case ACT_EDIT_FIELD:
        $this->edit_field();
        break;
      case ACT_DELETE_FIELD:
        $this->delete_field();
        break;
    }
  }

  function get_title()
  {
    global $fs_action;
    switch ($fs_action)
    {
      case ACT_EDIT_GROUP:
        return 'Edit group';
        break;
      case ACT_EDIT_FIELD:
        return "Edit field";
        break;
      default:
        return 'Groups';
        break;
    }
  }

  function show_content()
  {
    switch ($this->show)
    {
      case SHOW_EDIT:
        $this->show_edit();
        break;
      case SHOW_EDIT_FIELD:
        $this->show_edit_field();
        break;
      default:
        $this->show_index();
        break;
    }
  }
  
  function add_group()
  {
    global $fs_form_method;
    if ($fs_form_method != POST) return;
    
    $group = array();
    $group['key'] = sanitize_title_with_dashes(get_post_value('key'));
    
    if ($group['key'] != '')
    {
      $group = $this->fill_group_details($group);

      if (not_array($this->fs_groups->add($group)))
      {
        do_action('fs_add_group', $group);
        $this->fs_groups->update();
        do_action('fs_added_group', $group);
        $this->add_notice(sprintf(__('"%1$s" added.', 'fields'), $group['title']));
      }
      else
      {
        $this->last_input = $this->fill_group_details($group);
        $this->add_error(sprintf(__('A group with key "%1$s" already exists', 'fields'), $group['key']));
      }
    }
    else
    {
      $this->last_input = $this->fill_group_details($this->last_input);
      $this->add_error(__('group key cannot be blank', 'fields'));
    }  
  }
  
  function fill_group_details($group)
  {
    $new_group = $group;

    $new_group['title'] = get_post_value('title');
    $new_group['description'] = get_post_value('description');
    $new_group['layout'] = get_post_value('layout');
    $new_group['order'] = get_post_value('order');
    
    return $new_group;
  }
  
  function edit_group()
  {
    global $fs_form_method;
    $item = get_request_value('item');    
    if ($item != '')
    {
      $group = $this->fs_groups->get($item);
      $group['item'] = $item;
      
      if (not_array($group))
      {
        $this->add_error(sprintf(__('Group "%1$s" not found', 'fields'), $item));
        return;
      }
      
      if ($fs_form_method == POST)
      {
        $group['key'] = sanitize_title_with_dashes(get_post_value('key'));
        // blank key
        if ($group['key'] == '')
        {
          $this->add_error(__('Group key cannot be blank', 'fields'));
          $this->last_input = $this->fill_group_details($group);
          $this->show = SHOW_EDIT;
          return;
        }
        
        // new key
        if (strcasecmp($item, $group['key']) != 0)
        {
          // A group with the new key alredy exist
          if ($this->fs_groups->get($group['key']) != false)
          {
            $this->add_error(sprintf(__('A group with key "%1$s" already exist', 'fields'), $group['key']));
            $this->last_input = $this->fill_group_details($group);
            $this->last_input['key'] = $item;
            $this->show = SHOW_EDIT;
            return;
          }
          
          // new key approved
          $group = $this->fill_group_details($group);
          $this->fs_groups->key_replace($item, $group);          
        }
        // same key
        else
        {
          $group = $this->fill_group_details($group);
          $this->fs_groups->replace($group);
        }
        
        $this->add_notice(sprintf(__('Group "%1$s" updated', 'fields'), $group['title']));
        do_action('fs_edit_group', $group);
        $this->fs_groups->update();        
        do_action('fs_edited_group', $group);
      }
      elseif ($fs_form_method == GET)
      {
        $this->last_input = $group;
        $this->show = SHOW_EDIT;
      }
    }  
  }
  
  function delete_group()
  {
    $item =  sanitize_title_with_dashes(get_get_value('item'));
    if ($item != '')
    {
      $group = $this->fs_groups->delete($item);
      if (is_array($group))
      {
        $this->fs_groups->update();
        do_action('fs_deleted_group', $group);
        $this->add_notice(sprintf(__('Group "%1$s" deleted.', 'fields'), $group['title']));
      }
      else
      {
        $this->add_error(sprintf(__('Group "%1$s" not found', 'fields'), $item));
      }
    }
  }
  
  function add_field()
  {
    global $fs_form_method;
    if ($fs_form_method != POST) return;
    $item = sanitize_title_with_dashes(get_post_value('item'));
    $group = $this->fs_groups->get($item);
    if (not_array($group))
    {
      $this->add_error(sprintf(__('Group with key "%1$s" does not exist', 'fields'), $item));
      return;
    }
    
    $group['item'] = $item;
    
    $field = array();
    $field['key'] =  sanitize_title_with_dashes(get_post_value('key'));
    if ($field['key'] != '')
    {
      $field = $this->fill_field_details($field, $group);

      $this->show = SHOW_EDIT;
      
      // field exists
      $index = $this->fs_groups->add_field($field, $group);
      if ($index == -1)
      {
        $this->last_input = $group;
        $this->add_error(sprintf(__('Field with key "%1$s" already exists in group "%2$s"', 'fields'), $field['key'], $group['title']));
        return;
      }
      
      // approved
      $this->last_input = $this->fs_groups->from_index($index);
      do_action('fs_add_field', $field);
      $this->fs_groups->update(false);
      do_action('fs_added_field', $field);
      $this->add_notice(sprintf(__('Field "%1$s" added.', 'fields'), $field['title']));
    }
  }
  
  function fill_field_details($field, $group)
  {
    $new_field = $field;

    $new_field['title'] = get_post_value('title');
    $new_field['note'] = get_post_value('note');
    $new_field['order'] = get_post_value('order');
    $new_field['type'] = get_post_value('type');
    
    foreach (FS_FieldTypes::instance()->get_types() as $field_type)
    {
      $new_field = $field_type->save_options($new_field, $group);
    }
    
    return $new_field;
  }  
  
  function edit_field()
  {
    global $fs_form_method;
    $item = sanitize_title_with_dashes(get_request_value('item'));
    if ($item != '')
    {
      $group = $this->fs_groups->get($item);
      $this->last_input = $group;
      
      // gorup not found
      if (not_array($group))
      {
        $this->add_error(sprintf(__('Group "%1$s" not found', 'fields'), $item));
        return;
      }
      
      // blank field key
      $sub_item = sanitize_title_with_dashes(get_request_value('sub_item'));
      if ($sub_item == '')
      {
        $this->add_error(__('Invalid field', 'fields'));
        $this->show = SHOW_EDIT;        
        return;
      }
      
      // field not found
      $field = $this->fs_groups->get_field_from_group($sub_item, $group);
      if (not_array($field))
      {
        $this->add_error(sprintf(__('Field with key "%1$s" not found', 'fields'), $sub_item));
        $this->show = SHOW_EDIT;
        return;
      }
      
      // approved      
      $this->last_input = $field;
      $this->last_input['group'] = $group;
      $this->last_input['item'] = $item;
      $this->last_input['sub_item'] = $sub_item;        

      if ($fs_form_method == POST)
      {
        $field = $this->fill_field_details($field, $group);
        $key = sanitize_title_with_dashes(get_post_value('key'));
        
        // blank new field key
        if ($key == '')
        {
          $this->last_input['key'] = $key;
          $this->add_error(__('Field key cannot be blank', 'fields'));
          $this->show = SHOW_EDIT_FIELD;
          return;
        }
        
        // new field key exists
        if (strcasecmp($sub_item, $key) != 0)
        {
          $index = $this->fs_groups->get_field_key_from_group($key, $group);
          if ($index > -1)
          {
            $this->last_input['key'] = $key;
            $this->add_error(sprintf(__('Field with key "%1$s" already exists in group "%2$s"', 'fields'), $key, $group['title']));
            $this->show = SHOW_EDIT_FIELD;
            return;
          }
        }
        
        // nearly all approved
        $field['key'] = $key;
        if ($this->fs_groups->replace_field($sub_item, $field, $group))
        {
          do_action('fs_edi_field', $field);
          $this->fs_groups->update(false);
          do_action('fs_edited_field', $field);
          $this->add_notice(sprintf(__('Field "%1$s" updated.', 'fields'), $field['title']));
          $this->show_header();
          $url = build_group_url($group, ACT_EDIT_GROUP);
          echo "<script type='text/javascript'>location.href = '$url';</script>";
        }
        else
        {
          $this->add_error(__('Error while updating field', 'fields'));          
        }
      }
      elseif ($fs_form_method == GET)
      {
        $this->last_input['group'] = $group;
        $this->last_input['item'] = $item;
        $this->last_input['sub_item'] = $sub_item;   
        $this->show = SHOW_EDIT_FIELD;
      }      
    }
    else
    {
      $this->add_error(__('Invalid group', 'fields'));
    }
  }
  
  function delete_field()
  {
    $item =  sanitize_title_with_dashes(get_get_value('item'));
    if ($item != '')
    {
      if ($group = $this->fs_groups->get($item))
      {
        $key = sanitize_title_with_dashes(get_get_value('sub_item'));
        
        if ($key != '')
        {
          $this->show = SHOW_EDIT;
          $findex = $this->fs_groups->delete_field($key, $group);
          $this->last_input = $group;
          if ($findex > -1)
          {
            $this->fs_groups->update(false);
            do_action('fs_deleted_field', $group['fields'][$findex]);
            $this->add_notice(sprintf(__('Field "%1$s" deleted.', 'fields'), $group['fields'][$findex]['title']));
            unset($this->last_input['fields'][$findex]);
          }
          else
          {
            $this->add_error(sprintf(__('Field with key "%1$s" not found', 'fields'), $key));
            $this->last_input = $group;
          }
        }
        else
          $this->add_error(__('Invalid field key', 'fields'));
      }
      else
      {
        $this->add_error(__('Invalid group key', 'fields'));
      }
    }  
    else
      $this->add_error(__('Invalid parameter', 'fields'));
  }
  
  // show: index
  function show_index()
  {?>
    <div id="col-container">
      <?php 
      $this->show_index_left();
      $this->show_index_right();
      ?>
    </div>
  <?php
  }
  
  function show_index_left()
  {
    include('fs-page-groups-index-left.inc');
  }
  
  function show_table_header()
  {?>
  	<tr>
    	<th><?php _e('Title', 'fields'); ?></th>
    	<th><?php _e('Fields', 'fields'); ?></th>
    	<th><?php _e('Order', 'fields'); ?></th>
    	<th><?php _e('Actions', 'fields'); ?></th>
  	</tr>
  <?php
  }
  
  // list the groups on index page
  function show_groups()
  {
    include('fs-page-groups-show-groups.inc');
  }    
  
  function get_fields_str($group)
  {
    if (is_array($group['fields']))
    {
      $arr = array();
      foreach ($group['fields'] as $field)
      {
        $link = build_field_link($group, $field);
        $arr[] = $link;
      }
      return implode(', ', $arr);
    }
    return '';
  }  
  
  //
  function show_index_right()
  {
    include('fs-page-groups-index-right.inc');
  }
  
  //
  function show_edit()
  {
    include('fs-page-groups-show-edit.inc');
  }
  
  /* show: fields */
  function show_group_fields($group)
  {?>
    <div id="col-container">
      <?php 
      $this->show_group_fields_left($group);
      $this->show_group_fields_right($group);
      ?>
    </div>
  <?php
  }
  
  function show_group_fields_left($group)
  {?>
    <div id="col-right">
    <div class="col-wrap">
    <div class="form-wrap"> 
      <h3><?php _e('Fields', 'Fields'); ?></h3>
      <table class="widefat need-pad">
      <thead>
        <?php $this->show_fields_header(); ?>
      </thead>
      <tbody>
        <?php $this->show_fields($group); ?>
      </tbody>
      <tfoot>
        <?php $this->show_fields_header(); ?>
      </tfoot>
      </table>
    </div><!-- form-warp -->
    </div><!-- col-wrap -->
    </div><!-- col-right -->
  <?php
  }
  
  function show_fields_header()
  {?>
  	<tr>
    	<th><?php _e('Title', 'fields'); ?></th>
    	<th><?php _e('Type', 'fields'); ?></th>
    	<th><?php _e('Order', 'fields'); ?></th>
    	<th><?php _e('Actions', 'fields'); ?></th>
  	</tr>
  <?php
  }
  
  function show_fields($group)
  {
    if ((is_array($group)) && (is_array($group['fields'])))
    {
      global $fs_page_url, $fs_tab, $fs_nonce;
      $url = $fs_page_url . "&tab=$fs_tab";
      foreach ($group['fields'] as $key => $field) 
      {
        $item_url = $url . "&item=" . $group['key'] . "&sub_item=" . $field['key'] . "&_wpnonce=$fs_nonce";
        $edit_url = $item_url . '&action=' . ACT_EDIT_FIELD;
        $delete_url = $item_url . '&action=' . ACT_DELETE_FIELD;
        $title = $field['title'];
        ?>
          <tr>
            <td><?php echo "<a class='title' href='$edit_url'>$title</a><span class='fs-hidden'>({$field['key']})</span>"; ?></td>
            <td><?php echo FS_FieldTypes::instance()->label($field['type']); ?></td>
            <td><?php echo $field['order']; ?></td>
            <td><a href="<?php echo $edit_url; ?>">Edit</a> | <a href="<?php echo $delete_url ?>">Delete</a></td>
          </tr>                
        <?php
      }
    }
  }  
  
  // add-field form
  function show_group_fields_right($group)
  {
    global $fs_page_url;
    ?>
    <div id="col-left">
    <div class="col-wrap">
    <div class="form-wrap">
      <h3>Add new field</h3>
      <form method="post" action=<?php echo $fs_page_url; ?>>
        <?php show_nonce(); ?>
        <input type="hidden" id="item" name="item" value="<?php echo $group['key']; ?>" />
        <input type="hidden" id="tab" name="tab" value="groups" />
    		<input type="hidden" id="action" name="action" value="<?php echo ACT_ADD_FIELD; ?>" />
    		
    		<div class="form-field form-required">
        	<label for="tag-field-key">Key</label>
        	<input type="text" aria-required="true" size="20" id="tag-field-key" name="key" />
        	<p>A field key must be unique within its group and should be in lowercase and contain only alphabet, numbers and dashes '-'.</p>
    		</div>

    		<div class="form-field form-required">
        	<label for="tag-field-title">Title</label>
        	<input type="text" aria-required="true" id="tag-field-title" name="title" />
        	<p>As displayed in your box</p>
    		</div>

    		<div class="form-field form-required">
        	<label for="tag-field-note">Note</label>
        	<input type="text" aria-required="true" id="tag-field-note" name="note" />
        	<p>Note will be shown below the field</p>
    		</div>
    		
    		<div class="form-field form-required">
        	<label for="tag-field-order">Order</label>
        	<input type="text" aria-required="true" id="tag-field-order" name="order" value="0" />
    		</div>

    		<div class="form-field form-required">
        	<label for="tag-field-type">Type</label>
        	<?php $this->show_type_select(); ?>
    		</div>

        <!-- Additional -->
        <?php
          foreach (FS_FieldTypes::instance()->get_types() as $field_type)
          {
            $field_type->show_options('');
          }
        ?> 		

    		<p class="submit"><input type="submit" value="<?php _e('Add New Field' ,'fields'); ?>" /></p>
    		
      </form>      
    </div>
    </div>
    </div>        
  <?php
  }
  
  function show_type_select($value = 'text')
  {
    global $calce_field_types;
    $script = '<script type="text/javascript">var calce_types=new Array();';
  	echo "<select aria-required='true' id='tag-field-type' name='type'>";
  	foreach (FS_FieldTypes::instance()->get_types() as $field_type)
  	{
      $key = $field_type->type;
      $title = $field_type->label;
      $class = $field_type->html_class;
      $script .= "calce_types['$key'] = '$class';";
      if ($key == $value)
       echo "<option selected value='$key'>$title</option>";
      else
       echo "<option value='$key'>$title</option>";
  	}
  	$script .= '</script>';
  	echo '</select>';
  	echo $script;
  }
  
  function show_edit_field()
  {
    include('fs-page-edit-field.inc');
  }
  
  function show_layout($value)
  {
    if (!$value)
      $value = LABEL_LEFT;
  ?>
    <div class='check-row'><input type='radio' name='layout' id='tag-group-layout' value='<?php echo LABEL_LEFT; ?>' <?php if ($value == LABEL_LEFT) echo ' checked="checked"'; ?> /><label class='input-label' for='tag-layout-left'>Two columns</label></div>
    <div class='check-row'><input type='radio' name='layout' id='tag-group-layout' value='<?php echo LABEL_TOP; ?>' <?php if ($value == LABEL_TOP) echo ' checked="checked"'; ?> /><label class='input-label' for='tag-layout-left'>One column</label></div>    
  <?php 
  }
  
}

?>