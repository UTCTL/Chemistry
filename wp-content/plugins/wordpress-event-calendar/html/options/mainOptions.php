<?php
function wec_mainOptionsPage()
{
?>
<form method="post" action="<?php wec_currentURL ()?>?page=calendarOptions.php">
    <h3>General</h3>
    <table class="form-table">
        <tr valign="top">
            <th scope="row">
              Hide past events
            </th>
            <td>
                <label for="hideEventsThatHaveAlreadyHappened">
                    <input name="hideEventsThatHaveAlreadyHappened" type="checkbox" id="hideEventsThatHaveAlreadyHappened"
                    <?php
                    if (get_option('wec_hideEventsThatHaveAlreadyHappened') == 1) echo 'checked="checked"';
                    ?>
/> Hide events that have already taken place (This can be overridden in custom queries)
                </label>
            </td>
        </tr>
    </table>
   
   
    <h3>Automatic Publishing</h3>
    <p>
        Recurrences can be automatically generated and deleted by the system. Higher values for these numbers will use more system resources
    </p>
    <table class="form-table">
        <tr valign="top">
            <th scope="row">
                Recurrence Generation
            </th>
            <td>
                <label for="autoGenerateRecurrences">
                    <input name="autoGenerateRecurrences" type="checkbox" id="autoGenerateRecurrences"
                    <?php
                    if (get_option('wec_autoGenerateRecurrences') == 1) echo 'checked="checked"';
                    ?>
/> Automatically generate recurrences
                </label>
            </td>
        </tr>
        <tr valign="top">
            <th scope="row">
                Recurrence Creation Max
            </th>
            <td>
                <label for="recurrencesToCreate">
                    <input name="recurrencesToCreate" type="text" id="recurrencesToCreate" value="<?php echo get_option('wec_numberOfRecurrencesToCreateAtOnce'); ?>" />How many recurrences can be created automatically at one time?
                </label>
            </td>
        </tr>
        <tr valign="top">
            <th scope="row">
                Infinite event recurrences
            </th>
            <td>
                <label for="infiniteRecurrenceNumber">
                    <input name="infiniteRecurrenceNumber" type="text" id="infiniteRecurrenceNumber" value="<?php echo get_option('wec_numberOfEventsToCreateForInfiniteRecurrences'); ?>" />How many events should be created in advance for events that repeat forever? 
                    <br/>
                </label>
            </td>
        </tr>
        <tr valign="top">
            <th scope="row">
                Auto-Delete Recurrences
            </th>
            <td>
                <label for="autoDeleteRecurrences">
                    <input name="autoDeleteRecurrences" type="text" id="autoDeleteRecurrences" value="<?php echo get_option('wec_autoDeleteRecurrencesAfter'); ?>" />Number of days after a recurrence happens to delete it (set to 0 to keep forever)
                </label>
            </td>
        </tr>
    </table><h3>Feed Options</h3>
    <table class="form-table">
        <tr valign="top">
            <th scope="row">
                RSS Publishing Offset
            </th>
            <td>
                <label for="rssPublishingOffset">
                    <input name="rssPublishingOffset" type="text" id="rssPublishingOffset" value="<?php echo get_option('wec_numberOfDaysBeforeEventToPublishInRSSFeed'); ?>" />Number of days after before a recurrence happens to post it to the RSS feed
                </label>
            </td>
        </tr>
    </table>
	
	<h3>External Publishing Options</h3>
    <table class="form-table">
        <tr valign="top">
            <th scope="row">
                External Access
            </th>
            <td>
                <label for="allowExternalAccess">
                	<input type="checkbox" name="allowExternalAccess" id="allowExternalAccess" <?php if (get_option('wec_allowExternalAccess') == 1) echo 'checked="checked"'; ?>/> Allow external access to events
                </label>
            </td>
        </tr>
    </table>
	
	
	<?php wec_setSystemTimeZone(); ?>
	
	
    <br/>
    <input type="hidden" name="wec_action" value="saveOptions" /><input type="submit" name="Submit" class="button-primary" value="Save Changes" />
</form>
<?php
}

function wec_documentation()
{
    require_once ('documentation.html');
}

?>
