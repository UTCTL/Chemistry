<?php
function wec_editSettings() {
	?>

<div class="wrap">
<h2>Event Plugin Options</h2>

	<?php
	
	wec_adminOptionsHeader();
	//Lets make sure that the user has set their time zone. If they have not, then we won't let them run
	//the plugin, because otherwise the results could be unpredictable.
	?>
	<div class="clear"></div>
	
	<?php
	
	optionsActions::runAction();

	
	
	
	?>
	</div>
	<?php
	
	

}
	
?>
