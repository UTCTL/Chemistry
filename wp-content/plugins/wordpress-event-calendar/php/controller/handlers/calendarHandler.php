<?php 
class calendarHandler
{

    function add()
    {
    
        //Create a validation object and a blank message
        $validator = new calendarValidator();
        $validMessage = null;
        $valid = true;
        
        if (wp_verify_nonce($_POST['_wpnonce'], 'createCalendar') && check_admin_referer('createCalendar'))
        {
        
            //Check if the calendar name is valid
            if ($validator->validCreatedCalendarName($_POST['calendarName']))
            {
            
                //Check if the slug is valid
                if ($validator->validCreatedCalendarSlug($_POST['calendarSlug']))
                {
                
                    $calendar = new Calendar();
                    $calendar->setName($_POST['calendarName']);
                    $calendar->setSlug($validator->cleanCalendarSlug($_POST['calendarSlug']));
                    $calendar->setDescription($_POST['calendarDescription']);
                    
                    //Revalidate the slug after it's been cleaned, to make sure something is there
                    if (!$validator->validCreatedCalendarSlug($calendar->getSlug()))
                    {
                        $validMessage = 'This slug is invalid';
                    }
                    else
                    {
                        $calendarID = $calendar->add();
                    }
                }
                
                //If the slug isn't valid
                else
                {
                    $validMessage = 'The calendar slug is invalid. Calendar could not be added';
                }
            }
            //If the name isn't valid
            else
            {
                $validMessage = 'The calendar name is invalid. Calendar could not be added';
            }
        }
        else
        {
            $validMessage = 'This transaction didn\'t work out';
        }
        
        //If we have an error message then print it for the user
        if (! empty($validMessage))
        {
            raiserror($validMessage);
        }
        
    }
    
    function read($calendarID)
    {
        $calendarObject = new Calendar($calendarID);
        return $calendarObject;
    }
    
    function update()
    {
        //Create a validation object and a blank message
        $validator = new calendarValidator();
        $validMessage = null;
        
        //Check if the calendar name is valid
        if ($validator->validEditedCalendarName($_POST['calendarName'], $_POST['calendarID']))
        {
        
            //Check if the slug is valid
            if ($validator->validEditedCalendarSlug($_POST['calendarSlug'], $_POST['calendarID']))
            {
            
                $calendar = new Calendar($_POST['calendarID'], false);
                $calendar->setName($_POST['calendarName']);
                $calendar->setDescription($_POST['calendarDescription']);
                $calendar->setSlug($validator->cleanCalendarSlug($_POST['calendarSlug']));
                
                //Revalidate the slug after it's been cleaned, to make sure something is there
                if (!$validator->validEditedCalendarSlug($calendar->getSlug(), $_POST['calendarID']))
                {
                    $validMessage = 'he calendar slug is invalid. Calendar could not be updated';
                }
                else
                {
                    $calendar->update();
                }
            }
            //If the slug isn't valid
            else
            {
                $validMessage = 'The calendar slug is invalid. Calendar could not be updated';
            }
        }
        //If the name isn't valid
        else
        {
            $validMessage = 'The calendar name is invalid. Calendar could not be updated';
        }
        
        //If we have an error message then print it for the user
        if (! empty($validMessage))
        {
            raiserror($validMessage);
        }
    }
    
    function delete()
    {
        $calendarMetaDA = new eventCalendarMetaDA();
        $calendarMetaDA->deleteMetaByCalendarID($_POST['calendarID']);
        
		
		
		/* delete the calendar from this users' calendar selections */ 
		
		$calendarSelectionHandler = new calendarSelectionHandler();
		$calendarSelectionHandler->getSelectionArray();
		
		$calendarSelectionArray = array();
		$calendarSelectionArrayIndex = 0;
		
		
		foreach($calendarSelectionHandler as $calendarID){
			if($calendarID != $_POST['calendarID']){
				$calendarSelectionArray[$calendarSelectionArrayIndex] = $calendarID;
			}
		}
		
		
		$calendarSelectionHandler->storeSelection($calendarSelectionArray);
		
		
		/* now delete the calendar */
        $calendarDA = new calendarDA();
        return $calendarDA->deleteCalendar($_POST['calendarID']);
    }
    
    function readAll()
    {
        $calendarDA = new calendarDA;
        return $calendarDA->getAllEditableCalendars();
    }
    
    function calendarExists($calendarID)
    {
        $exists = false;
		
		$calendarDA = new calendarDA;
        $array = $calendarDA->lookupCalendarByCalendarId($calendarID);
        
        if (isset($array))
        {
            $exists = true;
        }
        
        return $exists;
    }
    
    function getCalendarName($calendarID)
    {
        $calendar = calendarInterface::read($calendarID);
        return $calendar->getCalendarName();
    }
    
}

?>
