=== Ultimate Post Type Manager ===
Contributors: deepak.seth
Donate link: https://www.paypal.com/cgi-bin/webscr?cmd=_donations&business=nikhilseth1989%40gmail%2ecom&item_name=WordPress%20Plugin%20(Ultimate%20Post%20Type%20Manager)&no_shipping=0&no_note=1&tax=0&currency_code=USD&lc=US&bn=PP%2dDonationsBF&charset=UTF%2d8
Tags: Custom Post Type,CPT,Ultimate Post Type,Post Type,Post,Post Type Manager
Requires at least: 2.9
Tested up to: 3.2 
Stable tag: trunk


This is an Easy to use Plugin to Create, Customize, Manage Custom Post Type.Do all you want to do with you Posts

== Description ==
This plugin is an **Easy to use Custom Post Type Manager** to Customize Post Types, with great UI.
**[Download now!](http://downloads.wordpress.org/plugin/ultimate-post-type-manager.zip)**.

**[[Plugin URL]](http://posttypemanager.wordpress.com/)** 

Some Features

* Create Custom Post Types.
* Customize every detail of Post Type.
* Create Rewrites for Permalink.
* Manage Supported Feature such as Title,Content,Excerpt,Comments etc.
* Very Easy to use interface.
* Automatically adds the Post type Count to Right Now box on Dashboard
* Automatically adds display of all post types to homepage and Feeds.

= Updates =

* Now Create Custom Fields for any Post Type
* Custom Field of Types Text, Textarea, Combobox.
* Use Shortcode to display Custom Fields.
* **Supports WordPress Multisite**
* Now Add default Post Tags and Cetegory to any Post type.
* Compaitble with WordPress 3.2 beta 2
* Option to define the template for post type
* Import/Export Custom Post Types
* Option to Make Your Own Custom Field Type.
* New Custom Fields Such as **Image,Link,Textarea, Rich Text area, Image Gallery**.
* Tabbed UI in Edit Post Meta Box.
* Modify Enter Title Here Text on Post Add/Edit Page



Also Check out **[[Ultimate Taxonomy Manager]](http://wordpress.org/extend/plugins/ultimate-taxonomy-manager/)**

== Installation ==

The automatic plugin installer should work for most people. Manual installation is easy and takes fewer than five minutes.

1. Upload 'ultimate-post-type-manager' directory to the `/wp-content/plugins/` directory
2. Activate the plugin through the 'Plugins' menu in WordPress
3. Navigate to Settings>Post Type Manager

ON Update deactivate the plugin and Reactivate it.

== Screenshots ==

1. The CPT Create administration screen of Ultimate Post Type Manager.
2. Listing of various Post Types
3. Custom Field Form on Post Page
4. Custom Field Designer


== Changelog ==


= 1.6.9 =
* Shortcodes should be working in custom post type format.
* Improved UX/UI
* Added function xydac_get_post_meta to access values directly with php
* Fixed working of Fields with - in fieldname
* Removed advanced option while adding custom post types.
* Fixed minor issues of message updated.
* Fieldtype:Image- Added WordPress inbuilt media library support.
* Fieldtype:CheckBox- Fixed Minor Issues.
* Added Enter Title Here Label
* Added shortcode list in the post.

= 1.6.8 =
* Fixed old data conversion issues.
* Fixed inclusion of non used script in header.

= 1.6.7 =
* Fixed data conversion problem for multisite.
* Fixed Checkbox issue
* Fixed some minor bugs

= 1.6.6 =
* Fixed the wrong Working of Radio Buttons, CSS changes for interfering with site style. Updated Documentation.

= 1.6.5 =
* Fixed the Multiple Values issues

= 1.6.4 =
* Fixed the Fieldtype classes issues

= 1.6.3 =
* Fixed the Content Issue

= 1.6.2 =
* Minor Bug Fixes

= 1.6.1 =
* Added POT file for translation

= 1.6 =
* Option to define the template for post type
* Import/Export Custom Post Types
* Option to Make Your Own Custom Field Type.
* New Custom Fields Such as Image,Link,Textarea, Rich Text area, Image Gallery.
* Fixed various Bugs and issues
* Improved performance
* Tabbed UI in Edit Post Meta Box.

= 1.5 =
* Custom Field Orders
* UI Improvement
* Updates all available options for WordPress 3.1
* Fixed Bugs
* Fixed Checkboxes and Radiobuttons.

= 1.4 =
* Radio Button added
* Checkbox Added
* Fixed Shortcode Bugs

= 1.3 =
* Added Enhancement to add default Category, Post Tags to any Post type.
* Fixed Bugs

= 1.2 =
* Fixed breaking of code on homepage and feeds

= 1.1 =
* Updated plugin to support WordPress Multisite.

= 1.0 =
* Major New Version Released
* Support for Custom Fields
* Support for Shortcodes

= 0.1 =
* New Plugin Released


== Frequently Asked Questions ==

Please let me know if you have any problem.

= I get ARRAY when using get_post_meta() =
I have used arrays to store data in custom fields. Please use a modified function xydac_get_post_meta() in the same way to fetch the values directly.

= How is the values stored in array in Custom Field =
Custom field hods two data fieldname and field value so I have stored the field name in the field name itself but changed the value part according to following rule.The values are stored in following way
`{field_type} => {field_value}`


== Upgrade Notice == 

= 1.6.9 =
* Shortcodes should be working in custom post type format. Improved UX/UI, Added function xydac_get_post_meta to access values directly with php, Fixed working of Fields with - in fieldname, Removed advanced option while adding custom post types, Fixed minor issues of message updated, Fieldtype:Image- Added WordPress inbuilt media library support,  Fieldtype:CheckBox- Fixed Minor Issues, Added Enter Title Here Label, Added shortcode list in the post.

= 1.6.7 =
* Fixed data conversion problem for multisite.Fixed Checkbox issue. Fixed some minor bugs

= 1.6 =
Option to define the template for post type, Import/Export Custom Post Types, Option to Make Your Own Custom Field Type, New Custom Fields Such as Image,Link,Textarea, Rich Text area, Image Gallery, Fixed various Bugs and issues, Improved performance. Definetly Upgrade to this release.

= 1.5 =
Custom Field Orders,UI Improvement,Updates all available options for WordPress 3.1,Fixed Bugs,Fixed Checkboxes and Radiobuttons.
= 1.4 =
Radio Button added, Checkbox Added, Fixed Shortcode Bugs

= 1.3 =
Added Enhancement to add default Category, Post Tags to any Post type and Fixed Bugs

= 1.2 =
Fixed breaking of code on homepage and feeds

= 1.1
Upgrade to this version if you are using WordPress Multisite.

= 1.0 =
New version with support for custom fields and shortcode.

= 0.1 = 
Fresh Plugin.