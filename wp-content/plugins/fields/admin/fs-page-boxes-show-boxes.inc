<?php
    global $fs_page_url, $fs_nonce;
    $i = 1;
    $boxes = $this->fs_boxes->hays();
    $fs_groups = FS_Groups::instance();
    if (is_array($boxes))
    {
      global $fs_page_url, $tab;
      $url = $fs_page_url . '&tab=' . TAB_BOXES;
      foreach ($boxes as $key => $box)
      {
        if (!is_array($box))
          continue;
        if ($i == 1)
          $class = "alternate";
        else
          $class = "";
        $i = 3 - $i;
        $box_url = $url . "&item={$box['key']}";
        
        $group_names = array();
        if (is_array($box['groups']))
        {
          foreach ($box['groups'] as $group_key)
          {
            $group = $fs_groups->get($group_key);
            if (is_array($group))            
              $group_names[] = build_group_link($group);
          }
        }
        $group_names = implode(', ', $group_names);
        
        $post_type_names = array();
        if (is_array($box['post_types']))
        {
          foreach ($box['post_types'] as $post_type_name)
          {
            $post_type = get_post_type_object($post_type_name);
            $post_type_names[] = $post_type->labels->name;
          }
          $post_type_names = implode(', ', $post_type_names);
        }
        
        $edit_url = "$box_url&action=" . ACT_EDIT_BOX . "&_wpnonce=$fs_nonce";
        echo "<tr class='$class'>". 
             "<td><a class='title' href='$edit_url'>" . ($box['title']) . "</a><span class='fs-hidden'>({$box['key']})</span></td>" .
             "<td>$group_names</td>" .
             "<td>$post_type_names</td>" .
             "<td><a href='$edit_url'>Edit</a> | " .
             "<a href='$box_url&action=" . ACT_DELETE_BOX . "&_wpnonce=$fs_nonce'>Delete</a></td>" .
             '</tr>';
      }
    }
?>