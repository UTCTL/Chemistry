<?php 
class ajaxController
{

    function deleteEventFromAjax()
    {
        if (wp_verify_nonce($_POST['wp_nonce'], 'deleteEvent'))
        {
            $eventHandler = new eventHandler();
            $eventHandler->delete($_POST['eventID']);
            new recurrenceGenerator();
            
            $jscommand = "document.getElementById('event".$_POST['eventID']."Row').fade();";
            $jscommand .= "var recurrencesToDelete = document.getElementsByClassName('event".$_POST['eventID']."Item');for (var i = 0; i < recurrencesToDelete.length; i++){recurrencesToDelete[i].fade();}";
            //	$jscommand .= 'alert("reached PHP layer: '.timer_stop().'");';
            die($jscommand);
        }
    }
    
    function deleteRecurrenceFromAjax()
    {
        if (wp_verify_nonce($_POST['wp_nonce'], 'deleteRecurrence'))
        {
            

            recurrence::deleteRecurrence($_POST['recurrenceID']);
            new recurrenceGenerator();
            
            $jscommand = "document.getElementById('recurrence".$_POST['recurrenceID']."Row').fade();";
            //	$jscommand .= 'alert("reached PHP layer: '.timer_stop().'");';
            die($jscommand);
        }

        
    }

    
}
?>
