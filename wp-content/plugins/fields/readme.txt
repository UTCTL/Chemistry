=== Fields ===
Contributors: Khanh Cao
Tags: fields, custom, admin, meta, data
Requires at least: 3.0
Tested up to: 3.0
Stable tag: 0.5
Donate Link: http://calce.net/donate/

Creates custom write panels to manage post custom fields.

== Description ==

Fields is a Wordpress plugin that let you manage write panels in your write/edit page. Fields supports post types that can have UIs.

With Fields, you can define boxes which appear in your write panels. A box can contain a number of groups which are sets of custom fields that you can define. Boxes are displayed as meta boxes and groups are shown as tabs that can be switched inside boxes. Within a group, fields can be shown as either textfields, textarea, drop boxes, radio group or check boxes.

Fields does not create custom post types, to do so, use other plugins such as WP Post Type UI.

Brief structure of Fields:

* Fields can be: textfield, textarea, select (drop box), radio group and  check boxes
* A group contains fields
* A box contains groups
* You can choose which groups a box should include and which post types a box should appear in

== Installation ==

To install Fields:

1. Upload the 'fields' folder to the '/wp-content/plugins/' directory
2. Activate the plugin.
3. Administer in Settings - Fields

== Frequently Asked Questions ==

= Get custom field data =

* To display a custom field's value, use fs_meta($key, $single = true, $id = '')
* To get the value only, use fs_get_meta($key, $single = true, $id = '')

= Display custom fields in posts =

use shortcode *field* and *field_count* e.g. [field key="title"]. Parameters for [field] are:

* key => '' (required)
* single => 'yes' ('yes'/'no')
* separator => ', '
* first_separator => ''
* last_separator => ''
* before => ''
* after => ''
* before_item => ''
* after_item => ''
* index => ''
* slug => ''
* post_type => ''
* post_status => 'publish'

== Screenshots ==

1. A box with two groups and fields
2. Boxes management
3. Groups management
4. Fields management

== Changelog ==

= 0.4.3 =

* Textfields with multiple values now can optionally be unordered. Unordered Textfields have their values in plain text which can be used in query_posts() or wp_query()

= 0.4.2 =

* Export page did not show groups correctly due to a html bug (thanks to Urbn for the fix)
* Export function may now correctly export a box's position

= 0.4.1.1 =

* Fixed a bug where a box with more than 1 groups would cause error

= 0.4.1 =

* Minor tweaks

= 0.4 =

* New option added to textfield: picker
* Fixed a bug where ampersand characters (&) in a field's attritutes caused the Export function to output invalid XML
* "Position" option was hidden in the edit box page
* Fixed a bug where boxes with no "position" option set did not show on edit screens

= 0.3.9.1 =

* Moved Options, Import and Export tabs into menu Options

= 0.3.9 =

* Added actions: fs_adding_box, fs_box_added, fs_editing_box, fs_box_edited, fs_box_deleted, fs_adding_group, fs_group_added, fs_editing_group, fs_group_edited, fs_adding_field, fs_field_added, fs_editing_field, fs_field_edited, fs_field_deleted
* Added new box options: position, include, exclude

= 0.3.8 =

* Fixed a bug where one-column groups were not displayed correctly in IE

= 0.3.7 =

* Minor css tweaks

= 0.3.6 =

* Fixed a bug where textfield and textarea did not show meta values correctly

= 0.3.5 =

* Testing Import & Export features

= 0.3.4.2 =

* Fixed a bug in field_get_meta() where it did not display multiple values properly

= 0.3.4.1 =

* Added filter 'fs_shortcode'
* The [field] shortcode now process shortcodes in its the field's value
* Fixed a bug where a single-column group did not show the delete button of a textfield

= 0.3.4 =

* field_get_meta() changed
* Groups now can have layout options

= 0.3.3 =

* Checkbox fields now show options to check all/none
* Radio fields now show option to clear selection
* Fixed a bug where tabs did not behave properly

= 0.3.2.3 =

* Minor tweaks

= 0.3.2.2 =

* Fixed a bug where fields could not be modified

= 0.3.2.1 =

* Fixed a bug where the addresses of the setting pages were not generated correctly when the Wordpress is installed as a sub folder
* Minor layout fix
* Removed textarea default values option

= 0.3.2 =

* Fixed a bug where textfield and textarea could not save when there are quotes in field data
* Removed "escape html" option on textfield

= 0.3.1 =

* Shortcodes now can reference other posts

= 0.3 =

* Checkboxes and Radio items can now have multi-column layouts

= 0.2.5.1 =
* Fixed a bug where the [field] shortcode did not display a textfield's multiple values properly

= 0.2.5 =
* Fixed a bug where a textfield's values were not saved in the correct order

= 0.2.4 =
* Fixed a bug where a just deleted field still shows on the group editing page
* Added shortcode 'field' and 'field_count'

= 0.2.3 =
* Textfields now can have multiple values
* Textfields can now store their values with or without html tags escaped
* Minor html bugs fixed
* Fields now can have notes attached
* Added an underscore as a prefix to all custom fields to hide them from the original Wordpress custom fields editor
* Added field_get_meta($meta, $single = true, $id = '') and field_meta($meta, $single = true, $id = ''), these functions can be used in themes to display fields

= 0.2.1 =
* Removed the debug panel
* Added a FAQ section

= 0.2 =
* Resolved some minor bugs
* Stable version

= 0.1 =
* First release