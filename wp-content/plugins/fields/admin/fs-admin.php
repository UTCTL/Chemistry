<?php

class FS_Admin
{
  public function __construct()
  {
    global $fs_page_name, $fs_plugin_url, $fs_option_pages;
    $fs_plugin_url = WP_PLUGIN_URL . '/' . $fs_page_name . '/';
    
    wp_register_script('fs-cookie', $fs_plugin_url . 'js/jquery.cookie.js', array('jquery'), '1.0', true);
    wp_register_script('fs-fields', $fs_plugin_url . 'js/fields.js', array('jquery'), '1.0', true);
    wp_register_script('fs-options', $fs_plugin_url . 'js/options.js', array('jquery'), '1.0', true);
    wp_register_script('fs-edit', $fs_plugin_url . 'js/edit.js', array('jquery', 'jquery-ui-core'), '1.0', true);
    wp_register_script('fs-import', $fs_plugin_url . 'js/import.js', array('jquery'), '1.0', true);
    
    wp_register_style('fs-options', $fs_plugin_url . 'css/options.css', array('colors'), '1.0');
    wp_register_style('fs-edit', $fs_plugin_url . 'css/edit.css', array('colors'), '1.0');

    add_action('admin_init', array($this, 'admin_init'));
    add_action('admin_menu', array($this, 'admin_menu'));
    
    add_action('wp_ajax_fs_import_preview', array($this, 'fs_import_preview'));    
    array_push($fs_option_pages, PAGE_MANAGE, PAGE_OPTIONS);
  }
  //get_option('date_format')
  function admin_init()
  {
    global $fs_page_name, $fs_nonce;
    $fs_nonce = get_nonce();
    $mode = get_admin_mode();
              
    wp_enqueue_script('fs-fields');
    wp_localize_script('fs-fields', 'fsAjax',
      array
      (
        'url' => admin_url('admin-ajax.php'),
        'nonce' => $fs_nonce,
      ));
      
    switch ($mode)
    {
      case MODE_OPTIONS:
      
        wp_enqueue_script('fs-options');
        wp_enqueue_style('fs-options');          
        
        $fs_tab = get_request_value('tab', 'boxes');
        
        if ($fs_tab == TAB_IMPORT)
        {
          wp_enqueue_script('fs-import');
          
          $importStrings = array(
            'error' => __('Unknown error encoutered.', 'Fields')
          );
          
          wp_localize_script('fs-import', 'importStrings', $importStrings);
        }
        
        break;
        
      case MODE_EDIT:
        wp_enqueue_style('fs-edit');
        wp_enqueue_script('fs-cookie');
        wp_enqueue_script('fs-edit');
        
        require('fs-meta.php');
        new FS_Meta();
        
    		add_filter('mce_buttons', array($this, 'filter_mce_button'));
    		add_filter('mce_external_plugins', array($this, 'filter_mce_plugin'));        
        
        break;
    }

    do_action('fs_admin_init');
    global $fs_option_pages;
    //add_action( "admin_print_scripts-$mypage", 'plugin_admin_head' );
  }
  
  function admin_menu()
  {
    global $fs_page_name;
    add_menu_page('Fields', 'Fields', 'update_core', PAGE_MANAGE, array($this, 'show_manage_page'));
    add_submenu_page(PAGE_MANAGE, 'Manage Fields', 'Fields', 'update_core', PAGE_MANAGE, array($this, 'show_manage_page'));
    add_submenu_page(PAGE_MANAGE, 'Fields Options', 'Options', 'update_core', PAGE_OPTIONS, array($this, 'show_options_page'));
  }
  
  function init_page()
  {
    $_REQUEST = array_map('stripslashes_deep', $_REQUEST); 
    $_GET = array_map('stripslashes_deep', $_GET); 
    $_POST = array_map('stripslashes_deep', $_POST); 
    $_COOKIE = array_map('stripslashes_deep', $_COOKIE); 

    require('fs-page.php');
    global $fs_tab, $fs_action, $fs_form_method, $fs_nonce;
    $fs_tab = get_request_value('tab', 'boxes');
    $fs_action = get_request_value('action');
    $fs_form_method = $_SERVER['REQUEST_METHOD'];
    
    if (($fs_form_method == POST) || ($fs_action != ''))
      security_check();
  }
  
  function show_page($page)
  {
    do_action('fs_options_init', $page);
    
    $page->think();
    $page->show();    
  }
  
  // show the tabs
  function show_manage_page()
  {
    $this->init_page();
    global $fs_tab, $fs_action, $fs_form_method, $fs_nonce;
    
    switch ($fs_tab)
    {
      case TAB_GROUPS:
        require('fs-page-groups.php');
        $page = new FS_GroupsPage();
        break;
      default:
        $fs_tab = TAB_BOXES;
        require('fs-page-boxes.php');
        $page = new FS_BoxesPage();
        break;
    }
    
    $this->show_page($page);
  }
  
  function show_options_page()
  {
    $this->init_page();
    global $fs_tab, $fs_action, $fs_form_method, $fs_nonce;
    
    switch ($fs_tab)
    {
      case TAB_IMPORT:
        require('fs-migrate.php');
        require('fs-page-import.php');
        $page = new FS_ImportPage();
        break;
      case TAB_EXPORT:
        require('fs-migrate.php');
        require('fs-page-export.php');
        $page = new FS_ExportPage();
        break;
      default:
        $fs_tab = TAB_OPTIONS;
        require('fs-page-options.php');
        $page = new FS_OptionsPage();
        break;        
    }

    $this->show_page($page);    
  }
  
  // ajax import preview
  function fs_import_preview()
  {
    header( "Content-Type: application/json" );
    if (current_user_can('update_core'))
    {
      security_check();
      $response = array();
      
      $s = stripslashes($_POST['s']);
      
      if (!empty($s))
      {
        require('fs-migrate.php');
        $fs_migrate = new FS_Migrate();
        $preview = $fs_migrate->preview($s);
        
        if ($preview)
        {
	        $response['preview'] = $preview;
	        $response['ok'] = true;
        }
        else
        {
          $response['ok'] = false;
          $response['message'] = __('Import text is invalid', 'Fields');
        }
      }
      else
      {
        $response['ok'] = false;
        $response['message'] = __('Import text must not be empty', 'Fields');
      }
    }
    else
    {
      $response['ok'] = false;
      $response['message'] = __('You do not have sufficient permissions to import fields', 'Fields');
    }
    
    echo json_encode($response);
    exit;
  }
  
  // toolbar buttons
  function filter_mce_button($buttons) {
  	array_push($buttons, '|', 'fs_shortcode_button');
  	return $buttons;
  }
  
  function filter_mce_plugin($plugins) {
    global $fs_plugin_url;
  	$plugins['fs_shortcode'] = $fs_plugin_url . 'js/fs-shortcode-plugin.js';
  	return $plugins;
  }
  
}

?>