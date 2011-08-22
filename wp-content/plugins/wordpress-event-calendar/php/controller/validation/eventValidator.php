<?php 
class eventValidator
{

    //Validates the event name by checking length
    function validEventName($name)
    {
        $valid = true;
        if (strlen($name) < 4)
        {
        
            $valid = false;
        }
        return $valid;
    }
    
    //Validates the event description by checking length
    function validEventDescription($description)
    {
        $valid = true;
        if (strlen($description) < 4)
        {
            $valid = false;
        }
        return $valid;
    }
    
    //Validates the event excerpt by checking length
    function validEventExcerpt($excerpt)
    {
        $valid = true;
        if (strlen($excerpt) < 4)
        {
            $valid = false;
        }
        return $valid;
    }
    
    //Validates the dates by making sure that the ending time is after the starting time
    function validDates($startingTime, $endingTime)
    {
        $valid = true;
        if ($startingTime > $endingTime)
        {
            $valid = false;
        }
        return $valid;
    }
    
    //Validates the date given to ensure it's actually a date
    function validDate($date)
    {
        $valid = true;
        if (!strtotime($date))
        {
            $valid = false;
        }
        return $valid;
    }
    
    //Validates the number of repeat times by checking if it's an integer
    function validRepeatTimes($repeatTimes)
    {
        $valid = true;
        if (!is_int($repeatTimes))
        {
            $valid = false;
        }
        return $valid;
    }
    
    //Validate the url
    function validateURL($url)
    {
        $valid = true;
		
		$trimmedURL = trim($url);
        if (! empty($trimmedURL))
        {
        
            $urlregex = "^(https?|ftp)\:\/\/([a-z0-9+!*(),;?&=\$_.-]+(\:[a-z0-9+!*(),;?&=\$_.-]+)?@)?[a-z0-9+\$_-]+(\.[a-z0-9+\$_-]+)*(\:[0-9]{2,5})?(\/([a-z0-9+\$_-]\.?)+)*\/?(\?[a-z+&\$_.-][a-z0-9;:@/&%=+\$_.-]*)?(#[a-z_.-][a-z0-9+\$_.-]*)?\$";
            
            if (!eregi($urlregex, $url))
            {
                //Allows this field to be blank
                if (! empty($url))
                {
                    $valid = false;
                }
            }
        }
        return $valid;
    }
    
}


?>
