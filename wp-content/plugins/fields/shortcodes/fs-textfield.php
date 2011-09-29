<?php

class FS_TextfieldShortCode extends FS_ShortCode
{

  public function __construct()
  {
    parent::__construct('text');
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
  		'index' => -1
  	), $atts));
  	
  	$multi = ($field['text_multi'] != '') | (strcasecmp($single, 'yes') == 0);
  	
  	if ($field['slug'] != '')
  	{
      $meta = fs_get_meta_from_slug($field['key'], $field['slug'], $field['post_type'], !$multi, $field['post_status']);
	  }
	  else
	  {  	
      $meta = fs_get_meta($field['key'], !$multi);
    }
    
    if ($meta == '') return '';
    if (is_array($meta))
    {
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
      
      return apply_filters('fs_shortcode', $str);
    }
    else
    {
      $meta = maybe_unserialize($meta);
      return is_array($meta)?apply_filters('fs_shortcode', $meta['value']):apply_filters('fs_shortcode', $meta);
    }
  }
  
}

?>