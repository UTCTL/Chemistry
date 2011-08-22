<?php

class FS_CheckboxShortCode extends FS_ShortCode
{

  public function __construct()
  {
    parent::__construct('check');
  }
  
  function run($field, $atts, $content, $code)
  {    
  	extract(shortcode_atts(array(
  		'key' => '',
  		'single' => 'yes',
  		'separator' => ', ',
  		'first_separator' => '',
  		'last_separator' => '',
  		'before' => '',
  		'after' => '',
  		'before_item' => '',
  		'after_item' => '',
  		'slug' => '',
  		'post_type' => '',
  		'post_status' => 'publish'  		
  	), $atts));
  	
  	if ($slug != '')
  	{
    	if ($post_type == '')
        $post_type = get_post_type();
      $meta = fs_get_meta_from_slug($field['key'], $slug, $post_type, false, $post_status);
	  }
	  else
	  {  	
      $meta = fs_get_meta($field['key'], false);
    }
    
    if ($meta == '') return '';
    $index = 0;
    $count = sizeof($meta);
    $str = '';
    
    // build from order
    $values = array();
    foreach ($meta as $v)
    {
      $v = maybe_unserialize($v);        
      if (is_array($v))
        $values[] = $v;
      else
      {
        $arr = array('order' => 0, 'value' => $v);
        $values[] = $arr;
      }
    }
    sort_by_order(&$values);      
    
    if ($before != '')
      $str = $before;
            
    foreach ($values as $item)
    {
      $item = $item['value'];
      if ($before_item != '')
        $str .= $before_item;
      $str .= $item;
      if ($after_item != '')
        $str .= $after_item;
        
      if ($index != $count - 1)
      {
        if ($index == 0)
        {
          if ($first_separator != '')
            $str .= $first_separator;
          else
            $str .= $separator;
        }
        elseif ($index == $count - 2)
        {
          if ($last_separator != '')
          {
            $str .= $last_separator;
          }
          else
            $str .= $separator;
        }
        else
          $str .= $separator;
      }
      
      if ($after != '')
        $str .= $after;
      $index++;
    }
    
    return $str;   
  }
  
}

?>