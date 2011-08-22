<?php 
class eventDA {
    /**
     * Gets all the data for all the events in the db
     * @return An associative array of values for all events
     */
    function getAllEvents() {
        global $wpdb;
        $query = 'SELECT * FROM '.WEC_EVENT_TABLE.' ORDER BY eventID';
        incrementWECqueries();
        return $this->parseResultsToArrayOfObjects($wpdb->get_results($query, ARRAY_A));
    }
    
    /**
     *
     * @return An associative array of values corresponding to an event
     * @param object $eventID
     */
    function lookupEventByID($eventID) {
        incrementWECqueries();
        if (is_null($eventID)) {
            throw new Exception('You must provide an event ID');
        }
        
        global $wpdb;
        $query = 'SELECT * FROM '.WEC_EVENT_TABLE.' WHERE eventID='.$eventID;
        return $wpdb->get_results($query, ARRAY_A);
    }
    
    /**
     *
     * @return An associative array with the events for this month
     * @param object $timestamp
     */
    function lookupEventsByMonth($timestamp) {
        incrementWECqueries();
        global $wpdb;
        $timeManager = new dateTimeManager();
        
        $timestampForThisMonth = $timeManager->getFirstSecondOfMonth($timestamp);
        $timestampForNextMonth = $timeManager->addMonthToTimestamp($timestampForThisMonth);
        
        $query = 'SELECT * FROM '.WEC_EVENT_TABLE.' WHERE eventStartTime > "'.$timestampForThisMonth.'" and eventEndTime < "'.$timestampForNextMonth.'" ORDER BY eventStartTime ASC';
        return $wpdb->get_results($query, ARRAY_A);
    }

    
    /**
     * Delete a single event
     * @return - Nothing
     * @param Integer $eventID
     */
    function deleteEvent($eventID) {
        incrementWECqueries();
        //echo 'Running Delete Event Script<br />';
        global $wpdb;
        $query = 'DELETE from '.WEC_EVENT_TABLE.' WHERE eventID='.$eventID;
        $wpdb->query($query);
        
        $query = 'DELETE from '.WEC_EVENT_CALENDAR_META_TABLE.' WHERE eventID='.$eventID;
        $wpdb->query($query);
        
    }
    
    /**
     * Get the events that recur forever
     * @return - Returns an associative array of all the events that recur forever
     */
    function getInfiniteRecurrenceEvents() {
        incrementWECqueries();
        global $wpdb;
        $query = 'SELECT eventID from '.WEC_EVENT_TABLE.' where repeatForever = 1';
        return $wpdb->get_results($query, ARRAY_A);
    }
    
    /**
     * Get the events that recur, but not infinitely
     * @return - Returns an associative array of all the events that recur
     */
    function getLimitedRecurrenceEvents() {
        incrementWECqueries();
        global $wpdb;
        $query = 'SELECT eventID, repeatTimes from '.WEC_EVENT_TABLE.' where repeatTimes > 0';
        return $wpdb->get_results($query, ARRAY_A);
    }
    
    /**
     * This function will count the recurrences that an event has.
     * @return - Returns an integer
     * @param Integer $eventID
     */
    function countEventRecurrences($eventID) {
        incrementWECqueries();
        global $wpdb;
        $query = 'SELECT count(*) FROM '.WEC_RECURRENCE_TABLE.' WHERE eventID ='.$eventID;
        return $wpdb->get_var($query);
    }
    
    /**
     * This function will return the event frequency
     * @return - Returns a character value
     * @param Integer $eventID
     */
    function getEventFrequency($eventID) {
        incrementWECqueries();
        global $wpdb;
        $query = 'select repeatFrequency from '.WEC_EVENT_TABLE.' where eventID = '.$eventID;
        return $wpdb->get_var($query);
    }
    
    /**
     * Selects the date of the original event
     * @return - Returns a timestamp of the original event date
     * @param Integer $eventID
     */
    function getOriginalEventDate($eventID) {
        incrementWECqueries();
        global $wpdb;
        $query = 'SELECT eventStartTime from '.WEC_EVENT_TABLE.' where eventID = '.$eventID;
        return $wpdb->get_var($query);
    }
    
    /**
     * Selects the number of recurrences that an event should have
     * @return - Returns an integer value
     * @param Integer $eventID
     */
    function getAllowedRecurrences($eventID) {
        incrementWECqueries();
        global $wpdb;
        $query = 'select repeatTimes from '.WEC_EVENT_TABLE.' where eventID = '.$eventID;
        return $wpdb->get_var($query);
    }
    
    function getWidowedEvents() {
        incrementWECqueries();
        global $wpdb;
        $query = 'select eventID from '.WEC_EVENT_TABLE.' where eventID not in (select eventID from '.WEC_RECURRENCE_TABLE.')';
        return $wpdb->get_results($query, ARRAY_A);
    }
    
    function getEventsWithRecurrencesThatHaveNotHappenedYet() {
        incrementWECqueries();
        global $wpdb;
        $query = 'SELECT distinct '.WEC_EVENT_TABLE.'.eventID FROM '.WEC_EVENT_TABLE.' inner join '.WEC_RECURRENCE_TABLE.' on '.WEC_EVENT_TABLE.'.eventID = '.WEC_RECURRENCE_TABLE.'.eventID where recurrenceStartTime > 1245338460 order by eventID';
        return $wpdb->get_results($query, ARRAY_N);
    }
    
    function lookupEventsByName($name) {
        incrementWECqueries();
        global $wpdb;
        $name = like_escape($name);
        $name = '"%'.$name.'%"';
        $query = 'SELECT * FROM '.WEC_EVENT_TABLE.' WHERE eventName like '.$name;
        $results = $wpdb->get_results($query, ARRAY_A);
        
        return $this->parseResultsToArrayOfObjects($results);
    }
	
    function parseResultsToArrayOfObjects($results) {
        if (! empty($results)) {
            //Convert these results into events
            $i = 0;
            $returnArray = array();
            foreach ($results as $result) {
                $event = new event();
                
                //Set basics
                $event->setID($result['eventID']);
                $event->setEventName($result['eventName']);
                $event->setEventDescription($result['eventDescription']);
                $event->setEventExcerpt($result['eventExcerpt']);
                
                //Set start + end times
                $event->setIsAllDay($result['isAllDay']);
                $event->setEventStartTime($result['eventStartTime']);
                $event->setEventEndTime($result['eventEndTime']);
                
                //Set repeat details
                $event->setRepeatTimes($result['repeatTimes']);
                $event->setRepeatFrequency($result['repeatFrequency']);
                $event->setRepeatEnd($result['repeatEnd']);
                $event->setRepeatForever($result['repeatForever']);
                
                //Set location
                $event->setLocation($result['location']);
                
				//Set TZ info
				$event->setCreationTZ($result['creationTZ']);
				
				//set postID
				$event->setPostID($result['postID']);
				
                $returnArray[$i] = $event;
                $i++;
            }
            
            return $returnArray;
        }
    }
}

?>
