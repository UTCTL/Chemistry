<?php
function wec_edit_calendar_page(){
	$calendarHandler = new calendarHandler();
	$calendar = $calendarHandler->read($_POST['calendarID']);
	
?>
<form method="post" action="<?php wec_currentURL ()?>?page=calendar.php">
<table class="form-table">

	<tr valign="top">
		<th scope="row"><label for="calendarName">Calendar Name</label></th>
		<td>
			<input name="calendarName" type="text" id="calendarName" value="<?php echo $calendar->getName(); ?>" onblur="validateCalendarNameOnEdit('<?php echo bloginfo('url'); ?>', 'calendarNameErrorField', 'calendarName', 'updateCalendarButton', <?php echo $_POST['calendarID']; ?>);"/>
				<span class="setting-description" id="calendarNameErrorField"></span>
		</td>
	</tr>

	<tr valign="top">
		<th scope="row"><label for="calendarSlug">Calendar Slug</label></th>
		<td><input name="calendarSlug" type="text" id="calendarSlug" value="<?php echo $calendar->getSlug(); ?>"/>
		<span class="setting-description" id="calendarSlugErrorField"></span>
		<br />Every calendar automatically becomes an RSS feed of it's contents. 
		<br />The slug defines what the URL to the feed looks like.</td>
	</tr>
	
	<tr valign="top">
		<th scope="row"><label for="calendarDescription">Calendar Description</label></th>
		<td>
			<input name="calendarDescription" type="text" id="calendarDescription" value="<?php echo $calendar->getDescription(); ?>"/>

			<br />In the RSS feed the description for this calendar will be required
			
		</td>
	</tr>
	
	
</table>

<input type="hidden" name="calendarID" value="<?php echo $calendar->getID(); ?>" />
<input type="hidden" name="wec_action" value="updateCalendar" />

<p class="submit">
	<input type="submit" name="Submit" class="button-primary" id="updateCalendarButton" value="Update Calendar" />
</p>

</form>


<script type="text/javascript">
		document.getElementById('calendarName').focus();
</script>
	
	
<?php
}
?>