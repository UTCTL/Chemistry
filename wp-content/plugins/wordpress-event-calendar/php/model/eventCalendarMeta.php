<?php 
class eventCalendarMeta extends wec_db {

    var $eventID;
    var $calendarID;
    
    function __construct($eventID = null, $calendarID = null) {
        $this->setCalendarID($calendarID);
        $this->setEventID($eventID);
    }
    
    function delete() {
        $eventCalendarMetaDA = new eventCalendarMetaDA();
        $eventCalendarMetaDA->delete($this);
    }
    
    /**
     * Returns $calendarID.
     * @see eventCalendarMeta::$calendarID
     */
    public function getCalendarID() {
        return $this->calendarID;
    }
    
    /**
     * Sets $calendarID.
     * @param object $calendarID
     * @see eventCalendarMeta::$calendarID
     */
    public function setCalendarID($calendarID) {
        $this->calendarID = $calendarID;
    }
    
    /**
     * Returns $eventID.
     * @see eventCalendarMeta::$eventID
     */
    public function getEventID() {
        return $this->eventID;
    }
    
    /**
     * Sets $eventID.
     * @param object $eventID
     * @see eventCalendarMeta::$eventID
     */
    public function setEventID($eventID) {
        $this->eventID = $eventID;
    }
    
}

?>
