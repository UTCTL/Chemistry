=== wpmathpub ===
Contributors: ronf
Donate link: http://www.embeddedcomponents.com/blogs/wordpress/wpmathpub/
Tags: axiom, equation, math, mathematics, MathML, LaTeX, symbol, arrow, set, root, limit, operator, delimiter, matrix, constructor, sum, integral, derivative, calculus, phpmathpublisher, wpmathpub, plugin, formatting, Post, comments, images
Requires at least: 1.5
Tested up to: 3.0.4
Stable tag: 1.0.8

Display mathematical equations within your posts and comments.

== Description ==

Display mathematical equations within your posts and comments.

Put your plain text <a href="http://www.xm1math.net/phpmathpublisher/doc/help.html">mathmatical expressions</a> between [pmath size=xx]...[/pmath] tags. The optional size attribute controls how large the images will be displayed. Useful xx integer values range from 8 to 24. Size defaults to 12 when attribute omitted. Pascal Brachet's PHP Math Publisher <a href="http://www.xm1math.net/phpmathpublisher/">library</a> is included. 

== Installation ==

1. Unzip into your `/wp-content/plugins/` directory. If you're uploading it make sure to upload
the top-level folder wpmathpub. 
2. Make sure the newly installed ./wpmathpub/phpmathpublisher/img directory is readable and writable on your web server (See FAQ for more details) 
3. Activate the plugin through the usual 'Plugins' menu in WordPress

== Changelog ==

= 1.0.8 =
* Improved documentation

= 1.0.7 =
* Fixed a few bugs, improved documentation.

== Upgrade Notice ==

= 1.0.8 =
Just a documentation update

= 1.0.7 =
Stable version

= 1.0.6 =
Upgrade if you have this version


== Frequently Asked Questions == 

= Where can I try wpmathpub text image converstion? =

wpmathpub is based on Pascal Brachet's phpmathpublisher library. 

You can see phpmathpublisher in action from here:
[demo and test](http://www.xm1math.net/phpmathpublisher/examples/online_demo.php?message=%3Cm%3ES%28f%29%28t%29%3Da_%7B0%7D%2Bsum%7Bn%3D1%7D%7B%2Binfty%7D%7Ba_%7Bn%7D+cos%28n+omega+t%29%2Bb_%7Bn%7D+sin%28n+omega+t%29%7D%3C%2Fm%3E+&size=14&choix=Examples&bouton=See "click here to go to Pascal's phpmathpubisher demo page and test page")

Note: wpmathpub WordPress plugin uses [pmath]your math text[/pmath] to create math graphical equations within posts and comments. While, from Pascal's demo and test site, you will use &lt;m&gt;your math text&lt;/m&gt; to create math equations.

= The [pmath] tag doesn't seem to work. How can I solve this problem? =

Starting with version 1.0.7, use the wpmathpub plugin status display menu from your blog's admin site's "Manage" menu. See screenshot #5 (in the screenshots tab) for details. The status display will:

* check your system for correct access to required directories, 
* determine if required libraries are available, and 
* show a sample math conversion from text to image format.

= Do some plugins interfere with the wpmathpub plugin? =

Starting with version 1.0.7, an enhanced priority scheme was implemented to improve reliability and better cooperation with some high bandwidth video streaming plugins. 

At this time, only one plugin is known to play havoc with display of math images from within comments called: Live Comment Preview.  Blog posts are not affected. This plugin causes the [pmath] start tag to get out of sync with the [/pmath] end tag.  

If you suspect plugin interferance, a simple test is to disable all of your plugins except wpmathpub. If wpmathpub works without other plugins, start turning on your plugins one by one to see which one(s) are interfering with [pmath] tag filtering.  If you find one, let me know - I may be able to find a solution.

= During installation how can I make sure the 'img' directory has write access? =

The 'img' directory needs write access to create new math images from your blog's math text. Starting with version 1.0.5, the wpmathpub plugin automatically assigns the correct access rights to the 'img' directory on Linux/Unix installations. This auto-assignment feature can be turned off by changing line 55 in wpmathpub.php to read:

define("AUTOCHMOD", false);

Below is a sample bash shell session demonstrating how to manually locate the 'img' directory, change its mode to include write access, and verify the change was made:

<br/>-bash-3.00$ cd wp-content
<br/>-bash-3.00$ cd plugins
<br/>-bash-3.00$ cd wpmathpub
<br/>-bash-3.00$ cd phpmathpublisher
<br/>-bash-3.00$ chmod 755 img
<br/>-bash-3.00$ stat -c %a img
<br/>755
<br/>-bash-3.00$ stat -c %A img
<br/>drwxr-xr-x

= How can I disable the use of [pmath] tags within blog comments? =

By default, the wpmathpub plugin supports user generated math equations in comments. Starting with wpmathpub plugin version 1.0.6, you can disable the use of [pmath] tags in comments by changing line 58 in wpmathpub.php to read:

define("ENGAGECOMMENTS", false);

This setting will not affect the display of math equations in blog posts and pages.


= Can I use HTML entities like "& gt;" (for ">") in my math text equations? =

Starting with wpmathpub version 1.0.5 HTML entities are supported.

= Can I use pmath tags in blog posts AND blog comments? =

Starting with wpmathpub version 1.0.5 both blog posts and comments support pmath tags.

= I have a new Q =
You may go to the WordPress wpmathpub support page to ask questions:
[WordPress wpmathpub Support Page](http://www.embeddedcomponents.com/blogs/2008/03/wpmathpubsupport/ "WordPress wpmathpub Support Page")

== Screenshots ==

1. WordPress post with [pmath] tags mixed with plain text
2. WordPress comments with [pmath] tags mixed with plain text (as shown from WP v:2.5.1 admin tool's detail view)
3. WordPress plugin management page after upload and activation
4. Sample directory structure of this plugin within a WordPress installation
5. status display from the author's blog > Manage > wpmathpub menu

== How To ==

To toggle to the math mode within your blog's content, you must use the [pmath size=xx]...[/pmath] markdown tag. The plugin automatically replaces your math text commands into HTML image tags that look sort of like this: 
&lt;img src="MathFileName.png" style="vertical-align:-xxpx; display: inline-block ;" alt="your math text command"/&gt;.

The math commands must be separated by a space character or surrounded by {}.

Examples: 

* [pmath size=xx]S(f)(t)=a_{0}+sum{n=1}{+infty}{a_{n} cos(n omega t)+b_{n} sin(n omega t)}[/pmath] 
* [pmath size=xx]delim{lbrace}{matrix{3}{1}{{3x-5y+z=0} {sqrt{2}x-7y+8z=0} {x-8y+9z=0}}}{ }[/pmath] 
* [pmath size=xx]delim{|}{{1/N} sum{n=1}{N}{gamma(u_n)} - 1/{2 pi} int{0}{2 pi}{gamma(t) dt}}{|} <= epsilon/3[/pmath]

Math elements supported:

* Usual commands
* Parenthesis
* Math space
* Greek letters
* Symbols
* Arrows
* Sets
* Roots
* Limits
* Big operators
* Delimiters
* Matrix
* Constructors

[pmath syntax](http://www.xm1math.net/phpmathpublisher/doc/help.html "See complete list of elements and the symbols they generate here")
