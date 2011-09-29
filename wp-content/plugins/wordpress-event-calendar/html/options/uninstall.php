<?php
function uninstallPage(){
?>
	<form method="post" action="<?php wec_currentURL ()?>?page=calendarOptions.php" id="reinstallerForm">
		<h3>Reinstall CalendarBuilder</h3>
		<p>Reinstalling CalendarBuilder will erase all calendar data and put the plugin back the way it was when it was first installed. Proceed with extreme caution!</p>
		
		
		<input type="hidden" name="wec_action" value="runReInstall" />
		<input class="button" type="button" name="wec_reinstaller" value="Reinstall"  onclick="if(confirm('You are about to erase all the data for the CalendarBuilder Plugin. Are you certain you want to do this?')){$('reinstallerForm').submit();}" />
	</form>

	<form method="post" action="<?php wec_currentURL ()?>?page=calendarOptions.php" id="uninstallerForm">
		<h3>Uninstall CalendarBuilder</h3>
		<p>Uninstalling CalendarBuilder will erase all calendar data! Proceed with extreme caution!</p>
		
		
		<input type="hidden" name="wec_action" value="runUnInstaller" />
		<input class="button" type="button" name="wec_deleter" value="Uninstall"  onclick="if(confirm('You are about to erase all the data for the CalendarBuilder Plugin. Are you certain you want to do this?')){$('uninstallerForm').submit();}" />
	</form>
	

	
	<?php
}
?>