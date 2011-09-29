<?php

define('SHOW_EDIT', 1);

class FS_ExportPage extends FS_PageOptionsBase
{
  private $last_input = '';
  private $fs_boxes;
  private $fs_groups;
  private $xml;
  
  function think()
  {
    global $fs_action;
    $this->fs_boxes = FS_Boxes::instance();
    $this->fs_groups = FS_Groups::instance();
    parent::think();
    if ($fs_action == ACT_EXPORT)
      $this->export();
  }

  function get_title()
  {
    return __('Export', 'Fields');
  }
  
  function export()
  {
    global $fs_form_method;    
    if ($fs_form_method == POST)
    {
      $boxes = array();
      $groups = array();
      
      if (is_array($_POST['boxes']))
      {
        foreach ($_POST['boxes'] as $box_key)
        {
          $box = $this->fs_boxes->get($box_key);
          if (is_array($box))
            $boxes[] = $box;
        }
      }
      
      if (is_array($_POST['groups']))
      {
        foreach ($_POST['groups'] as $group_key)
        {
          $group = $this->fs_groups->get($group_key);
          if (is_array($group))
            $groups[] = $group;
        }
      }
      
      $fs_migrate = new FS_Migrate();
      $this->xml = $fs_migrate->export($boxes, $groups);
    }
    else
    {
    }
  }
    
  function show_content()
  {
    $this->show_index();
  }
  
  function show_index()
  {?>
    <h3><?php _e('Select boxes and groups to export', 'Fields'); ?></h3>
    <form method="post" action="<?php echo $page_url; ?>">
      <?php show_nonce(); ?>
      <input type="hidden" id='tab' name='tab' value='<?php echo TAB_EXPORT; ?>' />
      <input type="hidden" id='action' name='action' value='<?php echo ACT_EXPORT; ?>' />
      
      <table class="form-table">
      <tbody>
        <tr>
      		<th valign="top" scope="row"><label for="tag-url"><?php _e('Boxes', 'Fields'); ?></label></th>
      		<td><?php $this->show_boxes(); ?>
      		<p class="description"><?php _e('Include these boxes', 'Fields'); ?></p></td>
      	</tr>
      	
        <tr>
      		<th valign="top" scope="row"><label><?php _e('Groups', 'Fields'); ?></label></th>
      		<td><?php $this->show_groups(); ?>
      		<?php _e('Include these groups and their fields', 'Fields'); ?></label>
      		</td>
      	</tr>
        
        <?php if (!empty($this->xml)): ?>
        <tr>
      		<th valign="top" scope="row"><label><?php _e('Exported boxes and groups', 'Fields'); ?></label></th>
      		<td><textarea rows="20" cols="80"><?php echo $this->xml; ?></textarea>
      		<p class="description"><?php _e('You should save this into a file for importing later. You can optionally modify this to quickly add new boxes and groups without using the boxes and groups managers.<br/>Please use a XML editor for more efficience.', 'Fields'); ?></p>
      		</td>
      	</tr>
        <?php endif; ?>

      </tbody>
      </table>      
      <p class="submit">
        <input type="submit" value="<?php _e('Export as Text', 'Fields'); ?>" class="button-primary" name="Submit">
      </p>
    </form>
  <?php
  }
  
  function show_boxes()
  {
    $index = 0;
    $boxes = $this->fs_boxes->hays();
    foreach ($boxes as $box)
    {
      $title = stripslashes($box['title']);
      echo "<label for='tag-box-{$box['key']}'><input type='checkbox' id='tag-box-{$box['key']}' name='boxes[]' value='{$box['key']}' />\n".
           "$title<span class='fs-hidden'>({$box['key']})</span></label><br />";
    }    
  }
  
  function show_groups()
  {
    $index = 0;
    $groups = $this->fs_groups->hays();
    foreach ($groups as $group)
    {
      $title = stripslashes($group['title']);
      echo "<label for='tag-group-{$group['key']}'><input type='checkbox' id='tag-group-{$group['key']}' name='groups[]' value='{$group['key']}' />\n".
           "$title<span class='fs-hidden'>({$group['key']})</span></label><br />";
    }    
  }
  

}

?>