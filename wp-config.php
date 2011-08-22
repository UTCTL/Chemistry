<?php
/**
 * The base configurations of the WordPress.
 *
 * This file has the following configurations: MySQL settings, Table Prefix,
 * Secret Keys, WordPress Language, and ABSPATH. You can find more information
 * by visiting {@link http://codex.wordpress.org/Editing_wp-config.php Editing
 * wp-config.php} Codex page. You can get the MySQL settings from your web host.
 *
 * This file is used by the wp-config.php creation script during the
 * installation. You don't have to use the web site, you can just copy this file
 * to "wp-config.php" and fill in the values.
 *
 * @package WordPress
 */

// ** MySQL settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define('DB_NAME', 'ch301');

/** MySQL database username */
define('DB_USER', 'ch301_app');

/** MySQL database password */
define('DB_PASSWORD', 'F9wcfueTQhxbJn8J');

/** MySQL hostname */
define('DB_HOST', 'localhost');

/** Database Charset to use in creating database tables. */
define('DB_CHARSET', 'utf8');

/** The Database Collate type. Don't change this if in doubt. */
define('DB_COLLATE', '');

/**#@+
 * Authentication Unique Keys and Salts.
 *
 * Change these to different unique phrases!
 * You can generate these using the {@link https://api.wordpress.org/secret-key/1.1/salt/ WordPress.org secret-key service}
 * You can change these at any point in time to invalidate all existing cookies. This will force all users to have to log in again.
 *
 * @since 2.6.0
 */
define('AUTH_KEY',         '/&G< Nj^^i]F|LzVJHFyK`ZJ1+2Zn&S*rD;g]Vho,*|#vk c5bCZC Gmv}#X(gnm');
define('SECURE_AUTH_KEY',  '*x<I`[f{Dn+!3SgoD;av;`4cD*IOHXvgJ-7ue0|Hhoq<{RW2VL@z2`5b_^srV}Da');
define('LOGGED_IN_KEY',    'SVq[k5Z51l7kF?|S]lHn~WCk`g(BcY#br]+.tu&cy+pp/l#~M2Tf131!)QTP||#i');
define('NONCE_KEY',        's>k~c:SkJ.Pr*uC!<r7&_Z?2]B2#Fmd>-2Bj=t+}GEQ2]P C<:;I&1yYxNj+EaXZ');
define('AUTH_SALT',        '7FB$1=#$]R?qy=G]a8[]xXgTZ$*%f6!gg]?k~N?V#wmGxsqQp4X2}$KWi3_9|exl');
define('SECURE_AUTH_SALT', '-Ec~*sef8}%nFbgD,I%^-~1y]&?3xjCKn5?!O!|X%wc)D+ P4|-vctaUP7TljxY*');
define('LOGGED_IN_SALT',   'a94p#}h@Kh:u:Sd-66^B%@163^yQT%vGDfLfzNhr%j!B7^XWK3.yc.^evSt[oQ$G');
define('NONCE_SALT',       '`uyy{x?PA9$Uce_vu g{|P.mRp$bR#6+>YEecN!.;piGa],.i_d!c<hWAIYq}>>v');

/**#@-*/

/**
 * WordPress Database Table prefix.
 *
 * You can have multiple installations in one database if you give each a unique
 * prefix. Only numbers, letters, and underscores please!
 */
$table_prefix  = 'wp_';

/**
 * WordPress Localized Language, defaults to English.
 *
 * Change this to localize WordPress. A corresponding MO file for the chosen
 * language must be installed to wp-content/languages. For example, install
 * de_DE.mo to wp-content/languages and set WPLANG to 'de_DE' to enable German
 * language support.
 */
define('WPLANG', '');

/**
 * For developers: WordPress debugging mode.
 *
 * Change this to true to enable the display of notices during development.
 * It is strongly recommended that plugin and theme developers use WP_DEBUG
 * in their development environments.
 */
define('WP_DEBUG', false);

/* That's all, stop editing! Happy blogging. */

/** Absolute path to the WordPress directory. */
if ( !defined('ABSPATH') )
	define('ABSPATH', dirname(__FILE__) . '/');

/** Sets up WordPress vars and included files. */
require_once(ABSPATH . 'wp-settings.php');
