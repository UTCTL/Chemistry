<?php
require('../../../wp-blog-header.php');
header('Content-type: text/css');

echo '/*
  CSS generated via the Suckerfish WordPress Plugin ... http://ryanhellyer.net/2008/01/14/suckerfish-wordpress-plugin/

  If you would like a similar dropdown for your own site, then please contact Ryan Hellyer for
  information about getting your own custom designed dropdown menu ... http://ryanhellyer.net/contact/
*/

';
echo get_option('suckerfish_css');
 ?>
