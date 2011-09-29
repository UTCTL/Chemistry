<?php

class FS_Checkbox extends FS_FieldType
{
  public function __construct()
  {
    parent::__construct('check', 'Checkbox group');
    $this->html_class = 'fs-checkbox-linked';  
  }
  
  // show the html the field needs
  function show_options($field)
  {
    // edit field form
    if (is_array($field))
    {
      echo
    		"<tr style='display: none' class='additional {$this->html_class}'>".
        '	<th valign="top" scope="row"><label for="tag-check-values">' . __('Checkbox values', 'Fields') . '</label></th>'.
        '	<td><textarea cols="50" rows="5" id="tag-check-values" name="check-values">' . $field['check_values'] . '</textarea>'.
        '  <p class="description">Comma-separated, put * infront of names to indicate checked items</p></td>'.
    		'</tr>'.
    		
        "<tr style='display: none' class='additional {$this->html_class}'>".
      	'	<th valign="top" scope="row"><label for="tag-check-width">' . __('Item width', 'Fields') . '</label></th>'.
      	"	<td><input type='text' name='check-width' id='tag-check-width' value='{$field['check_width']}'/>".
      	'<p class="description">The width of individual checkboxes. If specified, items will be arranged in columns instead of one item per row. E.g. 150px</p></td>'.
      	'</tr>'.

        "<tr style='display: none' class='additional {$this->html_class}'>".
      	'	<th valign="top" scope="row"><label for="tag-check-container-width">' . __('Container width', 'Fields') . '</label></th>'.
      	"	<td><input type='text' name='check-container-width' id='tag-check-container-width' value='{$field['check_container_width']}' />".
      	'<p class="description">The width of the checkboxes\' container, this will limit the number of items per row. E.g. 450px</p></td>'.
      	'</tr>';    		
    }
    // add field form
    else
    {
      echo
    		"<div style='display: none' class='additional {$this->html_class}'>".
    		'  <div class="form-field form-required">'.
        '  	<label for="tag-check-values">' . __('Checkbox values', 'Fields') . '</label>'.
        '  	<textarea cols="10" rows="3" id="tag-check-values" name="check-values"></textarea>'.
        '    <p>Comma-separated, put * infront of names to indicate checked items</p>'.
        '  </div>'.
    		'</div>'.
    		
    		"<div style='display: none' class='additional {$this->html_class}'>".
    		'  <div class="form-field form-required">'.
        '  	<label for="tag-check-width">' . __('Item width', 'Fields') . '</label>'.
        '  	<input type="text" name="check-width" id="tag-check-width" class="fs-short-input" />'.
        '    <p>The width of individual checkboxs. If specified, items will be arranged in columns instead of one item per row. E.g. 150px</p>'.
        '  </div>'.
    		'</div>'.
    		
    		"<div style='display: none' class='additional {$this->html_class}'>".
    		'  <div class="form-field form-required">'.
        '  	<label for="tag-check-container-width">' . __('Container width', 'Fields') . '</label>'.
        '  	<input type="text" name="check-container-width" id="tag-check-width" class="fs-short-input" />'.
        '    <p>The width of the checkboxes\' container, this will limit the number of items per row. E.g. 450px</p>'.
        '  </div>'.
    		'</div>';    		
    }  
  }
  
  // fired when new field or edit field forms are submitted
  // modify $field and return
  function save_options($field, $group)
  {
    $field['check_values'] = get_post_value('check-values');
    $field['check_width'] = get_post_value('check-width');
    $field['check_container_width'] = get_post_value('check-container-width');
    return $field;  
  }
  
  // show the field in a write panel / meta box
  function show_field($post, $box, $field)
  {
    $field['tag_name'] = META_FIELD . '[' . $field['key'] . '][]';
    
    if ($field['note'])
      $note = '<p class="description">' . $field['note'] . '</p>';
          
    $check_values = $field['check_values'];
    if ($check_values != '')
    {
      if ($field['group']['layout'] == LABEL_LEFT)
        echo "<th valign='top' scope='row'><label class='fs-check-label fs-relative'>{$field['title']}</label></th>";
      echo "<td valign='top'>";
      if ($field['group']['layout'] == LABEL_TOP)
        echo "<label class='fs-check-label fs-relative fs-one-column-label'>{$field['title']}</label>";
      $values = explode(',', $check_values);
      $meta = fs_get_meta($field['key'], false);
      $has_values = (is_array($meta) && (sizeof($meta) > 0));
      $index = 0;
      
      
      $width = $field['check_width'];
      if ($width != '')
      {
        $style = " style='float: left; width: $width;'";
        $cut = '<div class="cut"></div>';
      }

      $container_width = $field['check_container_width'];
      if ($container_width != '')
        $container_style = " style='width: $container_width;'";      
      
      if ($has_values)
      {        
        $meta_values = array();
        foreach ($meta as $m)
        {
          $m = maybe_unserialize($m);
          if (is_array($m))
            $meta_values[] = $m['value'];
          else
            $meta_values[] = $m;
        }
      }      
      
      echo "<div class='fs-columns'$container_style>";
      
      if ($has_values)
      {
        foreach ($values as $value)
        {
          $sub_id = $field['tag_id'] . '-' . $index++;
          $value = trim($value);
          if (substr($value, 0, 1) == '*')
          {
            $value = substr($value, 1);
          }
          
          if (in_array($value, $meta_values))
            $selected = ' checked="checked"';
          else
            $selected = '';
            
          echo "<div class='fs-column'$style><label class='input-label' for='$sub_id'><input type='checkbox' id='$sub_id' name='{$field['tag_name']}' value='$value'$selected />$value</label></div>";
        }
      }
      else
      {
        foreach ($values as $value)
        {
          $sub_id = $field['tag_id'] . '-' . $index++;
          $value = trim($value);
          if (substr($value, 0, 1) == '*')
          {
            $value = substr($value, 1);
            $selected = ' checked="checked"';
          }
          else
            $selected = '';
          echo "<div class='fs-column'$style><label class='input-label' for='$sub_id'><input type='checkbox' id='$sub_id' name='{$field['tag_name']}' value='$value'$selected />$value</label></div>";
        }      
      }
      echo "$cut$note</div></td>";
    }  
  }

  // save the field's data when a post/page is added/updated
  function save_field($postID, $field)
  {
    fs_delete_meta($postID, $field['key']);
    if (is_array($field['meta_value']))
      foreach ($field['meta_value'] as $v)
      {
        $value = esc_attr($v);
        fs_add_meta($postID, $field['key'], $value);
      }
  }
  
}

?>