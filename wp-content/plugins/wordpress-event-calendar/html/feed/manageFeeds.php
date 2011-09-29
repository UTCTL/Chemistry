<?php

function wec_customFeedOptions()
{
?>
<div id="col-container">
    <div id="col-right">
        <div class="col-wrap">
            <h3>Custom Feeds</h3>
            <div class="clear">
            </div>
            <table class="widefat" cellspacing="0">
                <thead>
                    <tr>
                        <th scope="col" id="name">
                            Name
                        </th>
                        <th scope="col" id="description">
                            Description
                        </th>
                        <th scope="col" id="slug">
                            Slug
                        </th>
                        <th scope="col" style="width: 50px;">
                            Edit
                        </th>
                        <th scope="col" style="width: 75px;">
                            Delete
                        </th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $feedHandler = new feedHandler();
                    $feeds = $feedHandler->getAllFeeds();
                    
                    if ( isset ($feeds))
                    {
                    
                    
                        foreach ($feeds as $feed)
                        {
                    ?>
                    <tr id='feed<?php echo $feed->getID(); ?>'>
                        <td class="name column-name">
                            <?php
                            echo $feed->getName();
                            ?>
                        </td>
                        <td>
                            <?php
                            echo textFunctions::truncate($feed->getDescription(), 20);
                            ?>
                        </td>
                        <td class="slug column-slug">
                            <?php
                            echo $feed->getSlug();
                            ?>
                        </td>
                        <td>
                            <?php
                            if (get_option('wec_defaultFeedID') != $feed->getID())
                            {
                            ?>
                            <form name="editFeed<?php echo $feed->getID(); ?>" id="editFeed<?php echo $feed->getID(); ?>" action="<?php echo wec_currentURL(); ?>?page=calendarOptions.php" method="post">
                                <input type="hidden" name="wec_action" value="editFeedPage" /><input type="hidden" name="feedID" value="<?php echo $feed->getID(); ?>" /><a href="#" onclick="$('editFeed<?php echo $feed->getID(); ?>').submit();">Edit</a>
                            </form>
                            <?php
                            }
                            ?>
                        </td>
                        <td>
                            <?php
                            if (get_option('wec_defaultFeedID') != $feed->getID())
                            {
                            ?>
                            <form name="deleteFeed<?php echo $feed->getID(); ?>" id="deleteFeed<?php echo $feed->getID(); ?>" action="<?php echo wec_currentURL(); ?>?page=calendarOptions.php" method="post">
                                <input type="hidden" name="wec_action" value="deleteFeed" /><input type="hidden" name="feedID" value="<?php echo $feed->getID(); ?>" /><a href="#" onclick="if(confirm('You are about to delete this feed \'Cancel\' to stop, \'OK\' to delete.')){$('deleteFeed<?php echo $feed->getID(); ?>').submit();}">Delete</a>
                            </form>
                            <?php
                            }
                            ?>
                        </td>
                    </tr>
                    <?php
                    //End foreach
                    }
                    } //End If
                    else
                    {
                    ?>
                    <tr>
                        <td colspan="5" align="center">
                            There are no feeds currently running
                        </td>
                    </tr>
                    <?php
                    
                    } //End Else
                    ?>
                </tbody>
            </table>
            <h3>Calendar Feeds</h3>
            <div class="clear">
            </div>
            <table class="widefat post fixed" cellspacing="0">
                <thead>
                    <tr>
                        <th scope="col" id="CalendarName">
                            Name
                        </th>
                        <th scope="col" id="CalendarDescription">
                            Description
                        </th>
                        <th scope="col" id="CalendarSlug">
                            Slug
                        </th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $calendarHandler = new calendarHandler();
                    $calendarData = $calendarHandler->readAll();
                    
                    if ( isset ($calendarData))
                    {
                        foreach ($calendarData as $calendar)
                        {
                            if ($calendar->getID() != get_option('wec_defaultCalendarID'))
                            {
                    ?>
                    <tr>
                        <td>
                            <?php
                            echo $calendar->getName();
                            ?>
                        </td>
                        <td>
                            <?php
                            echo $calendar->getDescription();
                            ?>
                        </td>
                        <td>
                            <?php
                            echo $calendar->getSlug();
                            ?>
                        </td>
                    </tr>
                    <?php
                    }
                    }
                    }
                    else
                    {
                    ?>
                    <tr>
                        <td colspan="3" align="center">
                            There are no calendars currently generating feeds
                        </td>
                    </tr>
                    <?php
                    }
                    ?>
                </tbody>
            </table>
        </div>
        <!-- /col-wrap -->
    </div>
    <!-- /col-right -->
    <div id="col-left">
        <div class="col-wrap">
            <div class="form-wrap">
                <h3>Add Feed</h3>
                <form name="addFeed" id="addFeed" method="post" action="<?php wec_currentURL ()?>?page=calendarOptions.php">
                    <input type="hidden" name="wec_action" value="addFeed" />
                    <div class="form-field form-required">
                        <label for="feedName">
                            Feed Name
                        </label>
                        <input name="feedName" id="feedName" type="text" size="40" onkeyup="duplicateField('feedName', 'feedSlug');"/>
                        <p>
                            The name is used to identify the feed
                        </p>
                    </div>
                    <div class="form-field">
                        <label for="feedSlug">
                            Feed Slug
                        </label>
                        <input name="feedSlug" id="feedSlug" type="text" size="40" onfocus="changeColorBack('feedSlug');"/>
                        <p>
                            The &#8220;slug&#8221; is the URL-friendly version of the name. It is usually all lowercase and contains only letters, numbers, and hyphens.
                        </p>
                    </div>
                    <div class="form-field">
                        <label for="feed_parameters">
                            Feed Parameters
                        </label>
                        <input name="feed_parameters" id="feed_parameters" type="text" size="40" />
                        <p>
                            Feeds can contain of many types of content. To include multiple calendars, for example, you could set the parameter to be calendarID = 4, 5, 6 If left blank, the feed will contain all events
                        </p>
                    </div>
                    <div class="form-field">
                        <label for="feedDescription">
                            Feed Description
                        </label>
                        <textarea name="feedDescription" id="feedDescription" rows="2" cols="40">
                        </textarea>
                        <p>
                            The feed description may show up in RSS Readers
                        </p>
                    </div>
                    <p class="submit">
                        <input type="submit" class="button" name="submit" value="Add Feed" />
                    </p>
                </form>
            </div><!-- /form-wrap -->
        </div><!-- /col-wrap -->
    </div><!-- /col-left -->
</div><!-- /col-container -->
<?php
}
?>
