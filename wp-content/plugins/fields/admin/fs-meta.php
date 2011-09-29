<?php

class FS_Meta
{
  private $fs_boxes;
  private $fs_groups;
  
  public function __construct()
  {
    $this->fs_boxes = FS_Boxes::instance();
    $this->fs_groups = FS_Groups::instance();
    
    $this->build();
    add_action('save_post', array($this, 'save'), 11, 2);
    //add_action('save_page', array($this, 'save'), 11, 2);
  }
  
  function build()
  {
    $postID = $_GET['post'] ? $_GET['post'] : $_POST['post_ID'];
    $post = get_post($postID);
    if (is_object($post))
    {
      // editing post
      foreach ($this->fs_boxes->hays() as $key => $box)
      {
        $show_box = false;
        
        // supported post types, check for exclusion
        if ((is_array($box['post_types'])) && (in_array($post->post_type, $box['post_types'])))
        {
          $exc = explode(',', str_replace(' ', '', $box['exclude']));
          $show_box = !in_array($post->ID, $exc);
        }
        // not supported, check for inclusion
        else
        {
          $inc = explode(',', str_replace(' ', '', $box['include']));
          $show_box = in_array($post->ID, $inc);
        }

        if ($show_box)
        {
          $box['tag_id'] = 'fs-box-' . $box['key'];
          if (empty($box['position']))
            $box['position'] = 'normal';            
          $c = add_meta_box($box['tag_id'], $box['title'], array($this, 'build_box'), $post->post_type, $box['position'], 'high', 
            array(
              'box' => $box,
              'boxes' => $this->fs_boxes->hays(),
              'groups' => $this->fs_groups->hays()
            ));
          
        }
      }
    }
    else
    {
      // new post
      foreach ($this->fs_boxes->hays() as $key => $box)
      {
        $post_types = $box['post_types'];
        if (is_array($post_types))
        {
          foreach ($post_types as $k => $post_type)
          {
            $box['tag_id'] = 'fs-box-' . $box['key'];
            if (empty($box['position']))
              $box['position'] = 'normal';            
            add_meta_box($box['tag_id'], $box['title'], array($this, 'build_box'), $post_type, $box['position'], 'high', 
              array(
                'box' => $box,
                'boxes' => $this->fs_boxes->hays(),
                'groups' => $this->fs_groups->hays()
              ));
          }
        }
      }
    }
  }
  
  function build_box($post, $metabox)
  {
    $boxes = $metabox['args']['boxes'];
    $groups = $metabox['args']['groups'];
    $box = $metabox['args']['box'];
    
    $g = $box['groups'];    
    $box_groups = $this->get_groups($box, $groups);
    $single_group = sizeof($box_groups) == 1;
    do_action('fs_show_box', $box, $box_groups);
    if ((sizeof($box_groups) > 0) && (is_array($g)) && (sizeof($g) > 0))
    {
      echo "<div class='categorydiv fs-box' id='{$box['tag_id']}'>";
      
      if (!$single_group)
      {
        $this->build_tabs($post, $box, $box_groups);
        foreach ($box_groups as $group)
        {
          $this->build_group($post, $box, $group);
        }      
      }
      else
      {
        list($key, $group) = each($box_groups);
        $this->build_group($post, $box, $group, true);
      }
 
      echo '<div class="cut"></div></div>';
    }
    else
    {
      echo '<p>' . __('No group included', 'Fields') . '</p>';
    }
    do_action('fs_showed_box', $box, $box_groups);
  }
  
  // get a list of groups that belong to a box
  function get_groups($box)
  {
    $arr = array();
    foreach ($box['groups'] as $group_key)
    {
      $group = $this->fs_groups->get($group_key);
      if (is_array($group))
      {
        $group['tag_id'] = $box['tag_id'] . '-' . $group['key'];
        $arr[] = $group;
      }
    }
    sort_by_order(&$arr);
    return $arr;
  }
  
  function build_tabs($post, $box, $box_groups) 
  {
    echo '<ul class="category-tabs">';
    $i = 0;  
    foreach ($box_groups as $group)
    {      
      $tab_id = $group['tag_id'] . '-tab';
      $title = $group['title'];
      if ($i++ == 0)
        $class = "tabs group-tab";
      else
        $class = "hide-if-no-js group-tab";
      echo "<li class='" . $class . "' id='$tab_id'><a tabindex='3' href='#{$group['tag_id']}'>$title</a></li>";
    }
    $custom_tabs = '';
    echo apply_filters('fs_show_tabs', $custom_tabs, $post, $box, $box_groups) . '</ul>';
  }
  
  function build_group($post, $box, $group, $single = false)
  {
    do_action('fs_show_group', $post, $box, $group, $single);
    if ($single) 
    {
      $style = ' style="margin: 0; padding: 0; border: none;"';      
    }
    
    if ($group['layout'] == LABEL_TOP)
    {
      $more = ' fs-one-column';
    }
    
    echo "<div$style class='tabs-panel$more' id='{$group['tag_id']}'>\n" .
         "<table><tbody>";
    if (is_array($group['fields']))
    {
      foreach ($group['fields'] as $field)
      {
        unset($group['fields']);
        $field['group'] = $group;
        $this->build_field($post, $box, $field);
      }
    }
    echo "</tbody></table></div>";
    do_action('fs_shown_group', $post, $box, $group, $single);
  }
  
  function build_field($post, $box, $field)
  {
    $field['tag_id'] = 'tag-' . $box['tag_id'] . '-' . $field['key'];
    $field['tag_name'] = META_FIELD . '[' . $field['key'] . ']';
    $meta_value = fs_get_meta($field['key']);
    if (is_array($meta_value))
      $field['meta_value'] = $meta_value['value'];
    else
      $field['meta_value'] = $meta_value;
    
    $field['title'] = $field['title'];
    do_action('fs_show_field', $post, $box, $field);
    echo '<tr class="fs-field">';
    $field_type = FS_FieldTypes::instance()->get($field['type']);    
    if (is_object($field_type))
      $field_type->show_field($post, $box, $field);
    else
      echo '<th><label></label></th><td>' . __('Field builder missing', 'Fields') . '</td>';
    echo '</tr>';
    do_action('fs_showed_field', $post, $box, $field);
  }
  
  /* Save */
  function save($postID, $post)
  {
    $_REQUEST = array_map('stripslashes_deep', $_REQUEST); 
    $_GET = array_map('stripslashes_deep', $_GET);
    $_POST = array_map('stripslashes_deep', $_POST); 
    $_COOKIE = array_map('stripslashes_deep', $_COOKIE); 
  
    global $fs_save_flag;
    if ($post->post_type == 'revision') return $postID;
    if (@constant( 'DOING_AUTOSAVE')) return $postID;
		if (!$_POST) return $postID;
		if (!in_array($_POST['action'], array('editpost', 'post'))) return $postID;

		$post_id = esc_attr($_POST['post_ID']);
		if (!$post_id) $post_id = $new_post_id;
		if (!$post_id) return $postID;
		
		if (!current_user_can('edit_post', $postID))
		  return $postID;
		
		if ( $p = wp_is_post_revision($postID)) $postID = $p;  
    $fields = $this->filter_valid_fields($post_type);
    do_action('fs_save_fields', $postID, $fields);
    if (is_array($fields))
    {
      foreach ($fields as $field)
      {
        $this->save_field($postID, $field);
      }
    }
    do_action('fs_saved_fields', $postID, $fields);
    // backward compa
    do_action('fs_meta_save', $postID, $fields);
  }
    
  function filter_valid_fields($post_type)
  {
    $boxes = FS_Boxes::instance()->hays();
    $fs_groups = FS_Groups::instance();
    $inputs = $_POST[META_FIELD];
    $fields = array();
    foreach ($boxes as $box)
    {
      if (is_array($box['groups']))
      {
        foreach ($box['groups'] as $group_key)
        {
          $group = $fs_groups->get($group_key);
          if (is_array($group['fields']))
          {
            foreach ($group['fields'] as $field)
            {
              //if (isset($inputs[$field['key']]))
              //{
                $field['meta_value'] = $inputs[$field['key']];
                $fields[] = $field;
              //}
            }
          }
        }
      }
    }
    return $fields;
  }  
  
  function save_field($postID, $field)
  {
    do_action('fs_save_field', $postID, $field);
    $field_type = FS_FieldTypes::instance()->get($field['type']);
    if (is_object($field_type))
      $field_type->save_field($postID, $field);
    do_action('fs_saved_field', $postID, $field);
  }  
}

?>