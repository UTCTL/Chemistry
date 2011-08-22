<?php 
function wec_FixInvalidEvent($postObject)
{
	require_once('event_boxes.php');
    	
    if (! empty($givenEventID)) 
    {
        $event = new event($givenEventID);
    }
    else 
    {
        $event = new event($_POST["eventID"]);
    }
    //	echo "<pre>" . var_dump($_POST) . "</pre>";
    
?>
<form method="post" action="<?php wec_currentURL ()?>?page=calendar.php">
    <div id="poststuff" class="metabox-holder has-right-sidebar">
       <div id="side-info-column" class="inner-sidebar">
            <div id="side-sortables" class="meta-box-sortables ui-sortable">
            	
                <?php showPublishBox($event->ID); ?>
              	<?php showTaxonomyBoxes($event->postID);?>
				
            </div>
        </div>        <div id="post-body">
            <div id="post-body-content">
                <table class="form-table">
                    <tr valign="top">
                        <th scope="row">
                            <label for="eventName">
                                Event Title
                            </label>
                        </th>
                        <td>
                            <input name="eventName" type="text" id="eventName" value="<?php echo $_POST['eventName']; ?>" maxlength="45"/>
                        </td>
                    </tr>
                    <tr valign="top">
                        <th scope="row">
                            <label for="eventDescription">
                                Event Description
                            </label>
                        </th>
                        <td>
                            <?php 
                            echo '<textarea name="eventDescription" id="eventDescription" cols="45" rows="5">';
                            echo $_POST['eventName'];
                            echo '</textarea>';
                            ?>
                        </td>
                    </tr>
                    <tr valign="top">
                        <th scope="row">
                            Event Excerpt
                        </th>
                        <td>
                            <input name="eventExcerpt" type="text" id="eventExcerpt" value="<?php echo $_POST['eventExcerpt']; ?>"/>
                        </td>
                    </tr>
                    <tr valign="top">
                        <th scope="row">
                            <label for="allDayEvent">
                                All-Day Event
                            </label>
                        </th>
                        <td>
                            <input name="allDayEvent" type="checkbox" id="allDayEvent"<?php if (isset($_POST['allDayEvent'])) { echo 'checked="checked"'; } ?>/>
                        </td>
                    </tr>
                    <tr valign="top">
                        <th scope="row">
                            <label for="eventStartDate" id="startDateLabel">
                                Start Date
                            </label>
                        </th>
                        <td>
                            <div class="yui-skin-sam">
                                <div class="box">
                                    <div class="datefield">
                                        <input type="text" id="eventStartDate" name="eventStartDate" value="<?php echo $_POST['eventStartDate']; ?>" />
                                    </div>
                                    <div id="start_date_container">
                                        <div class="hd">
                                            Calendar
                                        </div>
                                        <div class="bd">
                                            <div id="start_date_picker">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </td>
                    </tr>
                    <tr valign="top" id="startTimeRow">
                        <th scope="row">
                            Start Time
                        </th>
                        <td>
                            <div>
                                <select name="startTimeHour" id="startTimeHour">
                                    <option value="01"<?php if ($_POST['startTimeHour'] == '01') { echo 'selected="selected"'; } ?>>1  </option>
                                    <option value="02"<?php if ($_POST['startTimeHour'] == '02') { echo 'selected="selected"'; } ?>>2  </option>
                                    <option value="03"<?php if ($_POST['startTimeHour'] == '03') { echo 'selected="selected"'; } ?>>3  </option>
                                    <option value="04"<?php if ($_POST['startTimeHour'] == '04') { echo 'selected="selected"'; } ?>>4  </option>
                                    <option value="05"<?php if ($_POST['startTimeHour'] == '05') { echo 'selected="selected"'; } ?>>5  </option>
                                    <option value="06"<?php if ($_POST['startTimeHour'] == '06') { echo 'selected="selected"'; } ?>>6  </option>
                                    <option value="07"<?php if ($_POST['startTimeHour'] == '07') { echo 'selected="selected"'; } ?>>7  </option>
                                    <option value="08"<?php if ($_POST['startTimeHour'] == '08') { echo 'selected="selected"'; } ?>>8  </option>
                                    <option value="09"<?php if ($_POST['startTimeHour'] == '09') { echo 'selected="selected"'; } ?>>9  </option>
                                    <option value="10"<?php if ($_POST['startTimeHour'] == '10') { echo 'selected="selected"'; } ?>>10  </option>
                                    <option value="11"<?php if ($_POST['startTimeHour'] == '11') { echo 'selected="selected"'; } ?>>11  </option>
                                    <option value="00"<?php if ($_POST['startTimeHour'] == '00') { echo 'selected="selected"'; } ?>>12  </option>
                                </select>
                                <strong>:</strong>
                                <select name="startTimeMin" id="startTimeMin">
                                    <option value="00"<?php if ($_POST['startTimeMin'] == '00') { echo 'selected="selected"'; } ?>>00  </option>
                                    <option value="05"<?php if ($_POST['startTimeMin'] == '05') { echo 'selected="selected"'; } ?>>05  </option>
                                    <option value="10"<?php if ($_POST['startTimeMin'] == '10') { echo 'selected="selected"'; } ?>>10  </option>
                                    <option value="15"<?php if ($_POST['startTimeMin'] == '15') { echo 'selected="selected"'; } ?>>15  </option>
                                    <option value="20"<?php if ($_POST['startTimeMin'] == '20') { echo 'selected="selected"'; } ?>>20  </option>
                                    <option value="25"<?php if ($_POST['startTimeMin'] == '25') { echo 'selected="selected"'; } ?>>25  </option>
                                    <option value="30"<?php if ($_POST['startTimeMin'] == '30') { echo 'selected="selected"'; } ?>>30  </option>
                                    <option value="35"<?php if ($_POST['startTimeMin'] == '35') { echo 'selected="selected"'; } ?>>35  </option>
                                    <option value="40"<?php if ($_POST['startTimeMin'] == '40') { echo 'selected="selected"'; } ?>>40  </option>
                                    <option value="45"<?php if ($_POST['startTimeMin'] == '45') { echo 'selected="selected"'; } ?>>45  </option>
                                    <option value="50"<?php if ($_POST['startTimeMin'] == '50') { echo 'selected="selected"'; } ?>>50  </option>
                                    <option value="55"<?php if ($_POST['startTimeMin'] == '55') { echo 'selected="selected"'; } ?>>55  </option>
                                </select>
                                <select name="startTimeAMPMSelect" id="startTimeAMPMSelect">
                                    <option value="0"<?php if ($_POST['startTimeAMPMSelect'] == '0') { echo 'selected="selected"'; } ?>>AM</option>
                                    <option value="12"<?php if ($_POST['startTimeAMPMSelect'] == '12') { echo 'selected="selected"'; } ?>>PM</option>
                                </select>
                            </div>
                        </td>
                    </tr>
                    <tr valign="top">
                        <th scope="row">
                            <label for="eventEndDate" id="endDateLabel">
                                End Date
                            </label>
                        </th>
                        <td>
                            <div class="yui-skin-sam">
                                <div class="box">
                                    <div class="datefield">
                                        <input type="text" id="eventEndDate" name="eventEndDate" value="<?php echo $_POST['eventEndDate']; ?>" />
                                    </div>
                                    <div id="end_date_container">
                                        <div class="hd">
                                            Calendar
                                        </div>
                                        <div class="bd">
                                            <div id="end_date_picker">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </td>
                    </tr>
                    <tr valign="top" id="endTimeRow">
                        <th scope="row">
                            End Time
                        </th>
                        <td>
                            <div>
                                <select name="endTimeHour" id="endTimeHour">
                                    <option value="01"<?php if ($_POST['endTimeHour'] == '01') { echo 'selected="selected"'; } ?>>1  </option>
                                    <option value="02"<?php if ($_POST['endTimeHour'] == '02') { echo 'selected="selected"'; } ?>>2  </option>
                                    <option value="03"<?php if ($_POST['endTimeHour'] == '03') { echo 'selected="selected"'; } ?>>3  </option>
                                    <option value="04"<?php if ($_POST['endTimeHour'] == '04') { echo 'selected="selected"'; } ?>>4  </option>
                                    <option value="05"<?php if ($_POST['endTimeHour'] == '05') { echo 'selected="selected"'; } ?>>5  </option>
                                    <option value="06"<?php if ($_POST['endTimeHour'] == '06') { echo 'selected="selected"'; } ?>>6  </option>
                                    <option value="07"<?php if ($_POST['endTimeHour'] == '07') { echo 'selected="selected"'; } ?>>7  </option>
                                    <option value="08"<?php if ($_POST['endTimeHour'] == '08') { echo 'selected="selected"'; } ?>>8  </option>
                                    <option value="09"<?php if ($_POST['endTimeHour'] == '09') { echo 'selected="selected"'; } ?>>9  </option>
                                    <option value="10"<?php if ($_POST['endTimeHour'] == '10') { echo 'selected="selected"'; } ?>>10  </option>
                                    <option value="11"<?php if ($_POST['endTimeHour'] == '11') { echo 'selected="selected"'; } ?>>11  </option>
                                    <option value="00"<?php if ($_POST['endTimeHour'] == '00') { echo 'selected="selected"'; } ?>>12  </option>
                                </select>
                                <strong>:</strong>
                                <select name="endTimeMin" id="endTimeMin">
                                    <option value="00"<?php if ($_POST['endTimeMin'] == '00') { echo 'selected="selected"'; } ?>>00  </option>
                                    <option value="05"<?php if ($_POST['endTimeMin'] == '05') { echo 'selected="selected"'; } ?>>05  </option>
                                    <option value="10"<?php if ($_POST['endTimeMin'] == '10') { echo 'selected="selected"'; } ?>>10  </option>
                                    <option value="15"<?php if ($_POST['endTimeMin'] == '15') { echo 'selected="selected"'; } ?>>15  </option>
                                    <option value="20"<?php if ($_POST['endTimeMin'] == '20') { echo 'selected="selected"'; } ?>>20  </option>
                                    <option value="25"<?php if ($_POST['endTimeMin'] == '25') { echo 'selected="selected"'; } ?>>25  </option>
                                    <option value="30"<?php if ($_POST['endTimeMin'] == '30') { echo 'selected="selected"'; } ?>>30  </option>
                                    <option value="35"<?php if ($_POST['endTimeMin'] == '35') { echo 'selected="selected"'; } ?>>35  </option>
                                    <option value="40"<?php if ($_POST['endTimeMin'] == '40') { echo 'selected="selected"'; } ?>>40  </option>
                                    <option value="45"<?php if ($_POST['endTimeMin'] == '45') { echo 'selected="selected"'; } ?>>45  </option>
                                    <option value="50"<?php if ($_POST['endTimeMin'] == '50') { echo 'selected="selected"'; } ?>>50  </option>
                                    <option value="55"<?php if ($_POST['endTimeMin'] == '55') { echo 'selected="selected"'; } ?>>55  </option>
                                </select>
                                <select name="endTimeAMPMSelect" id="endTimeAMPMSelect">
                                    <option value="0"<?php if ($_POST['endTimeAMPMSelect'] == '0') { echo 'selected="selected"'; } ?>>AM</option>
                                    <option value="12"<?php if ($_POST['endTimeAMPMSelect'] == '12') { echo 'selected="selected"'; } ?>>PM</option>
                                </select>
                            </div>
                        </td>
                    </tr>
                    <tr valign="top" id="spacerAboveRepeatFrequency">
                        <th colspan="2" scope="row">
                            <br/>
                        </th>
                    </tr>
                    <tr valign="top" id="repeatFrequency">
                        <th scope="row">
                            Repeat
                        </th>
                        <td>
                            <select name="eventFrequency" id="eventFrequency" onchange="showHideRepeatDetails();">
                                <option value="n"<?php if ($_POST['eventFrequency'] == "n") { echo 'selected="selected"'; } ?>>None</option>
                                <option value="d"<?php if ($_POST['eventFrequency'] == "d") { echo 'selected="selected"'; } ?>>Every Day</option>
                                <option value="w"<?php if ($_POST['eventFrequency'] == "w") { echo 'selected="selected"'; } ?>>Every Week</option>
                                <option value="m"<?php if ($_POST['eventFrequency'] == "m") { echo 'selected="selected"'; } ?>>Every Month</option>
                                <option value="y"<?php if ($_POST['eventFrequency'] == "y") { echo 'selected="selected"'; } ?>>Every Year</option>
                                <option value="c"<?php if ($_POST['eventFrequency'] == "c") { echo 'selected="selected"'; } ?>>Custom</option>
                            </select>
                        </td>
                    </tr>
                    <tr valign="top" id="repeatForeverBox">
                        <th scope="row">
                            Repeat Forever
                        </th>
                        <td>
                            <label for="repeatForever">
                                <input name="repeatForever" type="checkbox" id="repeatForever" onclick="showHideRepeatTimes();"<?php if (isset($_POST['repeatForever'])) { echo 'checked="checked"'; } ?>/>
                            </label>
                        </td>
                    </tr>
                    <tr valign="top" id="repeatTimesBox">
                        <th scope="row">
                            Stop repeating after
                        </th>
                        <td>
                            <input name="eventRepeatTimes" type="text" id="eventRepeatTimes" value="<?php echo $_POST['eventRepeatTimes']; ?>" />times
                        </td>
                    </tr>
                    <tr valign="top">
                        <th scope="row">
                            Event Location
                        </th>
                        <td>
                            <input name="eventLocation" type="text" id="eventLocation" value="<?php echo $_POST['eventLocation']; ?>" />
                        </td>
                    </tr>
                    <tr valign="top">
                        <th scope="row">
                            <label for="eventURL">
                                Event URL
                            </label>
                        </th>
                        <td>
                            <input name="eventURL" type="text" id="eventURL" value="<?php echo $_POST['eventURL']; ?>"/>
                        </td>
                    </tr>
                    <?php 
                    $calendarHandler = new calendarHandler();
                    $calendarList = $calendarHandler->readAll();
                    if (! empty($calendarList))
                    {
                        
                    ?>
                    <tr valign="top">
                        <th scope="row">
                            Calendar
                        </th>
                        <td>
                          <ul id="categorychecklist-pop" class="categorychecklist form-no-clear">
                    <?php
                    foreach ($calendarList as $calendar)
                    {
                        //If this isn't the default calendar (which is invisible)
                        if ($calendar->getID() != get_option("wec_defaultCalendarID"))
                        {
                    ?>
                    <li id="category<?php echo $calendar->getID(); ?>" class="popular-category">
                        <label class="selectit">
                            <input name="categoryList[]" type="checkbox" value="<?php echo $calendar->getID(); ?>"
                            <?php
                           	if(isset($_POST['categoryList'])){
                           		if (in_array($calendar->getID(), $_POST['categoryList']))
                            	{
                               		echo 'checked="checked" ';
                            	}
                           	}
                            
                            ?>
/>
                            <?php
                            echo stripslashes($calendar->getName());
                            ?>
                        </label>
                    </li>
                    <?php
                    }
                    
                    }
                    ?>
                </ul>
                        </td>
                    </tr>
                    <?php } ?>
                </table>
            </div>
        </div>
    </div>
	<?php
	if (!empty($givenEventID)):
	?>
	
	<input type="hidden" name="wec_action" value="updateEvent" />
	<?php wp_nonce_field('editEvent'); ?>
	
	
	<?php elseif(isset($_POST["eventID"])): ?>
	<input type="hidden" name="wec_action" value="updateEvent" />
	<?php wp_nonce_field('editEvent'); ?>
	
	
	
	<?php else: ?>
	
	<input type="hidden" name="wec_action" value="createEvent" />
    <?php wp_nonce_field('editEvent');?>
	
	<?php endif; ?>
	
</form>
<script type="text/javascript">
    document.getElementById('repeatForeverBox').style.display = "none";
</script>
<script type="text/javascript">
    document.getElementById('repeatTimesBox').style.display = "none";
</script>
<script type="text/javascript">
    //Run these scripts in order to refresh the data
    showHideRepeatTimes();
    showHideRepeatDetails();
    showHideEventTimes();
    initalizeDateSelectors();
    
    Event.observe(window, 'load', function(){
        try {
            scroll(0, 0);
            //$('eventName').focus();   
        } 
        catch (e) {
        
        }
    });
</script>
<?php 
}
?>
