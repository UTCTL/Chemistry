<?php 
function wec_adminHeader() {
    //Check if the user has set their time zone!
    if (wecUser::userHasSetTimeZoneInfo()) {
        $adminRoleManager = new adminRoleManager();
        
?>
<ul class="subsubsub">
    <li>
        <?php 
        $listviewiscurrent = false;
        if (isset($_GET['wec_page'])) {
            if ($_GET['wec_page'] == 'listview') {
                $listviewiscurrent = true;
            }
        } elseif (!isset($_GET['wec_page']) && !isset($_POST['wec_action'])) {
            $listviewiscurrent = true;
        } elseif (isset($_POST['wec_action'])) {
            if ($_POST['wec_action'] == 'processUpcomingRecurrencesFilter') {
                $listviewiscurrent = true;
            }
        }
        ?>
        <a
            <?php 
            if ($listviewiscurrent)
                echo 'class="current"';
            ?>
 href="<?php echo $_SERVER['SCRIPT_NAME']; ?>?page=calendar.php">List View</a>
        <strong>| </strong>
    </li>
    <li>
        <?php 
        $calendarViewIsCurrent = false;
        if (isset($_GET['wec_page'])) {
            if ($_GET['wec_page'] == 'calendarview') {
                $calendarViewIsCurrent = true;
            }
        } elseif (isset($_POST['wec_action'])) {
            if ($_POST['wec_action'] == 'deleteRecurrenceFromCalendarView' || $_POST['wec_action'] == 'calendarview') {
                $calendarViewIsCurrent = true;
            }
        }
        ?>
        <a
            <?php 
            if ($calendarViewIsCurrent)
                echo 'class="current"';
            ?>
 href="<?php echo $_SERVER['SCRIPT_NAME']; ?>?page=calendar.php&amp;wec_page=calendarview">Calendar View</a>
    </li>
    <?php 
    if ($adminRoleManager->userIsEditorLevel()) {
        
    ?>
    <li>
        <strong>| </strong>
        <?php 
        $managecalendariscurrent = false;
        if (isset($_GET['wec_page'])) {
            if ($_GET['wec_page'] == 'manageCalendars') {
                $managecalendariscurrent = true;
            }
        } elseif (isset($_POST['wec_action'])) {
            if ($_POST['wec_action'] == 'create_calendar_page' || $_POST['wec_action'] == 'createCalendar' || $_POST['wec_action'] == 'edit_calendar_page' || $_POST['wec_action'] == 'updateCalendar' || $_POST['wec_action'] == 'deleteCalendar') {
                $managecalendariscurrent = true;
            }
        }
        
        ?>
        <a
            <?php 
            if ($managecalendariscurrent)
                echo 'class="current"';
            ?>
 href="<?php echo $_SERVER['SCRIPT_NAME']; ?>?page=calendar.php&amp;wec_page=manageCalendars">Manage Calendars</a>
    </li>
    <?php } ?>
</ul>
<?php 
}
}
?>
