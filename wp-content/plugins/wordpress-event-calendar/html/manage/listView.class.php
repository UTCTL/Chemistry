<?php 
class wec_backendListView
{
    var $nextPage;
    var $previousPage;
    var $filteredCalendarID;
    var $filteredMonth;
    var $eventsPage;
    var $currentPageNumber;
    
    function __construct()
    {
        $this->eventsPage = 1;
        $this->currentPageNumber = 1;
    }
    
    function display()
    {
        if (isset($_POST['searchText']))
        {
            $query = 'mode=event, name='.$_POST['searchText'];
        }
        else
        {
            $query = 'mode=event';
        }
        
        $eventQuery = new WEC_Query($query);
        $adminRoleManager = new adminRoleManager();
        
        //=============================================
        //Set which page we are on for both tables
        //=============================================
        if (isset($_POST['eventPage']))
        {
            //	echo ' List view page specified ' . $_POST['eventPage'];
            $this->eventsPage = $_POST['eventPage'];
        }
        else
        {
            $this->eventsPage = 1;
        }
        
        if (isset($_POST['listViewPage']))
        {
            //	echo ' List view page specified ' . $_POST['listViewPage'];
            $this->currentPageNumber = $_POST['listViewPage'];
        }
        else
        {
            $this->currentPageNumber = 1;
        }

        
        //=============================================
        //	Set filtering for recurrence table
        //=============================================
        if (isset($_POST['calendars']))
        {
            $this->filteredCalendarID = $_POST['calendars'];
        }
        
        if (isset($_POST['month']))
        {
            $this->filteredMonth = $_POST['month'];
        }
        
?>

<?php 
//If a user is editor level or higher, let them add events
if ($adminRoleManager->userIsEditorLevel())
{
    
?>
<form name="createNewEvent" id="createNewEventForm" method="post" action="<?php echo wec_currentURL ();?>?page=calendar.php" style="float:left;">
    <input type="hidden" name="wec_action" value="createNewEvent" /><input class="button" type="submit" name="createNewEventButton" value="Create Event" />
</form>
<?php 
}
//End of checking if user is editor level
?>
<form name="eventSearch" id="eventSearch" method="post" action="<?php echo wec_currentURL ();?>?page=calendar.php" style="float: right; width: 500px;">
    <p class="search-box">
        <label class="screen-reader-text" for="searchText">
            Search Events:
        </label>
        <input type="hidden" name="wec_action" value="processUpcomingRecurrencesFilter" />
		<input type="search" placeholder="Search for Events" id="searchText" name="searchText" value="<?php if(isset($_POST['searchText'])){ echo $_POST['searchText']; } ?>" /><input type="submit" value="Search" class="button" />
    </p>
</form>
<div class="clear">
</div>
<div class="tablenav">
    <h4 style="display: inline;">Events:</h4>
    <?php 
    $totalNumberOfRecurrences = $eventQuery->numberOfItems;
    
    //Check if we have more than one page
    if ($eventQuery->pagedResultSet->getNumberOfPages() > 1)
    {
        
    
    ?>
    <div class="tablenav-pages">
        <?php 
        //Load the current page!
        $eventQuery->loadPage($this->eventsPage);
        
        //Get the number of items on the last page
        $numberOfItemsOnLastPage = count($eventQuery->pagedResultSet->readPage($eventQuery->pagedResultSet->getNumberOfPages()));
        
        //If we are on the last page
        if ($this->eventsPage == $eventQuery->pagedResultSet->getNumberOfPages())
        {
            $endingNumber = $totalNumberOfRecurrences;
            $startingNumber = $endingNumber - $numberOfItemsOnLastPage;
        }
        //If we aren't on the last page
        else
        {
            //get the numbers for what we are displaying
            $endingNumber = $this->eventsPage * $eventQuery->pagedResultSet->itemsPerPage;
            $startingNumber = $endingNumber - $eventQuery->pagedResultSet->itemsPerPage + 1;
        }
        
        ?>
        <span class="displaying-num">Displaying 
            <?php 
            echo $startingNumber;
            ?>
            &#8211; 
            <?php 
            echo $endingNumber;
            ?>
            of 
            <?php 
            echo $totalNumberOfRecurrences;
            ?>
        </span>
        <?php 
        //============================
        // Paging
        //============================
        
        $filteredCalendarID = 0;
        $filteredMonth = 0;
        
        //Do simple paging if we have less than 7 pages
        if ($eventQuery->pagedResultSet->getNumberOfPages() <= 7)
        {
            for ($i = 1; $i < $eventQuery->pagedResultSet->getNumberOfPages() + 1; $i++)
            {
                $this->showPagingLinkForEventTable($i);
            }
        }
        elseif ($eventQuery->pagedResultSet->getNumberOfPages() > 7)
        {
            //Show previous page marker if we aren't on the first page
            if ($this->eventsPage > 1)
            {
                $this->showPreviousLinkForEventTable();
            }
            
            if ($this->eventsPage < 3)
            {
                for ($i = 1; $i < 4; $i++)
                {
                    $this->showPagingLinkForEventTable($i);
                }
                $this->showDots();
                $this->showPagingLinkForEventTable($eventQuery->pagedResultSet->getNumberOfPages());
            }
            elseif ($this->eventsPage <= 4 && $this->eventsPage < 7)
            {
                for ($i = 1; $i < $this->eventsPage + 2; $i++)
                {
                    $this->showPagingLinkForEventTable($i);
                }
                $this->showDots();
                $this->showPagingLinkForEventTable($eventQuery->pagedResultSet->getNumberOfPages());
            }
            //Complex middle paging
            elseif ($this->eventsPage >= 5 && $this->eventsPage <= $eventQuery->pagedResultSet->getNumberOfPages() - 5)
            {
                $this->showPagingLinkForEventTable(1);
                $this->showDots();
                
                for ($i = $this->eventsPage - 2; $i < $this->eventsPage + 3; $i++)
                {
                    $this->showPagingLinkForEventTable($i);
                }
                
                $this->showDots();
                $this->showPagingLinkForEventTable($eventQuery->pagedResultSet->getNumberOfPages());
            }
            elseif ($this->eventsPage > $eventQuery->pagedResultSet->getNumberOfPages() - 5)
            {
                //We add the +1 in this so we get the last page!
                for ($i = $this->eventsPage - 2; $i < $eventQuery->pagedResultSet->getNumberOfPages() + 1; $i++)
                {
                    $this->showPagingLinkForEventTable($i);
                }
        
                
            }
        
            
            //Show next page marker if we aren't on the last page
            if ($this->eventsPage < $eventQuery->pagedResultSet->getNumberOfPages())
            {
                $this->showNextLinkForEventTable();
            }
        }
        
        ?>
    </div>
    <?php 
    //End of checking for more than 1 page
    }
    ?>
</div>
<table class="widefat post fixed" cellspacing="0">
    <thead>
        <tr>
            <th scope="col" style="width: 50px;">
                ID
            </th>
            <th scope="col">
                Name
            </th>
            <th scope="col">
                Excerpt
            </th>
            <?php 
            if ($adminRoleManager->userIsEditorLevel())
            {
                
            ?>
            <th scope="col" style="width: 50px;">
                Edit
            </th>
            <th scope="col" style="width: 75px;">
                Delete
            </th>
            <?php 
            }
            ?>
        </tr>
    </thead>
    <tbody>
        <?php 
        if ($eventQuery->numberOfItems != 0)
        {
        
        
            while ($eventQuery->haveEvents()):
                $eventQuery->the_event();
                
        ?>
        <tr>
            <td>
                <?php 
                $eventQuery->eventID();
                ?>
            </td>
            <td>
                <?php 
                $eventQuery->eventTitle();
                ?>
            </td>
            <td>
                <?php 
                $eventQuery->eventExcerpt();
                
                ?>
            </td>
            <?php 
            if ($adminRoleManager->userIsEditorLevel())
            {
                
            ?>
            <td>
                <form name="editEvent<?php $eventQuery->eventID(); ?>" id="editEvent<?php echo $eventQuery->eventID(); ?>" action="<?php echo wec_currentURL(); ?>?page=calendar.php" method="post">
                    <input type="hidden" name="wec_action" value="editEvent" /><input type="hidden" name="eventID" value="<?php $eventQuery->eventID(); ?>" /><a href="#" onclick="$('editEvent<?php $eventQuery->eventID(); ?>').submit();">Edit</a>
                </form>
            </td>
            <td>
                <form name="deleteEvent<?php $eventQuery->eventID(); ?>" id="deleteEvent<?php echo $eventQuery->eventID(); ?>" action="<?php echo wec_currentURL(); ?>?page=calendar.php" method="post">
                    <input type="hidden" name="wec_action" value="deleteEvent" /><input type="hidden" name="eventID" value="<?php $eventQuery->eventID(); ?>" /><a href="#" onclick="if(confirm('You are about to delete this event \'Cancel\' to stop, \'OK\' to delete.')){$('deleteEvent<?php $eventQuery->eventID(); ?>').submit();}">Delete</a>
                </form>
            </td>
            <?php 
            }
            ?>
        </tr>
        <?php 
        //Ends the foreach loop
        endwhile;
        //ends the if statement
        }
        else
        {
            
        ?>
        <tr>
            <?php 
            if ($adminRoleManager->userIsEditorLevel())
            {
                
            ?>
            <td colspan="5" align="center">
            <?php 
            }
            else
            {
                
            ?>
            <td colspan="2" align="center">
                <?php 
                }
                ?>
                <form style="display: inline;" name="createNewEventLink" id="createNewEventLink" method="post" action="<?php echo wec_currentURL ();?>?page=calendar.php">
                    <?php 
                    //Check if this page has been loaded as part of a search,
                    //if so, we want to display a different message
                    if (isset($_POST['searchText']))
                    {
                        echo 'No events matched your search';
                    }
                    else
                    {
                        
                    ?>
                    <input type="hidden" name="wec_action" value="createNewEvent" />No events are scheduled. 
                    <?php 
                    //If the user is allowed to create events, put a link for them to
                 
                        
                    ?>
                    <span id="createEventMessage"<?php if (!$adminRoleManager->userIsEditorLevel()) { ?>style="display: none;"<?php } ?>>Why don't you  <a href="#" onclick="$('createNewEventForm').submit();">create</a> one?</span>
                    <?php 
                    //End of checking for user being editor level or higher
                 
                    //End of check for if this is a search or not
                    }
                    ?>
                </form>
            </td>
        </tr>
        <?php 
        }
        ?>
    </tbody>
</table>
<?php 
wec_backendListView::showUpcomingRecurrences();
}


function showUpcomingRecurrences($pageNumber = 1)
{
    
?>
<div class="clear">
    <h4>Upcoming Recurrences:</h4>
    <?php 
    $adminRoleManager = new adminRoleManager();
    $recurrenceQuery = processUpcomingRecurrencesFilter();
    
    if (recurrenceHandler::haveRecurrences())
    {
        
    ?>
    <div class="tablenav">
        <div class="alignleft actions">
            <!-- Start of Filter area -->
            <?php 
            $filteredCalendarID = 0;
            $filteredMonth = 0;
            
            
            if (isset($recurrenceQuery->partsArray['calendarID']))
            {
                // echo 'RECEIVED A CALENDAR ID';
                $filteredCalendarID = $recurrenceQuery->partsArray['calendarID'];
            }
            
            
            if (isset($recurrenceQuery->partsArray['startDate']))
            {
                // echo 'RECEIVED A DATE';
                $filteredMonth = $recurrenceQuery->partsArray['startDate'];
            }
            
            
            
            ?>
            <form name="filterRecurrences" id="filterRecurrences" action="<?php echo wec_currentURL(); ?>?page=calendar.php" method="post">
                <?php 
                $monthList = getMonthsThatHaveRecurrences();
                ?>
                <select name='month'>
                    <option selected="selected" value='0'>Show all dates</option>
                    <?php 
                    foreach ($monthList as $month)
                    {
                        
                    ?>
                    <option value="<?php echo $month['timestamp'];?>"
                        <?php 
                        if ($month['timestamp'] == $filteredMonth)
                            echo 'selected="selected"';
                        ?>
>
                        <?php 
                        echo $month['name'];
                        ?>
                    </option>
                    <?php 
                    }
                    ?>
                </select>
                <select name='calendars' id='calendars' class='postform'>
                    <option value='0'>View all calendars</option>
                    <?php 
                    $calendarData = calendarHandler::readAll();
                    
                    if (isset($calendarData))
                    {
                        foreach ($calendarData as $calendar)
                        {
                            
                    ?>
                    <option class="level-0" value="<?php echo $calendar->getID(); ?>"
                        <?php 
                        if ($calendar->getID() == $filteredCalendarID)
                            echo 'selected="selected"';
                        ?>
>
                        <?php 
                        echo stripslashes($calendar->getName());
                        ?>
                    </option>
                    <?php 
                    } //End of if statement
                    }
                    ?>
                </select>
                <input type="hidden" name="wec_action" value="processUpcomingRecurrencesFilter" /><input type="submit" id="filterButton" value="Filter" class="button-secondary" />
            </form>
        </div><!-- End of Filter area -->
        <?php 
        $totalNumberOfRecurrences = $recurrenceQuery->numberOfItems;
        
        //Check if we have more than one page
        if ($totalNumberOfRecurrences > $recurrenceQuery->pagedResultSet->itemsPerPage)
        {
            
        
        ?>
        <div class="tablenav-pages">
            <?php 
            //Load the current page!
            $recurrenceQuery->loadPage($this->currentPageNumber);
            
            
            //Get the number of items on the last page
            $numberOfItemsOnLastPage = count($recurrenceQuery->pagedResultSet->readPage($recurrenceQuery->pagedResultSet->getNumberOfPages()));
            
            //If we are on the last page
            if ($this->currentPageNumber == $recurrenceQuery->pagedResultSet->getNumberOfPages())
            {
                $endingNumber = $totalNumberOfRecurrences;
                $startingNumber = $endingNumber - $numberOfItemsOnLastPage;
            }
            //If we aren't on the last page
            else
            {
                //get the numbers for what we are displaying
                $endingNumber = $this->currentPageNumber * $recurrenceQuery->pagedResultSet->itemsPerPage;
                $startingNumber = $endingNumber - $recurrenceQuery->pagedResultSet->itemsPerPage + 1;
            }
            
            
            
            ?>
            <span class="displaying-num">Displaying 
                <?php 
                echo $startingNumber;
                ?>
                &#8211; 
                <?php 
                echo $endingNumber;
                ?>
                of 
                <?php 
                echo $totalNumberOfRecurrences;
                ?>
            </span>
            <?php 
            //============================
            // Paging
            //============================
            
            //Do simple paging if we have less than 7 pages
            if ($recurrenceQuery->pagedResultSet->getNumberOfPages() <= 7)
            {
                for ($i = 1; $i < $recurrenceQuery->pagedResultSet->getNumberOfPages() + 1; $i++)
                {
                    $this->showPagingLinkForRecurrenceTable($i);
                }
            }
            elseif ($recurrenceQuery->pagedResultSet->getNumberOfPages() > 7)
            {
                //Show previous page marker if we aren't on the first page
                if ($this->currentPageNumber > 1)
                {
                    $this->showPreviousLinkForRecurrenceTable();
                }
                
                if ($this->currentPageNumber < 3)
                {
                    for ($i = 1; $i < 4; $i++)
                    {
                        $this->showPagingLinkForRecurrenceTable($i);
                    }
                    $this->showDots();
                    $this->showPagingLinkForRecurrenceTable($recurrenceQuery->pagedResultSet->getNumberOfPages());
                }
                elseif ($this->currentPageNumber <= 4 && $this->currentPageNumber < 7)
                {
                    for ($i = 1; $i < $this->currentPageNumber + 2; $i++)
                    {
                        $this->showPagingLinkForRecurrenceTable($i);
                    }
                    $this->showDots();
                    $this->showPagingLinkForRecurrenceTable($recurrenceQuery->pagedResultSet->getNumberOfPages());
                }
                //Complex middle paging
                elseif ($this->currentPageNumber >= 5 && $this->currentPageNumber <= $recurrenceQuery->pagedResultSet->getNumberOfPages() - 5)
                {
                    $this->showPagingLinkForRecurrenceTable(1);
                    $this->showDots();
                    
                    for ($i = $this->currentPageNumber - 2; $i < $this->currentPageNumber + 3; $i++)
                    {
                        $this->showPagingLinkForRecurrenceTable($i);
                    }
                    
                    $this->showDots();
                    $this->showPagingLinkForRecurrenceTable($recurrenceQuery->pagedResultSet->getNumberOfPages());
                }
                elseif ($this->currentPageNumber > $recurrenceQuery->pagedResultSet->getNumberOfPages() - 5)
                {
                    $this->showPagingLinkForRecurrenceTable(1);
                    $this->showDots();
                    //We add the +1 in this so we get the last page!
                    for ($i = $this->currentPageNumber - 2; $i < $recurrenceQuery->pagedResultSet->getNumberOfPages() + 1; $i++)
                    {
                        $this->showPagingLinkForRecurrenceTable($i);
                    }
                    
                }
            
                
                //Show next page marker if we aren't on the last page
                if ($this->currentPageNumber < $recurrenceQuery->pagedResultSet->getNumberOfPages())
                {
                    $this->showNextLinkForRecurrenceTable();
                }
            }
            
            ?>
        </div>
        <?php 
        //End of checking for more than 1 page
        }
        //End the if statement for the filtering
        }
        ?>
    </div>
    <div class="clear">
    </div>
    <table class="widefat post fixed" cellspacing="0">
        <thead>
            <tr>
                <!--	<th scope="col" id="id" class="manage-column column-comments num" style="">ID</th> -->
                <th scope="col" id="title">
                    Event
                </th>
                <th scope="col" id="date">
                    Date
                </th>
                <th scope="col" id="time" style="">
                    Time
                </th>
                <?php 
                if ($adminRoleManager->userIsEditorLevel())
                {
                    
                ?>
                <th scope="col" id="Delete" style="width: 75px;">
                    Delete
                </th>
                <?php 
                }
                ?>
            </tr>
        </thead>
        <tbody>
            <?php 
            if ($recurrenceQuery->haveEvents())
            {
                $numberOfRecurrencesListed = 0;
                
                while ($recurrenceQuery->haveEvents() && $numberOfRecurrencesListed < $recurrenceQuery->numberOfItems && $numberOfRecurrencesListed < 15):
                    $recurrenceQuery->the_event();
                    
            ?>
            <tr>
                <!--	<td><?php $recurrenceQuery->recurrenceID(); ?></td> -->
                <td>
                    <?php 
                    $recurrenceQuery->eventTitle();
                    ?>
                </td>
                <td>
                    <?php 
                    $recurrenceQuery->theDate(get_option('date_format'));
                    ?>
                </td>
                <td>
                    <?php 
                    $recurrenceQuery->startTime(get_option('time_format'));
                    ?>
                </td>
                <?php 
                if ($adminRoleManager->userIsEditorLevel())
                {
                    
                ?>
                <td>
                    <form name="deleteRecurrence<?php $recurrenceQuery->recurrenceID(); ?>" id="deleteRecurrence<?php $recurrenceQuery->recurrenceID(); ?>" action="<?php echo wec_currentURL(); ?>?page=calendar.php" method="post">
                        <input type="hidden" name="wec_action" value="deleteRecurrenceFromListView" /><input type="hidden" name="listViewPage" value="<?php echo $pageNumber; ?>" /><input type="hidden" name="recurrenceID" value="<?php $recurrenceQuery->recurrenceID(); ?>" /><a href="#" onclick="if(confirm('You are about to delete this recurrence. You can\'t undo this. Are you sure you wish to continue?')){$('deleteRecurrence<?php $recurrenceQuery->recurrenceID(); ?>').submit();}">Delete</a>
                    </form>
                </td>
                <?php 
                }
                ?>
            </tr>
            <?php 
            $numberOfRecurrencesListed++;
            endwhile;
            }
            else
            {
                
            ?>
            <tr>
                <?php 
                if ($adminRoleManager->userIsEditorLevel())
                {
                    
                ?>
                <td colspan="4" align="center">
                    No recurrences found 
                </td>
                <?php 
                }
                else
                {
                    
                ?>
                <td colspan="3" align="center">
                    No recurrences found 
                </td>
                <?php 
                }
                ?>
            </tr>
            <?php 
            }
            ?>
        </tbody>
    </table>
</div>
<?php 
}

function showPagingLinkForRecurrenceTable($number)
{
    if ($this->currentPageNumber == $number)
    {
        echo '<span class="page-numbers current">'.$number.'</span>';
    }
    
    else
    {
        
?>
<form name="goToRecurrencePage<?php echo $number; ?>" id="goToRecurrencePage<?php echo $number; ?>" action="<?php echo wec_currentURL(); ?>?page=calendar.php" method="post" style="display: inline;">
    <input type="hidden" name="wec_action" value="processUpcomingRecurrencesFilter" /><input type="hidden" name="listViewPage" value="<?php echo $number; ?>" /><input type="hidden" name="calendars" value="<?php echo $this->filteredCalendarID; ?>" /><input type="hidden" name="month" value="<?php echo $this->filteredMonth; ?>" /><input type="hidden" name="eventPage" value="<?php echo $this->eventsPage; ?>" /><a class='page-numbers' href="#" onclick="$('goToRecurrencePage<?php echo $number; ?>').submit();">
        <?php 
        echo $number;
        ?>
    </a>
    <?php 
    //If we have a search query entered, pass it along too!
    if (isset($_POST['searchText']))
    {
        
    ?>
    <input type="hidden" name="searchText" value="<?php echo $_POST['searchText']; ?>" /><?php } ?>
</form>
<?php 
}
}

function showNextLinkForRecurrenceTable()
{

    $nextPage = $this->currentPageNumber + 1;
    
?>
<form name="goToRecurrencePage<?php echo $nextPage; ?>" id="goToNextRecurrencePage" action="<?php echo wec_currentURL(); ?>?page=calendar.php" method="post" style="display: inline;">
    <input type="hidden" name="wec_action" value="processUpcomingRecurrencesFilter" /><input type="hidden" name="listViewPage" value="<?php echo $nextPage; ?>" /><input type="hidden" name="calendars" value="<?php echo $this->filteredCalendarID; ?>" /><input type="hidden" name="month" value="<?php echo $this->filteredMonth; ?>" /><input type="hidden" name="eventPage" value="<?php echo $this->eventsPage; ?>" /><a class='page-numbers' href="#" onclick="$('goToNextRecurrencePage').submit();">&raquo;</a>
    <?php 
    //If we have a search query entered, pass it along too!
    if (isset($_POST['searchText']))
    {
        
    ?>
    <input type="hidden" name="searchText" value="<?php echo $_POST['searchText']; ?>" /><?php } ?>
</form>
<?php 
}

function showPreviousLinkForRecurrenceTable()
{
    $previousPage = $this->currentPageNumber - 1;
    
?>
<form name="goToRecurrencePage<?php echo $previousPage; ?>" id="goToPreviousRecurrencePage" action="<?php echo wec_currentURL(); ?>?page=calendar.php" method="post" style="display: inline;">
    <input type="hidden" name="wec_action" value="processUpcomingRecurrencesFilter" /><input type="hidden" name="listViewPage" value="<?php echo $previousPage; ?>" /><input type="hidden" name="calendars" value="<?php echo $this->filteredCalendarID; ?>" /><input type="hidden" name="month" value="<?php echo $this->filteredMonth; ?>" /><input type="hidden" name="eventPage" value="<?php echo $this->eventsPage; ?>" /><a class='page-numbers' href="#" onclick="$('goToPreviousRecurrencePage').submit();">&laquo;</a>
    <?php 
    //If we have a search query entered, pass it along too!
    if (isset($_POST['searchText']))
    {
        
    ?>
    <input type="hidden" name="searchText" value="<?php echo $_POST['searchText']; ?>" /><?php } ?>
</form>
<?php 
}

function showDots()
{
    
?>
<span class='page-numbers dots'>...</span>
<?php 
}


function showNextLinkForEventTable()
{
    $nextPage = $this->eventsPage + 1;
    
?>
<form name="goToEventPage<?php echo $nextPage; ?>" id="goToEventPage<?php echo $nextPage; ?>" action="<?php echo wec_currentURL(); ?>?page=calendar.php" method="post" style="display: inline;">
    <input type="hidden" name="wec_action" value="processUpcomingRecurrencesFilter" /><input type="hidden" name="listViewPage" value="<?php echo $this->currentPageNumber; ?>" /><input type="hidden" name="calendars" value="<?php echo $this->filteredCalendarID; ?>" /><input type="hidden" name="month" value="<?php echo $this->filteredMonth; ?>" /><input type="hidden" name="eventPage" value="<?php echo $nextPage; ?>" /><a class='page-numbers' href="#" onclick="$('goToEventPage<?php echo $nextPage; ?>').submit();">&raquo;</a>
    <?php 
    //If we have a search query entered, pass it along too!
    if (isset($_POST['searchText']))
    {
        
    ?>
    <input type="hidden" name="searchText" value="<?php echo $_POST['searchText']; ?>" /><?php } ?>
</form>
<?php 
}


function showPreviousLinkForEventTable()
{
    $previousPage = $this->eventsPage - 1;
    
?>
<form name="goToEventPage<?php echo $previousPage; ?>" id="goToEventPage<?php echo $previousPage; ?>" action="<?php echo wec_currentURL(); ?>?page=calendar.php" method="post" style="display: inline;">
    <input type="hidden" name="wec_action" value="processUpcomingRecurrencesFilter" /><input type="hidden" name="listViewPage" value="<?php echo $this->currentPageNumber; ?>" /><input type="hidden" name="calendars" value="<?php echo $this->filteredCalendarID; ?>" /><input type="hidden" name="month" value="<?php echo $this->filteredMonth; ?>" /><input type="hidden" name="eventPage" value="<?php echo $previousPage; ?>" /><a class='page-numbers' href="#" onclick="$('goToEventPage<?php echo $previousPage; ?>').submit();">&laquo;</a>
    <?php 
    //If we have a search query entered, pass it along too!
    if (isset($_POST['searchText']))
    {
        
    ?>
    <input type="hidden" name="searchText" value="<?php echo $_POST['searchText']; ?>" /><?php } ?>
</form>
<?php 
}

function showPagingLinkForEventTable($number)
{
    if ($this->eventsPage == $number)
    {
        echo '<span class="page-numbers current">'.$number.'</span>';
    }
    else
    {
        
?>
<form name="goToEventPage<?php echo $number; ?>" id="goToEventPage<?php echo $number; ?>" action="<?php echo wec_currentURL(); ?>?page=calendar.php" method="post" style="display: inline;">
    <input type="hidden" name="wec_action" value="processUpcomingRecurrencesFilter" /><input type="hidden" name="listViewPage" value="<?php echo $this->currentPageNumber; ?>" /><input type="hidden" name="calendars" value="<?php echo $this->filteredCalendarID; ?>" /><input type="hidden" name="month" value="<?php echo $this->filteredMonth; ?>" /><input type="hidden" name="eventPage" value="<?php echo $number; ?>" />
    <?php 
    //If we have a search query entered, pass it along too!
    if (isset($_POST['searchText']))
    {
        
    ?>
    <input type="hidden" name="searchText" value="<?php echo $_POST['searchText']; ?>" /><?php } ?>
    <a class='page-numbers' href="#" onclick="$('goToEventPage<?php echo $number; ?>').submit();">
        <?php 
        echo $number;
        ?>
    </a>
</form>
<?php 
}
}


}


?>
