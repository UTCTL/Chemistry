<?php
/**
 *
 */
class recurrenceHandler
{

    /**
     *
     * @return
     */
    function add()
    {

    }

    /**
     *
     * @return
     */
    function read($recurrenceID)
    {
        if ($recurrenceID == null)
        {
            throw new Exception('No recurrence ID specified for the read function of the recurrence interface');
        }
        else
        {
            $tempRecurrence = new recurrence($recurrenceID);
        }

        return $tempRecurrence;

    }

    /**
     *
     * @return
     */
    function update()
    {

    }

    /**
     *
     * @return
     */
    function delete()
    {

    }

    function findFirstRecurrenceForEvent($eventID)
    {
        recurrenceDA::lookupPrimaryRecurrenceID($eventID);
    }

    function haveRecurrences()
    {
        $count = recurrenceDA::countRecurrences();
        if ($count > 0)
        {
            return true;
        }
        else
        {
            return false;
        }
    }

    function readAll()
    {
        $recurrenceDA = new recurrenceDA();
        $recurrenceList = $recurrenceDA->lookupAllRecurrences();

        if ( isset ($recurrenceList))
        {
            $i = 0;
            $recurrenceArray = array ();

            foreach ($recurrenceList as $recurrence)
            {
                $recurrence = new recurrence($recurrence['eventID']);
                $recurrenceArray[$i] = $recurrence;
                $i++;
            }
        }
        else
        {
            $recurrenceArray = null;
        }

        return $recurrenceArray;
    }
}

?>
