<?php 
function wec_checkInstall()
{
    if (is_admin())
    {
        $adminRoleManager = new adminRoleManager();
        
        if ($adminRoleManager->userIsAdminLevel())
        {
            $calendarPluginObject = new calendarPlugin();
            
            if (!$calendarPluginObject->isInstalled())
            {
                //Schedule WEC Daily Events
                wp_schedule_event(time(), 'daily', 'wec_scheduledTasks');
            }
            else
            {
                wec_update();
            }
        }
    }
}


function wec_update()
{
    if (get_option('wec_uninstalled'))
    { //Cheat to skip the updating if we're trying to uninstall
        //    echo 'uninstalled, skipping update';
        return;
    }
    
    //echo 'running update script - currently at version '.wec_checkVersion();
    global $wpdb;
    $count = 0;
    
    //Add Version Number Option
    add_option('wec_versionNumber', 0.1);

    
    if (wec_checkVersion() < 0.2)
    {
        //    echo 'adding primary tables';
        
        //Add Calendar Table
        $tableName = WEC_PREFIX.'wec_calendar';
        $query = 'CREATE TABLE IF NOT EXISTS '.$tableName.' (
			 	`calendarID` INT NOT NULL AUTO_INCREMENT,
		  		`name` TEXT NOT NULL,
		  		`color` VARCHAR(6),
				`slug` TEXT NOT NULL,
				`description` TEXT NOT NULL,
		  		PRIMARY KEY (`calendarID`)
				)
				CHARACTER SET utf8;';
				
        $wpdb->query($query);

        
        //Add Event Table
        $tableName = WEC_PREFIX.'wec_event';
        $query = 'CREATE TABLE IF NOT EXISTS '.$tableName.' (
				`eventID` INT NOT NULL AUTO_INCREMENT,
				`eventName` text NOT NULL,
				`eventDescription` text,
				`eventExcerpt` text,
				`eventStartTime` BIGINT,
				`eventEndTime` BIGINT,
				`isAllDay` BOOLEAN,
				`repeatTimes` INT,
				`repeatFrequency` text,
				`repeatEnd` MEDIUMINT,
				`repeatForever` BOOLEAN,
				`location` text,
				PRIMARY KEY (`eventID`)
				)
				
				CHARACTER SET utf8;';
				
        $wpdb->query($query);
        
        //Add recurrence table
        $tableName = WEC_PREFIX.'wec_recurrence';
        $query = 'CREATE TABLE IF NOT EXISTS '.$tableName.'
						(
						`recurrenceID` INTEGER NOT NULL AUTO_INCREMENT UNIQUE,
						`eventID` INTEGER,
						`recurrenceStartTime` BIGINT,
						`recurrenceEndTime` BIGINT,
						`deleted` TINYINT NOT NULL DEFAULT 0,
						PRIMARY KEY (`recurrenceID`)
						);';
						
        $wpdb->query($query);

        
        //Add custom recurrence table
        //			$tableName = WEC_PREFIX . 'wec_custom_recurrence';
        //			$query = 'CREATE TABLE IF NOT EXISTS ' . $tableName . '
        //						(
        //						`CustomID` INTEGER NOT NULL AUTO_INCREMENT  UNIQUE,
        //						`recurrenceID` INTEGER,
        //						`eventName` VARCHAR(100),
        //						`eventDescription` TEXT,
        //						`eventStartTime` BIGINT zerofill  unsigned,
        //						`eventEndTime` BIGINT zerofill  unsigned,
        //						`isAllDay` BOOLEAN,
        //						`repeatTimes` INT,
        //						`repeatEnd` DATE,
        //						`repeatForever` BOOLEAN,
        //						`location` VARCHAR(25),
        //						`CalendarID` INTEGER,
        //						PRIMARY KEY (`CustomID`)
        //						);';
        //
        //			$wpdb->query ( $query );
        
        //Add Feed Table
        $query = 'CREATE TABLE IF NOT EXISTS '.WEC_FEED_TABLE.'
				(
	  			`feedID` INT NOT NULL AUTO_INCREMENT,
	  			`name` TEXT NOT NULL,
	  			`slug` TEXT NOT NULL,
	  			`feedParameters` MEDIUMTEXT,
				`description` TEXT NOT NULL,
	  			PRIMARY KEY (`feedID`)
				)
				CHARACTER SET utf8;';
        $wpdb->query($query);
        
        $feed = new feed();
        $feed->setName('events');
        $feed->setSlug('events');
        $feed->setDescription('Events for '.get_bloginfo('name'));
        $defaultFeedID = $feed->add();
        add_option('wec_defaultFeedID', $defaultFeedID);
        
        //Add the Calendar-Event Meta Table
        $query = 'CREATE TABLE IF NOT EXISTS '.WEC_EVENT_CALENDAR_META_TABLE.'
			(
			`eventID` INTEGER NOT NULL,
			`calendarID` INTEGER NOT NULL,
			PRIMARY KEY (`eventID`,`calendarID`)
			);';
			
        $wpdb->query($query);
        
        //Add a default calendar option
        if (!get_option('wec_defaultCalendarID'))
        {
            $calendar = new Calendar();
            $calendar->setName('Default Calendar');
            $calendar->setSlug('events');
            $calendar->setDescription('A calendar containing all events');
            $calendarID = $calendar->add();
            add_option('wec_defaultCalendarID', $calendarID);
        }

        
        add_option('wec_autoGenerateRecurrences', true);
        add_option('wec_numberOfRecurrencesToCreateAtOnce', 100);
        add_option('wec_numberOfEventsToCreateForInfiniteRecurrences', 100);
        add_option('wec_autoDeleteRecurrencesAfter', 30);
        add_option('wec_numberOfDaysBeforeEventToPublishInRSSFeed', 30);

        
        wec_updateVersion(0.2);
        $message = 'WordPress Event Calendar updated to version 0.2';

        
        //Will be used to add the events category
        //			//Check if there is a category called events, if not create one!
        //			if(!is_term( 'events' , 'category' )){
        //				$catArray = array();
        //				$catArray['cat_name'] = 'events';
        //				$catArray['category_description'] = 'Events created by the WEC Plugin';
        //				$catArray['category_nicename'] = 'events';
        //				$idOfEventsCategory = wp_insert_category($catArray);
        //
        //
        //			}
    }
    
    if (wec_checkVersion() < 0.21)
    {
        //    echo 'updated to 0.21';
        
        //Add an option to set a default time zone
        add_option('wec_default_time_zone', 'ETC/GMT');
        wec_updateVersion(0.21);
        $message = 'WordPress Event Calendar updated to version 0.21';
    }
    
    if (wec_checkVersion() < 0.22)
    {
        //    echo 'updated to 0.22';
        wec_updateVersion(0.22);
        $message = 'WordPress Event Calendar updated to version 0.22';
    }
    
    if (wec_checkVersion() < 0.24)
    {
    
        //check if this field exists before trying to create it. suppresses a nasty db error
        $query = "SHOW columns from  ".WEC_PREFIX.'wec_event';
        $checkQueryResult = $wpdb->get_results($query, ARRAY_A);
        
        $urlFieldExists = false;
        
        foreach ($checkQueryResult as $result)
        {
            if ($result['Field'] == 'url')
            {
                $urlFieldExists = true;
            }
            
        }
        
        if (!$urlFieldExists)
        {
            $query = "ALTER TABLE ".WEC_PREFIX.'wec_event'." add `url` varchar(255) null after `location`";
            $wpdb->query($query);
        }
        
        wec_updateVersion(0.24);
        $message = 'WordPress Event Calendar updated to version 0.24';
    }

    
    if (wec_checkVersion() < 0.25)
    {
        $query = "CREATE TABLE IF NOT EXISTS ".WEC_EVENT_CATEGORY_TABLE." (";
        $query .= "`eventID` int(11) NOT NULL DEFAULT '0',";
        $query .= "`categoryID` int(11) NOT NULL DEFAULT '0',";
        $query .= "PRIMARY KEY (`eventID`,`categoryID`)";
        $query .= ") ENGINE=MyISAM DEFAULT CHARSET=utf8";
        
        $wpdb->query($query);

        
        $query = "CREATE TABLE IF NOT EXISTS ".WEC_EVENT_TAG_TABLE." (";
        $query .= "`eventID` int(11) NOT NULL DEFAULT '0',";
        $query .= "`tagID` int(11) NOT NULL DEFAULT '0',";
        $query .= "PRIMARY KEY (`eventID`,`tagID`)";
        $query .= ") ENGINE=MyISAM DEFAULT CHARSET=utf8";
        
        $wpdb->query($query);
        
        wec_updateVersion(0.25);
        $message = 'WordPress Event Calendar updated to version 0.25';
        
    }
    
    if (wec_checkVersion() < 0.26)
    {
        wec_updateVersion(0.26);
        $message = 'WordPress Event Calendar updated to version 0.26';
    }
    
    if (wec_checkVersion() < 0.27)
    {
		$tableName = WEC_PREFIX.'wec_event';


		//check if this field exists before trying to create it. suppresses a nasty db error
        $query = "SHOW columns from  $tableName";
        $checkQueryResult = $wpdb->get_results($query, ARRAY_A);

    
    	$creationTZFieldExists = false;
        $postIDFieldExists = false;
        
        foreach ($checkQueryResult as $result)
        {
            if ($result['Field'] == 'creationTZ')
            {
                $creationTZFieldExists = true;
            }
            
            if ($result['Field'] == 'postID')
            {
                $postIDFieldExists = true;
            }
        }
        
        
        
        if (!$creationTZFieldExists)
        {
    		//add the creation tz column
    		$query = "ALTER TABLE $tableName ADD COLUMN `creationTZ` VARCHAR(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL AFTER `url`;";
    	
    		$wpdb->query($query);
		}
	
	
		if(!$postIDFieldExists)
		{
			//add the event ID column
			$query = "ALTER TABLE $tableName ADD COLUMN `postID` INT(128) NULL DEFAULT 0  AFTER `creationTZ`;";
			$wpdb->query($query);
		}
		

        wec_updateVersion(0.27);
        $message = 'WordPress Event Calendar updated to version 0.27';
    }
    
    if (isset($message))
    {
        raiserror($message);
    }

    
    if (wec_checkVersion() < wec_currentVersion())
    {
        raiserror('An error occured updating WEC');
    }
    
}

/**
 * Runs when the plugin is deactivated
 *
 */
function wec_delete()
{
    wp_clear_scheduled_hook('wec_scheduledTasks');
    delete_option('wec_uninstalled');
}

/**
 * Uninstaller function
 * @return boolean value based on success
 */
function wec_uninstall($reinstalling = false, $auto = false)
{

    global $wpdb;
    $query = 'drop table if exists '.WEC_EVENT_TABLE.', '.WEC_CALENDAR_TABLE.', '.WEC_RECURRENCE_TABLE.', '.WEC_FEED_TABLE.', '.WEC_CUSTOM_RECURRENCE_TABLE.','.WEC_EVENT_CALENDAR_META_TABLE.','.WEC_EVENT_TAG_TABLE.','.WEC_EVENT_CATEGORY_TABLE;
    $wpdb->query($query);
    
    wec_deleteOptions();
    add_option('wec_uninstalled', 1);
    
    if (!$reinstalling && !$auto)
    {
        adminAlert('All CalendarBuilder data has been erased, however you still must manually deactivate the plugin <a href=\''.get_bloginfo('url').'/wp-admin/plugins.php\'>here</a>');
    }
}


function wec_deleteOptions()
{

    delete_option('wec_autoGenerateRecurrences');
    delete_option('wec_numberOfRecurrencesToCreateAtOnce');
    delete_option('wec_numberOfEventsToCreateForInfiniteRecurrences');
    delete_option('wec_autoDeleteRecurrencesAfter');
    delete_option('wec_numberOfDaysBeforeEventToPublishInRSSFeed');
    delete_option('wec_defaultCalendarID');
    delete_option('wec_versionNumber');
    delete_option('wec_defaultFeedID');
    delete_option('wec_allowExternalAccess');
    delete_option('wec_default_time_zone');
}

function wec_reinstaller()
{
    wec_uninstall(true);
    wec_install();
    
    adminAlert('CalendarBuilder has been reset');
}
?>
