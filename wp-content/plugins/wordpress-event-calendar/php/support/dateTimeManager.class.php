<?php 
class dateTimeManager
{

    function getTimeStampFromString($date)
    {
        return strtotime($date);
    }
    
    function getYear($timestamp)
    {
        return date('Y', $timestamp);
    }
    
    function getMonthName($timestamp)
    {
        return date('F', $timestamp);
    }
    
    function getMonthNumber($timestamp)
    {
        return date('m', $timestamp);
    }
    
    function getDayOfWeekNumber($timestamp)
    {
        return date('w', $timestamp);
    }
    
    function getDayOfMonthNumber($timestamp)
    {
        return date('j', $timestamp);
    }
    
    function addMonthToTimeStamp($timestamp)
    {
        return $this->addMonthsToTimeStamp($timestamp, 1);
    }
    
    function subtractMonthFromTimeStamp($timestamp)
    {
        return $this->subtractMonthsFromTimeStamp($timestamp, 1);
    }
    
    function addDaysToTimeStamp($timestamp, $number)
    {
        $string = "+".$number." day";
        return strtotime($string, $timestamp);
    }
    
    function addDaysToTimeStampInTimeZone($timestamp, $number, $timezoneIdentifier)
    {
    
        // create the DateTimeZone object for later
        $dtzone = new DateTimeZone($timezoneIdentifier);
        
        // first convert the timestamp into a string representing the local time
        $time = date('r', $timestamp);
        
        // now create the DateTime object for this time
        $dtime = new DateTime($time);
        
        // convert this to the user's timezone using the DateTimeZone object
        $dtime->setTimeZone($dtzone);
        
        $dtime->modify("+$number day");

        
        return $dtime->format('U');
    }
    
    function addWeeksToTimeStamp($timestamp, $number)
    {
        $string = "+".$number." week";
        return strtotime($string, $timestamp);
    }
    
    function addWeeksToTimeStampInTimeZone($timestamp, $number, $timezoneIdentifier)
    {
    
        // create the DateTimeZone object for later
        $dtzone = new DateTimeZone($timezoneIdentifier);
        
        // first convert the timestamp into a string representing the local time
        $time = date('r', $timestamp);
        
        // now create the DateTime object for this time
        $dtime = new DateTime($time);
        
        // convert this to the user's timezone using the DateTimeZone object
        $dtime->setTimeZone($dtzone);

        
        $dtime->modify("+$number week");

        
        return $dtime->format('U');
    }
    
    function addMonthsToTimeStamp($timestamp, $number)
    {
        $string = "+".$number." month";
        return strtotime($string, $timestamp);
    }
    
    function addMonthsToTimeStampInTimeZone($timestamp, $number, $timezoneIdentifier)
    {
    
        // create the DateTimeZone object for later
        $dtzone = new DateTimeZone($timezoneIdentifier);
        
        // first convert the timestamp into a string representing the local time
        $time = date('r', $timestamp);
        
        // now create the DateTime object for this time
        $dtime = new DateTime($time);
        
        // convert this to the user's timezone using the DateTimeZone object
        $dtime->setTimeZone($dtzone);
        
        $dtime->modify("+$number month");

        
        return $dtime->format('U');
    }
    
    function addYearsToTimeStamp($timestamp, $number)
    {
        $string = "+".$number." year";
        return strtotime($string, $timestamp);
    }
    
    function addYearsToTimeStampInTimeZone($timestamp, $number, $timezoneIdentifier)
    {
    
        // create the DateTimeZone object for later
        $dtzone = new DateTimeZone($timezoneIdentifier);
        
        // first convert the timestamp into a string representing the local time
        $time = date('r', $timestamp);
        
        // now create the DateTime object for this time
        $dtime = new DateTime($time);
        
        // convert this to the user's timezone using the DateTimeZone object
        $dtime->setTimeZone($dtzone);
        
        $dtime->modify("+$number year");

        
        return $dtime->format('U');
    }
    
    function subtractDaysFromTimeStamp($timestamp, $number)
    {
        $string = "-".$number." days";
        return strtotime($string, $timestamp);
    }
    
    function subtractMonthsFromTimeStamp($timestamp, $number)
    {
        $string = "-".$number." months";
        return strtotime($string, $timestamp);
    }
    
    function getGMTTimeZoneObject()
    {
        $gmtObject = new DateTimeZone('Etc/GMT');
        return $gmtObject;
    }
    
    function getCurrentGMTTimestamp()
    {
        return gmdate('U');
    }
    
    function getWordPressTimeZone()
    {
        $wordpressOffset = get_option('gmt_offset');
        echo $wordpressOffset;
    }
    
    function convertToSystemTime($timestamp)
    {
        // set this to the time zone provided by the user
        $tz = wecUser::getUserLocale();
        
        // create the DateTimeZone object for later
        $dtzone = new DateTimeZone($tz);
        
        $time = date('l, F j, Y g:i:s A', $timestamp);
        
        // now create the DateTime object for this time and user time zone
        $dtime = new DateTime($time, $dtzone);
        
        // print the timestamp
        $timestamp = $dtime->format('U');
        
        return $timestamp;
    }
    
    function convertToUserTime($timestamp, $format_string = null)
    {
    
        // set this to the time zone provided by the user
        $tz = wecUser::getUserLocale();
        
        // create the DateTimeZone object for later
        $dtzone = new DateTimeZone($tz);
        
        // first convert the timestamp into a string representing the local time
        $time = date('r', $timestamp);
        
        // now create the DateTime object for this time
        $dtime = new DateTime($time);
        
        // convert this to the user's timezone using the DateTimeZone object
        $dtime->setTimeZone($dtzone);
        
        if (is_null($format_string))
        {
            // print the time using your preferred format
            $time = $dtime->format(get_option('time_format'));
        }
        else
        {
            // print the time using your preferred format
            $time = $dtime->format($format_string);
        }
        
        return $time;
    }
    
    function convertToTimeZone($timestamp, $timezoneIdentifier, $format_string = null)
    {
    
        // set this to the time zone provided by the user
        $tz = $timezoneIdentifier;
        
        // create the DateTimeZone object for later
        $dtzone = new DateTimeZone($tz);
        
        // first convert the timestamp into a string representing the local time
        $time = date('r', $timestamp);
        
        // now create the DateTime object for this time
        $dtime = new DateTime($time);
        
        // convert this to the user's timezone using the DateTimeZone object
        $dtime->setTimeZone($dtzone);
        
        if (is_null($format_string))
        {
            // print the time using your preferred format
            $time = $dtime->format(get_option('time_format'));
        }
        else
        {
            // print the time using your preferred format
            $time = $dtime->format($format_string);
        }
        
        return $time;
    }
    
    function getFirstSecondOfMonth($timestamp)
    {
        $monthNumber = date('m', $timestamp);
        $yearNumber = date('Y', $timestamp);
        $firstSecond = mktime(0, 0, 0, $monthNumber, 1, $yearNumber);
        return $firstSecond;
    }
    
}

?>
