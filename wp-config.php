<?php
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
 * * ABSPATH
 *
 * @link https://wordpress.org/support/article/editing-wp-config-php/
 *
 * @package WordPress
 */

// ** Database settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define( 'DB_NAME', 'nmlcyajr_wp686' );

/** Database username */
define( 'DB_USER', 'nmlcyajr_wp686' );

/** Database password */
define( 'DB_PASSWORD', '5S)I29(jp5' );

/** Database hostname */
define( 'DB_HOST', 'localhost' );

/** Database charset to use in creating database tables. */
define( 'DB_CHARSET', 'utf8mb4' );

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
define( 'AUTH_KEY',         'jsrjrqpdvbhdvrekuxrkqv59bwbp9il5c0bomw4rl1n8glgsfeciifp20zrdxotk' );
define( 'SECURE_AUTH_KEY',  '94js1zxxjbirm8enmb9wlro3vrgxeci3fywq4vg5qqiqtx7xgta4pj1uaxqqo1td' );
define( 'LOGGED_IN_KEY',    'h58peggwwcuk8ciig3ybz6xv5on3t2lbvvsyfl0bftfpcqkxebqiye0w6dlfes0h' );
define( 'NONCE_KEY',        'lx95ie0txqtupbmz2biwwfamq4srkayj2q0nmjcuiq5h0ohy3csijwpn64dcmf4j' );
define( 'AUTH_SALT',        'ai6asxyj6x7wipntzayhsmkvppkffbcmgzix78xovh8sqzqek8piv3plbyowtfnl' );
define( 'SECURE_AUTH_SALT', 'bs2xofod7fyerfdjvwbuxnx4flsxdudfn8gw8xfdtxh6q1vhe4lvul41bsmmpexf' );
define( 'LOGGED_IN_SALT',   'mvsvjfltid0t4cn8yd5ith7rihkm7w83jolathxvkqinktiq2loizr57tfe0hmk9' );
define( 'NONCE_SALT',       'brndh0xhhapbnjriejagrgzrcitcw8vtjtjdrdya0lypy84tlmlonrfslue2vgpx' );

/**#@-*/

/**
 * WordPress database table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
 */
$table_prefix = 'wp2d_';

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

/* Add any custom values between this line and the "stop editing" line. */



/* That's all, stop editing! Happy publishing. */

/** Absolute path to the WordPress directory. */
if ( ! defined( 'ABSPATH' ) ) {
	define( 'ABSPATH', __DIR__ . '/' );
}

/** Sets up WordPress vars and included files. */
require_once ABSPATH . 'wp-settings.php';
