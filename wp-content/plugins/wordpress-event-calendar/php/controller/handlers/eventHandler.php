<?php 
/**
 *
 */
class eventHandler
{
    /**
     *
     * @return
     */
    function add()
    {
    
        $validator = new eventValidator();
        $tempEvent = new event();
        $tagDA = new tagDA();
        $continue = true;
        $errorMessage = '';

        
        if (wp_verify_nonce($_POST['_wpnonce'], 'editEvent'))
        {
        
            //===================================================
            // Validate the Name
            //===================================================
            
            if ($validator->validEventName($_POST['eventName']))
            {
                $tempEvent->setEventName($_POST['eventName']);
            }
            else
            {
                $continue = false;
                $errorMessage .= 'The name you have entered is too short<br />';
            }
            
            //===================================================
            // Validate the Description
            //===================================================
            if ($validator->validEventDescription($_POST['eventDescription']))
            {
                $tempEvent->setEventDescription($_POST['eventDescription']);
            }
            else
            {
                $continue = false;
                $errorMessage .= 'The description you have entered is too short<br />';
            }
            
            //===================================================
            // Validate the Excerpt
            //===================================================
            if ($validator->validEventExcerpt($_POST['eventExcerpt']))
            {
                $tempEvent->setEventExcerpt($_POST['eventExcerpt']);
            }
            else
            {
                $continue = false;
                $errorMessage .= 'The excerpt you have entered is too short<br />';
            }

            
            //===================================================
            // Convert the Time
            //===================================================
            
            //Retrieve the time fields and turn them into one cohesive field
            if ($_POST['startTimeHour'] != '12')
            {
                $eventStartTimeTemp = $_POST['startTimeHour'] + $_POST['startTimeAMPMSelect'].':'.$_POST['startTimeMin'];
            }
            else //if the user selected 12 o'clock
            {
                if ($_POST['startTimeAMPMSelect'] == '12') //and if they set it to PM
                { //don't add the 12 hours for PM
                    $eventStartTimeTemp = $_POST['startTimeHour'].':'.$_POST['startTimeMin'];
                }
                else
                { //and subtract the 12 hours for AM
                    $eventStartTimeTemp = $_POST['startTimeHour'] - $_POST['startTimeAMPMSelect'].':'.$_POST['startTimeMin'];
                }
            }
            
            //Retrieve the time fields and turn them into one cohesive field
            if ($_POST['endTimeHour'] != '12')
            {
                $eventEndTimeTemp = $_POST['endTimeHour'] + $_POST['endTimeAMPMSelect'].':'.$_POST['endTimeMin'];
            }
            else //if the user selected 12 o'clock
            {
                if ($_POST['startTimeAMPMSelect'] == '12') //and if they set it to PM
                { //don't add the 12 hours for PM
                    $eventEndTimeTemp = $_POST['endTimeHour'].':'.$_POST['endTimeMin'];
                }
                else
                { //and subtract the 12 hours for AM
                    $eventEndTimeTemp = $_POST['endTimeHour'] - $_POST['endTimeAMPMSelect'].':'.$_POST['endTimeMin'];
                }
            }

            
            //echo 'Start time from form: '.$eventStartTimeTemp.' <br />';
            //echo 'End   time from form: '.$eventEndTimeTemp.'<br />';

            
            //Turn these fields into timestamps
            $eventStartTimeTemp = $this->processTime($eventStartTimeTemp, $_POST['eventStartDate']);
            $eventEndTimeTemp = $this->processTime($eventEndTimeTemp, $_POST['eventEndDate']);

            
            //Change the timestamps to GMT for storage in the DB
            $timeManager = new dateTimeManager();
            
            //echo 'Start time before conversion: ' . $eventStartTimeTemp . ' <br />';
            //echo 'End   time before conversion: ' . $eventEndTimeTemp . '<br />';

            
            $eventStartTimeTemp = $timeManager->convertToSystemTime($eventStartTimeTemp);
            $eventEndTimeTemp = $timeManager->convertToSystemTime($eventEndTimeTemp);

            
            //===================================================
            //Validate the dates
            //===================================================
            if (!$validator->validDate($_POST['eventStartDate']))
            {
                $continue = false;
                $errorMessage .= 'The start date you specified for this event is invalid<br />';
            }

            
            if (!$validator->validDate($_POST['eventEndDate']))
            {
                $continue = false;
                $errorMessage .= 'The end date you specified for this event is invalid<br />';
            }
            
            //===================================================
            //Validate the start and end time
            //===================================================
            if ($validator->validDates($eventStartTimeTemp, $eventEndTimeTemp))
            {
                //Store the times in the object
                $tempEvent->setEventStartTime($eventStartTimeTemp);
                $tempEvent->setEventEndTime($eventEndTimeTemp);
                $tempEvent->setCreationTZ(wecUser::getUserLocale());
            }
            else
            {
                $continue = false;
                $errorMessage .= 'The event end time must be after the start time';
            }

            
            //===================================================
            // Process remaining fields
            //===================================================
            //Check if the checkbox for it being an all day event is checked
            if (isset($_POST['allDayEvent']))
            {
                $tempEvent->setIsAllDay(true);
            }
            else
            {
                $tempEvent->setIsAllDay(false);
            }
            
            $tempEvent->setRepeatFrequency($_POST['eventFrequency']);
            $tempEvent->setRepeatTimes($_POST['eventRepeatTimes']);
            $tempEvent->setrepeatEnd($_POST['eventFrequency']);
            
            //Check if the checkbox for it repeating forever is checked
            if (isset($_POST['repeatForever']))
            {
                $tempEvent->setrepeatForever(true);
            }
            else
            {
                $tempEvent->setrepeatForever(false);
            }
            
            $tempEvent->setLocation($_POST['eventLocation']);
            
            $tempEvent->setUrl($_POST['eventURL']);

            
            if (isset($_POST['eventCalendar']))
            {
                $tempEvent->setCalendarID($_POST['eventCalendar']);
            }
            
        }
        else
        {
            $continue = false;
            $errorMessage = 'Transaction validation failed. Please try submitting the form again';
        }

        
        //Only write the data to the DB if the data is actually valid!
        if ($continue)
        {
            global $current_user;
            
            $post = array();
            $post['comment_status'] = 'closed'; // 'closed' means no comments.
            $post['ping_status'] = 'closed'; // 'closed' means pingbacks or trackbacks turned off $post['post_author'] = $current_user->ID, //The user ID number of the author. $post['post_category']=>$_POST['post_category']; //Add some categories. $post['post_content'] = $tempEvent->eventDescription; //The full text of the post.
            $post['post_date_gmt'] = $tempEvent->getEventStartTime(); //The time post was made, in GMT.
            $post['post_excerpt]'] = $tempEvent->getEventExcerpt(); //For all your post excerpt needs.
            $post['post_name'] = $tempEvent->eventName; // The name (slug) for your post
            $post['post_status'] = 'event'; //Set the status of the new post.
            $post['post_title'] = sanitize_title($tempEvent->getEventName()); //The title of your post.
            $post['post_type'] = 'event'; //Sometimes you want to post a page.
            $post['tags_input'] = $_POST['tax_input']["post_tag"]; //For tags.
            $post['post_category'] = $_POST['post_category'];

            $tempEvent->setPostID(wp_insert_post($post));
            //Add the event, get the event ID from the add method
            $eventID = $tempEvent->add();
            //If the user specified a list of calendars that this event belongs to, then store that
            
            if (isset($_POST['categoryList']))
            {
                $calendarList = array();
                $i = 0;
                foreach ($_POST['categoryList'] as $calendarID)
                {
                    $eventCalendarMeta = new eventCalendarMeta();
                    $eventCalendarMeta->setCalendarID($calendarID);
                    $eventCalendarMeta->setEventID($eventID);
                    $eventCalendarMeta->add();
                }
                $tempEvent->setCalendars($calendarList);
            }
            new recurrenceGenerator();
            $page = new wec_backendListView();
            $page->display();
        }
        //Otherwise, go back to the same page in order to edit the fields
        else
        {
            raiserror($errorMessage);
            wec_FixInvalidEvent($_POST);
        }
    }
    /**
     *
     * @return
     */
    function read($eventID)
    {
        if ($eventID == null)
        {
            throw new Exception('No event ID specified for the read function of the event interface');
        }
        else
        {
            $tempEvent = new event($eventID);
        }
        return $tempEvent;
    }
    function readAll()
    {
        $eventDA = new eventDA();
        return $eventDA->getAllEvents();
    }
    /**
     *
     *
     @return
     
     *
     @param
     object $eventID[optional]
     */
    function update()
    {
        $validator = new eventValidator();
        $tempEvent = new event($_POST['eventID']);
        $continue = true;
        $clearRecurrences = false;
        $errorMessage = '';
		
		//===================================================
        // Update tag and category info first
        //===================================================
		$post = get_post($tempEvent->postID);
        $post->post_category = $_POST['post_category'];
        $post->post_content =  $tempEvent->eventDescription;
        $post->post_date_gmt = $tempEvent->eventStartTime;
        $post->post_excerpt = $tempEvent->eventExcerpt;
        $post->post_name = $tempEvent->eventName;
        $post->post_title = sanitize_title($tempEvent->eventName);
        $post->tags_input = $_POST['tax_input']["post_tag"];
        
        wp_update_post($post);
		
		
		
        //===================================================
        // Validate the Name
        //===================================================
        if ($validator->validEventName($_POST['eventName']))
        {
            $tempEvent->setEventName($_POST['eventName']);
        }
        else
        {
            $continue = false;
            $errorMessage .= 'The name you have entered is too short<br />';
        }
        //===================================================
        // Validate the Description
        //===================================================
        if ($validator->validEventDescription($_POST['eventDescription']))
        {
            $tempEvent->setEventDescription($_POST['eventDescription']);
        }
        else
        {
            $continue = false;
            $errorMessage .= 'The description you have entered is too short<br />';
        }
        //===================================================
        // Validate the Excerpt
        //===================================================
        if ($validator->validEventExcerpt($_POST['eventExcerpt']))
        {
            $tempEvent->setEventExcerpt($_POST['eventExcerpt']);
        }
        else
        {
            $continue = false;
            $errorMessage .= 'The excerpt you have entered is too short<br />';
        }
        //===================================================
        // Convert the Time
        //===================================================
        //Retrieve the time fields and turn them into one cohesive field
        if ($_POST['startTimeHour'] != '12')
        {
            $eventStartTimeTemp = $_POST['startTimeHour'] + $_POST['startTimeAMPMSelect'].':'.$_POST['startTimeMin'];
        }
        else //if the user selected 12 o'clock
        {
            if ($_POST['startTimeAMPMSelect'] == '12') //and if they set it to PM
            { //don't add the 12 hours for PM
                $eventStartTimeTemp = $_POST['startTimeHour'].':'.$_POST['startTimeMin'];
            }
            else
            { //and subtract the 12 hours for AM
                $eventStartTimeTemp = $_POST['startTimeHour'] - $_POST['startTimeAMPMSelect'].':'.$_POST['startTimeMin'];
            }
        }
        //Retrieve the time fields and turn them into one cohesive field
        if ($_POST['endTimeHour'] != '12')
        {
            $eventEndTimeTemp = $_POST['endTimeHour'] + $_POST['endTimeAMPMSelect'].':'.$_POST['endTimeMin'];
        }
        else //if the user selected 12 o'clock
        {
            if ($_POST['startTimeAMPMSelect'] == '12') //and if they set it to PM
            { //don't add the 12 hours for PM
                $eventEndTimeTemp = $_POST['endTimeHour'].':'.$_POST['endTimeMin'];
            }
            else
            { //and subtract the 12 hours for AM
                $eventEndTimeTemp = $_POST['endTimeHour'] - $_POST['endTimeAMPMSelect'].':'.$_POST['endTimeMin'];
            }
        }
        //Change the timestamps to GMT for storage in the DB
        $timeManager = new dateTimeManager();
        //echo 'Start time before conversion: ' . $eventStartTimeTemp . ' <br />';
        //echo 'End   time before conversion: ' . $eventEndTimeTemp . '<br />';
        //Turn these fields into timestamps
        $eventStartTimeTemp = $this->processTime($eventStartTimeTemp, $_POST['eventStartDate']);
        $eventEndTimeTemp = $this->processTime(
        $eventEndTimeTemp, $_POST['eventEndDate']);
        $eventStartTimeTemp = $timeManager->convertToSystemTime($eventStartTimeTemp);
        $eventEndTimeTemp = $timeManager->convertToSystemTime($eventEndTimeTemp);
        //===================================================
        //Validate the dates
        //===================================================
        if (!$validator->validDate($_POST['eventStartDate'

        ]))
        {
            $continue = false;
            $errorMessage .= 'The start date you specified for this event is invalid<br />';
        }
        if (!$validator->

        validDate($_POST['eventEndDate']))
        {
            $continue = false;
            $errorMessage .= 'The end date you specified for this event is invalid<br />';
        }
        //===================================================
        //Validate the start and end time
        //===================================================
        if ($validator->validDates($eventStartTimeTemp, $eventEndTimeTemp))
        {
            if ($eventStartTimeTemp != $tempEvent->getEventStartTime() || $eventEndTimeTemp != $tempEvent->getEventEndTime())
            {
                //invalidate recurences
                $clearRecurrences = true;
            }
            //Store the times in the object
            $tempEvent->setEventStartTime($eventStartTimeTemp);
            $tempEvent->setEventEndTime($eventEndTimeTemp);
        }
        else
        {
            $continue = false;
            $errorMessage .= 'The end time must be after the start time<br />';
        }
        //===================================================
        // Process remaining fields
        //===================================================
        //Check if the checkbox for it being an all day event is checked
        if (isset($_POST['allDayEvent']))
        {
            $tempEvent->setIsAllDay(
            true);
        }
        else
        {
            $tempEvent->setIsAllDay(false);
        }
        
        //===================================================
        // Handle changing repeat frequency or times
        //===================================================
        //If our frequency has changed, we need to clear all recurrences and change it, otherwise we'll leave it the same
        if (strcmp($tempEvent->getRepeatFrequency(), $_POST['eventFrequency']) != 0)
        {
            $clearRecurrences = true;
            $tempEvent->setRepeatFrequency($_POST['eventFrequency']);
        }
        //Same deal, if it's changed, redo all recurrences
        if ($_POST['eventRepeatTimes'] != $tempEvent->getRepeatTimes())
        {
            $clearRecurrences = true;
            $tempEvent->setRepeatTimes($_POST['eventRepeatTimes']);
        }
        //If anything significant changed then redo all the recurrences
        if ($clearRecurrences)
        {
            $recurrenceHandler = new recurrenceDA();
            $recurrenceHandler->deleteAllRecurrences($_POST['eventID']);
        }
        $tempEvent->setrepeatEnd($_POST['eventFrequency']);
        //Check if the checkbox for it repeating forever is checked
        if (isset($_POST['repeatForever']))
        {
            $tempEvent->setrepeatForever(true);
        }
        else
        {
            $tempEvent->setrepeatForever(false);
        }
        $tempEvent->setLocation($_POST['eventLocation']);
        $tempEvent->setUrl($_POST['eventURL']);
        if (isset($_POST['eventCalendar']))
        {
            $tempEvent->setCalendarID($_POST['eventCalendar']);
        }
        //Only write the data to the DB if the data is actually valid!
        if ($continue)
        {
            $tagDA = new tagDA();
            $categoryDA = new categoryDA();
			
			
            // =======================================================
		    // Add the event, get the event ID from the add method
			// =======================================================
			
            $tempEvent->update();
            adminAlertFade($tempEvent->getEventName().' has been updated');
            
			
            //Clear out the set calendars for this event, in order to write the new ones
            $eventCalendarMetaDA = new eventCalendarMetaDA();
            $eventCalendarMetaDA->delete($_POST['eventID']);
            //If the user specified a list of categories this event belongs to, then store that
            if (isset($_POST['categoryList']))
            {
                $calendarList = array();
                $i = 0;
                foreach ($_POST['categoryList'] as $calendarID)
                {
                    $eventCalendarMeta = new eventCalendarMeta();
                    $eventCalendarMeta->setCalendarID($calendarID);
                    $eventCalendarMeta->setEventID($_POST['eventID']);
                    $eventCalendarMeta->add();
                }
                $tempEvent->setCalendars($calendarList);
            }
            //Once we're done, go to the default view
            new recurrenceGenerator();
            $listview = new wec_backendListView();
            $listview->display();
        }
        //Otherwise, go back to the same page in order to edit the fields
        else
        {
            raiserror($errorMessage);
            wec_FixInvalidEvent($_POST);
        }
    }
    function delete($eventID = null)
    {
        if ($eventID == null)
        {
            throw new Exception('No event ID specified for the delete function of the event interface');
        }
        else
        {
            $tempEvent = new event($eventID, false);
            $tempEvent->delete();
            $tagDA = new tagDA();
            $tagDA->deleteTagsByEventID($eventID);
            $categoryDA = new categoryDA();
            $categoryDA->deleteCategoryRelationshipsByEventID($eventID);
            wp_delete_post($tempEvent->postID, true);
        }
    }
    /**
     
     *
     
     * @return The results of the
     add() function. This
     
     is
     
     just a wrapper.
     */
    function create()
    {
        eventInterface::add();
    }
    private function processTime($timeField, $dateField)
    {
        $timeManager = new dateTimeManager();
        //Turn the event time into an array of values with hours and minutes
        $startTimeArray = explode(':', $timeField);
        $hours = $startTimeArray[0];
        $minutes = $startTimeArray[1];
        //DateTimeStamp is a UNIX timestamp that represents the date of the event
        //in user time, with the comma removed. We implode and then explode it
        //to remove the comma.
        $dateTimeStamp = strtotime(implode('', explode(',', $dateField)));
        $yearNumber = $timeManager->getYear($dateTimeStamp);
        $monthNumber = $timeManager->getMonthNumber($dateTimeStamp);
        $dayNumber = $timeManager->getDayOfMonthNumber($dateTimeStamp);
        $timestamp = mktime($hours, $minutes, 0, $monthNumber, $dayNumber, $yearNumber);
        return $timestamp;
    }
    private function processBoolean($field)
    {
        //Check if the value is zero, if it is, set it to false, otherwise, set it to true
        if ( empty($field))
        {
            $temp = false;
        }
        else
        {
            $temp = true;
        }
        return $temp;
    }
    function lookupCalendarsForEvent($eventID = null)
    {
        if (isset($eventID))
        {
            $eventCalendarMetaDA = new eventCalendarMetaDA();
            return $eventCalendarMetaDA->lookupCalendarsForEvent($eventID);
        }
        else
        {
            throw new Exception('You must enter an eventID');
        }
    }
    private function createTagRelationships($eventID)
    {
        //if there were tags specified
        if (strlen($_POST['tax_input']["post_tag"]) > 0)
        {
            $tagDA = new tagDA();
            $tagsSent = explode(',', trim($_POST['tax_input']['post_tag']));
            $allTagNames = $tagDA->getAllTagNames();
            //make a list of tags that don't exist yet
            $tagsThatDontExist = array();
            $tagsThatDontExistIndex = 0;
            foreach ($tagsSent as $tag)
            {
                //if the tag name isn't in the list of tag names
                if (!in_array($tag, $allTagNames))
                {
                    //add it to the list
                    $tagsThatDontExist[$tagsThatDontExistIndex] = $tag;
                    $tagsThatDontExistIndex++;
                }
            }
            unset($tag);
            //add all the tags that don't exist yet to the database
            foreach ($tagsThatDontExist as $tag)
            {
                //	echo "<br />New Tag:" .$tag . "<br />";
                wp_insert_term($tag, "post_tag");
            }
            unset($tag);
            //get the list again
            $allTags = $tagDA->getAllTags();
            //if there are tags in the db now
            if (count($allTags) > 0)
            {
                //go through all the tags
                foreach ($allTags as $tag)
                {
                    if (in_array($tag["name"], $tagsSent))
                    { //if one of the tags is in the list of tags that were specified...
                        $tagDA->createTagRelationship($tag['id'], $eventID); //create a relationship for it
                    }
                }
            }
        }
    }
    private function createCategoryRelationships($eventID)
    {
        $categoryDA = new categoryDA();
        if (isset($_POST['post_category']))
        {
            foreach ($_POST['post_category'] as $categoryID)
            {
                $categoryDA->createCategoryRelationship($categoryID, $eventID);
            }
        }
    }
}

?>
