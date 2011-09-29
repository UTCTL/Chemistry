<?php

require('fs-textfield.php');
require('fs-checkbox.php');

add_action('fs_viewer_init', 'add_common_shortcodes');
function add_common_shortcodes()
{
  fs_add_shortcode(new FS_TextfieldShortCode());
  fs_add_shortcode(new FS_CheckboxShortCode());
}

?>