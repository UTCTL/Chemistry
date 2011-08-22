<?php
abstract class wecUser
{
    function userHasSetTimeZoneInfo()
    {
        //Get the latest user info for this user so we can grab the user's ID
        global $current_user;
        get_currentuserinfo();
        $userID = $current_user->ID;
        $userLocale = get_usermeta($userID, 'wec_userLocale');
        $userHasSetLocale = false;

        if (! empty($userLocale))
        {
            $userHasSetLocale = true;
        }

        return $userHasSetLocale;
    }

    /**
     * How to use it: This function returns a DateTimeZone object.
     * See documentation at: http://ca2.php.net/manual/en/class.datetime.php
     * @tutorial http://ca2.php.net/manual/en/class.datetime.php
     * @return User time zone object
     */
    function getUsersTimeZoneObject()
    {
        $userTimeZone = new DateTimeZone(wecUser::getUserLocale());

        return $userTimeZone;
    }

    function getUserLocale($userID = null)
    {

        if ( empty($userID))
        {
            //Get the latest user info for this user so we can grab the user's ID
            global $current_user;
            get_currentuserinfo();
            $userID = $current_user->ID;
        }
	

        //Are we logged in?
        if (is_user_logged_in())
        {
            //If the user has set their time zone info, give them that locale,
            //otherwise, give them the system default
            if (wecUser::userHasSetTimeZoneInfo())
            {
                $locale = get_usermeta($userID, 'wec_userLocale');
            }
            else
            {
                $locale = calendarPlugin::getDefaultTimeZoneName();
            }
        }
        else
        {
            $locale = calendarPlugin::getDefaultTimeZoneName();
        }

        return $locale;
    }

    function getUsersTimeZoneName()
    {
        //Get the latest user info for this user so we can grab the user's ID
        global $current_user;
        get_currentuserinfo();
        $userID = $current_user->ID;

        if (!get_usermeta($userID, 'wec_userLocale'))
        {
            $userLocale = false;
        }
        else
        {
            $userLocale = get_usermeta($userID, 'wec_userLocale');
        }

        return $userLocale;

    }

    function getUserID()
    {
        global $current_user;
        get_currentuserinfo();
        return $current_user->ID;
    }

}

?>
