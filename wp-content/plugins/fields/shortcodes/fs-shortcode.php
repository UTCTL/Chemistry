<?php

class FS_ShortCode
{
  public $field_type;
  public function __construct($field_type = '')
  {
    $this->field_type = $field_type;
  }

  // return something good
  function run($field, $atts, $content, $code)
  {
    if ($field['slug'] == '')
      $meta = maybe_unserialize(fs_get_meta($field['key']));
    else
      $meta = maybe_unserialize(fs_get_meta_from_slug($field['key'], $field['slug'], $field['post_type'], true, $field['post_status']));
    if (is_array($meta))
      $meta = $meta['value'];
    return apply_filters('fs_shortcode', $meta);
  }
}

class FS_ShortCodes
{
  public $hays;
  private $simpleCoder;
  private static $instance;

  public function __construct()
  {
    $hays = array();
    add_shortcode('field', array($this, 'code'));
    add_shortcode('fs', array($this, 'code'));
    $this->simpleCoder = new FS_ShortCode();
  }

  public static function instance()
  {
    if (!self::$instance)
    {
      self::$instance = new FS_ShortCodes();
    }
    return self::$instance;
  }

  function add($shortcode)
  {
    $this->hays[$shortcode->field_type] = $shortcode;
  }

  function code($atts, $content=null, $code="")
  {
  	extract(shortcode_atts(array(
  		'key' => '',
  		'slug' => '',
  		'post_type' => get_post_type(),
  		'post_status' => 'publish'  		
  	), $atts));
  	  	
    if ($field = $this->get_field($key, $post_type))
    {
      $field['slug'] = $slug;
      $field['post_type'] = $post_type;
      $field['post_status'] = $post_status;
      return $this->run_code($field['type'], $field, $atts, $content, $code);
    }
  }

  function run_code($field_type, $field, $atts, $content=null, $code="")
  {
  
    $coder = $this->hays[$field_type];    
     if (is_object($coder))
    {
      return $coder->run($field, $atts, $content, $code);
    }
    else
    {
      return $this->simpleCoder->run($field, $atts, $content, $code);
    }
  }

  function get_field($key, $post_type = 'post')
  {
    $fs_boxes = FS_Boxes::instance();
    $groups = $fs_boxes->get_groups_for_types($post_type);    
    foreach ($groups as $group)
    {
      if (is_array($group['fields']))
        foreach ($group['fields'] as $field)
        {
          if (strcasecmp($key, $field['key']) == 0)
            return $field;
        }
    }
    return false;
  }

}

function fs_add_shortcode($coder)
{
  FS_ShortCodes::instance()->add($coder);
}

add_shortcode('field_count', 'field_count');
add_shortcode('fs_count', 'field_count');

function field_count($atts) {
	extract(shortcode_atts(array(
		'key' => '',
		'slug' => '',
		'post_type' => '',
		'post_status' => 'publish'  		
	), $atts));
	
	if ($key == '')
	 return '';
	 
	if ($slug != '')
	{
  	if ($post_type == '')
      $post_type = get_post_type();
	}	 
	
  if ($field['slug'] == '')
    $value = maybe_unserialize(fs_get_meta($field['key']), false);
  else
    $value = maybe_unserialize(fs_get_meta_from_slug($key, $slug, $post_type, false, $post_status));
  if (is_array($value))
    return sizeof($value);
  else
    return 1;
}

?>