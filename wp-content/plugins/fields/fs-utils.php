<?php

if (!defined('ABSPATH'))
  die("Can't load this file directly");

function sort_by_order($arr)
{
  usort($arr, 'do_compare');
}

function do_compare($a, $b)
{
  return $a['order'] - $b['order'];
}

function get_admin_mode()
{
  global $fs_site_url, $fs_page_name, $fs_page_url, $fs_option_pages;
  
  $req_uri = $_SERVER['REQUEST_URI'];
  
  foreach ($fs_option_pages as $page)
  {
    if (strstr($req_uri, 'page=' . $page))
    {
      return MODE_OPTIONS;
    }
  }
  if ((strstr($req_uri, 'wp-admin/post-new.php') != false) | (strstr($req_uri, 'wp-admin/post.php') != false) | (strstr($req_uri, 'wp-admin/edit.php') != false))
  {
    return MODE_EDIT;
  }
  else
    return MODE_ADMIN;
}

function get_request_value($key, $default = '')
{
  return isset($_REQUEST[$key])? esc_attr($_REQUEST[$key]):$default;
}

function get_post_value($key, $default = '')
{
  return isset($_POST[$key])? esc_attr($_POST[$key]):$default;
}

function get_get_value($key, $default = '')
{
  return isset($_GET[$key])? esc_attr($_GET[$key]):$default;
}

function get_plain_request_value($key, $default = '')
{
  return isset($_REQUEST[$key])? $_REQUEST[$key]:$default;
}

function get_plain_post_value($key, $default = '')
{
  return isset($_POST[$key])? $_POST[$key]:$default;
}

function get_plain_get_value($key, $default = '')
{
  return isset($_GET[$key])? $_GET[$key]:$default;
}

function build_group_url($group, $action = ACT_EDIT_GROUP)
{
  global $fs_page_url, $fs_nonce;
  return $fs_page_url . "&tab=" . TAB_GROUPS . "&item={$group['key']}&action=$action&_wpnonce=$fs_nonce";
}

function build_group_link($group, $title = '', $action = ACT_EDIT_GROUP)
{
  if ($title == '')
    $title = $group['title'];
  $url = build_group_url($group, $action);
  return "<a href='$url'>{$group['title']}</a>";
}

function build_field_url($group, $field, $action = ACT_EDIT_FIELD)
{
  global $fs_page_url, $fs_nonce;
  return $fs_page_url . "&tab=" . TAB_GROUPS . "&item={$group['key']}&sub_item={$field['key']}&action=$action&_wpnonce=$fs_nonce";
}

function build_field_link($group, $field, $title = '', $action = ACT_EDIT_FIELD)
{
  if ($title == '')
    $title = $field['title'];
  $url = build_field_url($group, $field, $action);
  return "<a href='$url'>$title</a>";
}

function print_nice($elem,$max_level=10,$print_nice_stack=array())
{
  if(is_array($elem) || is_object($elem)){ 
      if(in_array(&$elem,$print_nice_stack,true)){ 
          echo "<font color=red>RECURSION</font>"; 
          return; 
      } 
      $print_nice_stack[]=&$elem; 
      if($max_level<1){ 
          echo "<font color=red>nivel maximo alcanzado</font>"; 
          return; 
      } 
      $max_level--; 
      echo "<table border=1 cellspacing=0 cellpadding=3 width=100%>"; 
      if(is_array($elem)){ 
          echo '<tr><td colspan=2 style="background-color:#333333;"><strong><font color=white>ARRAY</font></strong></td></tr>'; 
      }else{ 
          echo '<tr><td colspan=2 style="background-color:#333333;"><strong>'; 
          echo '<font color=white>OBJECT Type: '.get_class($elem).'</font></strong></td></tr>'; 
      } 
      $color=0; 
      foreach($elem as $k => $v){ 
          if($max_level%2){ 
              $rgb=($color++%2)?"#888888":"#BBBBBB"; 
          }else{ 
              $rgb=($color++%2)?"#8888BB":"#BBBBFF"; 
          } 
          echo '<tr><td valign="top" style="width:40px;background-color:'.$rgb.';">'; 
          echo '<strong>'.$k."</strong></td><td>"; 
          print_nice($v,$max_level,$print_nice_stack);
          echo "</td></tr>"; 
      } 
      echo "</table>"; 
      return; 
  } 
  if($elem === null){ 
      echo "<font color=green>NULL</font>"; 
  }elseif($elem === 0){ 
      echo "0"; 
  }elseif($elem === true){ 
      echo "<font color=green>TRUE</font>"; 
  }elseif($elem === false){ 
      echo "<font color=green>FALSE</font>"; 
  }elseif($elem === ""){ 
      echo "<font color=green>EMPTY STRING</font>"; 
  }else{ 
      echo str_replace("\n","<strong><font color=red>*</font></strong><br>\n",$elem); 
  } 
}

function get_nonce()
{
  return wp_create_nonce('fields');
}

function show_nonce()
{
  global $fs_nonce;
  echo "<input type='hidden' id='_wpnonce' name='_wpnonce' value='$fs_nonce' />";
}

function security_check()
{
  $nonce = $_REQUEST['_wpnonce'];
  if (!wp_verify_nonce($nonce, 'fields') ) die('Security check'); 
}

function register_field_type($field_type)
{
  FS_FieldTypes::instance()->register_field_type($field_type);
}

function not_array($arr)
{
  return !is_array($arr);
}

function _get_meta($meta, $single = true, $id = '') 
{  
  global $post;
  if ($id != '') 
  {
    $meta = get_post_meta($id, $meta, $single);
  }
  else 
  {
    $id = (get_the_id()) ? get_the_id() : $post->ID;
    $meta = get_post_meta($id, $meta, $single);
  }
  return $meta;
}

// put a '_' infront of meta key
function field_delete_meta($postID, $key)
{
  delete_post_meta($postID, '_' . $key);
}

function field_get_meta($key, $single = true, $id = '')
{
  $meta = _get_meta('_' . $key, $single, $id);
  
  if ($single)
  {
    $meta = maybe_unserialize($meta);
    if (is_array($meta))
      $meta = $meta['value'];
    return $meta;
  }
  else
  {
    $arr = array();
    if (is_array($meta))
    {
      foreach ($meta as $value)
      {
        $value = maybe_unserialize($value);
        if (is_array($value))
          $arr[] = $value['value'];
        else
          $arr[] = $value;
      }
    }
    else
    {
      $value = maybe_unserialize($meta);
      if (is_array($value))
        $arr[] = $value['value'];
      else
        $arr[] = $value;
    }
    return $arr;
  }
}

function field_add_meta($postID, $key, $value)
{
  return add_post_meta($postID, '_' . $key, $value, false);
}

function field_meta($meta, $single = true, $id = '')
{
  echo field_get_meta($meta, $single, $id); 
}

function field_update_meta($postID, $key, $value)
{
  return update_post_meta($postID, '_' . $key, $value);
}

function fs_delete_meta($postID, $key)
{
  return delete_post_meta($postID, '_' . $key);
}

function fs_get_meta($key, $single = true, $id = '')
{
  return _get_meta('_' . $key, $single, $id);
}

function fs_add_meta($postID, $key, $value)
{
  return add_post_meta($postID, '_' . $key, $value, false);
}

function fs_meta($meta, $single = true, $id = '')
{
  echo _get_meta($meta, '_' . $single, $id); 
}

function fs_update_meta($postID, $key, $value)
{
  return update_post_meta($postID, '_' . $key, $value);
}

function fs_get_meta_from_slug($key, $slug, $post_type, $single=true, $status = 'publish')
{
  if ($postID = fs_get_postID($slug, $post_type, $status))
  {
    return fs_get_meta($key, $single, $postID);
  }
  else
    echo "<p>postID = $postID</p>";
}

function fs_get_postID($slug, $post_type, $status = 'publish')
{
  $args = array(
    'name' => $slug,
    'post_type' => $post_type,
    'post_status' => $status,
    'posts_per_page' => 1,
    'caller_get_posts'=> 1
  );
  $posts = get_posts($args);

  if($posts) {
    return $posts[0]->ID;
  }
  return '';
}

function fs_count($o)
{
  if ((is_object($o)) | (is_array($o)))
    return count((array) $o);
  else
    return 0;
}

global $fs_site_url, $fs_page_name, $fs_page_url_base, $fs_page_url, $fs_option_pages;
$fs_site_url = get_bloginfo('wpurl');
$path = explode('/', plugin_basename(__FILE__));
$size = sizeof($path);
if ($size > 1)
  $fs_page_name = $path[$size-2];
$fs_page_name = PAGE_MANAGE;
$fs_page_url_base = $fs_site_url . '/wp-admin/admin.php?page=';
$fs_page_url = $fs_page_url_base . $fs_page_name;
$fs_option_pages = array();
?>