<?php

if (phpversion() < 5)
{
    die ('Sorry, but this plugin requires PHP 5 to function properly. Please update your server, then try again');
}

if(!wp_timezone_supported())
{
    die ('Sorry, but this plugin requires PHP 5.2 with PHP date functions in order to function properly. Please update your server, then try again');
}

global $wpdb;

define('WEC_PREFIX', $wpdb->prefix);
define('WEC_CALENDAR_TABLE', ''.DB_NAME.'.'.WEC_PREFIX.'wec_calendar'.'');
define('WEC_EVENT_TABLE', ''.DB_NAME.'.'.WEC_PREFIX.'wec_event'.'');
define('WEC_RECURRENCE_TABLE', ''.DB_NAME.'.'.WEC_PREFIX.'wec_recurrence');
define('WEC_CUSTOM_RECURRENCE_TABLE', ''.DB_NAME.'.'.WEC_PREFIX.'wec_custom_recurrence');
define('WEC_FEED_TABLE', ''.DB_NAME.'.'.WEC_PREFIX.'wec_feed');
define('WEC_EVENT_CALENDAR_META_TABLE', ''.DB_NAME.'.'.WEC_PREFIX.'wec_eventCalendarMeta');
define('WEC_EVENT_CATEGORY_TABLE', ''.DB_NAME.'.'.WEC_PREFIX.'wec_event_category_relationships');
define('WEC_EVENT_TAG_TABLE', ''.DB_NAME.'.'.WEC_PREFIX.'wec_event_tag_relationships');


define('INSTALLED_FOLDER_NAME', '/'.str_replace(" ", "%20", basename(dirname( __FILE__ ))));


//Installer
require_once ('php/installer.php');

//Controllers
require_once ('php/controller/calendarPlugin.class.php');
require_once ('php/controller/adminActions.class.php');
require_once ('php/controller/optionsActions.class.php');
require_once ('php/controller/wecUser.class.php');
require_once ('php/controller/generators/feedGenerator.class.php');
require_once ('php/controller/generators/recurrenceGenerator.class.php');
require_once ('php/controller/WEC_Query.php');

//Handlers
require_once ('php/controller/handlers/calendarHandler.php');
require_once ('php/controller/handlers/eventHandler.php');
require_once ('php/controller/handlers/recurrenceHandler.php');
require_once ('php/controller/handlers/filterHandler.php');
require_once ('php/controller/handlers/optionsHandler.php');
require_once ('php/controller/handlers/feedHandler.php');
require_once ('php/controller/handlers/calendarSelectionHandler.php');
require_once ('php/controller/handlers/calendarSelectionSession.php');
require_once ('php/controller/handlers/calendarSession.php');



//Validation
require_once ('php/controller/validation/ajax/support/ajaxValidationSupport.php');

	//Calendar Validation
	require_once ('php/controller/validation/calendarValidator.php');
	require_once ('php/controller/validation/ajax/create/calendar.php');
	require_once ('php/controller/validation/ajax/edit/calendar.php');
	
	//Event Validation
	require_once ('php/controller/validation/eventValidator.php');
	
	//Feed Validation
	require_once ('php/controller/validation/feedValidator.php');


//Support
require_once ('php/support/adminSupport.php');
require_once ('php/support/debugging.class.php');
require_once ('php/support/dateTimeManager.class.php');
require_once ('php/support/adminMessages.php');
require_once ('php/support/textFunctions.php');

//Model
require_once ('php/model/Object.class.php');
require_once ('php/db/wec_db.php');
require_once ('php/model/feed.class.php');
require_once ('php/model/calendar.class.php');
require_once ('php/model/event.class.php');
require_once ('php/model/recurrence.class.php');
require_once ('php/model/customRecurrence.class.php');
require_once ('php/model/eventCalendarMeta.php');
require_once ('php/model/resultset.php');
require_once ('php/model/calendarView.php');
require_once ('php/model/calendarUserView.php');

//Database Access Objects
require_once ('php/db/tagDA.php');
require_once ('php/db/categoryDA.php');
require_once ('php/db/eventDA.class.php');
require_once ('php/db/recurrenceDA.class.php');
require_once ('php/db/calendarDA.class.php');
require_once ('php/db/feedDA.class.php');
require_once ('php/db/eventCalendarMetaDA.php');

//Views
require_once ('html/manage/calendarView.php');
require_once ('html/manage/calendarUserView.php');
require_once ('html/manage/listView.class.php');
//require_once ('html/widget/widgets.php');


//Admin Pages

	//Interface Elements
	
	//Create Events
	require_once ('html/event/create_event.php');
	require_once ('html/event/edit_event.php');
	require_once ('html/event/fix_invalid_event.php');
	
	//Manage Section
	require_once ('html/templates/manage/adminHeader.php');
	require_once ('html/templates/manage/adminWrapper.php');
	
	//Options Section
	require_once ('html/templates/options/adminOptionsHeader.php');
	require_once ('html/templates/options/optionsWrapper.php');
	require_once ('calendarOptions.php');
	
	//Calendar Editing
	require_once ('html/calendar/manageCalendars.php');
	require_once ('html/calendar/create_calendar.php');
	require_once ('html/calendar/edit_calendar.php');
	
	//Feed Editing
	require_once ('html/feed/manageFeeds.php');
	require_once ('html/feed/edit_feed.php');
	
	
//Options
require_once ('html/options/mainOptions.php');
require_once ('html/options/setUserTimeZone.php');
require_once ('html/options/setSystemTimeZone.php');
		
	//Uninstaller
	require_once ('html/options/uninstall.php');

//User Role Manager
require_once('php/controller/adminRoleManager.class.php');

//External Access Manager
require_once('php/controller/externalAccess.class.php');

?>
