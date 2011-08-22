<?php
function wec_manage_calendars_page(){?>

	<table class="widefat post fixed" cellspacing="0">
			<thead>
				<tr>
					<th scope="col" id="CalendarName">Calendar Name</th>
					<th scope
					="col" id="CalendarSlug">Calendar Slug</th>
					<th scope="col" id="Edit">Edit</th>
					<th scope="col" id="Delete">Delete</th>
				</tr>
			</thead>	
		
			<tbody>
				<?php 
				$calendarHandler = new calendarHandler();
				$calendarData = $calendarHandler->readAll();

				if(isset($calendarData)){
					foreach($calendarData as $calendar){
						if($calendar->getID() != get_option ( 'wec_defaultCalendarID' )){
						?>
							<tr>
								<td><?php echo stripslashes($calendar->getName()); ?></td>
								<td><?php echo $calendar->getSlug(); ?></td>
								<td>
									<form name="editCalendar<?php echo $calendar->getID(); ?>" id="editCalendar<?php echo $calendar->getID(); ?>" action="<?php echo wec_currentURL(); ?>?page=calendar.php" method="post">
										<input type="hidden" name="wec_action" value="edit_calendar_page" />
										<input type="hidden" name="calendarID" value="<?php echo $calendar->getID(); ?>" />
										
										<a href="#" onclick="$('editCalendar<?php echo $calendar->getID(); ?>').submit();">Edit</a>
									</form>
								</td>
								<td>
									<form name="deleteCalendar<?php echo $calendar->getID(); ?>" id="deleteCalendar<?php echo $calendar->getID(); ?>" action="<?php echo wec_currentURL(); ?>?page=calendar.php" method="post">
										<input type="hidden" name="wec_action" value="deleteCalendar" />
										<input type="hidden" name="calendarID" value="<?php echo $calendar->getID(); ?>" />
										
										<a href="#" onclick="if(confirm('You are about to delete the calendar &quot;<?php echo $calendar->getName(); ?>&quot; This cannot be undone')){$('deleteCalendar<?php echo $calendar->getID(); ?>').submit();}">Delete</a>
									</form>
									
								</td>
							</tr>
					
					
				<?php }
					}
				}
				else{
				?>
				<tr>
					<td colspan="4" align="center">No calendars found</td>
				</tr>
			<?php } ?>
			</tbody>
		</table>
		
		<form class="submit" name="createCalendar" id="createCalendar" action="<?php echo wec_currentURL(); ?>?page=calendar.php" method="post">
			<input type="hidden" name="wec_action" value="create_calendar_page" />	
			<input type="submit" name="CreateCalendar" class="button-secondary" value="Create Calendar" />
		</form>

<?php } ?>