<?php

class FS_Textarea extends FS_FieldType
{

  public function __construct()
  {
    parent::__construct('textarea', 'Textarea');
    $this->html_class = 'fs-textarea-linked';    
  }
  
  // show the html the field needs
  function show_options($field)
  {
    // editing a field
    if (is_array($field))
    {
      if ($field['visual'] != '') $checked = ' checked=checked'; else $checked = '';
      echo 
        "<tr style='display: none' class='additional {$this->html_class}'>".
      	'	<th valign="top" scope="row"><label for="tag-rows">' . __('Rows', 'fields') . '</label></th>'.
      	'	<td><input type="text" aria-required="true" value="'.$field['rows'].'" id="tag-rows" name="rows"></input></td>'.
      	'</tr>'.
  
        "<tr style='display: none' class='additional {$this->html_class}'>".
      	'	<th valign="top" scope="row"><label for="tag-visual">' . __('Use visual editor', 'fields') . '</label></th>'.
      	'	<td><input type="checkbox"'.$checked.' name="visual" id="tag-visual"></input></td>'.
      	'</tr>';    
    }
    // new field form
    else
    {
      echo
      "<div class='form-field form-required additional {$this->html_class}'>".
      '	<label for="tag-rows">' . __('Rows', 'Fields') . '</label>'.
      '	<input class="small" type="text" id="tag-rows" size="40" name="rows" value="0"></input>'.
      '</div>'.
		  "<div class='form-field form-required check-field additional check-row {$this->html_class}'>".
  		'  <input type="checkbox" id="tag-visual" name="visual"></input><label class="input-label" for="tag-visual" class="normal">Use visual editor</label>'.
		  '</div>';    
    }
  }
  
  // fired when new field or edit field forms are submitted
  // modify $field and return
  function save_options($field, $group)
  {
    $field['rows'] = esc_attr($_POST['rows']);
    $field['textarea_default'] = $_POST['textarea-default'];
    $field['visual'] = esc_attr($_POST['visual']);
    return $field;
  }
  
  // show the field in a write panel / meta box
  function show_field($post, $box, $field)
  {
    if ($field['note'])
      $note = '<p class="description">' . $field['note'] . '</p>';
      
    if ($field['visual'] != '')
    {
      $visual = ' fs-visual';
    }
    
    $rows = $field['rows'];
    $value = maybe_unserialize($field['meta_value']);
    if (is_array($value))
      $value = $value['value'];
      
    if ($field['group']['layout'] == LABEL_LEFT)
      echo "<th valign='top' scope='row'><label for='{$field['tag_id']}'>{$field['title']}</label></th>";
    echo "<td valign='middle'>";
    if ($field['group']['layout'] == LABEL_TOP)
      echo "<label for='{$field['tag_id']}' class='fs-one-column-label'>{$field['title']}</label>";
    
    echo "<textarea class='fs-textarea$visual' aria-required='true' rows='$rows' id='{$field['tag_id']}' name='{$field['tag_name']}'$visual>{$value}</textarea>" .
         '<p class="description">' . $note . '</p>'.
         '</td>';  
  }
  
  // save the field's data when a post/page is added/updated
  function save_field($postID, $field)
  {
    fs_delete_meta($postID, $field['key']);
    fs_update_meta($postID, $field['key'], $field['meta_value']);
  }

}

?>