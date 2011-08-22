<?php

class FS_Radio extends FS_FieldType
{
  public function __construct()
  {
    parent::__construct('radio', 'Radio group');
    $this->html_class = 'fs-radio-linked';  
  }
  
  // show the html the field needs
  function show_options($field)
  {
    // edit field form
    if (is_array($field))
    {
      echo
    		"<tr style='display: none' class='additional {$this->html_class}'>".
        '	<th valign="top" scope="row"><label for="tag-radio-values">' . __('Radio values', 'Fields') . '</label></th>'.
        '	<td><textarea cols="50" rows="5" id="tag-radio-values" name="radio-values">' . $field['radio_values'] . '</textarea>'.
        '  <p class="description">' . __('Comma-separated, put * infront of item name to indicate the default item<', 'Fields') . '/p></td>'.
    		'</tr>'.

        "<tr style='display: none' class='additional {$this->html_class}'>".
      	'	<th valign="top" scope="row"><label for="tag-radio-width">' . __('Item width', 'Fields') . '</label></th>'.
      	"	<td><input type='text' name='radio-width' id='tag-radio-width' value='{$field['radio_width']}' />".
      	'<p class="description">' . __('The width of individual radio item. If specified, items will be arranged in columns instead of one item per row. E.g. 150px', 'Fields') . '</p></td>'.
      	'</tr>'.

        "<tr style='display: none' class='additional {$this->html_class}'>".
      	'	<th valign="top" scope="row"><label for="tag-radio-container-width">' . __('Container width', 'Fields') . '</label></th>'.
      	"	<td><input type='text' name='radio-container-width' id='tag-radio-container-width' value='{$field['radio_container_width']}' />".
      	'<p class="description">' . __('The width of the radio items\' container, this will limit the number of items per row. E.g. 450px', 'Fields') . '</p></td>'.
      	'</tr>';
    }
    // add field form
    else
    {
      echo
    		"<div style='display: none' class='additional {$this->html_class}'>".
    		'  <div class="form-field form-required">'.
        '  	<label for="tag-radio-values">' . __('Radio values', 'Fields') . '</label>'.
        '  	<textarea cols="10" rows="3" id="tag-radio-values" name="radio-values"></textarea>'.
        '    <p>' . __('Comma-separated, put * infront of item name to indicate the default item', 'Fields') . '</p>'.
        '  </div>'.
    		'</div>'.

    		"<div style='display: none' class='additional {$this->html_class}'>".
    		'  <div class="form-field form-required">'.
        '  	<label for="tag-radio-width">' . __('Item width', 'Fields') . '</label>'.
        '  	<input type="text" name="radio-width" id="tag-radio-width" class="fs-short-input" />'.
        '    <p>' . __('The width of individual radio item. If specified, items will be arranged in columns instead of one item per row. E.g. 150px', 'Fields') . '</p>'.
        '  </div>'.
    		'</div>'.
    		
    		"<div style='display: none' class='additional {$this->html_class}'>".
    		'  <div class="form-field form-required">'.
        '  	<label for="tag-radio-container-width">' . __('Container width', 'Fields') . '</label>'.
        '  	<input type="text" name="radio-container-width" id="tag-radio-width" class="fs-short-input" />'.
        '    <p>' . __('The width of the radio items\' container, this will limit the number of items per row. E.g. 450px', 'Fields') . '</p>'.
        '  </div>'.
    		'</div>';    		
    		
    } 
  }
  
  // fired when new field or edit field forms are submitted
  // modify $field and return
  function save_options($field, $group)
  {
    $field['radio_values'] = get_post_value('radio-values');
    $field['radio_width'] = get_post_value('radio-width');
    $field['radio_container_width'] = get_post_value('radio-container-width');
    return $field;  
  }
  
  // show the field in a write panel / meta box
  function show_field($post, $box, $field)
  {
    $radio_values = $field['radio_values'];
    if ($radio_values != '')
    {
      if ($field['group']['layout'] == LABEL_LEFT)
        echo "<th valign='top' scope='row'><label class='fs-radio-label fs-relative'>{$field['title']}</label></th>";
      echo "<td valign='top'>";
      if ($field['group']['layout'] == LABEL_TOP)
        echo "<label class='fs-radio-label fs-relative fs-one-column-label'>{$field['title']}</label>";

      $values = explode(',', $radio_values);
      $meta = maybe_unserialize(fs_get_meta($field['key']));
      if (is_array($meta))
        $meta = $meta['value'];
      $selected_index = -1;
      $index = 0;
      
      foreach ($values as $key => $value)
      {
        $value = trim($value);
        if (substr($value, 0, 1) == '*')
        {
          $value = substr($value, 1);
          $values[$key] = $value;
          if ($selected_index == -1)
            $selected_index = $index;
        }
        
        if ($meta == $value)
        {
          $selected_index = $index;
        }        
        
        $index++;        
      }
      
      $width = $field['radio_width'];
      if ($width != '')
      {
        $style = " style='float: left; width: $width;'";
        $cut = '<div class="cut"></div>';
      }

      $container_width = $field['radio_container_width'];
      if ($container_width != '')
        $container_style = " style='width: $container_width;'";
      
      echo "<div class='fs-columns'$container_style>";
      $index = 0;
      foreach ($values as $value)
      {
        $sub_id = $field['tag_id'] . '-' . $i++;
        $value = trim($value);
        if ($index++ == $selected_index)
          $selected = ' checked';
        else
          $selected = '';
        echo "<div class='fs-column'$style><label class='input-label' for='$sub_id'><input type='radio' id='$sub_id' name='{$field['tag_name']}' value='$value'$selected />$value</label></div>";
      }
      echo "$cut</div></td>";
    }  
  }

  // save the field's data when a post/page is added/updated
  function save_field($postID, $field)
  {
    fs_delete_meta($postID, $field['key']);
    $value = esc_attr($field['meta_value']);
    fs_update_meta($postID, $field['key'], $value);
  }
  
}

?>