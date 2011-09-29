<?php
class feedValidator
{
    var $allFeeds;
    var $allCalendars;

    function __construct()
    {
        $this->allFeeds = feedHandler::getAllFeeds();
        $this->allCalendars = calendarHandler::readAll();
    }
    function validFeedName($name)
    {
        $valid = true;

        if (strlen($name) < 4)
        {
            $valid = false;
        }

        if ( isset ($this->allFeeds))
        {
            //Check to see if any feeds have the same slug
            foreach ($this->allFeeds as $feed)
            {
                if (strcasecmp($feed->getName(), $name) == 0)
                {
                    $valid = false;
                }
            }
        }


        return $valid;
    }

    function validFeedSlug($slug)
    {
        $valid = true;
        if (strlen($slug) < 4)
        {
            $valid = false;
        }


        if ( isset ($this->allFeeds))
        {
            //Check to see if any feeds have the same slug
            foreach ($this->allFeeds as $feed)
            {
                if (strcasecmp($feed->getSlug(), $slug) == 0)
                {
                    $valid = false;
                }
            }

            //Check to see if any calendars have the same slug
            foreach ($this->allCalendars as $calendar)
            {
                if (strcasecmp($calendar->getSlug(), $slug) == 0)
                {
                    $valid = false;
                }
            }
        }


        return $valid;
    }

    function validFeedNameOnEdit($name, $feedID)
    {
        $valid = true;

        if (strlen($name) < 4)
        {
            $valid = false;
        }

        if ( isset ($this->allFeeds))
        {
            //Check to see if any feeds have the same slug
            foreach ($this->allFeeds as $feed)
            {
                if (strcasecmp($feed->getName(), $name) == 0)
                {
                    if ($feed->getID() != $feedID)
                    {
                        $valid = false;
                    }

                }
            }
        }


        return $valid;
    }

    function validFeedSlugOnEdit($slug, $feedID)
    {
        $valid = true;

        if (strlen($slug) < 4)
        {
            $valid = false;
        }

        if ( isset ($this->allFeeds))
        {
            //Check to see if any feeds have the same slug
            foreach ($this->allFeeds as $feed)
            {
                if (strcasecmp($feed->getSlug(), $slug) == 0)
                {
                    if ($feed->getID() != $feedID)
                    {
                        $valid = false;
                    }

                }
            }

            //Check to see if any calendars have the same slug
            foreach ($this->allCalendars as $calendar)
            {
                if (strcasecmp($calendar->getSlug(), $slug) == 0)
                {
                    $valid = false;
                }
            }
        }


        return $valid;
    }

    function cleanSlug($slug)
    {
        return sanitize_title($slug);
    }

}

?>
