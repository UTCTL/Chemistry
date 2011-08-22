<?php

class FS_Select extends FS_FieldType
{
  public function __construct()
  {
    parent::__construct('select', 'Drop box');
    $this->html_class = 'fs-select-linked';  
  }
  
  // show the html the field needs
  function show_options($field)
  {
    // edit field form
    if (is_array($field))
    {
      echo
    		"<tr style='display: none' class='additional {$this->html_class}'>".
        '	<th valign="top" scope="row"><label for="tag-select-values">' . __('Drop box values', 'Fields') . '</label></th>'.
        '	<td><textarea cols="50" rows="5" id="tag-select-values" name="select-values">' . $field['select_values'] . '</textarea>'.
        '  <p class="description">' . __('Comma-separated, put * infront of item name to indicate the default item', 'Fields') . '</p></td>'.
    		'</tr>';
    }
    // add field form
    else
    {
      echo
    		"<div style='display: none' class='additional {$this->html_class}'>".
    		'  <div class="form-field form-required">'.
        '  	<label for="tag-select-values">' . __('Drop box values', 'Fields') . '</label>'.
        '  	<textarea cols="10" rows="3" id="tag-select-values" name="select-values"></textarea>'.
        '    <p>' . __('Comma-separated, put * infront of item name to indicate the default item', 'Fields') . '</p>'.
        '  </div>'.
    		'</div>';
    }  
  }
  
  // fired when new field or edit field forms are submitted
  // modify $field and return
  function save_options($field, $group)
  {
    $field['select_values'] = get_post_value('select-values');
    return $field;
  }
  
  // show the field in a write panel / meta box
  function show_field($post, $box, $field)
  {
    $select_values = $field['select_values'];
    $use_default = true;
    if ($select_values != '')
    {
      if ($field['group']['layout'] == LABEL_LEFT)
        echo "<th valign='top' scope='row'><label>{$field['title']}</label></th>";
      echo "<td valign='top'>";
      if ($field['group']['layout'] == LABEL_TOP)
        echo "<label class='fs-one-column-label'>{$field['title']}</label>";

      echo "<select class='fs-select' id='{$field['tag_id']}' name='{$field['tag_name']}'>\n";

      $values = explode(',', $select_values);
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
      
      
      $index = 0;
      foreach ($values as $value)
      {
        $value = trim($value);
        if ($index++ == $selected_index)
          $selected = ' selected';
        else
          $selected = '';
        echo "<option value='$value'$selected>$value</option>\n";
      }
      if ($field['note'])
        $note = '<p class="description">' . $field['note'] . '</p>';    
      echo "</select>$note</td>\n";
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