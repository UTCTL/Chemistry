<?php

class FS_Groups extends FS_Base
{
  private static $instance;
  
  public function __construct($option_name)
  {
    return parent::__construct($option_name);
  }
  
  public static function instance()
  {
    if (!self::$instance)
    {      
      self::$instance = new FS_Groups(OPTION_GROUPS);
    }
    return self::$instance;
  }
  
  function get_field_from_group($key, $group)
  {
    if ((is_array($group)) && (is_array($group['fields'])))
    {
      foreach($group['fields'] as $field)
      {
        if (strcasecmp($field['key'], $key) == 0)
          return $field;
      }
    }
    return false;
  }

  function get_field_key_from_group($key, $group)
  {
    if ((is_array($group)) && (is_array($group['fields'])))
    {
      foreach($group['fields'] as $k => $field)
      {
        if (strcasecmp($field['key'], $key) == 0)
          return $k;
      }
    }
    return -1;
  }
  
  function is_field_in_group($field, $group)
  {
    if ((is_array($group)) && (is_array($group['fields'])))
    {
      foreach($group['fields'] as $gield)
      {
        if (strcasecmp($gield['key'], $field['key']) == 0)
          return true;
      }
    }
    return false;
  }
  
  function get_field($key, $group_key = '')
  {
    if ($group_key != '')
    {
      if ($group = $this->get($group_key))
      {
        return $this->get_field_from_group($key, $group);
      }
    }
    else
    {
      foreach ($this->hays as $hay)
      {
        if ($field = $this->get_field_from_group($key, $hay))
          return $field;
      }
    }
    return false;
  }
  
  function field_in_group($key)
  {
    foreach ($this->hays as $hay)
    {
      if ($field = $this->get_field_from_group($key, $hay))
        return $hay;
    }
  }
  
  function get_field_key($key, $group_key = '')
  {
    if ($group_key != '')
    {
      if ($group = $this->get($group_key))
      {
        return $this->get_field_key_from_group($key, $group);
      }
    }
    else
    {
      foreach ($hays as $hay)
      {
        $k = $this->get_field_key_from_group($key, $hay);
        if ($k > -1)
          return $k;
      }
    }
    return -1;
  }
  
  /*
   * >-1: successful
   * -1: field exists
   */
  function add_field($field, $group)
  {
    if (!$this->is_field_in_group($field, $group))
    {
      $index = $this->get_index($group['key']);
      $this->hays[$index]['fields'][] = $field;
      sort_by_order(&$this->hays[$index]['fields']);
      return $index;
    }
    return -1;
  }
  
  function replace_field($key, $field, $group)
  {
    $index = $this->get_field_key_from_group($key, $group);
    $gindex = $this->get_index($group['key']);
    if (($gindex !== -1) && ($index !== -1))
    {
      $this->hays[$gindex]['fields'][$index] = $field;
      sort_by_order(&$this->hays[$gindex]['fields']);
      return true;
    }
    return false;
  }
  
  function delete_field($field_key, $group)
  {
    if (is_array($group) && is_array($group['fields']))
    {
      $gindex = $this->get_index($group['key']);
      if ($gindex != -1)
        foreach ($group['fields'] as $findex => $field)
        {
          if (strcasecmp($field['key'], $field_key) == 0)
          {
            unset($this->hays[$gindex]['fields'][$findex]);
            return $findex;
          }
        }
    }
    return -1;
  }
  
  function create_dummy()
  {
    $first_field = array('key' => 'first-key', 'title' => 'First field', 'type' => 'text', 'note' => "simply put [field key='first_field'] into your post content and publish or update to show this field's value!");
    $second_field = array('key' => 'second-key', 'title' => 'Second field', 'type' => 'text', 'note' => 'a note for this field');
    
    $first_group = array('key' => 'first-group', 'title' => 'Your first group', 'description' => 'This is your first group, is is included in your first box. Start adding more fields into this group!', 'order' => 0, 'fields' => array(0 => $first_field));
    
    $second_group = array('key' => 'second-group', 'title' => 'Your second group', 'description' => 'This is your second group, is is included in your first box. This group will appear as a tab in your box', 'order' => 1, 'fields' => array(0 => $second_field));
    
    $this->hays = array(0 => $first_group, 1 => $second_group);
    $this->update();
  }  
}

?>