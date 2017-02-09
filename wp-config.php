<?php
/**
 * The base configuration for WordPress
 *
 * The wp-config.php creation script uses this file during the
 * installation. You don't have to use the web site, you can
 * copy this file to "wp-config.php" and fill in the values.
 *
 * This file contains the following configurations:
 *
 * * MySQL settings
 * * Secret keys
 * * Database table prefix
 * * ABSPATH
 *
 * @link https://codex.wordpress.org/Editing_wp-config.php
 *
 * @package WordPress
 */

// ** MySQL settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define('DB_NAME', 'gaston');

/** MySQL database username */
define('DB_USER', 'root');

/** MySQL database password */
define('DB_PASSWORD', '');

/** MySQL hostname */
define('DB_HOST', 'localhost');

/** Database Charset to use in creating database tables. */
define('DB_CHARSET', 'utf8mb4');

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
define('AUTH_KEY',         'n|gAgRCm7_9ctw1-HV9t1>(|{|YJK~L/:l k76keM@|6<!H=+hkgV9ptp7-Ja=DE');
define('SECURE_AUTH_KEY',  'Z<zO]*|(X(s|bfI]bFnmSB@TMJ&(0XF5 2BUL)2}AM1WNZq/@#;v:82Ri^s%[;s5');
define('LOGGED_IN_KEY',    'Ow9abQr!5sxsmI?HL>o5n.0.(D?7+XG EpIwpDJcb^[}* w,j|/D|Gvftp^mQMsC');
define('NONCE_KEY',        'no9.Q|[!rie1 O1>lV@@Ot9725R5-00KpgV)KzS7|pde 4=fI$S>Lea1.D0qsaH2');
define('AUTH_SALT',        'AX40=)El;*`nk;#13UVYwg?3r9i|BMQZOp#0s5rcFGGFle~iUKY2[Sh[)+NFP*)n');
define('SECURE_AUTH_SALT', ';x%2<vC9)5]ACPX72=zee!vCs?|zCop9,Kp5-,u<h2k&c+G/U1L&D?Kl2p}@CS&%');
define('LOGGED_IN_SALT',   '=AI(3&5p:}hg9e[c7Pt=TZ#&p}V8/y[;f]dE%_{@ofqFVB1*5I~(S*:PrTW-T`%W');
define('NONCE_SALT',       'xl!GD?97UTXPFi>!F<`o~ @EcdliS]]R,v)ou9Vx:9<U}3GQ _A;sCM-L)7xX>AE');

/**#@-*/

/**
 * WordPress Database Table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
 */
$table_prefix  = 'wp_';

/**
 * For developers: WordPress debugging mode.
 *
 * Change this to true to enable the display of notices during development.
 * It is strongly recommended that plugin and theme developers use WP_DEBUG
 * in their development environments.
 *
 * For information on other constants that can be used for debugging,
 * visit the Codex.
 *
 * @link https://codex.wordpress.org/Debugging_in_WordPress
 */
define('WP_DEBUG', false);

/* That's all, stop editing! Happy blogging. */

/** Absolute path to the WordPress directory. */
if ( !defined('ABSPATH') )
	define('ABSPATH', dirname(__FILE__) . '/');

/** Sets up WordPress vars and included files. */
require_once(ABSPATH . 'wp-settings.php');
