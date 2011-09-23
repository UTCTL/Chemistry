=== Plugin Name ===
Contributors: unijimpe
Donate link: http://blog.unijimpe.net/
Tags: flash, swf, flv, swfobject, video, youtube, media, player, post
Requires at least: 1.5
Tested up to: 2.8
Stable tag: 2.3

Insert Flash Movies into WordPress.

== Description ==

This plugin enable insert flash movies into WordPress using **SWFObject** library for prevening EOLA'S. 

**Features**

*	Easy install
*	Insert Flash movie with simple code
*	Panel for easy configuration
*	Config flash player version required
*	Config message for iPhone Browser
*	Support FlashVars param
*	Support FullScreen param
*	Generate `<object>` code for RSS compatibility	
*	Select version of SWFObject (1.5 or 2.0)
*	Allow use SWFObject from Google AJAX Libraries API
*	Detect iPhone Browser to show message o link for Youtube Videos
*	Easy integration with Youtube videos
*	Support for show Loading image

For insert single swf into post use:

`[SWF]movie.swf, width, heigth[/SWF]`

For insert swf with flashvars use:

`[SWF]movie.swf, width, heigth, var1=val1&var2=val2[/SWF]`

For insert swf into code of blog use:

`<?php wp_swfobject_echo("movie.swf", "width", "heigth"); ?>`


For more information visit [plugin website](http://blog.unijimpe.net/wp-swfobject/ "plugin website")



== Installation ==

This section describes how to install the plugin and get it working.

1. Upload folder `wp-swfobject` to the `/wp-content/plugins/` directory
1. Activate the plugin through the 'Plugins' menu in WordPress
1. Configure plugin into 'Settings' -> 'WP-SWFObject' menu


== Screenshots ==

1. Install and Activate plugin is easy.
2. Config panel for WP-SWFObject.


