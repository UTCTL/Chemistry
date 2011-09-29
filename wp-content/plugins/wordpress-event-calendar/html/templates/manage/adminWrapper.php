<?php
function wec_manageEventsPage()
{
?>
<div class="wrap">
	 
	<div id="icon-tools" class="icon32">
	    <br/>
	</div>
	
    <h2>Manage Events</h2>
    <?php
    
    wec_adminHeader();
	?>
	<div class="clear"></div>
	
	<?php
    javascriptMessage();
    
    //Lets make sure that the user has set their time zone. If they have not, then we won't let them run
    //the plugin, because otherwise the results could be unpredictable.
    if (wecUser::userHasSetTimeZoneInfo())
    {
        adminActions::runAction();
    } else
    {
        adminError('Your time zone is not set. <br />Click <a href="'. get_bloginfo('url') .'/wp-admin/profile.php#setTimeZone">here</a> to set your time zone', 'Fatal Error - You must set your time zone to continue');
    }
    
    ?>
    <!-- End of Wrap Div-->
</div>

<?php



}

?>
