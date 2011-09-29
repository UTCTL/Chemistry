<?php
/*
Plugin Name: Fields
Version: 0.4.3
Author URI: http://calce.net/
Plugin URI: http://calce.net/fields
Description: Creates custom write panels to manage your custom fields.
Contributors: Khanh Cao
Author: Khanh Cao

	USAGE:

	See http://calce.net/fields

	LICENCE:

    This program is free software: you can redistribute it and/or modify
    it under the terms of the GNU General Public License as published by
    the Free Software Foundation, either version 3 of the License, or
    (at your option) any later version.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with this program.  If not, see <http://www.gnu.org/licenses/>.
    
    
*/

if (!defined('ABSPATH'))
  die("Can't load this file directly");

global $fields_version;

$fields_version = 0.43;

require('fs-def.php');
require('fs-utils.php');
require('fs-base.php');
require('fs-boxes.php');
require('fs-groups.php');
require('field-types/fs-field-types.php');
require('field-types/fs-common-field-types.php');


class FS_Fields
{
  function __construct()
  {
    register_activation_hook(__FILE__, array($this, 'activate'));

    add_action("activated_plugin", array($this, 'fields_load_first'));

    $plugin_dir = basename(dirname(__FILE__));
    load_plugin_textdomain('Fields', null, $plugin_dir . '/languages');
    
    add_action('init', array($this, 'init'));

    if (is_admin())
    {
      require('admin/fs-admin.php');  
      new FS_Admin();
    }
    else
    {
      require('shortcodes/fs-shortcode.php');
      require('shortcodes/fs-common-shortcodes.php');
      require('fs-commoner.php');
      add_filter('fs_shortcode', array($this, 'do_shortcode'));
    }

  }
 
  function activate()
  {
    global $fields_version;
  
    $current_version = get_option('net_calce_fields_version', 0);
    
    // 0.3 data structure
    if ($current_version < 0.3)
    {
      // upgrade old data structure
      
      $boxes = get_option(OPTION_BOXES);
      if (is_array($boxes))
      {
        $index = 0;
        foreach ($boxes as $box_key => $box)
        {
          if (!isset($box['key']))
          {
            $box['key'] = isset($box['box_key'])?$box['box_key']:'box'.$index;
            $index++;
            if (is_array($box['groups']))
              foreach ($box['groups'] as $key => $group)
              {
                unset($box['groups'][$key]);
                $box['groups'][] = $group;
              }
            $boxes[$box_key] = $box;
          }
        }
        update_option(OPTION_BOXES, $boxes);
      }
    
      $groups = get_option(OPTION_GROUPS);
      if (is_array($groups))
      {
        $index = 0;
        foreach ($groups as $group_key => $group)
        {
          if (!isset($group['key']))
          {
            $group['key'] = isset($group['group_key'])?$group['group_key']:'group-'.$index;
            $index++;
            if (is_array($group['fields']))
            {
              $findex = 0;
              foreach ($group['fields'] as $field_key => $field)
              {
                $group['fields'][$field_key]['key'] = isset($field['field_key'])?$field['field_key']:'field-'.$findex++;
              }
            }
            $groups[$group_key] = $group;
          }
        }
        update_option(OPTION_GROUPS, $groups);
      }
      
      update_option('net_calce_fields_version', $fields_version);
    }
    
  }
  
  function init()
  {
    do_action('fs_init');
    if (!is_admin())
    {
      do_action('fs_viewer_init');
    }
  }

  function do_shortcode($meta)
  {
    return do_shortcode($meta);
  }  
  
  function fields_load_first()
  {
  	$wp_path_to_this_file = preg_replace('/(.*)plugins\/(.*)$/', WP_PLUGIN_DIR."/$2", __FILE__);
  	$this_plugin = plugin_basename(trim($wp_path_to_this_file));
  	$active_plugins = get_option('active_plugins');
  	$this_plugin_key = array_search($this_plugin, $active_plugins);
  	if ($this_plugin_key)
  	{
  		array_splice($active_plugins, $this_plugin_key, 1);
  		array_unshift($active_plugins, $this_plugin);
  		update_option('active_plugins', $active_plugins);
  	}
  }
  
}

/*delete_option(OPTION_GROUPS);
delete_option(OPTION_BOXES);*/

new FS_Fields();

?>