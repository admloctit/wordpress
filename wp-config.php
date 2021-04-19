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
 * @link https://wordpress.org/support/article/editing-wp-config-php/
 *
 * @package WordPress
 */

// ** MySQL settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define( 'DB_NAME', 'wordpress' );

/** MySQL database username */
define( 'DB_USER', 'root' );

/** MySQL database password */
define( 'DB_PASSWORD', '' );

/** MySQL hostname */
define( 'DB_HOST', 'localhost' );

/** Database Charset to use in creating database tables. */
define( 'DB_CHARSET', 'utf8mb4' );

/** The Database Collate type. Don't change this if in doubt. */
define( 'DB_COLLATE', '' );

/**#@+
 * Authentication Unique Keys and Salts.
 *
 * Change these to different unique phrases!
 * You can generate these using the {@link https://api.wordpress.org/secret-key/1.1/salt/ WordPress.org secret-key service}
 * You can change these at any point in time to invalidate all existing cookies. This will force all users to have to log in again.
 *
 * @since 2.6.0
 */
define( 'AUTH_KEY',         '}%0`*,YIDVf.VM+B7$#COf+%nLyJ|KT$G!0:B,5QgrZ!j2tR/[8/?WhpStl%~.<a' );
define( 'SECURE_AUTH_KEY',  'es4k5~`{`&B-t}pE{K%|c]ZXD.{,qk 65yOxz,; 6]&5pM3s8~g=fjVy0$oi7S2e' );
define( 'LOGGED_IN_KEY',    '_)7pXWtI95tm{Rwij=bH9.<6K@^SPkur{RCdZC!aLS)E](3sHDDMyKr-z7z0uH$$' );
define( 'NONCE_KEY',        ')b>HH>e}(UN8R+mCOKxc9:Pk?( 2Q`y3|Xqy<>ZFT=c2}c$VK,]Sodm,b7l4YI&R' );
define( 'AUTH_SALT',        'NQGg9t%I<*D}wkS&,JDwwXIyJ}:FT3br%Pf0wP[)k[]J^jQ:1$NmY1*2X+CF}|%q' );
define( 'SECURE_AUTH_SALT', '}r4n`kctLdZNR|z3fdRjD]9lU^OQH5K?D]m04c^}KB4G^-N{WEYW-1I2PX*fLhIA' );
define( 'LOGGED_IN_SALT',   'qDeHiEA>Yobw:#>K: W9[5J8 HS6XJj6[FVq8XeA?fpyV/|7NWfoAf1we2X!JF5=' );
define( 'NONCE_SALT',       'Q.&XRwD,afaa[)e_o@]#GY+rO1:7k}P-)M~-mlHDzYlc;Vx}N2GE{sHd72Vh~f0]' );

/**#@-*/

/**
 * WordPress Database Table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
 */
$table_prefix = 'wp_';

/**
 * For developers: WordPress debugging mode.
 *
 * Change this to true to enable the display of notices during development.
 * It is strongly recommended that plugin and theme developers use WP_DEBUG
 * in their development environments.
 *
 * For information on other constants that can be used for debugging,
 * visit the documentation.
 *
 * @link https://wordpress.org/support/article/debugging-in-wordpress/
 */
define( 'WP_DEBUG', false );

/* That's all, stop editing! Happy publishing. */

/** Absolute path to the WordPress directory. */
if ( ! defined( 'ABSPATH' ) ) {
	define( 'ABSPATH', __DIR__ . '/' );
}

/** Sets up WordPress vars and included files. */
require_once ABSPATH . 'wp-settings.php';
