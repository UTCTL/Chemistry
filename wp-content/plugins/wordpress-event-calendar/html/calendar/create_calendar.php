<?php
function wec_create_calendar_page(){
	//echo 'Location: ' . calendarPlugin::getInstalledPath();
	
?>
<form method="post" action="<?php wec_currentURL ()?>?page=calendar.php">
	
	
<table class="form-table">

	<tr valign="top">
		<th scope="row"><label for="calendarName">Calendar Name</label></th>
		<td>
			<input name="calendarName" type="text" id="calendarName" onkeyup="duplicateField('calendarName', 'calendarSlug');" onblur="validateCalendarNameOnCreate('<?php echo bloginfo('url'); ?>', 'calendarNameErrorField', 'calendarName', 'submitCalendarAdd');"/>
			<span class="setting-description" id="calendarNameErrorField"></span>
		</td>
	</tr>
	
<!--
	<tr valign="top">
		<th scope="row"><label for="calendarColor">Calendar Colour</label></th>
		<td><input name="calendarColor" type="text" id="calendarColor" /></td>
	</tr>
-->

	<tr valign="top">
		<th scope="row"><label for="calendarSlug">Calendar Slug</label></th>
		<td>
			<input name="calendarSlug" type="text" id="calendarSlug" onfocus="changeColorBack('calendarSlug');" onblur="validateCalendarSlugOnCreate('<?php echo bloginfo('url'); ?>', 'calendarSlugErrorField', 'calendarSlug', 'submitCalendarAdd');"/>
			<span class="setting-description" id="calendarSlugErrorField"></span>
			<br />Every calendar automatically becomes an RSS feed of it's contents. 
			<br />The slug defines what the URL to the feed looks like.
		</td>
	</tr>
	
	<tr valign="top">
		<th scope="row"><label for="calendarDescription">Calendar Description</label></th>
		<td>
			<input name="calendarDescription" type="text" id="calendarDescription" />

			<br />In the RSS feed the description for this calendar will be required
			
		</td>
	</tr>
	
	
</table>
<input type="hidden" name="wec_action" value="createCalendar" />
<?php wp_nonce_field('createCalendar'); ?>
<p class="submit"><input type="submit" name="Submit" class="button-secondary" value="Save Changes" id="submitCalendarAdd"/>
<a href="<?php wec_currentURL ()?>?page=calendar.php"><input type="button" value="Back" class="button-secondary"/></a></p>
</form>


<script type="text/javascript">
	document.getElementById('calendarName').focus();
</script>
	
	
<?php
}
?>