<?php
class optionsHandler
{
	function saveOptions(){
		//=================================================
		// Checkboxes
		//=================================================
		if(isset($_POST['autoGenerateRecurrences'])){
			update_option('wec_autoGenerateRecurrences', true);
		}
		else{
			update_option('wec_autoGenerateRecurrences', false);
		}
		
		if(isset($_POST['allowExternalAccess'])){
			update_option('wec_allowExternalAccess', true);
		}
		else{
			update_option('wec_allowExternalAccess', false);
		}
		
		if(isset($_POST['hideEventsThatHaveAlreadyHappened'])){
			update_option('wec_hideEventsThatHaveAlreadyHappened', true);
		}
		else{
			update_option('wec_hideEventsThatHaveAlreadyHappened', false);
		}
	
	
		//=================================================
		// Validation
		//=================================================
		
		if(is_numeric($_POST['recurrencesToCreate'])){
			update_option('wec_numberOfRecurrencesToCreateAtOnce', $_POST['recurrencesToCreate']);
		}
		else{
			raiserror('The recurrence creation maximum must be a number');
		}
		
		if(is_numeric($_POST['infiniteRecurrenceNumber'])){
			update_option('wec_numberOfEventsToCreateForInfiniteRecurrences', $_POST['infiniteRecurrenceNumber']);
		}
		else{
			raiserror('The number of recurrences for events that repeat forever must be a number');
		}
		
		if(is_numeric($_POST['autoDeleteRecurrences'])){
			update_option('wec_autoDeleteRecurrencesAfter', $_POST['autoDeleteRecurrences']);
		}
		else{
			raiserror('The auto-delete recurrences field must be a number');
		}
		
		if(is_numeric($_POST['recurrencesToCreate'])){
			update_option('wec_numberOfRecurrencesToCreateAtOnce', $_POST['recurrencesToCreate']);
		}
		else{
			raiserror('The number of recurrences must be a number');
		}
		
		if(is_numeric($_POST['rssPublishingOffset'])){
			update_option('wec_numberOfDaysBeforeEventToPublishInRSSFeed', $_POST['rssPublishingOffset']);
		}
		else{
			raiserror('The RSS publishing offset must be a number');
		}
		
		//Update global time zone
		update_option('wec_default_time_zone', $_POST['timezone_string']);
		
		
		
		//After options are saved, go back to the page
		wec_mainOptionsPage();
		
		
	}

}

?>