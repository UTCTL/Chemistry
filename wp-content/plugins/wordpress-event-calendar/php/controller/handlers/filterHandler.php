<?php

function filterApplied()
{
    return processUpcomingRecurrencesFilter();
}

//This function will gather data from the filter command in the
//list view and create a wec_query from it

function processUpcomingRecurrencesFilter()
{

    if ( isset ($_POST['calendars']) && isset ($_POST['month']))
    {

        $query = null;

        //If we have a calendarID, add it to the query
        if ($_POST['calendars'] != 0)
        {
            $query = 'calendarID='.$_POST['calendars'];
        }

        //If we have a timestamp, add that to the query, too
        if ($_POST['month'] != 0)
        {
            $query .= ', startDate='.$_POST['month'];
            $query .= ', endDate='.strtotime('+1 month', $_POST['month']);
        }


        //If we actually had a query, then create the query object
        if ( isset ($query))
        {
            $queryObject = new WEC_Query($query);
            $queryObject->setFiltered();
        }
        //Probably unnecessary logic, creates default query
        else
        {
            $queryObject = new WEC_Query();
        }

        return $queryObject;
    }
    //return a default query if nothing was specified
    else
    {
        return new WEC_Query();
    }

}

function getMonthsThatHaveRecurrences()
{
    $tempList = recurrenceDA::lookupMonthsWithRecurrences();
	$timeManager = new dateTimeManager();
	
    $monthList = array ();
    $i = 0;

    if (! empty($tempList))
    {
        foreach ($tempList as $month)
        {
            $monthList[$i]['name'] = $month['name'];
            $monthList[$i]['timestamp'] = strtotime($month['name']);
            $i++;
        }

    }



    return $monthList;

}
?>
