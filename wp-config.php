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
define('DB_NAME', 'aml');

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
define('AUTH_KEY',         'M6q!M5IO]&bLE80nCD-8;>Jm<W,SWR7)kos2DxkRQ -VV6)2Ea!qO` 5WkFLmG6`');
define('SECURE_AUTH_KEY',  'ksP.2,+<B 02vEm$=o,~/1*k%78i CBuc/JrQ.{gmMD%POu,ftCT~u/5A>]a6NW>');
define('LOGGED_IN_KEY',    'Fc1QDE_^<(Pl]1ZJ}fw<@Cw>/Gy(`x%}fg7U%pw[D?-8ZiBu49;SgPx,%-G`}Koy');
define('NONCE_KEY',        'fp<)bi::;YqH2:@E ^ fKw,_kUlv8e^+/DzNbit^r%aK8Pkfnay;Qc[Oe.]D]SZX');
define('AUTH_SALT',        'B>wHWX?cgC*AhL^%=PRY0>&v*ax#0>p?:t9.27i._j(|v;;.=nm!g>*JfaU.Tm}{');
define('SECURE_AUTH_SALT', 'GF$z,>I9%<D +xom>laPUif0uyoN86gO@D_GR+In(Smrs.47@lz$[kne`yv`CR4j');
define('LOGGED_IN_SALT',   '!,FbkH~iIP_sD=reX+Dn9qhTXxl1FB56DDQd_HOkO};(3:H)XNsI5e-=Apm4PA}B');
define('NONCE_SALT',       'uH(9`uO`tjj;3~WYg##&tAXe0_VyC{USOB*Fks8%*+OW~,rpd%r26)xsFiC0.Ihq');

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
