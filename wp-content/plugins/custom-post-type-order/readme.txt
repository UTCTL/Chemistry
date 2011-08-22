=== Custom Post Type Order ===
Contributors: momo360modena
Tags: custom, post, customposttype, type, custom type, post type, order, ordering, sort, menu_order, custom
Requires at least: 3.0
Tested up to: 3.0.1
Stable tag: 1.0

Add a page on admin for order items for each hierarchical custom post type

== Description ==

Add a page on admin for order items for each hierarchical custom post type
This plugin allow the same thing of "My Order Page", but for each hierarchical custom type !

Contrary to the plugin "My Order Page", you can modify the order and the hierarchy at one time.
The drag and drop works as the menus of WordPress 3.0

The effect JavaScript is a little bit sensitive for the moment, it is not always easy to control the movements.
If a kind soul wishes to improve the behavior, I am a buyer in 100 %!

== Installation ==

1. Upload `custom-post-type-order` directory to the `/wp-content/plugins/` directory.
2. Activate the plugin via the Plugins menu.
3. Order items via the "Custom Post Type" > "Order this" Settings menu added on each custom post type.

After, on your theme, you can by example list your items with :
	<?php wp_list_pages('title_li=&orderby=menu_order&post_type=books'); ?>

== Frequently Asked Questions  ==

Plugin is too limited for questions no ?

== Change Log ==

* Version 1.0
	* Make hierarchical javascript drag and drop
	* Add save button
* Version 0.9
	* initial release

== Screenshots ==

1. Order page
