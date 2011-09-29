<?php
class calendarValidator
{
	var $allCalendars;
	
	function __construct(){
		$calendarDA = new calendarDA();
		$this->allCalendars = $calendarDA->getAllCalendars();
	}

    function validCreatedCalendarName($calendarName)
    {
        $exists = false;

        foreach ($this->allCalendars as $calendar)
        {
            if (strcasecmp($calendar->getName(), $calendarName) == 0)
            {
                $exists = true;
            }
        }

        //Return the opposite, if it exists, it's not valid, if it doesn't, it is
        return !$exists;
    }


    function validCreatedCalendarSlug($calendarSlug)
    {
        $valid = true;

        if (strlen($calendarSlug) < 3)
        {
            $valid = false;
        }

        foreach ($this->allCalendars as $calendar)
        {
            if (strcasecmp($calendar->getSlug(), $calendarSlug) == 0)
            {
                //if it exists, then we set valid to false
                $valid = false;
            }
        }

        return $valid;
    }

    function validEditedCalendarName($calendarName, $calendarID)
    {

        $valid = true;

        //Loop through all the calendars. Check if any have the same name,
        //if so, then check if it's one with the same ID. If there's two
        //with the same name, but different IDs, we have duplicates. Cool
        foreach ($this->allCalendars as $calendar)
        {
            if (strcasecmp($calendar->getName(), $calendarName) == 0)
            {
                if ($calendarID != $calendar->getID())
                {
                    //if it exists, then we set valid to false
                    $valid = false;
                }
            }
        }

        //Return the opposite, if it exists, it's not valid, if it doesn't, it is
        return $valid;
    }

    function validEditedCalendarSlug($calendarSlug, $calendarID)
    {
    	$valid = true;

        //Loop through all the calendars. Check if any have the same name,
        //if so, then check if it's one with the same ID. If there's two
        //with the same name, but different IDs, we have duplicates. Cool
        foreach ($this->allCalendars as $calendar)
        {
            if (strcasecmp($calendar->getSlug(), $calendarSlug) == 0)
            {
                if ($calendarID != $calendar->getID())
                {
                    //if it exists, then we set valid to false
                    $valid = false;
                }
            }
        }

        //Return the opposite, if it exists, it's not valid, if it doesn't, it is
        return $valid;
    }

    function cleanCalendarSlug($slug)
    {
        return sanitize_title($slug);
    }


}
?>
