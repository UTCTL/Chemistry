<?php 
/**
 * @comingsoon
 */
class customRecurrence extends wec_db {
    var $customID;
    var $date;
    var $startTime;
    var $endTime;
    var $location;
    var $description;

    
    function __construct($recurrenceID, $eventID = null) {
        //If we don't have an event ID
        if ( empty($eventID)) {
        
        }

        
    }

    
}

?>
