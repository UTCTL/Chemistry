<?php
    global $fs_page_url, $fs_nonce;
    $i = 1;
    $groups = $this->fs_groups->hays();
    if (sizeof($groups) > 0)
    {      
      global $fields_page_url, $tab;
      $i = 1;
      foreach ($groups as $key => $group)
      {
        if ($i == 1)
          $class = "alternate";
        else
          $class = "";
        $i = 3 - $i;      
        $fields = $this->get_fields_str($group);
        $edit_url = build_group_url($group, ACT_EDIT_GROUP);
        $delete_url = build_group_url($group, ACT_DELETE_GROUP);
        echo "<tr class='$class'>". 
             "<td><a class='title' href='$edit_url'>" . $group['title'] . "</a><span class='fs-hidden'>({$group['key']})</span></td>" .
             "<td>$fields</td>" .
             '<td>' . $group['order'] . '</td>' .
             "<td><a href='$edit_url'>Edit</a> | " .
             "<a href='$delete_url'>Delete</a></td>" .
             '</tr>';
      }
    }
    else
    {
      echo "<tr class='alternate'><td>There are no groups yet, create a new group by using the Add New Group form</td><td></td><td></td><td></td></tr>";
    }
?>