<?php

abstract class FS_Page
{
  private $title;
  private $messages = array();
  
  function think()
  {
    $this->title = $this->get_title();
  }
  
  function add_notice($msg)
  {
    $this->messages[] = array('type' => NOTICE_UPDATE, 'message' => $msg);
  }
  
  function add_error($msg)
  {
    $this->messages[] = array('type' => NOTICE_ERROR, 'message' => $msg);
  }
  
  function show()
  {
    $this->show_header();
    $this->show_content();
    $this->show_footer();
  }
  
  abstract function show_navi_menu();
  
  function show_header()
  {
    ?>
    <div class="wrap nosubsub">
      <h2><?php echo $this->title; ?></h2>
      <?php $this->show_navi_menu(); ?>
      <div class='clear'></div>
    <?php
    // notice messages
    foreach ($this->messages as $item)
    {
      $msg = $item['message'];
      if ($item['type'] == NOTICE_ERROR)
      {
        $class = 'error';
      }
      else
      {
        $class = 'updated';
      }
      
      echo "<div class='$class'><p>$msg</p></div>\n";
    }
    ?>
    
    <?php    
  }
  
  function show_footer()
  {?>
    </div>
  <?php
  }
  
}

class FS_PageManageBase extends FS_Page
{

  function show_navi_menu()
  {
    global $fs_page_url_base, $fs_tab;
    $url = $fs_page_url_base . PAGE_MANAGE . '&tab=';
    ?>
    <ul class="subsubsub">
      <li>
        <a <?php if ($fs_tab == TAB_BOXES) echo 'class="current"'; ?> href="<?php echo $url; echo TAB_BOXES; ?>"><?php _e('Boxes', 'fields'); ?></a> |
      </li>
      <li>
        <a <?php if ($fs_tab == TAB_GROUPS) echo 'class="current"'; ?> href="<?php echo $url; echo TAB_GROUPS; ?>"><?php _e('Groups', 'fields'); ?></a>
      </li>
    </ul>
  <?php
  }
}

class FS_PageOptionsBase extends FS_Page
{
  function show_navi_menu()
  {
    global $fs_page_url_base, $fs_tab;
    $url = $fs_page_url_base . PAGE_OPTIONS . '&tab=';
    ?>
    <ul class="subsubsub">
      <li>
        <a <?php if ($fs_tab == TAB_OPTIONS) echo 'class="current"'; ?> href="<?php echo $url; echo TAB_OPTIONS; ?>"><?php _e('Options', 'fields'); ?></a> |
      </li>
      <li>
        <a <?php if ($fs_tab == TAB_IMPORT) echo 'class="current"'; ?> href="<?php echo $url; echo TAB_IMPORT; ?>"><?php _e('Import', 'fields'); ?></a> |
      </li>
      <li>
        <a <?php if ($fs_tab == TAB_EXPORT) echo 'class="current"'; ?> href="<?php echo $url; echo TAB_EXPORT; ?>"><?php _e('Export', 'fields'); ?></a>
      </li>
    </ul>
    <?php
  }
}

?>