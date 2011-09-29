<?php 
class recurrenceDA {

    /**
     *
     * @return An associative array of values corresponding to an event
     * @param object $eventID
     */
    function lookupRecurrenceByRecurrenceID($recurrenceID) {
        global $wpdb;
        $query = 'SELECT * FROM '.WEC_RECURRENCE_TABLE.' WHERE recurrenceID='.$recurrenceID;
        incrementWECqueries();
        return $this->parseResultsToArrayOfObjects($wpdb->get_results($query, ARRAY_A));
    }
    
    function lookupRecurrencesByEventID($eventID) {
        global $wpdb;
        $query = 'SELECT recurrenceID FROM '.WEC_RECURRENCE_TABLE.' WHERE eventID='.$eventID.' ORDER BY recurrenceStartTime';
        incrementWECqueries();
        return $this->parseResultsToArrayOfObjects($wpdb->get_results($query, ARRAY_A));
    }
    
    function lookupAllRecurrences($excludeEventsThatHaveAlreadyHappened = true) {
        global $wpdb;
        if ($excludeEventsThatHaveAlreadyHappened) {
            $query = 'SELECT * FROM '.WEC_RECURRENCE_TABLE.' WHERE recurrenceEndTime > now() ORDER BY recurrenceStartTime';
        } else {
            $query = 'SELECT * FROM '.WEC_RECURRENCE_TABLE.' ORDER BY recurrenceStartTime';
        }
        
        return $this->parseResultsToArrayOfObjects($wpdb->get_results($query, ARRAY_A));
    }

    
    /**
     *
     * @return Returns an associative array of all the records matching the date parameters
     * in the recurrences table
     * @param object $startDate Accepts a UNIX style timestamp
     * @param object $endDate[optional] Accepts a UNIX style timestamp
     */
    function lookupRecurrenceByDate($startDate, $endDate = null) {
        global $wpdb;
        
        $timeManager = new dateTimeManager();
        
        if (is_null($endDate)) {
            $recurrenceDate = $timeManager->getSQLFormattedDate($startDate);
            $query = 'SELECT * FROM '.WEC_RECURRENCE_TABLE.' WHERE recurrenceStartTime='.$recurrenceDate;
            incrementWECqueries();
            return $this->parseResultsToArrayOfObjects($wpdb->get_results($query, ARRAY_A));
        } else {
            $query = 'SELECT * FROM '.WEC_RECURRENCE_TABLE.' WHERE recurrenceStartTime < '.$startDate.' and recurrenceEndTime > '.$endDate;
            incrementWECqueries();
            return $this->parseResultsToArrayOfObjects($wpdb->get_results($query, ARRAY_A));
        }
    }
    
    /**
     *
     * @return An associative array with the recurrences for this month
     * @param object $timestamp
     */
    function lookupRecurrencesByMonth($timestamp) {
    
        global $wpdb;
        $timeManager = new dateTimeManager();
        
        $timestampForThisMonth = $timeManager->getFirstSecondOfMonth($timestamp);
        $timestampForNextMonth = $timeManager->addMonthToTimestamp($timestampForThisMonth);
        
        $query = 'SELECT * FROM '.WEC_RECURRENCE_TABLE.' WHERE recurrenceStartTime > "'.$timestampForThisMonth.'" and recurrenceEndTime < "'.$timestampForNextMonth.'" ORDER BY recurrenceStartTime ASC';
        incrementWECqueries();
        return $this->parseResultsToArrayOfObjects($wpdb->get_results($query, ARRAY_A));
    }
    
    function deleteFutureRecurrences($recurrenceID) {
        global $wpdb;
        $recurrence = new recurrence($recurrenceID);
        $recurrenceDate = $recurrence->getRecurrenceStartTime();
        $eventID = $recurrence->getEventID();
        
        $query = 'update '.WEC_RECURRENCE_TABLE.' SET deleted = 1 WHERE eventID = '.$eventID.' and recurrenceStartTime >= "'.$recurrenceDate.'"';
        $wpdb->query($query);
        incrementWECqueries();
    }
    
    function deleteAllRecurrences($eventID) {
    
        global $wpdb;
        $query = 'delete from '.WEC_RECURRENCE_TABLE.' where eventID = '.$eventID;
        $wpdb->query($query);
        incrementWECqueries();
    }
    
    function countRecurrencesForEvent($eventID) {
    
        global $wpdb;
        $query = 'SELECT count(*) \'count\' FROM '.WEC_RECURRENCE_TABLE.' where eventID = '.$eventID;
        $wpdb->get_var($query);
        incrementWECqueries();
    }
    
    function lookupEventsWithNoRecurrences() {
    
        global $wpdb;
        $query = 'SELECT eventID from '.WEC_EVENT_TABLE.' where eventID not in(select distinct eventID from '.WEC_RECURRENCE_TABLE.')';
        incrementWECqueries();
        return $wpdb->get_results($query, ARRAY_A);
    }
    
    function lookupEventsWithNoPrimaryRecurrence() {
        //		global $wpdb;
        //		$query = 'select eventID from ' . WEC_EVENT_TABLE . ' where eventID not in(select distinct ' . WEC_EVENT_TABLE . '.eventID from ' . WEC_EVENT_TABLE . ' inner join ' . WEC_RECURRENCE_TABLE . ' on ' . WEC_EVENT_TABLE . '.eventID = ' . WEC_RECURRENCE_TABLE . '.eventID where ' . WEC_EVENT_TABLE . '.eventDate = ' . WEC_RECURRENCE_TABLE . '.eventDate)';
        //		return $wpdb->get_results ( $query, ARRAY_A );
    }
    
    function lookupOrphanedRecurrences() {
        global $wpdb;
        $query = 'select distinct eventID from '.WEC_RECURRENCE_TABLE.' where eventID not in(select eventID from '.WEC_EVENT_TABLE.' where 1=1)';
        incrementWECqueries();
        return $wpdb->get_results($query, ARRAY_A);
    }
    
    function hideRecurrence($recurrenceID) {
        global $wpdb;
        $query = 'update '.WEC_RECURRENCE_TABLE.' SET deleted = 1 WHERE recurrenceID = '.$recurrenceID;
        $wpdb->query($query);
        incrementWECqueries();
    }
    
    function lookupPrimaryRecurrenceID($eventID) {
        global $wpdb;
        $query = 'SELECT recurrenceID FROM '.WEC_RECURRENCE_TABLE.' WHERE eventID = '.$eventID.'  ORDER BY `recurrenceStartTime` LIMIT 1';
        incrementWECqueries();
        return $wpdb->get_var($query);
    }
    
    function lookupMonthsWithRecurrences() {
        global $wpdb;
        $query = 'select distinct from_unixtime(recurrenceStartTime, \'%M %Y\') \'name\' from '.WEC_RECURRENCE_TABLE.'  where deleted = 0';
        incrementWECqueries();
        return $wpdb->get_results($query, ARRAY_A);
    }
    
    function countRecurrences() {
        global $wpdb;
        $query = 'select count(*) from '.WEC_RECURRENCE_TABLE;
        incrementWECqueries();
        return $wpdb->get_var($query);
    }
    
    function lookupRecurrencesBeforeDate($timeStamp) {
        global $wpdb;
        $query = 'SELECT * FROM '.WEC_RECURRENCE_TABLE.' WHERE recurrenceStartTime <'.$timeStamp;
        incrementWECqueries();
        return $this->parseResultsToArrayOfObjects($wpdb->get_results($query, ARRAY_A));
    }
    
    function destroyDeletedRecurrences() {
        global $wpdb;
        $query = 'DELETE FROM '.WEC_RECURRENCE_TABLE.' WHERE deleted = 1';
        incrementWECqueries();
        return $wpdb->query($query);
    }
    
    //    function lookupByEventName($name) {
    //        global $wpdb;
    //        $query = 'SELECT * FROM '.WEC_RECURRENCE_TABLE.' inner join '.WEC_EVENT_TABLE.' on '.WEC_EVENT_TABLE.'.eventID = '.WEC_RECURRENCE_TABLE.'.eventID where eventName like \'%'.$name.'%\' order by recurrenceStartTime';
    //        incrementWECqueries();
    //        return $this->parseResultsToArrayOfObjects($wpdb->get_results($query, ARRAY_A));
    //    }
    //
    function parseResultsToArrayOfObjects($results) {
        if (! empty($results)) {
            //Convert these results into events
            $i = 0;
            $returnArray = array();
            foreach ($results as $result) {
                $tempRecurrence = new recurrence();
                
                //Set basics
                $tempRecurrence->setID($result['recurrenceID']);
                $tempRecurrence->setEventID($result['eventID']);
                
                //Set start + end times
                $tempRecurrence->setRecurrenceStartTime($result['recurrenceStartTime']);
                $tempRecurrence->setRecurrenceEndTime($result['recurrenceEndTime']);
                
                //Set is deleted?
                $tempRecurrence->setDeleted($result['deleted']);

                
                $returnArray[$i] = $tempRecurrence;
                $i++;
            }
            
            return $returnArray;

            
        }
    }
}
?>
