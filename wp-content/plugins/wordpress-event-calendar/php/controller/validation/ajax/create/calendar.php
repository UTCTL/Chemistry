<?php
class createCalendarValidator
{

    /**
     * Functions to validate calendar name in the Create Calendar Screen
     *
     */
    function validateCalendarNameOnCreate()
    {

        $confirmationField = $_POST['confirmationField'];
        $submitButton = $_POST['submitButton'];

        if (!$this->validCreatedCalendarName($_POST['calendarName']))
        {

            $dieString = "document.getElementById('".$confirmationField."').innerHTML='This calendar already exists!';";
            $dieString .= "document.getElementById('".$submitButton."').disabled = true;";
            $dieString .= "document.getElementById('".$confirmationField."').style.color = 'Red';";

            die ($dieString);
        }
        else
        {

            $dieString = "document.getElementById('".$confirmationField."').innerHTML='';";
            $dieString .= "document.getElementById('".$submitButton."').disabled = false;";

            die ($dieString);
        }
    }


    /**
     * Functions to validate calendar slug in the Create Calendar Screen
     *
     */

    function validateCalendarSlugOnCreate()
    {


        $confirmationField = $_POST['confirmationField'];
        $submitButton = $_POST['submitButton'];


        if (!validSlug($_POST['calendarSlug']))
        {

            $dieString = "document.getElementById('".$confirmationField."').innerHTML='This calendar already exists!';";
            $dieString .= "document.getElementById('".$submitButton."').disabled = true;";
            $dieString .= "document.getElementById('".$confirmationField."').style.color = 'Red';";

            die ($dieString);
        }
        else
        {

            $dieString = "document.getElementById('".$confirmationField."').innerHTML='';";
            $dieString .= "document.getElementById('".$submitButton."').disabled = false;";

            die ($dieString);
        }
    }
}
?>
