<?php 
/*
 Plugin Name: Wordpress Event calendar
 Plugin URI: http://truthmedia.com/wordpress/event-calendar/
 Description: Allows complex calendar display and management
 Version: 0.27
 Author: TruthMedia Internet Group
 Author URI: http://www.truthmedia.com/
 */

define('WEC_VERSION', 0.27);
$number_of_wec_queries = 0;
$wec_query_log = array();

//Include all required files for this plugin
require_once ('requirements.php');

$serverLocale = date('e');

// Add the main menu
add_action('admin_menu', 'wec_mainMenuAction');
add_action('init', 'wec_initActions');
add_action('admin_print_scripts', 'wec_print_scripts');

add_action('admin_footer', 'wec_displayqueries');

//Add activation/deactivation
//register_activation_hook(__FILE__, 'wec_install');
register_deactivation_hook(__FILE__, 'wec_run_deactivation');
register_uninstall_hook(__FILE__, 'wec_delete');

function wec_mainMenuAction() {
    wec_checkInstall();
    
    add_management_page('Events', 'Events (Beta)', 2, 'calendar.php', 'wec_manageEventsPage');
    add_options_page('WordPress Event Calendar Options', 'Events (Beta)', 8, 'calendarOptions.php', 'wec_options_page');
    
    //Add actions to set the user's time zone
    add_action('edit_user_profile', 'wec_setUserTimeZone');
    add_action('show_user_profile', 'wec_setUserTimeZone');
    add_action('profile_update', 'wec_updateUserInfo');
    
    //Add auto-deleter to schedule
    add_action('autoDeleteRecurrences', 'wec_scheduledTasks');
}

function wec_initActions()
{
	if(is_admin())
	{
	    wec_update();
	}
    
    //    register_sidebar_widget('Event Calendar', 'wec_listViewWidget');
    
    //Add all the ajax actions
    doAjaxCalls();
    
    if (is_admin()) {
        wec_addScripts();
    }
    
    
    
    //register event post type
    
    $args = array(
        'label' => __('Events'),
        'singular_label' => __('Event'),
        'public' => true,
        'show_ui' => false,
        'hierarchical' => false,
        'rewrite' => false,
        'taxonomies' => array('post_tag', 'category')
     );

    register_post_type( 'event' , $args );
    
    
}

function doAjaxCalls() {
    // wp_ajax_* action, php function
    
    $createCalendarValidator = new createCalendarValidator();
    $editCalendarValidator = new editCalendarValidator();

    
    //Calendar Creation
    add_action('wp_ajax_validateCalendarNameOnCreate', array(&$createCalendarValidator, 'validateCalendarNameOnCreate'));
    add_action('wp_ajax_validateCalendarSlugOnCreate', array(&$createCalendarValidator, 'validateCalendarSlugOnCreate'));
    
    //Calendar Edit
    add_action('wp_ajax_validateCalendarNameOnEdit', array(&$editCalendarValidator, 'validateCalendarNameOnEdit'));

    
    //External Recurrence Creation
    add_action('wp_ajax_wec_runRecurrenceGenerator', 'wec_ajax_recurrence_generator');
    
    if (get_option('wec_allowExternalAccess') == 1) {
        //External Access
        $externalAccessObject = new externalAccess();
        add_action('wp_ajax_displayCalendarFromExternalSource', array(&$externalAccessObject, 'doExternalAccess'));
        add_action('wp_ajax_getTableCalendar', array(&$externalAccessObject, 'getTable'));
    }
    
}


function wec_run_deactivation() {
    wec_delete();
}

function wec_run_delete() {
    wec_uninstall(false, true);
    wec_delete();
}

function wec_scheduledTasks() {
    $recurrenceGenerator = new recurrenceGenerator();
    $recurrenceGenerator->destroyDeletedRecurrences();
}

function incrementWECqueries() {
    global $number_of_wec_queries,$wpdb,$wec_query_log;
    $wec_query_log[$number_of_wec_queries]['query'] = $wpdb->last_query;
    $number_of_wec_queries++;
}


function wec_displayqueries() {
    global $number_of_wec_queries,$wec_query_log;
    
    if (isset($_GET['wecdebugmode_queryNumber'])) {
        echo 'WEC did '.$number_of_wec_queries.' queries';
    }
    
    if (isset($_GET['wecdebugmode_queryLog'])) {
        echo 'Query Log';
        var_dump($wec_query_log);
    }
    
}


?>
