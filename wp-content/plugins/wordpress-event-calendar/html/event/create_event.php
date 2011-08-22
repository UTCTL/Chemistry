<?php 
function wec_CreateEventScreen()
{

    require_once ('event_boxes.php');

    if (isset($_POST['date']))
    {
        $specifiedDate = $_POST['date'];
    }
    
?>
<form method="post" action="<?php wec_currentURL ()?>?page=calendar.php">
    <div id="poststuff" class="metabox-holder has-right-sidebar">
        <div id="side-info-column" class="inner-sidebar">
            <div id="side-sortables" class="meta-box-sortables ui-sortable">
                <?php showPublishBox(); ?>
               
               	<?php showTaxonomyBoxes(); ?>
    
            </div>
        </div>
        <div id="post-body">
            <div id="post-body-content">
                <table class="form-table">
                    <tr valign="top">
                        <th scope="row">
                            Event Title
                        </th>
                        <td>
                            <input name="eventName" type="text" id="eventName" />
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
							
							//this prevents us from nasty bugs with strange spacing
                            echo '<textarea name="eventDescription" id="eventDescription" cols="45" rows="5">';
                            echo '</textarea>';
							?>
                        </td>
                    </tr>
                    <tr valign="top">
                        <th scope="row">
                            Event Excerpt
                        </th>
                        <td>
                            <input name="eventExcerpt" type="text" id="eventExcerpt" />
                        </td>
                    </tr>
                    <tr valign="top">
                        <th scope="row">
                            <label for="allDayEvent">
                                All-Day Event
                            </label>
                        </th>
                        <td>
                            <input name="allDayEvent" type="checkbox" id="allDayEvent"/>
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
                                        <input type="text" id="eventStartDate" name="eventStartDate" value="" />
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
                                    <option value="01" selected="selected">1</option>
                                    <option value="02">2</option>
                                    <option value="03">3</option>
                                    <option value="04">4</option>
                                    <option value="05">5</option>
                                    <option value="06">6</option>
                                    <option value="07">7</option>
                                    <option value="08">8</option>
                                    <option value="09">9</option>
                                    <option value="10">10</option>
                                    <option value="11">11</option>
                                    <option value="00">12</option>
                                </select>
                                <select name="startTimeMin" id="startTimeMin">
                                    <option value="00" selected="selected">00</option>
                                    <option value="05">05</option>
                                    <option value="10">10</option>
                                    <option value="15">15</option>
                                    <option value="20">20</option>
                                    <option value="25">25</option>
                                    <option value="30">30</option>
                                    <option value="35">35</option>
                                    <option value="40">40</option>
                                    <option value="45">45</option>
                                    <option value="50">50</option>
                                    <option value="55">55</option>
                                </select>
                                <select name="startTimeAMPMSelect" id="startTimeAMPMSelect">
                                    <option value="0" selected="selected">AM</option>
                                    <option value="12">PM</option>
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
                                        <input type="text" id="eventEndDate" name="eventEndDate" value="" />
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
                                <select name="endTimeHour">
                                    <option value="01" selected="selected">1</option>
                                    <option value="02">2</option>
                                    <option value="03">3</option>
                                    <option value="04">4</option>
                                    <option value="05">5</option>
                                    <option value="06">6</option>
                                    <option value="07">7</option>
                                    <option value="08">8</option>
                                    <option value="09">9</option>
                                    <option value="10">10</option>
                                    <option value="11">11</option>
                                    <option value="00">12</option>
                                </select>
                                <select name="endTimeMin" id="endTimeMin">
                                    <option value="00" selected="selected">00</option>
                                    <option value="05">05</option>
                                    <option value="10">10</option>
                                    <option value="15">15</option>
                                    <option value="20">20</option>
                                    <option value="25">25</option>
                                    <option value="30">30</option>
                                    <option value="35">35</option>
                                    <option value="40">40</option>
                                    <option value="45">45</option>
                                    <option value="50">50</option>
                                    <option value="55">55</option>
                                </select>
                                <select name="endTimeAMPMSelect" id="endTimeAMPMSelect">
                                    <option value="0" selected="selected">AM</option>
                                    <option value="12">PM</option>
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
                            <label for="eventFrequency">
                                Repeat
                            </label>
                        </th>
                        <td>
                            <select name="eventFrequency" id="eventFrequency">
                                <option value="n" selected="selected">None</option>
                                <option value="d">Every Day</option>
                                <option value="w">Every Week</option>
                                <option value="m">Every Month</option>
                                <option value="y">Every Year</option>
                            <!--    <option value="c">Custom</option> -->
                            </select>
                        </td>
                    </tr>
                    
                    <?php// include('custom_repeat_selector.php'); ?>
                    
                    
                    
                    <tr valign="top" id="repeatForeverBox" style="display: none;">
                        <th scope="row">
                            <label for="repeatForever">
                                Repeat Forever
                            </label>
                        </th>
                        <td>
                            <input name="repeatForever" type="checkbox" id="repeatForever"/>
                        </td>
                    </tr>
                    <tr valign="top" id="repeatTimesBox">
                        <th scope="row">
                            <label for="eventRepeatTimes">
                                Stop repeating after
                            </label>
                        </th>
                        <td>
                            <input name="eventRepeatTimes" type="text" id="eventRepeatTimes" />times
                        </td>
                    </tr>
                    <tr valign="top">
                        <th scope="row">
                            <label for="eventLocation">
                                Event Location
                            </label>
                        </th>
                        <td>
                            <input name="eventLocation" type="text" id="eventLocation"/>
                        </td>
                    </tr>
                    <tr valign="top">
                        <th scope="row">
                            <label for="eventURL">
                                Event URL
                            </label>
                        </th>
                        <td>
                            <input name="eventURL" type="text" id="eventURL"/>
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
                                    if ($calendar->getID() != get_option("wec_defaultCalendarID"))
                                    {
                                        
                                ?>
                                <li id="calendar<?php echo $calendar->getID(); ?>" class="popular-category">
                                    <label class="selectit">
                                        <input name="categoryList[]" type="checkbox" value="<?php echo $calendar->getID(); ?>" />
                                        <?php 
                                        echo '&nbsp;' . stripslashes($calendar->getName());
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
                    <?php 
                    }
                    
                 
                    ?>
                </table>
            </div>
        </div>
    </div><input type="hidden" name="wec_action" value="createEvent" />
    <?php 
    wp_nonce_field('editEvent');
    
    ?>
</form>
<script type="text/javascript">
    document.getElementById('repeatForeverBox').style.display = "none";
    document.getElementById('repeatTimesBox').style.display = "none";
    initalizeDateSelectors();
    
    Event.observe(window, 'load', function(){
        try {
       		scroll(0,0);
			$('eventName').focus();
        } 
        catch (e) {
        
        }
    });
</script>
<?php 
}
?>
