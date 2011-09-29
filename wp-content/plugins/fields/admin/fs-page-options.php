<?php

class FS_OptionsPage extends FS_PageOptionsBase
{
  
  function think()
  {
    global $fs_action;
    parent::think();
  }

  function get_title()
  {
    global $fs_action;
    switch ($fs_action)
    {
      case ACT_EDIT_BOX:
        return 'Edit box';
      default:
        return 'Boxes';
    }
  }
  
  function show_content()
  {?>
    <div id="col-container">
      <div id="col-left">
        <div class="col-wrap">
        Sorry, there is nothing in here yet.
        </div>
      </div>
      <div id="col-right">
        <div class="col-wrap">
        </div>
      </div>
    </div>
  <?php    
  }
  
}

?>