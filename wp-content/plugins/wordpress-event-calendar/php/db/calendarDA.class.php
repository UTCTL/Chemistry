<?php 
class calendarDA {
    /**
     * Gets all the calendars
     * @return - Returns an associative array of all the calendar data
     */
    function getAllCalendars() {
        global $wpdb;
        $query = 'SELECT * FROM '.WEC_CALENDAR_TABLE.' ORDER BY calendarID ASC';
        $calendarData = $wpdb->get_results($query, ARRAY_A);
        
        incrementWECqueries();
        return $this->parseResultsToArrayOfObjects($calendarData);
    }
    
    function getAllEditableCalendars() {
        global $wpdb;
        $query = 'SELECT * FROM '.WEC_CALENDAR_TABLE.' WHERE calendarID != '.get_option('wec_defaultCalendarID').' ORDER BY calendarID ASC';
        
        $calendarData = $wpdb->get_results($query, ARRAY_A);
        
        incrementWECqueries();
        return $this->parseResultsToArrayOfObjects($calendarData);
    }
    
    function getAllRecurrencesOnCalendar($calendarID) {
        $recurrenceDA = new recurrenceDA();
        
        global $wpdb;
        $query = 'SELECT * '.'FROM '.WEC_CALENDAR_TABLE.' inner join '.WEC_EVENT_CALENDAR_META_TABLE.' on '.WEC_CALENDAR_TABLE.'.calendarID '.' = '.WEC_EVENT_CALENDAR_META_TABLE.'.calendarID '.'inner join '.WEC_RECURRENCE_TABLE.' on '.WEC_RECURRENCE_TABLE.'.eventID = '.''.WEC_EVENT_CALENDAR_META_TABLE.'.eventID  WHERE '.WEC_CALENDAR_TABLE.'.calendarID '.'= '.$calendarID.' ORDER BY '.WEC_RECURRENCE_TABLE.'.recurrenceStartTime';
        
        incrementWECqueries();
        return $recurrenceDA->parseResultsToArrayOfObjects($wpdb->get_results($query, ARRAY_A));
    }
    
    function getAllRecurrencesOnCalendars($arrayOfCalendarIDs) {
        $recurrenceDA = new recurrenceDA();
        global $wpdb;
        
        $whereClause = '';
        $i = 1;
        $numberOfIDs = count($arrayOfCalendarIDs);
        
        if (! empty($arrayOfCalendarIDs)) {
            foreach ($arrayOfCalendarIDs as $id) {
                if ($i == 0) {
                    $whereClause .= 'calendarID='.$id;
                    
                } elseif ($i == $numberOfIDs) {
                    $whereClause .= 'calendarID='.$id;
                } else {
                    $whereClause .= 'calendarID='.$id.' OR ';
                }
                $i++;
                
            }
        }

        
        $query = 'SELECT * FROM '.WEC_RECURRENCE_TABLE.' inner join '.WEC_EVENT_CALENDAR_META_TABLE.' on '.WEC_EVENT_CALENDAR_META_TABLE.'.eventID = '.WEC_RECURRENCE_TABLE.'.eventID where '.$whereClause.' order by recurrenceStartTime';
        
        // var_dump($query);
        $results = $wpdb->get_results($query, ARRAY_A);
        incrementWECqueries();
        return $recurrenceDA->parseResultsToArrayOfObjects($results);
    }
    
    function getAllEventsOnCalendar($calendarID) {
        $eventDA = new eventDA();
        global $wpdb;
        $query = 'SELECT '.WEC_EVENT_TABLE.'.eventID '.'FROM '.WEC_CALENDAR_TABLE.' inner join '.WEC_EVENT_CALENDAR_META_TABLE.' on '.WEC_CALENDAR_TABLE.'.calendarID '.' = '.WEC_EVENT_CALENDAR_META_TABLE.'.calendarID '.'inner join '.WEC_EVENT_TITLE.' on '.WEC_EVENT_TITLE.'.eventID = '.''.WEC_EVENT_CALENDAR_META_TABLE.'.eventID  WHERE '.WEC_CALENDAR_TABLE.'.calendarID '.'= '.$calendarID.' ORDER BY '.WEC_EVENT_TABLE.'.eventStartTime';
        incrementWECqueries();
        return $eventDA->parseResultsToArrayOfObjects($wpdb->get_results($query, ARRAY_A));
    }
    
    /**
     *
     * @return Returns an associative array of values
     * @param object $calendarID The ID of the calendar that we are looking up.
     */
    function lookupCalendarByCalendarID($calendarID) {
        global $wpdb;
        
        if (! empty($calendarID)) {
            $query = 'SELECT * FROM '.WEC_CALENDAR_TABLE.' WHERE calendarID='.$calendarID;
            incrementWECqueries();
            return $wpdb->get_results($query, ARRAY_A);
        } else {
            throw new Exception('You must provide a calendar ID');
        }
        
    }
    
    function lookupCalendarByRecurrenceID($recurrenceID) {
        global $wpdb;
        
        if (! empty($recurrenceID)) {
        
            $query = 'select * from '.WEC_CALENDAR_TABLE.' inner join '.WEC_EVENT_CALENDAR_META_TABLE.' '.'on '.WEC_EVENT_CALENDAR_META_TABLE.'.calendarID = '.WEC_CALENDAR_TABLE.'.calendarID inner join '.WEC_EVENT_TABLE.' on '.WEC_EVENT_TABLE.'
			.eventID = '.WEC_EVENT_CALENDAR_META_TABLE.'.eventID inner join '.WEC_RECURRENCE_TABLE.' on '.WEC_EVENT_TABLE.'.eventID = '.WEC_RECURRENCE_TABLE.'.eventID WHERE recurrenceID = '.$recurrenceID.' group by '.WEC_RECURRENCE_TABLE.'.eventID';
			
            incrementWECqueries();
            return $wpdb->get_results($query, ARRAY_A);
        } else {
            throw new Exception('You must provide a recurrence ID');
        }
    }

    
    function lookupCalendarByEventID($eventID) {
        global $wpdb;
        
        if (! empty($eventID)) {
        
            $query = 'select * from '.WEC_CALENDAR_TABLE.' inner join '.WEC_EVENT_CALENDAR_META_TABLE.' '.'on '.WEC_EVENT_CALENDAR_META_TABLE.'.calendarID = '.WEC_CALENDAR_TABLE.'.calendarID inner join '.WEC_EVENT_TABLE.' on '.WEC_EVENT_TABLE.'
			.eventID = '.WEC_EVENT_CALENDAR_META_TABLE.'.eventID'.' WHERE '.WEC_EVENT_TABLE.'.eventID = '.$eventID.' group by '.WEC_EVENT_TABLE.'.eventID';
			
            incrementWECqueries();
            return $wpdb->get_results($query, ARRAY_A);
        } else {
            throw new Exception('You must provide an event ID');
        }
    }

    
    /**
     * This function deletes a calendar from the db
     * @return - nothing
     * @param Integer $calendarID
     */
    function deleteCalendar($calendarID) {
        global $wpdb;
        
        $query = 'UPDATE '.WEC_EVENT_CALENDAR_META_TABLE.' SET calendarID='.get_option('wec_defaultCalendarID').' WHERE calendarID = '.$calendarID;
        $wpdb->query($query);
        
        $query = 'DELETE from '.WEC_CALENDAR_TABLE.' WHERE calendarID='.$calendarID;
        $wpdb->query($query);
        incrementWECqueries();
    }
    
    function getCalendarsByID($arrayOfIDs) {
        global $wpdb;
        $whereclause = '';
        
        for ($i = 0; $i < count($arrayOfIDs); $i++) {
            if ($i < count($arrayOfIDs) - 1) {
                $whereclause .= 'calendarID = '.$arrayOfIDs[$i].' OR ';
            } else {
                $whereclause .= 'calendarID = '.$arrayOfIDs[$i];
            }
        }
        
        $query = 'select * from '.WEC_CALENDAR_TABLE.' where '.$whereclause;
        incrementWECqueries();
        return $this->parseResultsToArrayOfObjects($wpdb->get_results($query, ARRAY_A));
    }
    
    function parseResultsToArrayOfObjects($results) {
        if (! empty($results)) {
            //Convert these results into events
            $i = 0;
            $returnArray = array();
            foreach ($results as $result) {
                $calendar = new calendar(null, false);
                $calendar->setID($result['calendarID']);
                $calendar->setName($result['name']);
                $calendar->setSlug($result['slug']);
                $calendar->setDescription($result['description']);
                $returnArray[$i] = $calendar;
                $i++;
            }
            
            return $returnArray;
        } else {
            return null;
        }
    }
}

?>
