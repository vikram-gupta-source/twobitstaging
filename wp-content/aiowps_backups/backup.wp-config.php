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
define('WP_CACHE', true);
define( 'WPCACHEHOME', 'C:\Users\Alex Nguyen\Work\Working\twobitcircus\dev\wp-content\plugins\wp-super-cache/' );
define('DB_NAME', 'wp_twobitdev');

/** MySQL database username */
define('DB_USER', 'root');

/** MySQL database password */
define('DB_PASSWORD', 'root');

/** MySQL hostname */
define('DB_HOST', '192.168.1.36');

/** Database Charset to use in creating database tables. */
define('DB_CHARSET', 'utf8');

/** The Database Collate type. Don't change this if in doubt. */
define('DB_COLLATE', 'utf8_unicode_ci');

/**#@+
 * Authentication Unique Keys and Salts.
 *
 * Change these to different unique phrases!
 * You can generate these using the {@link https://api.wordpress.org/secret-key/1.1/salt/ WordPress.org secret-key service}
 * You can change these at any point in time to invalidate all existing cookies. This will force all users to have to log in again.
 *
 * @since 2.6.0
 */

 # Security Salts, Keys, Etc
 define('AUTH_KEY',         'x* 2+KcKu68^B5vCW`HYZztv;sY+nf`+KbP!dX b7@$ k.8png+^jdAjK~ YYK^+');
 define('SECURE_AUTH_KEY',  'd*9+8}<b<|,%a*C>(q><b@n5+>;X8Pt7F-}.:xX./I.B1NDlahT7p|D&.etaTa-Z');
 define('LOGGED_IN_KEY',    '^-JVxWm*hJmBh;?%|fULZ?+Aln!N=9?{}>!@tI6Yy-^NU>qiH(4|E5TcAi`=dt6A');
 define('NONCE_KEY',        'bGIk<a0b2qfAp7pqmMVX4-r|)JN, j3K+NZ;C/@DOmcB@W*eX6HxeE2HL;V$s5D%');
 define('AUTH_SALT',        '26H[i!_}b)s.GE@KS% kLQ&tygYq=Z,f -B#,t+V``EqSBHq+zg+ZoJJEKf|oh_s');
 define('SECURE_AUTH_SALT', 'I<|L~A?{iG&)URNKW0_44QLNaRQlG={0+hO2E!F]wcja/9WN] LU8CL>`3s16B,.');
 define('LOGGED_IN_SALT',   'U!HU[tVS& pYHO3LnS@@_dsURKm_;4P-EFI>U^Nq%>kq%T&!%sb +W(hz*wLol.p');
 define('NONCE_SALT',       'O3!9j,*-wh%p`x%+rarn`+a+:>mMwHBv1[|-`9YZePi:0zzUvkQi+l~+c9.);sX&');

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
define('WP_DEBUG', true);
define( 'WPCF7_VALIDATE_CONFIGURATION', false );

/* That's all, stop editing! Happy blogging. */

/** Absolute path to the WordPress directory. */
if ( !defined('ABSPATH') )
	define('ABSPATH', dirname(__FILE__) . '/');

/** Sets up WordPress vars and included files. */
require_once(ABSPATH . 'wp-settings.php');
