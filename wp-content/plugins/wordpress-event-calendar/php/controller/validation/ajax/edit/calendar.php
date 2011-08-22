<?php
class editCalendarValidator
{

    /**
     * Functions to validate calendar name in the Edit Calendar Screen
     *
     */

    function validateCalendarNameOnEdit()
    {

        $confirmationField = $_POST['confirmationField'];
        $submitButton = $_POST['submitButton'];


        if (!$this->validEditedCalendarName($_POST['calendarName'], $_POST['calendarID']))
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
