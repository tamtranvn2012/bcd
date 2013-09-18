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
define('DB_NAME', 'bcdD');

/** MySQL database username */
define('DB_USER', 'thanh');

/** MySQL database password */
define('DB_PASSWORD', 'h5f9p5h4');

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
define('AUTH_KEY',         ' &oa]G>@:!vY5 (voI!9`(hsK|+Rz/(5$-RthB5c{!=.$}AK&C&rm6[37rb>pSy~');
define('SECURE_AUTH_KEY',  '+8sMF[rNV4be6$)~&;$[])AI~V~OWHNaTJ!m7jC{ZkCD-k?u4|_0Qm /zySneQUQ');
define('LOGGED_IN_KEY',    'Gydl/VO](1r#Nz$u}aN,/el9o8}l!.h(lKo?4mndVb@QL@@(T%=b4%noD@A;B_0|');
define('NONCE_KEY',        '@EkPK:Run{d7)K,dyrJ89|nWC6TGZ)vxy8gi{GN]%.oLs.q+wv^g-.)1]Z-7RyMI');
define('AUTH_SALT',        '#EdQ7|,&r_`@yEtlL,YIrnnZpNzH:zPR E7/*cxgvwTx2FUIbJ}V+tL;Q]pke+=l');
define('SECURE_AUTH_SALT', 'tznyra<7N,W{th/.Di{3Zb;R!UW2dJU-jQJ%TQ%y.{I*dSeiGFJXPJ2;U* 5}9$&');
define('LOGGED_IN_SALT',   '?z?+4%10 X5<^@@sw:xxyFf3UEosP=,:HYee)ll9D.p?@J5tBc=W.R*OG*5FOUhX');
define('NONCE_SALT',       '4>b3Ro)-KuYjKi#zBOGr1xQvh#tk!U=-{G4j.sG?).38uIm#eF-BLmCJWg@)2>U ');

/**#@-*/

/**
 * WordPress Database Table prefix.
 *
 * You can have multiple installations in one database if you give each a unique
 * prefix. Only numbers, letters, and underscores please!
 */
$table_prefix  = 'wp_rot';

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
/** add new membership level */
define("MEMBERSHIP_LEVELS", 10); 