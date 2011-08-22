<?php

class FS_Textfield extends FS_FieldType
{

  public function __construct()
  {
    parent::__construct('text', 'Text');
    $this->html_class = 'fs-text-linked';
  }
  
  // show the html the field needs
  function show_options($field)
  {
    // editing a field
    if (is_array($field))
    {
      if ($field['text_multi'] != '') $checked_multi = ' checked'; else $checked_multi = '';
      if ($field['text_unordered'] != '') $checked_unordered = ' checked'; else $checked_unordered = '';
      echo
        "<tr class='additional {$this->html_class}'>".
      	'	<th valign="top" scope="row"></th>'.
      	'	<td valign="middle"><input type="checkbox"'. $checked_multi .' name="text-multi" id="tag-text-multi" /><label class="input-label" for="tag-text-multi">' . __('Multiple values', 'Fields') . '</label>'.
      	'<p class="description">' . __('Users will be able to add multiple values to this field', 'fields') . '</p>'.
      	'</td></tr>' .

        "<tr class='additional {$this->html_class}'>".
      	'	<th valign="top" scope="row"></th>'.
      	'	<td valign="middle"><input type="checkbox"'. $checked_unordered .' name="text-unordered" id="tag-text-unordered" /><label class="input-label" for="tag-text-unordered">' . __('Unordered', 'Fields') . '</label>'.
      	'<p class="description">' . __('Multiple values are not shown in any particular order.') . '</p>' .
      	'</td></tr>' .
      	
    		"<tr class='additional {$this->html_class}'>".
        '	<th valign="top" scope="row"><label for="tag-text-picker">' . __('Picker', 'Fields') . '</label></th>'.
        '	<td><select id="tag-text-picker" name="text-picker">'.
        '<option value="none">none</option>'.
        '<option value="date"'. (($field['text_picker'] == 'date')?' selected':'') . '>Date</option>'.
        '<option value="color"'. (($field['text_picker'] == 'color')?' selected':'') . '>Colors</option>'.
        '</select>'.
        '</td>'.
    		'</tr>';
      	
    }
    // new field form
    else
    {
      echo
      "<div class='form-field form-required additional {$this->html_class} check-row'>".
      '<input type="checkbox" name="text-multi" id="tag-text-multi" /><label class="input-label" for="tag-text-multi">' . __('Multiple values', 'Fields') . '</label>'.
      '<br/ ><input type="checkbox" name="text-unordered" id="tag-text-unordered" /><label class="input-label" for="tag-text-unordered">' . __('Unordered', 'Fields') . '</label>'.      
      '</div>' .

      "<div class='form-field form-required additional {$this->html_class}'>".
      '<label class="input-label" for="tag-text-picker">' . __('Picker', 'Fields') . '</label>'.
      '<select id="tag-text-picker" name="text-picker">'.
      '<option value="none">none</option>'.
      '<option value="date">Date</option>'.
      '<option value="color">Colors</option>'.
      '</select>'.
      '</div>';
    }
  }
  
  // fired when new field or edit field forms are submitted
  // modify $field and return
  function save_options($field, $group)
  {
    $field['text_multi'] = get_post_value('text-multi');
    $field['text_unordered'] = get_post_value('text-unordered');
    $field['text_picker'] = get_post_value('text-picker');
    return $field;
  }
  
  // show the field in a write panel / meta box
  function show_field($post, $box, $field)
  {
    if ($field['note'])
      $note = '<p class="description">' . $field['note'] . '</p>';

    if ($field['group']['layout'] == LABEL_LEFT)
      echo "<th valign='top' scope='row'><label for='{$field['tag_id']}'>{$field['title']}</label></th>";
    echo "<td class='fs-sortable' valign='top'>";
    if ($field['group']['layout'] == LABEL_TOP)
      echo "<label for='{$field['tag_id']}' class='fs-one-column-label'>{$field['title']}</label>";
    
    if ($field['text_picker'] == 'date')
      $picker_class = ' fs-date-picker';
    elseif ($field['text_picker'] == 'color')
      $picker_class = ' fs-color-picker';
    if ($field['text_multi'] != '')
    {
      $field['tag_name'] .= '[]';
      $values = $this->get_values($field);
      
      $index = 1;
      foreach ($values as $value)
      {
        echo "<div class='fs-multi-row'>" .
             "<input type='text' class='fs-textfield$picker_class' aria-required='true' value='{$value['value']}' id='{$field['tag_id']}$index' name='{$field['tag_name']}' />" .
             "<a href='#' tabindex='-1' class='fs-hidden fs-remove-row'><br /></a>" .
             "</div>";
        $index++;
      }
      echo "<div class='fs-add-more-wrap'>$note<a class='button fs-add-more' href='#'>" . __('Add more', 'Fields') . '</a>'.
           "</div>";
    }
    else
    {
      $value = maybe_unserialize($field['meta_value']);
      if (is_array($value))
        $value = $value['value'];      
      echo "<div class='fs-row'><input type='text' class='fs-textfield$picker_class' aria-required='true' value='$value' id='{$field['tag_id']}' name='{$field['tag_name']}' />$note</div>";
    }
    
    echo "</td>";
  }
  
  // save the field's data when a post/page is added/updated
  function save_field($postID, $field)
  {
    field_delete_meta($postID, $field['key']);
        
    if ($field['text_multi'])
    {
      if (is_array($field['meta_value']))
      {
        $index = 0;
        if ($field['text_unordered'])
        {
          foreach ($field['meta_value'] as $value)
          {
            fs_add_meta($postID, $field['key'], $value);
          }
        }
        else
        {
          foreach ($field['meta_value'] as $value)
          {
            $arr = array('order' => $index++, 'value' => $value);
            fs_add_meta($postID, $field['key'], serialize($arr));
          }
        }
      }
    }
    else
    {
      $value = esc_attr($field['meta_value']);
      fs_update_meta($postID, $field['key'], $value);
    }
  }

  function get_values($field)
  {
    $meta = fs_get_meta($field['key'], false);
    $values = array();
    if (is_array($meta))
    {
      foreach ($meta as $value)
      {
        $value = maybe_unserialize($value);
        $values[] = $value;
      }
      sort_by_order(&$values);
    }
    else
    {
      $values[] = maybe_unserialize($meta);
    }
    
    if (sizeof($values) == 0)
    {
      $value = array('order' => 0, 'value' => '');
      $values[] = $value;
    }
    
    return $values;
  }
}

?>