<?php 
function wec_calendar_user_view($currentPage)
{

    //Get the persistent calendar info
    $calendarSelectionHandler = new calendarSelectionSession(); //changed from calendarSelectionHandler to calendarSelectionSession
    $usersCalendarSelection = $calendarSelectionHandler->getSelectionArray();
    $usersLastViewedMonth = $calendarSelectionHandler->getCurrentMonth();

    
    $calendars = array();
    if (! empty($usersCalendarSelection))
    {
        if (isset($_POST['calendars']))
        {
            $calendars = $_POST['calendars'];
            $calendarSelectionHandler->setSelectionArray($calendars);
            $calendarSelectionHandler->storeSelection();
        }
        else
        {
            $calendars = $usersCalendarSelection;
        }
        
    }
    else
    {
        if (isset($_POST['calendarData']))
        {
            //echo 'settostore';
            $calendars = unserialize(stripslashes($_POST['calendarData']));
            $calendarSelectionHandler->setSelectionArray($calendars);
            $calendarSelectionHandler->storeSelection();
        }
        elseif (isset($_POST['calendars']))
        {
            $calendars = $_POST['calendars'];
            $calendarSelectionHandler->setSelectionArray($calendars);
            $calendarSelectionHandler->storeSelection();
        }
        else
        {
            $calendars = null;
        }
    }

    
    if (isset($_POST['calendarViewDate']))
    {
        $theDate = $_POST['calendarViewDate'];
        $calendarSelectionHandler->setCurrentMonth($theDate);
        $calendarSelectionHandler->storeCurrentMonth();
    }
    elseif (isset($usersLastViewedMonth))
    {
        $theDate = $usersLastViewedMonth;
    }
    else
    {
        $theDate = date('U');
    }
    
    if ( empty($theDate))
    {
        $theDate = date('U');
    }
    
    $calendar = new calendarUserView($theDate);
?>
<div class="monthNameWrapper">
    <div class="rightArrow" class="inRow" style="float:left; margin: 0px 5px 0px 5px;">
        <span id="rightArrow"><a href="#" onclick="jQuery('#goBackOneMonth').submit();">&laquo;</a></span>
        <form style="display: inline;" name="goBackOneMonth" id="goBackOneMonth" action="<?php echo $currentPage; ?>" method="post">
            <input type="hidden" name="wec_action" value="calendarview" />
            <input type="hidden" name="calendarViewDate" value="<?php echo strtotime(date('F Y', $theDate) . '-1 month'); ?>" />
            <?php 
            if (isset($calendars))
            {
                
            ?>
            <input type="hidden" name="calendarData" value="<?php echo attribute_escape(serialize($calendars)); ?>" />
            <?php 
            }
            ?>
            <noscript>
                <input type="submit" value="&laquo;" />
            </noscript>
        </form>
    </div>
    <div class="monthName" class="inRow" style="float:left; margin: 0px 5px 0px 5px;">
        <h3 class="monthNameText">
            <?php 
            echo date('F Y', $theDate);
            ?>
        </h3>
    </div>
    <div class="leftArrow" class="inRow" style="float:left; margin: 0px 5px 0px 5px;">
        <span id="leftArrow"><a href="#" onclick="jQuery('#goForwardOneMonth').submit();">&raquo;</a></span>
        <form name="goForwardOneMonth" id="goForwardOneMonth" action="<?php echo $currentPage; ?>" method="post">
            <input type="hidden" name="wec_action" value="calendarview" />
            <input type="hidden" name="calendarViewDate" value="<?php echo strtotime(date('F Y', $theDate) . '+1 month'); ?>" />
            <?php 
            if (isset($calendars))
            {
                
            ?>
            <input type="hidden" name="calendarData" value="<?php echo attribute_escape(serialize($calendars)); ?>" />
            <?php 
            }
            ?>
            <noscript>
                <input type="submit" value="&raquo;" />
            </noscript>
        </form>
    </div>
</div>
<div id="todayButton" style="float: right; display: inline; margin: 0 15px 5px 0;">
    <form name="goToToday" id="goToToday" action="<?php echo $currentPage; ?>" method="post">
        <input type="hidden" name="wec_action" value="calendarview" /><input type="hidden" name="calendarViewDate" value="<?php echo strtotime(date('F Y'), date('U')); ?>" /><input type="submit" value="Today" class="button" style="width: 65px; height: 20px; -webkit-border-radius: 0px; -moz-border-radius: 0px; margin: 0px 0px 4px 0px;"/>
    </form>
</div>
<script type = "text/javascript">
    jQuery('#leftArrow').css('display', 'inline');
    jQuery('#rightArrow').css('display', 'inline');
    jQuery('#goBackOneMonth').css('display', 'inline');
    jQuery('#goForwardOneMonth').css('display', 'inline');
</script>


<form method="post" action="<?php echo $currentPage; ?>" id="filterCalendars">
    <table class="widefat" cellspacing="0" style="display:none; width: 60%; float: left; margin-right: 15px;">
        <thead>
            <tr>
                <th scope="col" colspan="2">
                    <!-- Calendars -->
                </th>
            </tr>
        </thead>
        <?php 
        $calendarHandler = new calendarSession(); //changed from calendarHandler to calendarSession
        $listOfCalendars = $calendarHandler->readAll();
        //var_dump($listOfCalendars);
        if (! empty($listOfCalendars))
        {
            foreach ($listOfCalendars as $calendarObject)
            {
        ?>
        <tr>
            <th scope="col" class="manage-column column-cb check-column">
                <input type="radio" id="checkCalendar<?php echo $calendarObject->getID(); ?>" name="calendars[]" value="<?php echo $calendarObject->getID(); ?>" onclick="jQuery('#filterCalendars').submit();"
                <?php 
                if (! empty($calendars))
                {
                    if (in_array($calendarObject->getID(), $calendars))
                    {
                        echo ' checked="checked"';
                    }
                }
                ?>
/>
            </th>
            <td>
                <label for="checkCalendar<?php echo $calendarObject->getID(); ?>">
                    <?php 
                    echo stripslashes($calendarObject->getName());
                    ?>
                </label>
            </td>
        </tr>
        <?php 
        }
        }
        else
        {
            
        ?>
        <tr align="center">
            <td>
                No calendars found
            </td>
        </tr>
        <?php 
        }
        ?>
        <tr align="center">
            <?php 
			//if there are no calendars
            if (count($listOfCalendars) == 0)
            {
                
            ?>
            <td colspan="2" style="color: grey;">No Calendars Found </td>
			<?php } ?>
			
			 <?php 
			// echo count($calendars);
			 
			 //if there are no calendars selected
            if (count($calendars) == 1)
            {
                
            ?>
			
            <td colspan="2" style="color: grey;">
			    <!--if no calendars are selected, all events are shown-->
            </td>
			
			<?php } ?>
			
        </tr>
    </table>
    <input type="hidden" name="wec_action" value="filterCalendars" /><input type="hidden" name="calendarViewDate" value="<?php echo strtotime(date('F Y', $theDate)); ?>" />
</form>
<table class="widefat post fixed" cellspacing="0" style="width: 80%; float: left; clear:none;">
    <thead>
        <tr>
            <th scope="col" style="text-align: center;">
                Sunday
            </th>
            <th scope="col" style="text-align: center;">
                Monday
            </th>
            <th scope="col" style="text-align: center;">
                Tuesday
            </th>
            <th scope="col" style="text-align: center;">
                Wednesday
            </th>
            <th scope="col" style="text-align: center;">
                Thursday
            </th>
            <th scope="col" style="text-align: center;">
                Friday
            </th>
            <th scope="col" style="text-align: center;">
                Saturday
            </th>
        </tr>
    </thead>
    <tbody>
        <?php 
        if (! empty($calendars))
        {
            $query = 'calendarID='.implode('&', $calendars);
        }
        else
        {
            $query = "";
        }
        
        $queryObject = new WEC_Query($query);
        
        //Start generating calendar boxes
        for ($i = 0; $i < count($calendar->month); $i++)
        {
            echo '<tr>';
            
            for ($j = 0; $j < count($calendar->month[$i]); $j++)
            {
                
        ?>
        <td height="75px" style="border-left-style: solid; border-left-width: 1px;" class="wec_calendarDayBox"<?php if (isset($calendar->month[$i][$j]['dayNumber'])) { ?> id="dayOfMonthNumber<?php echo $calendar->month[$i][$j]['dayNumber'];?>"<?php } ?>>
            <?php 
            if (isset($calendar->month[$i][$j]['dayNumber']))
            {
                
            ?>
            <div class="wec_day_of_month_number">
                <strong>
                    <?php 
                    echo $calendar->month[$i][$j]['dayNumber'];
                    ?>
                </strong>
            </div>
            <?php 
            if (! empty($calendars))
            {
                //if there are many calendars
                $query = 'startDate='.$calendar->month[$i][$j]['timestamp'].', endDate='.$calendar->month[$i][$j]['timestampTomorrow'].', calendarID='.implode('&', $calendars);
            }
            else
            {
                //if there is only the default calendar (ie...0)
                $query = 'startDate='.$calendar->month[$i][$j]['timestamp'].', endDate='.$calendar->month[$i][$j]['timestampTomorrow'];
            }
            
            $queryObject->changeQuery($query);
            $queryObject->applyDateFilter();
            $queryObject->countItems();
            
            //display today's events
            if (! empty($queryObject))
            {
                while ($queryObject->haveEvents()):
                    $queryObject->the_event();
                    
            ?>
            <div onmouseover="document.getElementById('showEditBox<?php echo $queryObject->getRecurrenceID(); ?>').style.display='inline';" onmouseout="document.getElementById('showEditBox<?php echo $queryObject->getRecurrenceID(); ?>').style.display='none';" style="margin: 0px; padding: 0px; display: inline-block;">
                <?php 
                //echo $queryObject->getStartTime('g:i a');
                ?>
                <?php 
                $queryObject->theTitle();
                
                ?>
                <span class="inlineEditBox" id="showEditBox<?php echo $queryObject->getRecurrenceID(); ?>"><img title="Edit Event" onclick="jQuery('editEvent<?php echo $queryObject->getEventID(); ?>withRecurrenceID<?php echo $queryObject->getRecurrenceID(); ?>').submit();" style="display:inline; margin: 0px; padding: 0px" src="<?php bloginfo('url'); echo '/wp-content/plugins' . INSTALLED_FOLDER_NAME . '/images/pencil.jpg'; ?>" width="11px" height="10px" alt="Edit" /><a title="Delete event" style="color: #ca5353;" href="#" onclick="if(confirm('You are about to delete this event. This cannot be undone. Are you sure you wish to continue?')){jQuery('deleteRecurrence<?php echo $queryObject->getRecurrenceID();?>').submit();}">x</a></span>
            </div>
            <form name="editEvent<?php echo $queryObject->getEventID(); ?>" id="editEvent<?php echo $queryObject->getEventID(); ?>withRecurrenceID<?php echo $queryObject->getRecurrenceID(); ?>" action="<?php echo wec_currentURL(); ?>?page=calendar.php" method="post">
                <input type="hidden" name="wec_action" value="editEvent" /><input type="hidden" name="eventID" value="<?php echo $queryObject->getEventID(); ?>" />
            </form>
            <form name="deleteRecurrence<?php echo $queryObject->getRecurrenceID(); ?>" id="deleteRecurrence<?php echo $queryObject->getRecurrenceID(); ?>" action="<?php echo wec_currentURL(); ?>?page=calendar.php" method="post">
                <input type="hidden" name="wec_action" value="deleteRecurrenceFromCalendarView" /><input type="hidden" name="recurrenceID" value="<?php echo $queryObject->getRecurrenceID(); ?>" /><input type="hidden" name="calendarViewDate" value="<?php echo strtotime(date('F Y', $theDate)); ?>" />
                <?php 
                if (isset($calendars))
                {
                    
                ?>
                <input type="hidden" name="calendarData" value="<?php echo attribute_escape(serialize($calendars)); ?>" />
                <?php 
                }
                ?>
            </form>
            <?php 
            //End the loop
            endwhile;
            $queryObject->unfilterResults();
            }
            }
            ?>
        </td>
        <?php 
        }
        
        echo '</tr>';
        }
        
        ?>
    </tbody>
</table>
<?php 
}
?>
