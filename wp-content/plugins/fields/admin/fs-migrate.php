<?php

class FS_Migrate
{

  /*
  * Import functions
  */
  function import($s, $page = false)
  {
    $hays = $this->parse($s);
    if ($hays)
    {
      $fs_boxes = FS_Boxes::instance();
      $fs_groups = FS_Groups::instance();    
      $box_count = 0;
      $group_count = 0;
      foreach ($hays['boxes'] as $box)
      {
        $fs_boxes->override($box);
        $box_count++;
      }

      foreach ($hays['groups'] as $group)
      {
        $fs_groups->override($group);
        $group_count++;
      }
      
      $fs_boxes->update();
      $fs_groups->update();

      // eww
      if (is_a($page, 'FS_Page'))
      {
        $page->add_notice(sprintf(__('%1$d boxes and %2$d groups imported.', 'fields'), $box_count, $group_count));
      }
    }
  }
  
  function preview($s)
  {
    $preview = array();

    $hays = $this->parse($s);
    if ($hays)
    {
      $fs_boxes = FS_Boxes::instance();
      $fs_groups = FS_Groups::instance();

      foreach ($hays['boxes'] as $box)
      {
        $entry = array();
        if ($fs_boxes->get($box['key']))
          $entry['action'] = __('Override', 'Fields');
        else
          $entry['action'] = __('Add New', 'Fields');
        $entry['key'] = $box['key'];
        $entry['title'] = $box['title'];
        $entry['groups'] = is_array($box['groups'])?implode(', ', $box['groups']):'';
        $entry['post_types'] = is_array($box['post_types'])?implode(', ', $box['post_types']):'';
        $preview['boxes'][] = $entry;
      }

      foreach ($hays['groups'] as $group)
      {
        $entry = array();
        if ($fs_groups->get($group['key']))
          $entry['action'] = __('Override', 'Fields');
        else
          $entry['action'] = __('Add New', 'Fields');
        $entry['key'] = $group['key'];
        $entry['title'] = $group['title'];
        $entry['order'] = $group['order'];        
        $entry['fields'] = $this->build_fields_str($group['fields']);
        $preview['groups'][] = $entry;
      }

      return $preview; 
    }
    else
      return false;
  }
  
  function build_fields_str($fields)
  {
    $s = array();
    if (is_array($fields))
    {
      foreach ($fields as $field)
      {
        $s[] = $field['key'];
      }
    }
    return implode(', ', $s);
  }
  
  function parse($s)
  {
    libxml_use_internal_errors(true);
    $xml = simplexml_load_string($s, NULL, LIBXML_ERR_NONE);
    
    if ($xml === false)
    {
      /*$errors = array();
      foreach(libxml_get_errors() as $error) {
        $errors[] = $error->message;
      }*/
      return false;
    }    
    else
    {
      $hays = array();
      $hays['boxes'] = $this->boxes_from_xml($xml->boxes->children());
      $hays['groups'] = $this->groups_from_xml($xml->groups->children());
      return $hays;
    }
  }
  
  // import boxes
  function boxes_from_xml($boxes)
  {
    $hay = array();
    
    if (fs_count($boxes) > 0)
    {
      foreach ($boxes as $box)
        $hay[] = $this->box_from_xml($box);
    }
    
    return $hay;
  }
  
  function box_from_xml($box)
  {
    $key = sanitize_title_with_dashes((string)$box->key);
    if (empty($key))
      return false;
    $hay = array();
    $hay['key'] = $key;
    $hay['title'] = (string)$box->title;
    $hay['position'] = (string)$box->position;
    $hay['description'] = (string)$box->description;
    $hay['groups'] = $this->box_groups_from_xml($box->groups->children());
    $hay['post_types'] = $this->box_post_types_from_xml($box->post_types->children());
    
    return $hay;
  }
  
  function box_groups_from_xml($groups)
  {
    $hay = array();
    
    if (fs_count($groups) > 0)
    {
      foreach ($groups as $group)
      {
        $hay[] = (string)$group;
      }
    }
    
    return $hay;
  }
  
  function box_post_types_from_xml($post_types)
  {
    $hay = array();
    
    if (fs_count($post_types) > 0)
    {
      foreach ($post_types as $post_type)
      {
        $hay[] = (string)$post_type;
      }
    }
    
    return $hay;
  }
  
  function groups_from_xml($groups)
  {
    $hay = array();
    
    if (fs_count($groups) > 0)
    {
      foreach ($groups as $group)
      {
        $hay[] = $this->group_from_xml($group);
      }
    }
    
    return $hay;
  }
  
  function group_from_xml($group)
  {
    $key = sanitize_title_with_dashes(((string)$group->key));
    if (empty($key))
      return false;
      
    $hay = array();
    $hay['key'] = $key;
    $hay['title'] = (string)$group->title;
    $hay['description'] = (string)$group->description;
    $hay['order'] = (int)$group->order;
    $hay['fields'] = $this->fields_from_xml($group->fields->children());
    
    return $hay;
  }
  
  function fields_from_xml($fields)
  {
    $hay = array();
    
    if (fs_count($fields) > 0)
    {
      foreach ($fields as $field)
      {
        $hay[] = $this->field_from_xml($field);
      }
    }
    
    return $hay;
  }
  
  function field_from_xml($field)
  {
    if (empty($field->key))
      return false;
    
    $hay = array();
    if (fs_count($field) > 0)
    {
      foreach ($field as $attr)
      {
        $hay[$attr->getName()] = (string)$attr;
      }
    }
    
    return $hay;
  }
  
  /*
  * Export functions
  */  
  function export($boxes, $groups)
  {
    return $this->to_xml($boxes, $groups);
  }
  
  function to_xml($boxes, $groups)
  {
    $xml = '<?xml version="1.0" encoding="utf-8"?><document>';
    $xml .= $this->xml_boxes($boxes) . $this->xml_groups($groups);
    return str_replace('&', '&amp;', $xml . '</document>');
  }
  
  function xml_boxes($boxes)
  {
    $s = '<boxes>';
    foreach ($boxes as $box)
    {
      $s .= $this->xml_box($box);
    }
    return $s . '</boxes>';
  }
  
  function xml_box($box)
  {
    $s = "<box>" .
         "<key>{$box['key']}</key>" .
         "<title>{$box['title']}</title>" .
         "<description>{$box['description']}</description>" .
         "<position>{$box['position']}</position>";
    $s .= $this->xml_box_groups($box['groups']) .
          $this->xml_box_post_types($box['post_types']) . '</box>';
    return $s;
  }
  
  function xml_box_groups($groups)
  {
    $s = '<groups>';
    if (is_array($groups))
    {
      foreach ($groups as $group)
      {
        $s .= "<group>$group</group>";
      }
    }
    return $s . '</groups>';
  }
  
  function xml_box_post_types($post_types)
  {
    $s = '<post_types>';
    if (is_array($post_types))
    {
      foreach ($post_types as $post_type)
      {
        $s .= "<post_type>$post_type</post_type>";
      }
    }
    return $s . '</post_types>';
  }
  
  function xml_groups($groups)
  {
    $s = '<groups>';
    foreach ($groups as $group)
    {
      $s .= $this->xml_group($group);
    }
    return $s . '</groups>';
  }
  
  function xml_group($group)
  {
    $s = "<group>" .
         "<key>{$group['key']}</key>" .
         "<title>{$group['title']}</title>" .
         "<order>{$group['order']}</order>" .
         "<layout>{$group['layout']}</layout>" .
         "<description>{$group['description']}</description>";
         
    $s .= $this->xml_fields($group['fields']);
    
    return $s . '</group>';
  }
  
  function xml_fields($fields)
  {
    $s = '<fields>';
    if (is_array($fields))
    {
      foreach ($fields as $field)
      {
        $s .= $this->xml_field($field);
      }
    }
    
    return $s . '</fields>';
  }
  
  function xml_field($field)
  {
    $s = '<field>';
    foreach ($field as $key => $value)
    {
      $s .= "<$key>" . esc_attr($value) . "</$key>";
    }
    
    return $s . '</field>';
  }
  
}

?>