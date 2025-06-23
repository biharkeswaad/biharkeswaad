<?php
define( 'WP_CACHE', true );

/**
 * The base configuration for WordPress
 *
 * The wp-config.php creation script uses this file during the installation.
 * You don't have to use the web site, you can copy this file to "wp-config.php"
 * and fill in the values.
 *
 * This file contains the following configurations:
 *
 * * Database settings
 * * Secret keys
 * * Database table prefix
 * * Localized language
 * * ABSPATH
 *
 * @link https://wordpress.org/support/article/editing-wp-config-php/
 *
 * @package WordPress
 */

// ** Database settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define( 'DB_NAME', 'u597229210_nBIJU' );

/** Database username */
define( 'DB_USER', 'u597229210_2idou' );

/** Database password */
define( 'DB_PASSWORD', 'fTWRWRf0vD' );

/** Database hostname */
define( 'DB_HOST', '127.0.0.1' );

/** Database charset to use in creating database tables. */
define( 'DB_CHARSET', 'utf8' );

/** The database collate type. Don't change this if in doubt. */
define( 'DB_COLLATE', '' );

/**#@+
 * Authentication unique keys and salts.
 *
 * Change these to different unique phrases! You can generate these using
 * the {@link https://api.wordpress.org/secret-key/1.1/salt/ WordPress.org secret-key service}.
 *
 * You can change these at any point in time to invalidate all existing cookies.
 * This will force all users to have to log in again.
 *
 * @since 2.6.0
 */
define( 'AUTH_KEY',          ':+X>/hD10Fu3.W`}}XG:^*$(=1aj()26s* nO*~@sps,M73^]+mnepsMmT[:9|1?' );
define( 'SECURE_AUTH_KEY',   'HYR8g,3k1R^6cAU]r3I.&jI<(WG9pPMaqycZW1abl-p 8T;+&ON$t/iW^jT:]|@ ' );
define( 'LOGGED_IN_KEY',     '>28:l@u6*KmTfT1BluADi&bKOeV^]F67+5vF|4y|:!%?}KB>I7/rnoq`N?euA>k#' );
define( 'NONCE_KEY',         'e}n)mY>vPd8/,96MNH#QhJh mEB)_=-?lzW$KB-:0heuw &<T)35()|*: ]zi2<*' );
define( 'AUTH_SALT',         'T;Vsst%(<!]h=5tYx$|I]V[wQq)#cV7-4|iry?Rym.4$wRt`jJEhc_gK)w&>oF~W' );
define( 'SECURE_AUTH_SALT',  'h4ac^X<1~}2,@9g#G$|%<9xFgMi^nQ}^5fb5,)InDdfH.F-gsZg$<~ME,bhuEPYA' );
define( 'LOGGED_IN_SALT',    'K0Lo2WH4#XKv0rK68R*[@wR2r88sl(++TA{A-`qsw%A[bh1 p:-Tio@q>Lohy?|u' );
define( 'NONCE_SALT',        'qujoC(rs~&7qqyHEmo-FeA?w0e1QHb2AW=,JjRQqWbQ6u:nBf$|#;*XnM_:2pg/k' );
define( 'WP_CACHE_KEY_SALT', '2#XdKbm#X[{N<;eUwkLk0f5C?Uhd+M}SwS%K3Yn7Oa<P>kc@WmFIIMbx^JiV=GZF' );


/**#@-*/

/**
 * WordPress database table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
 */
$table_prefix = 'wp_';


/* Add any custom values between this line and the "stop editing" line. */



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
if ( ! defined( 'WP_DEBUG' ) ) {
	define( 'WP_DEBUG', false );
}

define( 'FS_METHOD', 'direct' );
define( 'COOKIEHASH', '621457b74b6016806f3fac73975238b6' );
define( 'WP_AUTO_UPDATE_CORE', 'minor' );
/* That's all, stop editing! Happy publishing. */

/** Absolute path to the WordPress directory. */
if ( ! defined( 'ABSPATH' ) ) {
	define( 'ABSPATH', __DIR__ . '/' );
}

/** Sets up WordPress vars and included files. */
require_once ABSPATH . 'wp-settings.php';
