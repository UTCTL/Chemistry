<?php 
class eventCalendarMetaDA {
    function lookupCalendarsForEvent($eventID) {
        incrementWECqueries();
        global $wpdb;
        
        if (isset($eventID)) {
            $query = 'select calendarID from '.WEC_EVENT_CALENDAR_META_TABLE.' where eventID = '.$eventID;
            $calendarIDs = $wpdb->get_results($query, ARRAY_A);
            
            $calendarList = array();
            $i = 0;
            
            //If this event does have calendars
            if (isset($calendarIDs)) {
                //And if we have more than one
                if (is_array($calendarIDs)) {
                    //Loop through each one, making a calendar object from each
                    foreach ($calendarIDs as $a) {
                    
                        $calendar = new Calendar($a['calendarID']);
                        $calendarList[$i] = $calendar;
                        $i++;
                    }
                }
                //If we only have one
                else {
                    $calendar = new Calendar($calendarIDs);
                    $calendarList[0]['calendarID'] = $calendar;
                }
                
            }

            
            return $calendarList;
            
        } else {
            throw new Exception('You must enter an event ID');
        }
        
    }
    
    function lookupEventsForCalendar() {
        incrementWECqueries();
        global $wpdb;

        
    }
    
    function delete($eventID) {
        incrementWECqueries();
        global $wpdb;
        $query = 'DELETE FROM '.WEC_EVENT_CALENDAR_META_TABLE.' WHERE eventID='.$eventID;
        $wpdb->query($wpdb->prepare($query));
    }
	
	function deleteMetaByCalendarID($calendarID){
		incrementWECqueries();
        global $wpdb;
        $query = 'DELETE FROM '.WEC_EVENT_CALENDAR_META_TABLE.' WHERE calendarID='.$calendarID;
        $wpdb->query($wpdb->prepare($query));
	}
    
    function lookupAll() {
        incrementWECqueries();
        global $wpdb;
        $query = 'select * from '.WEC_EVENT_CALENDAR_META_TABLE;
        return $wpdb->get_results($query, ARRAY_N);
    }
    
    function cleanOrphans() {
        incrementWECqueries();
        global $wpdb;
        $query = 'delete from '.WEC_EVENT_CALENDAR_META_TABLE.' where eventID not in (select eventID from '.WEC_EVENT_TABLE.')';
        return $wpdb->get_results($query, ARRAY_N);
    }
}

?>
