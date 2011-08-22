=== Wordpress Event Calendar ===
Contributors: truthmedia
Donate link: http://truthmedia.com/engage/giving
Tags: event, calendar, events, calendars, iCal, schedule
Requires at least: 2.8
Tested up to: 3.0
Stable tag: 0.27

Allows complex calendar management

== Description ==

Allows complex calendar management

== Installation ==

1. Upload the folder to the `/wp-content/plugins/` directory
2. Activate the plugin through the 'Plugins' menu in WordPress
3. Set your time zone in user options
4. Go back to Tools->Events to use plugin
5. To view the documentation, choose Settings -> Events, then at the top choose Documentation

== Frequently Asked Questions ==

= Why is this plugin in beta? =
We have tested this plugin extensively on our own servers, but it's very complex so there could be unforeseen issues we don't know about. It's our way of warning you of that

= How do I integrate this into my theme?! =
We have documentation for that! On your blog, go to Settings -> Events, then at the top, choose Documentation. If you know how to use the WordPress loop, you should be completely comfortable working with this

= I really want your plugin to do ________ but it doesn't! Please add it? =
We're working on it! If you want to add a feature request, please visit our site and leave a comment. We really do read them!

= I'm stuck! =
If you have a problem with this plugin and are looking for help, we'd be glad to answer! Visit our website and leave us a comment!

== Changelog ==

= 0.27 =
* Fixed an issue where calendars couldn't be deleted if they contained apostrophes
* Global timezone, daylight savings issues fixed. Now requires PHP 5.2 or greater. No support for OS X servers at this time. (sorry)
* Fixed issues where tagging events with categories and tags wouldn't work correctly
* Added the ability to search for events with WP_Query. Use post_type = 'event'
* Added a couple fixes in WEC_Query that should provide more flexibility


= 0.26 =
* Fixed an issue where getting the URL doesn't work correctly. Thanks to Russell for this one!
* Disabled the widget, as it is not yet complete, and shouldn't be visible!

= 0.25 =
* Fixed an issue where automatic recurrences wouldn't work
* Fixed an issue where nothing would be displayed in calendar view if no calendars existed
* Fixed an issue that would cause validation errors if adding an item from 12:00 PM -> 1:00 PM
* Added support for different start and end dates
* Added support for tagging and categorizing events
* Revamped UI for creating events
* Fixed an issue where after deleting an event from calendar view you would be sent back one month
* Added the ability to add an edit link on templates for easy access to edit events
* Added a url field for events
* Improved efficiency by lightening script calls and database reads
* Fixed an issue where some event titles wouldn't appear correctly
* Updated documentation

= 0.23 =
* Fixed a pathing issue on blogs where WordPress is not at the root of the domain

= 0.22 =
* Fixed a couple of bugs
* Greatly improved performance

= 0.21 =
* First release

== Upgrade Notice ==

= 0.27 =
* This version fixes issues with daylight savings time for repeating events. It also vastly improves stability.

= 0.26 =
This version fixes an issue where getting the URL in a template doesn't work properly.

= 0.25 =
This version fixes issues where events don't repeat correctly

= 0.23 =
This version fixes a pathing bug. Update recommended

= 0.22 =
This version improves efficiency


== Screenshots == 
1. The main page. Shows events and their recurrences
2. The calendar view
3. The event creation screen