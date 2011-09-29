<?php 
/**
 *
 * @author Jeremy Massel
 * @version 0.53
 */
 
abstract class adminActions
{

    function runSetAction($specifiedAction)
    {
        $calendarHandler = new calendarHandler();
        $eventHandler = new eventHandler();
        $recurrenceHandler = new recurrenceHandler();
        
        switch ($specifiedAction)
        {
            case 'calendarview':
                new recurrenceGenerator();
                wec_calendar_view();
                break;
                
            case 'listview':
                new recurrenceGenerator();
                $page = new wec_backendListView();
                $page->display();
                break;
                
            case 'showOptionsPage':
                break;
                
            //Called from views that allow event creation
            case 'createNewEvent':
            
                wec_createEventScreen();
                break;
                
            //Called from event creation screen
            case 'createEvent':
                $eventHandler->add();
                break;
                
            case 'editEvent':
            
                if (isset($_GET['eventID']))
                {
                    wec_EditEvent($_GET['eventID']);
                }
                else
                {
                    wec_EditEvent();
                }
                
                break;
                
            case 'updateEvent':
                $eventHandler->update($_POST['eventID']);
                new recurrenceGenerator();
                break;
                
            case 'deleteEvent':
                $eventID = $_POST['eventID'];
                $eventHandler->delete($eventID);
                new recurrenceGenerator();
                $page = new wec_backendListView();
                $page->display();
                break;
                
            case 'deleteAllEventRecurrences':
                $eventID = $_POST['eventID'];
                recurrence::deleteAllRecurrences($eventID);
                new recurrenceGenerator();
                $page = new wec_backendListView();
                $page->display();
                break;
                
            case 'deleteRecurrence':
                $recurrenceID = $_POST['recurrenceID'];
                recurrence::deleteRecurrence($recurrenceID);
                new recurrenceGenerator();
                $page = new wec_backendListView();
                $page->display();
                break;
                
            case 'deleteFutureRecurrences':
                $recurrenceID = $_POST['recurrenceID'];
                recurrence::deleteAllFutureRecurrences($recurrenceID);
                new recurrenceGenerator();
                
                $page = new wec_backendListView();
                $page->display();
                break;
                
            case 'generateRecurrences':
                new recurrenceGenerator();
                break;
                
            //Calendars
            case 'manageCalendars':
                wec_manage_calendars_page();
                break;
                
            case 'create_calendar_page':
                wec_create_calendar_page();
                break;
                
            case 'createCalendar':
                $calendarHandler->add();
                wec_manage_calendars_page();
                break;
                
            case 'edit_calendar_page':
                wec_edit_calendar_page();
                break;
                
            case 'updateCalendar':
                $calendarHandler->update();
                wec_manage_calendars_page();
                break;
                
            case 'deleteCalendar':
                $calendarHandler->delete();
                wec_manage_calendars_page();
                break;

                
            //List View
            
            case 'deleteRecurrenceFromListView':
                $recurrenceID = $_POST['recurrenceID'];
                recurrence::deleteRecurrence($recurrenceID);
                $page = new wec_backendListView();
                $page->display();
                break;

                
            case 'defaultView':
                $page = new wec_backendListView();
                $page->display();
                break;
                
            case 'processUpcomingRecurrencesFilter':
                $page = new wec_backendListView();
                $page->display();
                break;

                
            //================================================
            // Actions for Calendar View
            //================================================
            case 'deleteRecurrenceFromCalendarView':
                $recurrenceID = $_POST['recurrenceID'];
                recurrence::deleteRecurrence($recurrenceID);
                wec_calendar_view();
                break;
                
            case 'filterCalendars':
                wec_calendar_view();
                break;
                
            default:
                new recurrenceGenerator();
                $page = new wec_backendListView();
                $page->display();
                break;
                
        }
        
    }
    
    function runAction($action = null)
    {
        if (isset($action))
        {
            adminActions::runSetAction($action);
        }
        else
        {
            if (isset($_POST['wec_action']))
            {
                adminActions::runSetAction($_POST['wec_action']);
            }
            elseif (isset($_GET['wec_page']))
            {
                adminActions::runSetAction($_GET['wec_page']);
            }
            else
            {
                adminActions::runSetAction(null);
            }
            
        }
    }
    
}
?>
