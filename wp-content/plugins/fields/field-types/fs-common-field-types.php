<?php

include('fs-textfield.php');
include('fs-textarea.php');
include('fs-select.php');
include('fs-radio.php');
include('fs-checkbox.php');


function register_common_types()
{
  register_field_type(new FS_Textfield());
  register_field_type(new FS_Textarea());
  register_field_type(new FS_Select());
  register_field_type(new FS_Radio());
  register_field_type(new FS_Checkbox());
}
add_action('fs_init', 'register_common_types');

?>