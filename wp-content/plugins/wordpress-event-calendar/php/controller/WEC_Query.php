<?php 
/**
 * The query object
 *
 *
 */
 
class WEC_Query
{
    /**
     * The query. It makes this whole thing go
     *
     * @var query
     */
    var $query;
    
    /**
     * The parts of the query
     *
     * @var partsArray
     */
    var $partsArray = array();
    
    /**
     * @var Recurrences[]
     */
    var $pagedResultSet = null;
    
    var $pageToDisplay = 1;
    
    var $resultSet = array();
    /**
     * This is the recurrence that we are currently on
     *
     * @var Recurrence
     */
    var $recurrence;
    
    /**
     * This is the number of items that are in this query
     *
     * @var Integer
     */
    var $numberOfItems;
    
    /**
     * This is the index of the recurrence array that we're at right now
     * @var Integer
     */
    var $currentItem = -1;
    
    /**
     * The event for the recurrence we're working with at the moment
     *
     * @var Event
     */
    var $event;
    
    /**
     * A list of events, used when we only want events, and don't care
     * about recurrences
     *
     * @var eventList
     */
    var $eventList;
    
    /**
     *
     *
     * @var A list of events that are paged for display
     */
    var $pagedEventList;
    
    /**
     * The calendar for the event for the recurrence we're working with at the moment
     *
     * @var Calendar
     */
    var $calendar;
    
    /**
     * This boolean flag is true if there has been a filter applied to
     * the query. It allows whatever is displaying the results to pick
     * that up, and pull out the query variables.
     *
     * @var filterApplied
     */
    var $filterApplied;
    
    /**
     * This boolean flag is true if there has been a filter applied to
     * the query. It allows whatever is displaying the results to pick
     * that up, and pull out the query variables.
     *
     * @var filterApplied
     */
    var $unfilteredResults;
    
    /**
     * This determines the mode that the query is running in. It defaults
     * to recurrence mode, but can be put into events mode to gather events
     * instead of recurrences
     *
     * @var mode
     */
    var $mode;
    
    /**
     * This holds the timezone object for the query, and makes sure the times are
     * displayed correctly
     * @var timezone
     */
    var $timezone;

    
    function __construct($query = null)
    {
        $this->pagedResultSet = new resultset();
        $this->mode = 'recurrence';
        $this->query = $query;
        $this->parseQuery();
    }
    
    function WEC_Query($query = null)
    {
        __construct($query);
    }
    
    function query($query)
    {
        $this->query = $query;
        $this->parseQuery();
    }
    
    function changeQuery($query)
    {
        $this->query = $query;
        $this->parseQueryParts();
    }
    
    function parseQueryParts()
    {
        $queryParts = explode(',', $this->query);
        
        $i = 0;
        
        //Create an array with all parts of the query broken up
        foreach ($queryParts as $part)
        {
            $data = explode('=', $part);
            if (isset($data[0]) && isset($data[1]))
            {
                $this->partsArray[trim($data[0])] = $data[1];
            }
        }
        
        //Turn the list of calendars back into an array, if it is one
        if (isset($this->partsArray['calendarID']))
        {
            //Check if the calendar ID part has an &
            if (strstr($this->partsArray['calendarID'], '&'))
            {
                $this->partsArray['calendarID'] = explode('&', $this->partsArray['calendarID']);
            }
        }
    }
    
    function checkMode()
    {
        $this->parseQueryParts();
        
        if (isset($this->partsArray['mode']))
        {
            $this->mode = $this->partsArray['mode'];
        }
        
        $this->partsArray = null;
    }
    
    function parseQuery()
    {
        $this->checkMode();
        $this->pagedResultSet->clear();
        $eventHandler = new eventHandler();
        $recurrenceHandler = new recurrenceHandler();
        
        $eventDA = new eventDA();
        $recurrenceDA = new recurrenceDA();
        
        //=======================================
        //
        //  If we are in event mode
        //
        //=======================================
        if ($this->mode == 'event')
        {
        
            //If this object has been instantiated without a query
            //we just display everything
            
            if (is_null($this->query))
            {
                $eventData = $eventHandler->readAll();
                $i = 0;
                
                //Don't do anything if we don't have any recurrences
                if (isset($eventData))
                {
                
                    $i = 0;
                    foreach ($eventData as $event)
                    {
                        $this->resultSet[$i] = $event;
                        $this->pagedResultSet->add($event);
                        $i++;
                    }
                }
            }
            else
            {
                //Parse the query!
                $this->parseQueryParts();

                
                //Specifying a recurrence ID or event ID is the highest priority item, so
                //deal with it only
                if (! empty($this->partsArray['eventID']) || ! empty($this->partsArray['recurrenceID']))
                {
                
                    //If both are specified, then get the event ID
                    if (! empty($this->partsArray['eventID']) && ! empty($this->partsArray['recurrenceID']))
                    {
                        $this->resultSet[0] = new event($this->partsArray['eventID']);
                        $this->pagedResultSet->add($this->resultSet[0]);
                    }
                    
                    //If only the eventID is specified, get just this event
                    elseif (! empty($this->partsArray['eventID']) && empty($this->partsArray['recurrenceID']))
                    {
                        $this->resultSet[0] = new event($this->partsArray['eventID']);
                        $this->pagedResultSet->add($this->resultSet[0]);
                    }
                    
                    //If only the recurrenceID is specified
                    elseif ( empty($this->partsArray['eventID']) && ! empty($this->partsArray['recurrenceID']))
                    {
                        //Build a recurrence based on the ID, in order to get the event ID
                        $tempRecurrence = new recurrence($this->partsArray['recurrenceID']);
                        $tempEvent = new event($tempRecurrence->getEventID());
                        $this->resultSet[0] = $tempEvent;
                        $this->pagedResultSet->add($tempEvent);
                    }
                    else
                    {
                        $this->resultSet = null;
                    }
                }
                elseif (! empty($this->partsArray['name']))
                {
                    $eventData = $eventDA->lookupEventsByName($this->partsArray['name']);
                    $i = 0;
                    
                    //Don't do anything if we don't have any recurrences
                    if (isset($eventData))
                    {
                        $i = 0;
                        foreach ($eventData as $event)
                        {
                            $this->resultSet[$i] = $event;
                            $this->pagedResultSet->add($event);
                            $i++;
                        }
                    }
                }
                //If nothing in this list was specified, lets get it all
                else
                {
                    $eventData = $eventHandler->readAll();
                    $i = 0;
                    
                    //Don't do anything if we don't have any recurrences
                    if (isset($eventData))
                    {
                        $i = 0;
                        foreach ($eventData as $event)
                        {
                            $this->resultSet[$i] = $event;
                            $this->pagedResultSet->add($event);
                            $i++;
                        }
                    }
                }
            }
        }
        
        //============================================================================
        //																			||
        //																			||
        //  					If we are in recurrence mode						||
        //																			||
        //																			||
        //============================================================================
        else
        {
        
            //If this object has been instantiated without a query
            //we just display everything
            
            if (is_null($this->query))
            {
            
                $recurrenceData = $recurrenceDA->lookupAllRecurrences();
                
                //Don't do anything if we don't have any recurrences
                if (isset($recurrenceData))
                {
                
                    $i = 0;
                    foreach ($recurrenceData as $recurrence)
                    {
                        if (!$recurrence->isDeleted())
                        {
                            $this->resultSet[$i] = $recurrence;
                            $this->pagedResultSet->add($recurrence);
                            $i++;
                        }
                    }
                    
                }
            }
            else
            {
                //Parse the query!
                $this->parseQueryParts();

                
                //Specifying a recurrence ID or event ID is the highest priority item, so
                //deal with it only
                if (! empty($this->partsArray['eventID']) || ! empty($this->partsArray['recurrenceID']))
                {
                
                    //If some genuis specifies both, then use only the recurrenceID
                    if (! empty($this->partsArray['eventID']) && ! empty($this->partsArray['recurrenceID']))
                    {
                        $recurrence = recurrenceInterface::read($this->partsArray['recurrenceID']);
                        
                        $this->resultSet[0] = $recurrence;
                        $this->pagedResultSet->add($recurrence);
                        
                    }
                    
                    //If only the eventID is specified, get all the recurrences for this event
                    elseif (! empty($this->partsArray['eventID']) && empty($this->partsArray['recurrenceID']))
                    {
                        $tempData = recurrenceDA::lookupRecurrencesByEventID($this->partsArray['eventID']);
                        
                        //Check if any values were returned. If not, do nothing
                        if (!is_null($tempData))
                        {
                            $i = 0;
                            foreach ($tempData as $recurrence)
                            {
                                $tempRecurrence = recurrenceInterface::read($recurrence['recurrenceID']);
                                $this->resultSet[$i] = $tempRecurrence;
                                $this->pagedResultSet->add($tempRecurrence);
                                $i++;
                            }
                        }
                    }
                    
                    //If only the recurrenceID is specified
                    elseif ( empty($this->partsArray['eventID']) && ! empty($this->partsArray['recurrenceID']))
                    {
                        $recurrence = recurrenceInterface::read($this->partsArray['recurrenceID']);
                        $this->resultSet[0] = $recurrence;
                        $this->pagedResultSet->add($recurrence);
                    }
                    else
                    {
                        $this->resultSet = null;
                    }
                }
                elseif (! empty($this->partsArray['name']))
                {
                    $recurrenceData = $recurrenceDA->lookupByEventName($this->partsArray['name']);
                    
                    $i = 0;
                    
                    //Don't do anything if we don't have any recurrences
                    if (isset($recurrenceData))
                    {
                        foreach ($recurrenceData as $recurrence)
                        {
                            if (!$recurrence->isDeleted())
                            {
                                $this->resultSet[$i] = $recurrence;
                                $this->pagedResultSet->add($recurrence);
                                $i++;
                            }
                            
                        }
                    }
                    
                }
                //If nothing in this list was specified, lets get it all
                else
                {
                
                    $recurrenceData = $recurrenceDA->lookupAllRecurrences();
                    $i = 0;
                    
                    //Don't do anything if we don't have any recurrences
                    if (isset($recurrenceData))
                    {
                        foreach ($recurrenceData as $recurrence)
                        {
                            if (!$recurrence->isDeleted())
                            {
                                $this->resultSet[$i] = $recurrence;
                                $this->pagedResultSet->add($recurrence);
                                $i++;
                            }
                            
                        }
                    }
                }
            }
        }

        
        $this->applyCalendarFilter();
        $this->applyDateFilter(false);
        
        //Unless directed otherwise, apply a filter that will
        //make sure that events that have already happened don't show up!
        if (get_option('wec_hideEventsThatHaveAlreadyHappened'))
        {
            if (isset($this->partsArray['show']))
            {
                //If part of the query says 'show=all' then we show everything
                if (strcasecmp($this->partsArray['show'], 'all') != 0)
                {
                    $this->applyAfterTodayFilter();
                }
            }
            else
            {
                $this->applyAfterTodayFilter();
            }
        }
        
        //Truncate the list
        $this->applyLimitFilter(false);
        
        //Count up what we have so we know for the loop
        $this->numberOfItems = count($this->resultSet);
    }
    
    function applyDateFilter($customFiltered = true)
    {
        //Apply Full Date Filter
        if (! empty($this->partsArray['startDate']) && ! empty($this->partsArray['endDate']))
        {
            $timeManager = new dateTimeManager();
            
            //Store what's in here for later in case we need it again
            if ($customFiltered)
            {
                $this->unfilteredResults = $this->resultSet;
            }
            
            $i = 0;
            $tempResultSet = array();
            $this->pagedResultSet->clear();
            
            $startDate = $timeManager->convertToSystemTime($this->partsArray['startDate']);
            $endDate = $timeManager->convertToSystemTime($this->partsArray['endDate']);
            
            foreach ($this->resultSet as $result)
            {
                if ($result->getRecurrenceStartTime() > $startDate && $result->getRecurrenceStartTime() < $endDate)
                {
                    $tempResultSet[$i] = $result;
                    $this->pagedResultSet->add($result);
                    $i++;
                }
            }
            $this->resultSet = $tempResultSet;
        }
        elseif (! empty($this->partsArray['startDate']))
        {
            $i = 0;
            $tempResultSet = array();
            $this->pagedResultSet->clear();
            
            $startDate = $timeManager->convertToSystemTime($this->partsArray['startDate']);
            
            foreach ($this->resultSet as $result)
            {
                if ($result->getRecurrenceStartTime() > $startDate)
                {
                    $tempResultSet[$i] = $result;
                    $this->pagedResultSet->add($result);
                    $i++;
                    
                }
            }
            
            $this->resultSet = $tempResultSet;
            
        }
        elseif (! empty($this->partsArray['endDate']))
        {
            $i = 0;
            $tempResultSet = array();
            
            $endDate = $timeManager->convertToSystemTime($this->partsArray['endDate']);
            
            $this->pagedResultSet->clear();
            
            foreach ($this->resultSet as $result)
            {
                if ($result->getRecurrenceStartTime() < $endDate)
                {
                    $tempResultSet[$i] = $result;
                    $this->pagedResultSet->add($result);
                    $i++;
                    
                }
            }
            
            $this->resultSet = $tempResultSet;
            $this->isFiltered(true);
            
        }
    }
    
    function applyAfterTodayFilter()
    {
        $i = 0;
        $tempResultSet = array();
        $this->pagedResultSet->clear();
        
        $startDate = gmdate('U');
        
        //If we are in event mode scroll through checking event start times
        if ($this->mode == 'event')
        {
            $eventDA = new eventDA;
            $eventsWithRecurrencesThatHaveNotHappenedYet = $eventDA->getEventsWithRecurrencesThatHaveNotHappenedYet();

            
            foreach ($this->resultSet as $result)
            {
                // Check if this event happens after the start date, or
                // if it still has recurrences that haven't happened yet
                if ($result->getEventEndTime() > $startDate || in_array(array($result->getID()), $eventsWithRecurrencesThatHaveNotHappenedYet))
                {
                
                    $tempResultSet[$i] = $result;
                    $this->pagedResultSet->add($result);
                    $i++;
                }
                
            }
        }

        
        //If we are in recurrence mode, scroll through checking recurrence start times
        else
        {
        
            foreach ($this->resultSet as $result)
            {
                if ($result->getRecurrenceEndTime() > $startDate)
                {
                    $tempResultSet[$i] = $result;
                    $this->pagedResultSet->add($result);
                    $i++;
                }
            }
            
        }
        
        $this->resultSet = $tempResultSet;
    }
    
    function applyLimitFilter($customFiltered = true)
    {
        //Apply Limit Filter
        if (! empty($this->partsArray['limit']))
        {
            if ($customFiltered)
            {
                $this->unfilteredResults = $this->resultSet;
            }
            
            $limit = $this->partsArray['limit'];
            
            $this->resultSet = array_slice($this->resultSet, 0, $limit);
            
            $this->pagedResultSet->clear();
            
            foreach ($this->resultSet as $result)
            {
                $this->pagedResultSet->add($result);
            }
            
            $this->isFiltered(true);
        }
    }
    
    function applyCalendarFilter()
    {
        //If we have a calendarID specified
        if (! empty($this->partsArray['calendarID']))
        {
            //Prepare for new results
            $this->pagedResultSet->clear();
            $i = 0;
            $tempResultSet = array();
            
            //Create Database Access Objects
            $calendarMetaDA = new eventCalendarMetaDA();
            $calendarDA = new calendarDA();
            
            //=================================================
            //if somebody passes in an array of calendars
            //=================================================
            if (is_array($this->partsArray['calendarID']))
            {
            
                $listOfEventsAlreadyInList = array();
                $j = 0;
                
                //if it's an event
                if ($this->mode == 'event')
                {
                
                }
                //=================================================
                //if it's a recurrence
                //=================================================
                else
                {
                    $listOfEventCalendarRelationships = $calendarMetaDA->lookupAll();
                    if (! empty($listOfEventCalendarRelationships))
                    {

                    
                        foreach ($this->partsArray['calendarID'] as $id)
                        {
                            foreach ($this->resultSet as $result)
                            {
                            
                                if (in_array(array($result->getEventID(), $id), $listOfEventCalendarRelationships))
                                {
                                
                                    //This prevents us from having duplicates by storing all the event ids already here
                                    if (!in_array($result->getID(), $listOfEventsAlreadyInList))
                                    {
                                    
                                        $tempResultSet[$i] = $result;
                                        $this->pagedResultSet->add($result);
                                        $i++;
                                        
                                        //Add this item to the list of events already in the list
                                        $listOfEventsAlreadyInList[$j] = $result->getID();
                                        $j++;
                                    }
                                    
                                }
                                
                            }
                        }
                    }
                    
                }
            }
            //In this case we only want a listing of one calendar
            else
            {
            
                //Lookup all the upcoming event recurrences in this calendar
                if (calendarHandler::calendarExists($this->partsArray['calendarID']))
                {
                
                    $arrayOfRecurrencesOnThisCalendar = $calendarDA->getAllRecurrencesOnCalendar($this->partsArray['calendarID']);
                    $i = 0;
                    
                    //If there are actually events on this calendar, and those events have recurrences...
                    if (isset($arrayOfRecurrencesOnThisCalendar))
                    {
                        //Build an object array of all the recurrences on this calendar
                        foreach ($arrayOfRecurrencesOnThisCalendar as $recurrence)
                        {
                            $tempResultSet[$i] = $recurrence;
                            $this->pagedResultSet->add($recurrence);
                            $i++;
                        }
                    }
                }
            }
            $this->resultSet = $tempResultSet;
        }
    }

    
    function unfilterResults()
    {
        $this->resultSet = $this->unfilteredResults;
        $this->numberOfItems = count($this->resultSet);
        $this->currentItem = -1;
    }
    
    /**
     * Alias for nextRecurrence
     * @return result of nextRecurrence
     */
    function theEvent()
    {
        return $this->goToNextItem();
    }
    
    /**
     * Alias for theEvent
     * @return result of nextRecurrence
     */
    function the_event()
    {
        return $this->theEvent();
    }
    
    /**
     * Moves the pointer on the query forward
     * @return the next item in the query that is happening
     */
    private function goToNextItem()
    {
        $this->currentItem++;
        
        //If we are in event mode
        if ($this->mode == 'event')
        {
            $this->event = $this->resultSet[$this->currentItem];
            $this->calendar = calendarDA::lookupCalendarByEventID($this->event->getID());
            
            return $this->event;
        }
        //If we are in recurrence mode
        else
        {
            $this->recurrence = $this->resultSet[$this->currentItem];
            $this->event = new event($this->recurrence->getEventID());
            /**
             * @todo: This is crazy inefficient!
             */
            $this->calendar = calendarDA::lookupCalendarByRecurrenceID($this->recurrence->getID());
            
            return $this->recurrence;
        }
        
    }
    
    function haveEvents()
    {
    
        if ($this->currentItem + 1 < $this->numberOfItems)
        {
            return true;
        }
        elseif ($this->numberOfItems == 0)
        {
            return false;
        }
        elseif ($this->currentItem + 1 == $this->numberOfItems && $this->numberOfItems > 0)
        {
            return false;
        }
    }
    
    function getEventTitle()
    {
        return $this->event->getEventName();
    }

    
    //=========================================
    // eventTitle
    //=========================================
    function eventTitle()
    {
        echo $this->getEventTitle();
    }
    function getTheTitle()
    {
        return $this->getEventTitle();
    }
    function theTitle()
    {
        $this->eventTitle();
    }

    
    //=========================================
    // eventDescription
    //=========================================
    function eventDescription()
    {
        echo $this->getEventDescription();
    }
    function getEventDescription()
    {
        return $this->event->getEventDescription();
    }
    function theDescription()
    {
        $this->eventDescription();
    }
    
    //=========================================
    // eventExcerpt
    //=========================================
    function eventExcerpt()
    {
        echo $this->getEventExcerpt();
    }
    function getEventExcerpt()
    {
        return $this->event->getEventExcerpt();
    }
    function theExcerpt()
    {
        $this->eventExcerpt();
    }
    
    //=========================================
    // eventLocation
    //=========================================
    function eventLocation()
    {
        echo $this->getEventLocation();
    }
    function getEventLocation()
    {
        return $this->event->getLocation();
    }
    function theLocation()
    {
        $this->eventLocation();
    }
    
    //=========================================
    // eventURL
    //=========================================
    function eventURL()
    {
        echo $this->event->getUrl();
    }
    function geteventURL()
    {
        return $this->event->getUrl();
    }
    function theURL()
    {
        $this->eventURL();
    }
    
    //=========================================
    // eventID
    //=========================================
    function eventID()
    {
        echo $this->getEventID();
    }
    function getEventID()
    {
        return $this->event->getID();
    }
    function theEventID()
    {
        $this->eventID();
    }
    
    //=========================================
    // recurrenceID
    //=========================================
    function recurrenceID()
    {
        echo $this->recurrence->getID();
    }
    
    function getRecurrenceID()
    {
        return $this->recurrence->getID();
    }
    
    /**
     * @todo Function is definitely not stable
     */
    //=========================================
    // calendarID
    //=========================================
    //    function calendarID()
    //    {
    //        echo $this->getCalendarID();
    //    }
    //    function getCalendarID()
    //    {
    //        return $this->event->getCalendarID();
    //    }
    
    //=========================================
    // startTime
    //=========================================
    function startTime($formatString = null)
    {
        echo $this->getStartTime($formatString);
    }
    
    function getStartTime($formatString = null)
    {
       $timeManager = new dateTimeManager();
    
       $time = $timeManager->convertToUserTime($this->recurrence->getrecurrenceStartTime(), $formatString);
      
       return $time;
    }

    
    //=========================================
    // endTime
    //=========================================
    function endTime($formatString = null)
    {
        echo $this->getEndTime($formatString);
    }
    
    function getEndTime($formatString = null)
    {
		$timeManager = new dateTimeManager();
    
		$time = $timeManager->convertToUserTime($this->recurrence->getrecurrenceEndTime(), $formatString);
      
		return $time;
    }
    
    //=========================================
    // theDate
    // @@deprecated
    //=========================================
    
    function theDate($formatString = null)
    {
        echo $this->getTheDate($formatString);
    }
    
    function getTheDate($formatString = null)
    {
    	$timeManager = new dateTimeManager();
    
    	$date = $timeManager->convertToUserTime($this->recurrence->getrecurrenceStartTime(), $formatString);
      
        return $date;
    }

    
    //=========================================
    // startDate
    //=========================================
    function startDate($formatString = null)
    {
        echo $this->getStartDate($formatString);
    }
    
    function getStartDate($formatString = null)
    {
   		$timeManager = new dateTimeManager();
    
    	$date = $timeManager->convertToUserTime($this->recurrence->getrecurrenceStartTime(), $formatString);
      
        return $date;
    }
    
    //=========================================
    // endDate
    //=========================================
    function endDate($formatString = null)
    {
        echo $this->getTheDate($formatString);
    }
    
    function getEndDate($formatString = null)
    {
        
        $timeManager = new dateTimeManager();
    
    	$date = $timeManager->convertToUserTime($this->recurrence->getrecurrenceEndTime(), $formatString);
      
        return $date;
    }
    
    //=========================================
    // isAllDay
    //=========================================
    function isAllDay($formatString = null)
    {
	 	return $this->event->isAllDay;
    }
    
    function getIsAllDay($formatString = null)
    {
     	return $this->event->isAllDay;
    }
    
    
    //=========================================
    // editLink
    //=========================================
    function editLink($text = "Edit")
    {
        if (is_user_logged_in())
        {
            echo '<a href="'.$this->getEditLink().'" class="wecEditLink">'.$text.'</a>';
        }
    }
    
    function getEditLink()
    {
        return $editLink = get_bloginfo('url')."/wp-admin/tools.php?page=calendar.php&wec_page=editEvent&eventID=".$this->getEventID();
    }
    
    function dumpResultSet()
    {
        debug::dumpArray($this->resultSet);
    }
    
    /**
     * Returns $filterApplied.
     * @see WEC_Query::$filterApplied
     */
    public function isFiltered()
    {
        return $this->filterApplied;
    }
    
    /**
     * Sets $filterApplied.
     * @param object $filterApplied
     * @see WEC_Query::$filterApplied
     */
    public function setFiltered()
    {
        $this->filterApplied = true;
    }
    
    public function loadPage($pageNumber)
    {
        $this->pageToDisplay = $pageNumber;
        $this->resultSet = $this->pagedResultSet->readPage($this->pageToDisplay);
        $this->numberOfItems = count($this->resultSet);
    }
    
    public function loadAllEvents()
    {
        $eventHandler = new eventHandler();
        $this->eventList = $eventHandler->readAll();
        $this->pagedEventList = new resultset();
        
        foreach ($this->eventList as $event)
        {
            $this->pagedEventList->add($event);
        }
    }
    
    public function changeToEventMode()
    {
        //If we aren't in event mode, change to be
        //otherwise, just ignore this command
        if ($this->mode == 'recurrence')
        {
            $this->mode = 'event';
            $this->parseQuery();
        }
    }
    
    public function changeToRecurrenceMode()
    {
        //If we aren't in recurrence mode, change to be
        //otherwise, just ignore this command
        if ($this->mode == 'event')
        {
            $this->mode = 'recurrence';
            $this->parseQuery();
        }
    }
    
    function countItems()
    {
        $this->numberOfItems = count($this->resultSet);
    }

    
}

?>
