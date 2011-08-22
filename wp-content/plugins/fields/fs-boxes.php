<?php

class FS_Boxes extends FS_Base
{
  private static $instance;
  
  public static function instance()
  {
    if (!self::$instance)
    {
      self::$instance = new FS_Boxes(OPTION_BOXES);
    }
    return self::$instance;
  }
  
  function get_groups_for_types($post_type)
  {
    $arr = array();
    $fs_groups = FS_Groups::instance();
    foreach ($this->hays as $box)
    {
      if ((in_array($post_type, $box['post_types'])) && (is_array($box['groups'])))
      {
        foreach ($box['groups'] as $gkey)
        {
          $group = $fs_groups->get($gkey);
          if (is_array($group))
            $arr[] = $group;
        }
      }
    }
    return $arr;
  }
  
  function create_dummy()
  {
    $box = array('key' => 'hello-world', 'title' => "Hello World!", 'description' => 'This is your first box, it will appear in both post and page write panels. This box includes 2 groups, click on the tab Groups up top to start start editing those groups!', 'groups' => array(0 => 'first-group', 1 => 'second-group'), 'post_types' => array(0 => 'post', 1 => 'page'));
    $this->hays = array(0 => $box);
    $this->update(false);
  }
  
}

?>