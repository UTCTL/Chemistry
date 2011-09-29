<?php

class FS_FieldType
{
  public $type;
  public $label;
  public $html_class;
  
  public function __construct($type, $label, $html_class = '')
  {
    $this->type = $type;
    $this->label = $label;
    $this->html_class = $html_class;
  }
  
  // show the html the field needs
  function show_options($field)
  {
  }
  
  // fired when new field or edit field forms are submitted
  // modify $field and return
  function save_options($field, $group)
  {
    return $field;
  }
  
  // show the field in a write panel / meta box
  function show_field($post, $box, $field)
  {
  }
  
  // save the field's data when a post/page is added/updated
  function save_field($postID, $field)
  {
  }
  
}

class FS_FieldTypes
{
  public $types;
  public $hays;
  private static $instance;
  
  public function __construct()
  {
    $this->types = array();
    $this->hays = array();
  }
  
  public static function instance()
  {
    if (!self::$instance)
    {
      self::$instance = new FS_FieldTypes();
    }
    return self::$instance;
  }
    
  function register_field_type($field_type)
  {
    $type = $field_type->type;
    $this->types[$type] = $field_type;
    $this->hays[$type] = $field_type->label;
  }
  
  function get($type)
  {
    return $this->types[$type];
  }
  
  function get_types()
  {
    return $this->types;
  }
  
  function get_type_names()
  {
    return $this->hays;
  }
  
  function label($type)
  {
    return $this->hays[$type];
  }
}

?>