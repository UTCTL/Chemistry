<?php 
/**
 * This is the event model
 */
class event extends wec_db
{
    var $ID;
    var $eventName;
    var $eventDescription;
    var $eventExcerpt;
    var $eventStartTime;
    var $eventEndTime;
    var $isAllDay;
    var $repeatTimes;
    var $repeatFrequency;
    var $repeatEnd;
    var $repeatForever;
    var $location;
    var $url;
    var $creationTZ;
    var $postID;
    
    /**
     * @var This is an array of all the recurrences for this event (at least as many as are specified in the options)
     */
    //private $recurrences = array();
    //private $calendars = array();
    
    function __construct($eventID = null, $autoPopulate = true)
    {
        //If we are given an ID
        if (! empty($eventID))
        {
            $this->setID($eventID);
            
            if ($autoPopulate)
            {
                $this->populateData();
            }
        }
    }
    
    /**
     * This function fills out the object using the database
     * @return
     */
    function populateData()
    {
    
        //Create DA Objects
        $eventCalendarMetaDA = new eventCalendarMetaDA();
        $eventDA = new eventDA();
        
        //LookupData
        $eventInfo = $eventDA->lookupEventByID($this->getID());
        $eventInfo = $eventInfo[0];

        
        $this->setEventName($eventInfo['eventName']);
        $this->setEventDescription($eventInfo['eventDescription']);
        $this->setEventExcerpt($eventInfo['eventExcerpt']);
        $this->setEventStartTime($eventInfo['eventStartTime']);
        $this->setEventEndTime($eventInfo['eventEndTime']);
        $this->setIsAllDay($eventInfo['isAllDay']);
        $this->setRepeatTimes($eventInfo['repeatTimes']);
        $this->setRepeatFrequency($eventInfo['repeatFrequency']);
        $this->setRepeatEnd($eventInfo['repeatEnd']);
        $this->setRepeatForever($eventInfo['repeatForever']);
        $this->setLocation($eventInfo['location']);
        $this->setUrl($eventInfo['url']);
		$this->setCreationTZ($eventInfo['creationTZ']);
		$this->setPostID($eventInfo['postID']);
    }
    
    /**
     * Returns $eventDescription.
     * @see event::$eventDescription
     */
    public function getEventDescription()
    {
        return stripslashes($this->eventDescription);
    }
    
    /**
     * Sets $eventDescription.
     * @param object $eventDescription
     * @see event::$eventDescription
     */
    public function setEventDescription($eventDescription)
    {
        $this->eventDescription = trim(attribute_escape($eventDescription));
    }
    
    /**
     * Returns $eventEndTime.
     * @see event::$eventEndTime
     */
    public function getEventEndTime()
    {
        return $this->eventEndTime;
    }
    
    /**
     * Sets $eventEndTime.
     * @param object $eventEndTime
     * @see event::$eventEndTime
     */
    public function setEventEndTime($eventEndTime)
    {
        $this->eventEndTime = $eventEndTime;
    }
    
    /**
     * Returns $eventExcerpt.
     * @see event::$eventExcerpt
     */
    public function getEventExcerpt()
    {
        return stripslashes($this->eventExcerpt);
    }
    
    /**
     * Sets $eventExcerpt.
     * @param object $eventExcerpt
     * @see event::$eventExcerpt
     */
    public function setEventExcerpt($eventExcerpt)
    {
        $this->eventExcerpt = attribute_escape($eventExcerpt);
    }
    
    /**
     * Returns $ID.
     * @see event::$eventID
     */
    public function getID()
    {
        return $this->ID;
    }
    
    /**
     * Sets $eventID.
     * @param object $eventID
     * @see event::$eventID
     */
    public function setID($ID)
    {
        $this->ID = $ID;
    }
    
    /**
     * Returns $eventName.
     * @see event::$eventName
     */
    public function getEventName()
    {
        return stripslashes($this->eventName);
    }
    
    /**
     * Sets $eventName.
     * @param object $eventName
     * @see event::$eventName
     */
    public function setEventName($eventName)
    {
        $this->eventName = attribute_escape($eventName);
    }
    
    /**
     * Returns $eventStartTime.
     * @see event::$eventStartTime
     */
    public function getEventStartTime()
    {
        return $this->eventStartTime;
    }
    
    /**
     * Sets $eventStartTime.
     * @param object $eventStartTime
     * @see event::$eventStartTime
     */
    public function setEventStartTime($eventStartTime)
    {
        $this->eventStartTime = $eventStartTime;
    }
    
    /**
     * Returns $isAllDay.
     * @see event::$isAllDay
     */
    public function getIsAllDay()
    {
        return $this->isAllDay;
    }
    
    /**
     * Sets $isAllDay.
     * @param object $isAllDay
     * @see event::$isAllDay
     */
    public function setIsAllDay($isAllDay)
    {
        $this->isAllDay = $isAllDay;
    }
    
    /**
     * Returns $location.
     * @see event::$location
     */
    public function getLocation()
    {
        return stripslashes($this->location);
    }
    
    /**
     * Sets $location.
     * @param object $location
     * @see event::$location
     */
    public function setLocation($location)
    {
        $this->location = attribute_escape($location);
    }
    
    /**
     * Returns $repeatEnd.
     * @see event::$repeatEnd
     */
    public function getRepeatEnd()
    {
        return $this->repeatEnd;
    }
    
    /**
     * Sets $repeatEnd.
     * @param object $repeatEnd
     * @see event::$repeatEnd
     */
    public function setRepeatEnd($repeatEnd)
    {
        $this->repeatEnd = $repeatEnd;
    }
    
    /**
     * Returns $repeatForever.
     * @see event::$repeatForever
     */
    public function getRepeatForever()
    {
        return $this->repeatForever;
    }
    
    /**
     * Sets $repeatForever.
     * @param object $repeatForever
     * @see event::$repeatForever
     */
    public function setRepeatForever($repeatForever)
    {
        $this->repeatForever = $repeatForever;
    }
    
    /**
     * Returns $repeatFrequency.
     * @see event::$repeatFrequency
     */
    public function getRepeatFrequency()
    {
        return $this->repeatFrequency;
    }
    
    /**
     * Sets $repeatFrequency.
     * @param object $repeatFrequency
     * @see event::$repeatFrequency
     */
    public function setRepeatFrequency($repeatFrequency)
    {
        $this->repeatFrequency = $repeatFrequency;
    }
    
    /**
     * Returns $repeatTimes.
     * @see event::$repeatTimes
     */
    public function getRepeatTimes()
    {
        return $this->repeatTimes;
    }
    
    /**
     * Sets $repeatTimes.
     * @param object $repeatTimes
     * @see event::$repeatTimes
     */
    public function setRepeatTimes($repeatTimes)
    {
        $this->repeatTimes = $repeatTimes;
    }
    
    /**
     * Returns $recurrences.
     * @see event::$recurrences
     */
    public function getRecurrences()
    {
        return $this->recurrences;
    }
    
    /**
     * Sets $recurrences.
     * @param object $recurrences
     * @see event::$recurrences
     */
    public function setRecurrences($recurrences)
    {
        $this->recurrences = $recurrences;
    }

    
    /**
     * Returns $calendars.
     * @see event::$calendars
     */
    public function getCalendars()
    {
        return $this->calendars;
    }
    
    /**
     * Sets $calendars.
     * @param object $calendars
     * @see event::$calendars
     */
    public function setCalendars($calendars)
    {
        $this->calendars = $calendars;
    }

    
    /**
     * Returns $url.
     *
     * @see event::$url
     */
    public function getUrl()
    {
        return $this->url;
    }
    
    /**
     * Sets $url.
     *
     * @param object $url
     * @see event::$url
     */
    public function setUrl($url)
    {
        $this->url = $url;
    }

    
    /**
     * Returns $creationTZ.
     *
     * @see event::$creationTZ
     */
    public function getCreationTZ()
    {
        if ( empty($this->creationTZ))
        {
            $this->creationTZ = get_option('wec_default_time_zone');
        }
        
        return $this->creationTZ;
    }
    
    /**
     * Sets $creationTZ.
     *
     * @param object $creationTZ
     * @see event::$creationTZ
     */
    public function setCreationTZ($creationTZ)
    {
        $this->creationTZ = $creationTZ;
    }

    
    /**
     * Returns $postID.
     *
     * @see event::$postID
     */
    public function getPostID()
    {
        return $this->postID;
    }
    
    /**
     * Sets $postID.
     *
     * @param object $postID
     * @see event::$postID
     */
    public function setPostID($postID)
    {
        $this->postID = $postID;
    }
}
?>
