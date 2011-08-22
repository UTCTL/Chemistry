<?php 
class recurrence extends wec_db {
    var $ID;
    var $eventID;
    var $recurrenceStartTime;
    var $recurrenceEndTime;
    var $deleted;
    private $calendarID;
    
    /**
     * @classDescription: This class deals with recurrences. It provides functions used to
     * read and write them, and hooks into the data acess layer.
     * @param Integer $id[optional]
     */
    public function __construct($recurrenceID = null, $autoPopulate = true) {
        if (!is_null($recurrenceID)) {
            $this->setID($recurrenceID);
            $this->read();
        }
    }
    
    /**
     * A php 4x compatible constructor
     * @param Integer $id[optional]
     */
    public function recurrence($id = null) {
        __construct($id);
    }
    
    /**
     * Populates the data for this object
     * @return
     */
    private function populateData() {
        /**
         * @todo: USE OOP
         */
        $recurrenceData = recurrenceDA::lookupRecurrenceByRecurrenceID($this->getID());
        $this->setEventID($recurrenceData[0]['eventID']);
        $this->setDeleted($recurrenceData[0]['deleted']);
        $this->setRecurrenceStartTime($recurrenceData[0]['recurrenceStartTime']);
        $this->setRecurrenceEndTime($recurrenceData[0]['recurrenceEndTime']);
        
    }
    
    public function manuallyPopulateData($eventID, $deleted, $recurrenceStartTime, $recurrenceEndTime) {
        $this->setEventID($eventID);
        $this->setDeleted($deleted);
        $this->setRecurrenceStartTime($recurrenceStartTime);
        $this->setRecurrenceEndTime($recurrenceEndTime);
    }
    
    public function addPost($eventID, $recurrenceID) {
        //	$post = new calendarPost($eventID, $recurrenceID);
        //	$post->populateDataFromEvent();
        //	$post->add_post();
        //	echo 'Post Added<br />';
    }
    
    /**
     * Returns $recurrenceID.
     * @see recurrence::$recurrenceID
     */
    public function getID() {
        return $this->ID;
    }
    
    /**
     * Sets $recurrenceID.
     * @param object $recurrenceID
     * @see recurrence::$recurrenceID
     */
    public function setID($recurrenceID) {
        $this->ID = $recurrenceID;
    }
    
    /**
     * Returns $eventID.
     * @see recurrence::$eventID
     */
    public function getEventID() {
        return $this->eventID;
    }
    
    /**
     * Sets $eventID.
     * @param object $eventID
     * @see recurrence::$eventID
     */
    public function setEventID($eventID) {
        $this->eventID = $eventID;
    }
    
    /**
     * Returns $recurrenceEndTime.
     * @see recurrence::$recurrenceEndTime
     */
    public function getRecurrenceEndTime() {
        return $this->recurrenceEndTime;
    }
    
    /**
     * Sets $recurrenceEndTime.
     * @param object $recurrenceEndTime
     * @see recurrence::$recurrenceEndTime
     */
    public function setRecurrenceEndTime($recurrenceEndTime) {
        $this->recurrenceEndTime = $recurrenceEndTime;
    }
    
    /**
     * Returns $recurrenceStartTime.
     * @see recurrence::$recurrenceStartTime
     */
    public function getRecurrenceStartTime() {
        return $this->recurrenceStartTime;
    }
    
    /**
     * Sets $recurrenceStartTime.
     * @param object $recurrenceStartTime
     * @see recurrence::$recurrenceStartTime
     */
    public function setRecurrenceStartTime($recurrenceStartTime) {
        $this->recurrenceStartTime = $recurrenceStartTime;
    }
    
    public function deleteAllFutureRecurrences($recurrenceID) {
        recurrenceDA::deleteFutureRecurrences($recurrenceID);
    }
    
    public function deleteAllRecurrences($eventID) {
        recurrenceDA::deleteAllRecurrences($eventID);
    }
    
    public function deleteRecurrence($recurrenceID = null) {
        if (is_null($recurrenceID)) {
            recurrenceDA::hideRecurrence($this->getID());
        } else {
            recurrenceDA::hideRecurrence($recurrenceID);
        }
        
    }
    
    public function destroyRecurrence($recurrenceID) {
        recurrenceDA::deleteRecurrence($recurrenceID);
    }
    
    /**
     * Returns $deleted.
     * @see recurrence::$deleted
     */
    public function isDeleted() {
        if ($this->deleted == 1) {
            return true;
        } else {
            return false;
        }
    }
    
    /**
     * Sets $deleted.
     * @param object $deleted
     * @see recurrence::$deleted
     */
    public function setDeleted($deleted) {
        $this->deleted = $deleted;
    }
    
}

?>
