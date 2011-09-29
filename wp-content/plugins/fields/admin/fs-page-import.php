<?php

define('SHOW_EDIT', 1);

class FS_ImportPage extends FS_PageOptionsBase
{
  private $last_input = '';
  
  function think()
  {
    global $fs_action;
    
    parent::think();  
    if ($fs_action == ACT_IMPORT)
      $this->import();
  }

  function get_title()
  {
    return __('Import', 'Fields');
  }
  
  function import()
  {
    global $fs_form_method;
    if ($fs_form_method == POST)
    {
      $s = $_POST['s'];
      if (!empty($s))
      {
        $fs_migrate = new FS_Migrate();
        $fs_migrate->import($s, $this);
      }      
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
    <h3><?php _e('Input your import text', 'Fields'); ?></h3>
    <form method="post" action="<?php echo $page_url; ?>">
      <?php show_nonce(); ?>
      <input type="hidden" id='tab' name='tab' value='import' />
      <input type="hidden" id='action' name='action' value='<?php echo ACT_IMPORT; ?>' />
      
      <table class="form-table" id='fs-table'>
      <tbody>
        <tr>
      		<th valign="top" scope="row"><label><?php _e('Import from text', 'Fields'); ?></label></th>
      		<td><textarea name='s' id='tag-s' rows='10' cols='80'><?php echo stripslashes($_POST['s']); ?></textarea>
      		<p class="description">Must be in XML. Use the Export feature for the structure of the xml.</p>
      		</td>
      	</tr>

        <tr id="fs-preview-row" class="hidden">
      		<th valign="top" scope="row"><label><?php _e('Preview', 'Fields'); ?></label></th>
      		<td>
      		
        		<table id='fs-preview-boxes' class='widefat tag fixed'>
        		<thead>
        		  <th scope='row' valign="top" class='manage-column column-name'><?php _e('Action', 'Fields'); ?></th>
        		  <th scope='row' valign="top"><?php _e('Box', 'Fields'); ?></th>
        		  <th scope='row' valign="top"><?php _e('Title', 'Fields'); ?></th>
        		  <th scope='row' valign="top"><?php _e('Groups', 'Fields'); ?></th>
        		  <th scope='row' valign="top"><?php _e('Post types', 'Fields'); ?></th>
        		</thead>
        		<tbody></tbody>
        		</table>
        		<p></p>
  
        		<table id='fs-preview-groups' class='widefat'>
        		<thead>
        		  <th scope='row' valign="top"><?php _e('Action', 'Fields'); ?></th>
        		  <th scope='row' valign="top"><?php _e('Group', 'Fields'); ?></th>
        		  <th scope='row' valign="top"><?php _e('Title', 'Fields'); ?></th>
        		  <th scope='row' valign="top"><?php _e('Order', 'Fields'); ?></th>
        		  <th scope='row' valign="top"><?php _e('Fields', 'Fields'); ?></th>
        		</thead>
        		<tbody></tbody>      		
        		</table>
      		
      		</td>
      	</tr>
      	      	
      </tbody>
      </table>

      <p class="submit">
        <input type="submit" value="Import" class="button-primary" name="Submit">
        <a class="button hide-if-no-js" id='fs-preview' href="#"><?php _e('Preview', 'Fields'); ?></a>
      </p>
    </form>
  <?php    
  }
  
}

?>