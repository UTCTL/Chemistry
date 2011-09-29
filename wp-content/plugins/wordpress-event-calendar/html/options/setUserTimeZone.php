<?php

function wec_setUserTimeZone()
{
?>
<a name="setTimeZone"></a>
<h3>Time Zone Settings</h3>
<?php
global $current_user;
get_currentuserinfo();
$timezone_format = _x('Y-m-d G:i:s', 'timezone date format');


//Get the latest user info for this user so we can grab the user's ID
$timeManager = new dateTimeManager();

$gmtStamp = $timeManager->getCurrentGMTTimestamp();
?>
<table class="form-table">
    
<tr>
<?php
if ( !wp_timezone_supported() ) : // no magic timezone support here
?>
<th scope="row"><label for="gmt_offset"><?php _e('Timezone') ?> </label></th>
<td>
<select name="gmt_offset" id="gmt_offset">
<?php
$current_offset = get_option('gmt_offset');
$offset_range = array (-12, -11.5, -11, -10.5, -10, -9.5, -9, -8.5, -8, -7.5, -7, -6.5, -6, -5.5, -5, -4.5, -4, -3.5, -3, -2.5, -2, -1.5, -1, -0.5,
	0, 0.5, 1, 1.5, 2, 2.5, 3, 3.5, 4, 4.5, 5, 5.5, 5.75, 6, 6.5, 7, 7.5, 8, 8.5, 8.75, 9, 9.5, 10, 10.5, 11, 11.5, 12, 12.75, 13, 13.75, 14);
foreach ( $offset_range as $offset ) {
	if ( 0 < $offset )
		$offset_name = '+' . $offset;
	elseif ( 0 == $offset )
		$offset_name = '';
	else
		$offset_name = (string) $offset;

	$offset_name = str_replace(array('.25','.5','.75'), array(':15',':30',':45'), $offset_name);

	$selected = '';
	if ( $current_offset == $offset ) {
		$selected = " selected='selected'";
		$current_offset_name = $offset_name;
	}
	echo "<option value=\"" . esc_attr($offset) . "\"$selected>" . sprintf(__('UTC %s'), $offset_name) . '</option>';
}
?>
</select>
<?php _e('hours'); ?>
<span id="utc-time"><?php printf(__('<abbr title="Coordinated Universal Time">UTC</abbr> time is <code>%s</code>'), date_i18n( $time_format, false, 'gmt')); ?></span>
<?php if ($current_offset) : ?>
	<span id="local-time"><?php printf(__('UTC %1$s is <code>%2$s</code>'), $current_offset_name, date_i18n($time_format)); ?></span>
<?php endif; ?>
<br />
<span class="description"><?php _e('Unfortunately, you have to manually update this for daylight saving time. The PHP Date/Time library is not supported by your web host.'); ?></span>
</td>
<?php
else: // looks like we can do nice timezone selection!
$current_offset = get_option('gmt_offset');
$tzstring = wecUser::getUserLocale();

$check_zone_info = true;

// Remove old Etc mappings.  Fallback to gmt_offset.
if ( false !== strpos($tzstring,'Etc/GMT') )
	$tzstring = '';

if ( empty($tzstring) ) { // Create a UTC+- zone if no timezone string exists
	$check_zone_info = false;
	if ( 0 == $current_offset )
		$tzstring = 'UTC+0';
	elseif ($current_offset < 0)
		$tzstring = 'UTC' . $current_offset;
	else
		$tzstring = 'UTC+' . $current_offset;
}

?>
<th scope="row"><label for="timezone_string"><?php _e('Timezone') ?></label></th>
<td>

<select id="timezone_string" name="timezone_string">
<?php echo wp_timezone_choice($tzstring); ?>
</select>

    <span id="utc-time"><?php printf(__('<abbr title="Coordinated Universal Time">UTC</abbr> time is <code>%s</code>'), date_i18n($timezone_format, false, 'gmt')); ?></span>
<?php if ( get_option('timezone_string') ) : ?>
	<span id="local-time"><?php printf(__('Local time is <code>%1$s</code>'), $timeManager->convertToUserTime(date('U'), 'Y-m-d G:i:s')); ?></span>
<?php endif; ?><br />
<span class="description"><?php _e('Choose a city in the same timezone as you.'); ?></span>
<?php if ($check_zone_info && $tzstring) : ?>
<br />
<span>
	<?php
	// Set TZ so localtime works.
	date_default_timezone_set($tzstring);
	$now = localtime(time(), true);
	if ( $now['tm_isdst'] )
		_e('This timezone is currently in daylight saving time.');
	else
		_e('This timezone is currently in standard time.');
	?>
	<br />
	<?php
	if ( function_exists('timezone_transitions_get') ) {
		$found = false;
		$date_time_zone_selected = new DateTimeZone($tzstring);
		$tz_offset = timezone_offset_get($date_time_zone_selected, date_create());
		$right_now = time();
		foreach ( timezone_transitions_get($date_time_zone_selected) as $tr) {
			if ( $tr['ts'] > $right_now ) {
			    $found = true;
				break;
			}
		}

		if ( $found ) {
			echo ' ';
			$message = $tr['isdst'] ?
				__('Daylight saving time begins on: <code>%s</code>.') :
				__('Standard time begins  on: <code>%s</code>.');
			// Add the difference between the current offset and the new offset to ts to get the correct transition time from date_i18n().
			printf( $message, date_i18n(get_option('date_format') . ' ' . get_option('time_format'), $tr['ts'] + ($tz_offset - $tr['offset']) ) );
		} else {
			_e('This timezone does not observe daylight saving time.');
		}
	}
	// Set back to UTC.
	date_default_timezone_set('UTC');
	?>
	</span>
<?php endif; ?>
</td>

<?php endif; ?>
</tr>
</table>
<?php
}


function wec_updateUserInfo()
{
    //Get the current user ID and the form data from the submitted info
    $currentUserId = $_POST['user_id'];
    $formData = $_POST['timezone_string'];

    //Check if the form data reads NULL, if so, the user hasn't selected a time zone so do nothing.
    if (!strcasecmp($formData, "NULL") == 0)
    {

        //If we can't update the user's locale, then add the user meta entry required to do this
        update_usermeta($currentUserId, 'wec_userLocale', $formData);

    }

}
?>
