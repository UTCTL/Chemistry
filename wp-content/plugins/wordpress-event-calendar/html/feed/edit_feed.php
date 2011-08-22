<?php
function wec_edit_feed_page()
{
    $feedHandler = new feedHandler();
    $feed = new feed($_POST['feedID']);
?>
<form method="post" action="<?php wec_currentURL ()?>?page=calendarOptions.php">
    <table class="form-table">
        <tr valign="top">
            <th scope="row">
                <label for="feedName">
                    Feed Name
                </label>
            </th>
            <td>
                <input name="feedName" type="text" id="feedName" value="<?php echo $feed->getName(); ?>" onblur="validateCalendarNameOnEdit('<?php echo bloginfo('url'); ?>', 'calendarNameErrorField', 'calendarName', 'updateCalendarButton', <?php echo $_POST['feedID']; ?>);"/><span class="setting-description" id="calendarNameErrorField"></span>
                The name is used to identify the feed
            </td>
        </tr>
        <tr valign="top">
            <th scope="row">
                <label for="feedSlug">
                    Feed Slug
                </label>
            </th>
            <td>
                <input name="feedSlug" type="text" id="feedSlug" value="<?php echo $feed->getSlug(); ?>"/><span class="setting-description" id="calendarSlugErrorField"></span>
                The “slug” is the URL-friendly version of the name. 
            </td>
        </tr>
        <tr valign="top">
            <th scope="row">
                <label for="feed_parameters">
                    Feed Parameters
                </label>
            </th>
            <td>
                <textarea name="feed_parameters" id="feed_parameters" rows="2" cols="25">
                    <?php
                    echo $feed->getDescription();
                    ?>
                </textarea>
                <br/>
                Feeds can contain of many types of content. To include multiple calendars, for example, you could set the parameter to be calendarID = 4, 5, 6 If left blank, the feed will contain all events
            </td>
        </tr>
        <tr valign="top">
            <th scope="row">
                <label for="feedDescription">
                    Feed Description
                </label>
            </th>
            <td>
                <input name="feedDescription" type="text" id="feedDescription" value="<?php echo $feed->getDescription(); ?>"/>
                <br/>
                The feed description may show up in RSS Readers
            </td>
        </tr>
    </table>
    <input type="hidden" name="feedID" value="<?php echo $feed->getID(); ?>" /><input type="hidden" name="wec_action" value="updateFeed" />
    <p class="submit">
        <input type="submit" name="Submit" class="button-primary" id="updateFeedButton" value="Update Feed" />
    </p>
</form>
<script type="text/javascript">
    document.getElementById('feedName').focus();
</script>
<?php
}
?>
