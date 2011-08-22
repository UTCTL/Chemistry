<?php
class recurrenceGenerator
{

    var $limitedRecurrenceEvents;
    var $eventsWithOrphans;
    var $eventsNeedingMoreRecurrences;
    var $eventDA;
    var $recurrenceDA;

    function __construct()
    {
        if (get_option('wec_autoGenerateRecurrences'))
        {

            //Create data access objects
            $this->eventDA = new eventDA;
            $this->recurrenceDA = new recurrenceDA();

            //Populate the list of infinite recurrences
            $this->doInfiniteRecurrenceEvents();

            //Get recurrences that don't go forever
            $this->getLimitedRecurrenceEvents();

            //Get rid of any recurrences that don't have events associated with them
            $this->fixOrphanedRecurrences();

            $this->createRecurrences();

            //Delete Recurrences past their prime
            $this->deleteOldRecurrences();

			$this->destroyDeletedRecurrences();

			$this->fixOrphanedEventCalendarMeta();

        }




        $this->correctEventsWithNoRecurrences();


        //	$post = new calendarPost();


    }

    //PHP 4.x compatible constructor
    function recurrenceGenerator()
    {
        __construct();
    }

    //Get all the events that repeat forever
    function doInfiniteRecurrenceEvents()
    {
        $tempEvents = $this->eventDA->getInfiniteRecurrenceEvents();

        //If we have events that recur infinitely
        if (! empty($tempEvents))
        {

            //Loop through the temp events
            foreach ($tempEvents as $event)
            {

                //Get the number of recurrences for this event
                $numberOfEventRecurrences = $this->eventDA->countEventRecurrences($event['eventID']);

                //If we don't have enough
                if ($numberOfEventRecurrences < get_option('wec_numberOfEventsToCreateForInfiniteRecurrences'))
                {

                    //Find out how many more we need
                    $numberOfRecurrencesToCreate = get_option('wec_numberOfEventsToCreateForInfiniteRecurrences')-$numberOfEventRecurrences;

                    //Then create that many
                    for ($i = 0; $i < $numberOfRecurrencesToCreate; $i++)
                    {
                        $this->writeNextRecurrence($event['eventID'], true);
                    }

                }

            }
        }

    }

    //Get all the events that repeat, but not forever
    function getLimitedRecurrenceEvents()
    {
        $tempEvents = eventDA::getLimitedRecurrenceEvents();

        $countOfTempEvents = count($tempEvents);

        for ($i = 0; $i < $countOfTempEvents; $i++)
        {
            //Get the event ID and number of times that it is supposd to repeat from the first query
            $eventID = $tempEvents[$i]['eventID'];
            $eventRepeatTimes = $tempEvents[$i]['repeatTimes'];

            //Get the number of recurrences for this event
            $numberOfEventRecurrences = eventDA::countEventRecurrences($eventID);

            //echo 'EventID: ' . $eventID . ' repeats '. $eventRepeatTimes . ' times and has ' . $numberOfEventRecurrences
            //.' recurrences<br />';


            if ($eventRepeatTimes < $numberOfEventRecurrences)
            {
                $count = count($this->eventsWithOrphans);
                $this->eventsWithOrphans[$count] = $eventID;
            }

            if ($eventRepeatTimes > $numberOfEventRecurrences)
            {
                $count = count($this->eventsNeedingMoreRecurrences);
                $this->eventsNeedingMoreRecurrences[$count] = $eventID;
            }

            $this->limitedRecurrenceEvents[$i]['eventID'] = $eventID;
            $this->limitedRecurrenceEvents[$i]['recurrencesNeeded'] = $eventRepeatTimes;
            $this->limitedRecurrenceEvents[$i]['recurrencesInDB'] = $numberOfEventRecurrences;

        }
    }

    function fixOrphanedRecurrences()
    {
        $eventsWithOrhpans = $this->recurrenceDA->lookupOrphanedRecurrences();

        if (! empty($eventsWithOrhpans))
        {
            foreach ($eventsWithOrhpans as $event)
            {
                $this->recurrenceDA->deleteAllRecurrences($event['eventID']);
            }
        }
    }

    function readCustomRecurrenceStructure($eventID)
    {
        $fakeRecurrenceStructure = 'm, w, f';

        $explodedArray = explode(',', $fakeRecurrenceStructure);
        $countOfItemsInRecurrenceStructure = count($explodedArray);

        $daysArray = array (false, false, false, false, false, false, false);
        for ($i = 0; $i < $countOfItemsInRecurrenceStructure; $i++)
        {
            $comparisonItem = ltrim(rtrim($explodedArray[$i]));
            if (strcmp($comparisonItem, 'su') == 0)
            {
                $daysArray[0] = true;
                echo 'This event recurrs on Sundays<br />';
            }

            if (strcmp($comparisonItem, 'm') == 0)
            {
                $daysArray[1] = true;
                echo 'This event recurrs on mondays<br />';
            }

            if (strcmp($comparisonItem, 't') == 0)
            {
                $daysArray[2] = true;
                echo 'This event recurrs on tuesdays<br />';
            }

            if (strcmp($comparisonItem, 'w') == 0)
            {
                $daysArray[3] = true;
                echo 'This event recurrs on wednesdays<br />';
            }

            if (strcmp($comparisonItem, 'th') == 0)
            {
                $daysArray[4] = true;
                echo 'This event recurrs on thursdays<br />';
            }

            if (strcmp($comparisonItem, 'f') == 0)
            {
                $daysArray[5] = true;
                echo 'This event recurrs on fridays<br />';
            }

            if (strcmp($comparisonItem, 's') == 0)
            {
                $daysArray[6] = true;
                echo 'This event recurrs on saturdays<br />';
            }

        }

    }

    function correctEventsWithNoRecurrences()
    {

        $events = recurrenceDA::lookupEventsWithNoRecurrences();
        $numberOfEvents = count($events);

        for ($i = 0; $i < $numberOfEvents; $i++)
        {
            //Get the event ID, get the original date of the event, write a recurrence on this date.
            $event = new event($events[$i]['eventID']);
            $recurrence = new recurrence();
            $recurrence->setRecurrenceStartTime($event->getEventStartTime());
            $recurrence->setRecurrenceEndTime($event->getEventEndTime());
            $recurrence->eventID = $event->getID();
            $recurrence->add();
        }
    }

    /**
     * This function is a wrapper for the write recurrence function of the recurrence object,
     * used only for writing the primary recurrence on a newly created event.
     * @return nothing
     * @param object $eventID is the event ID of the newly created event
     * @param object $date is the date, already in mysql format, for the recurrence of this event
     */
    function writePrimaryRecurrence($eventID, $date)
    {
        recurrence::writeRecurrence($eventID, $date);
    }

    function createPrimaryRecurrenceForEvents()
    {
        $this->correctEventsWithNoRecurrences();
    }

    function writeNextRecurrence($eventID, $infinite = false)
    {

        $event = new event($eventID);
        $timeManager = new dateTimeManager();


        $frequencyString = $event->getRepeatFrequency();
        $numberOfRecurrencesInDB = eventDA::countEventRecurrences($eventID);


        //Check if this event is daily
        if (strcmp($frequencyString, 'd') == 0)
        {

            $frequency = ceil($numberOfRecurrencesInDB);
            $startDateOfNextRecurrence = $timeManager->addDaysToTimeStampInTimeZone($event->getEventStartTime(), $frequency, $event->getCreationTZ());
            $endDateOfNextRecurrence = $timeManager->addDaysToTimeStampInTimeZone($event->getEventEndTime(), $frequency, $event->getCreationTZ());

            if ($numberOfRecurrencesInDB < $event->getRepeatTimes() || $infinite)
            {
                $recurrence = new recurrence();
                $recurrence->setRecurrenceStartTime($startDateOfNextRecurrence);
                $recurrence->setRecurrenceEndTime($endDateOfNextRecurrence);
                $recurrence->setEventID($eventID);
                $recurrence->add();
            }

        }
        //Check if this event is weekly
        elseif (strcmp($frequencyString, 'w') == 0)
        {

            $frequency = ceil($numberOfRecurrencesInDB);
            $startDateOfNextRecurrence = $timeManager->addWeeksToTimeStampInTimeZone($event->getEventStartTime(), $frequency, $event->getCreationTZ());
            $endDateOfNextRecurrence = $timeManager->addWeeksToTimeStampInTimeZone($event->getEventEndTime(), $frequency, $event->getCreationTZ());

            if ($numberOfRecurrencesInDB < $event->getRepeatTimes() || $infinite)
            {
                $recurrence = new recurrence();
                $recurrence->setRecurrenceStartTime($startDateOfNextRecurrence);
                $recurrence->setRecurrenceEndTime($endDateOfNextRecurrence);
                $recurrence->setEventID($eventID);
                $recurrence->add();
            }



        }
        //Check if this event is monthly
        elseif (strcmp($frequencyString, 'm') == 0)
        {

            $frequency = ceil($numberOfRecurrencesInDB);
            $startDateOfNextRecurrence = $timeManager->addMonthsToTimeStampInTimeZone($event->getEventStartTime(), $frequency, $event->getCreationTZ());
            $endDateOfNextRecurrence = $timeManager->addMonthsToTimeStampInTimeZone($event->getEventEndTime(), $frequency, $event->getCreationTZ());

            if ($numberOfRecurrencesInDB < $event->getRepeatTimes() || $infinite)
            {
                $recurrence = new recurrence();
                $recurrence->setRecurrenceStartTime($startDateOfNextRecurrence);
                $recurrence->setRecurrenceEndTime($endDateOfNextRecurrence);
                $recurrence->setEventID($eventID);
                $recurrence->add();
            }
        }
        //Check if this event is yearly
        elseif (strcmp($frequencyString, 'y') == 0)
        {

            $frequency = ceil($numberOfRecurrencesInDB);
            $startDateOfNextRecurrence = $timeManager->addYearsToTimeStampInTimeZone($event->getEventStartTime(), $frequency, $event->getCreationTZ());
            $endDateOfNextRecurrence = $timeManager->addYearsToTimeStampInTimeZone($event->getEventEndTime(), $frequency, $event->getCreationTZ());

            if ($numberOfRecurrencesInDB < $event->getRepeatTimes() || $infinite)
            {
                $recurrence = new recurrence();
                $recurrence->setRecurrenceStartTime($startDateOfNextRecurrence);
                $recurrence->setRecurrenceEndTime($endDateOfNextRecurrence);
                $recurrence->setEventID($eventID);
                $recurrence->add();
            }
        }

    }

    /**
     * This function is the brains behind creating recurrences
     * @return Nothing
     */
    function createRecurrences()
    {


        $numberOfRecurrencesCreatedThisCycle = 0;

        //Loop through all the events that need more recurrences
        for ($i = 0; $i < count($this->eventsNeedingMoreRecurrences); $i++)
        {

            //Retrieve an eventID that we should make a new recurrence for
            $eventID = $this->eventsNeedingMoreRecurrences[$i];
            $j = 0;

            while ($j < get_option('wec_numberOfRecurrencesToCreateAtOnce') && $numberOfRecurrencesCreatedThisCycle < get_option('wec_numberOfRecurrencesToCreateAtOnce'))
            {
                $this->writeNextRecurrence($eventID);
                $j++;

                $numberOfRecurrencesCreatedThisCycle++;
            }
            $j = 0;

        }
    }


    function deleteOldRecurrences()
    {
        $numberOfDays = get_option('wec_autoDeleteRecurrencesAfter');


        //If the number of days is zero, we don't want to delete anything
        if ($numberOfDays != 0)
        {

            $timeManager = new dateTimeManager();
            $recurrenceDA = new recurrenceDA();

            $negativeNumberOfDays = $numberOfDays-$numberOfDays-$numberOfDays;

            //Get all the recurrences that we want to get rid of
            $recurrences = $recurrenceDA->lookupRecurrencesBeforeDate($timeManager->addDaysToTimeStamp(date('U'), $negativeNumberOfDays));

            //Check to see if we have any values before we loop through
            if (is_array($recurrences))
            {
                //Loop through, and destroy each recurrence on our list!
                foreach ($recurrences as $recurrence)
                {
                    $illFatedRecurrence = new recurrence($recurrence->getID());
                    $illFatedRecurrence->deleteRecurrence();
                }
            }


        }
    }

    function destroyDeletedRecurrences()
    {
        $recurrenceDA = new recurrenceDA();
        $recurrenceDA->destroyDeletedRecurrences();
    }
	
	function fixOrphanedEventCalendarMeta(){
		$eventCalendarMetaDA = new eventCalendarMetaDA();
		$results = $eventCalendarMetaDA->cleanOrphans();
	}
	
	
}

?>
