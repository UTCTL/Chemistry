<?php

define('SHOW_EDIT', 1);

class FS_BoxesPage extends FS_PageManageBase
{
  private $fs_boxes;
  private $item;
  private $show = 0;
  private $last_input = array();
  
  function think()
  {
    global $fs_action;
    parent::think();
    $this->fs_boxes = FS_Boxes::instance();
    switch ($fs_action)
    {
      case ACT_ADD_BOX:
        $this->add_box();
        break;
      case ACT_EDIT_BOX:
        $this->edit_box();     
        break;
      case ACT_DELETE_BOX:
        $this->delete_box();
        break;
    }
  }

  function get_title()
  {
    global $fs_action;
    switch ($fs_action)
    {
      case ACT_EDIT_BOX:
        return 'Edit box';
      default:
        return 'Boxes';
    }
  }
  
  function add_box()
  {
    global $fs_form_method;
    if ($fs_form_method != POST) return;
    
    $box = array();
    $box['key'] = sanitize_title_with_dashes(get_post_value('key'));
    
    if ($box['key'] != '')
    {
      $fs_boxes = FS_Boxes::instance();      
      $box = $this->fill_box_details($box);

      if (not_array($fs_boxes->add($box)))
      {
        do_action('fs_add_box', &$box);
        $fs_boxes->update(false);
        do_action('fs_added_box', $box);
        $this->add_notice(sprintf(__('"%1$s" added.', 'fields'), $box['title']));        
      }
      else
      {
        $this->last_input = $this->fill_box_details($box);
        $this->add_error(sprintf(__('A box with key "%1$s" already exists', 'fields'), $box['key']));
      }
    }
    else
    {
      $this->last_input = $this->fill_box_details($this->last_input);
      $this->add_error(__('Box key cannot be blank', 'fields'));
    }
  }
  
  // fill in checked groups and post types
  function fill_box_details($box)
  {
    $new_box = $box;

    $new_box['title'] = get_post_value('title');
    $new_box['description'] = get_post_value('description');

    $new_box['groups'] = array();
    $new_box['post_types'] = array();
    
    $new_box['position'] = get_post_value('position');
    $new_box['include'] = get_post_value('include');
    $new_box['exclude'] = get_post_value('exclude');
    
    // included groups
    $groups = get_plain_post_value('groups');
    if (is_array($groups))
    {
      foreach ($groups as $g)
        $new_box['groups'][] = esc_attr($g);
    }
    
    // supported post types
    $post_types = get_plain_post_value('post-types');
    if (is_array($post_types))
    {
      foreach ($post_types as $g)
        $new_box['post_types'][] = esc_attr($g);
    }
    
    return $new_box;
  }
  
  function edit_box()
  {
    global $fs_form_method;
    $item = get_request_value('item');    
    if ($item != '')
    {
      $box = $this->fs_boxes->get($item);
      $box['item'] = $item;
      
      if (not_array($box))
      {
        $this->add_error(sprintf(__('Box "%1$s" not found', 'fields'), $item));
        return;
      }
      
      if ($fs_form_method == POST)
      {
        $box['key'] = sanitize_title_with_dashes(get_post_value('key'));
        
        // blank key
        if ($box['key'] == '')
        {
          $this->add_error(__('Box key cannot be blank', 'fields'));
          $this->last_input = $this->fill_box_details($box);
          $this->show = SHOW_EDIT;
          return;
        }
        
        // new key
        if (strcasecmp($item, $box['key']) != 0)
        {
          // A box with the new key alredy exist
          if ($this->fs_boxes->get($box['key']) != false)
          {
            $this->add_error(sprintf(__('A box with key "%1$s" already exist', 'fields'), $box['key']));
            $this->last_input = $this->fill_box_details($box);
            $this->last_input['key'] = $item;
            $this->show = SHOW_EDIT;
            return;
          }
          
          // new key approved
          $box = $this->fill_box_details($box);
          $this->fs_boxes->key_replace($item, $box);          
        }
        // same key
        else
        {
          $box = $this->fill_box_details($box);
          $this->fs_boxes->replace($box);
        }
        
        $this->add_notice(sprintf(__('Box "%1$s" updated.', 'fields'), $box['title']));
        do_action('fs_edit_box', $box);
        $this->fs_boxes->update(false);
        do_action('fs_edited_box', $box);
      }
      elseif ($fs_form_method == GET)
      {
        $this->last_input = $box;
        $this->show = SHOW_EDIT;
      }
    }
  }
  
  function delete_box()
  {
    $item = sanitize_title_with_dashes(get_get_value('item'));
    if ($item != '')
    {
      $box = $this->fs_boxes->delete($item);
      if (is_array($box))
      {
        $this->fs_boxes->update(false);
        do_action('fs_deleted_box', $box);
        $this->add_notice(sprintf(__('Box "%1$s" deleted.', 'fields'), $box['title']));
      }
      else
      {
        $this->add_error(sprintf(__('Box "%1$s" not found', 'fields'), $item));
      }
    }
  }
  
  function show_content()
  {
    switch ($this->show)
    {
      case SHOW_EDIT:
        $this->show_edit();
        break;        
      default:
        $this->show_index();
        break;
    }
  }
  
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
    include('fs-page-boxes-index-left.inc');
  }
  
  function show_index_right()
  {
    include('fs-page-boxes-index-right.inc');
  }
  
  function show_table_header()
  {?>
  	<tr>
    	<th><?php _e('Title', 'fields'); ?></th>
    	<th><?php _e('Groups', 'fields'); ?></th>
    	<th><?php _e('Post types', 'fields'); ?></th>
    	<th><?php _e('Actions', 'fields'); ?></th>
  	</tr>
  <?php
  }
  
    // list the boxes on index page
  function show_boxes()
  {
    include('fs-page-boxes-show-boxes.inc');
  }
  
  // a list of box positions
  function list_position($current = 'normal')
  {
    $this->show_position_input('tag-position-normal', 'normal', 'Normal', $current);
    $this->show_position_input('tag-position-advanced', 'advanced', 'Advanced', $current);
    $this->show_position_input('tag-position-side', 'side', 'Side', $current);
  }
  
  function show_position_input($id, $value, $label, $current)
  {
    if ($value === $current)
      $checked = ' checked=""';
    echo "<div class='check-row'><input type='radio' id='$id'$checked name='position' value='$value'/><label class='input-label' for='$id'>$label&nbsp;&nbsp;</label></div>";
  }
  
  // a list of groups with checkboxes
  function list_groups($arr) 
  {
    $i = 1;
    $groups = FS_Groups::instance()->hays();
    foreach ($groups as $key => $group) 
    {
      $checked = false;
      if (is_array($arr))
      foreach ($arr as $v)
        if (strcasecmp($v, $group['key']) == 0) 
        {
          $checked = true;
          break;
        }
      if ($checked)
        $checked = ' checked="checked"';
      else
        $checked = '';
      $title = $group['title'];
      echo "<div class='check-row'><input type='checkbox' name='groups[]' id='group-$i' value='{$group['key']}'$checked /><label class='input-label' for='group-$i'>$title</label></div>";
      $i++;
    }
    echo '<div class"cut"></div>';
  }
  
  // a list of post types with checkboxes
  function list_post_types($arr) {
    $args = array(
      'show_ui' => true
    );
    $post_types = get_post_types($args, 'objects');
    $i = 1;
    foreach ($post_types as $post_type) {
      $checked = false;
      if (is_array($arr))
      foreach ($arr as $v) {
        if (strcasecmp($v, $post_type->name) == 0) {
          $checked = true;
          break;
        }
      }
      if ($checked)
        $checked = ' checked="checked"';
      else
        $checked = '';
      echo "<div class='check-row'><input type='checkbox' name='post-types[]' id='post-type-$i'".
           " value='{$post_type->name}'$checked /><label class='input-label' for='post-type-$i'>".
           "{$post_type->labels->name}</label></div>";
      $i++;
    }
    echo '<div class"cut"></div>';
  }
  
  function show_edit()
  {
    include('fs-page-boxes-show-edit.inc');
  }
}

?>