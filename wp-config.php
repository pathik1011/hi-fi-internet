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
define( 'DB_NAME', 'hi-fi-internet' );

/** MySQL database username */
define( 'DB_USER', 'root' );

/** MySQL database password */
define( 'DB_PASSWORD', '' );

/** MySQL hostname */
define( 'DB_HOST', '127.0.0.1' );

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
define( 'AUTH_KEY',         'jVah~Co[+ uT2x;idJX}Dn:(Z8/oP+Y@EiEJ|joOe=floR4R+<cHl&?@Z@>4^UVY' );
define( 'SECURE_AUTH_KEY',  ':jZH79z_SJ$h:sBGR/2!sApnescH8tD=yb$IZc<<Tx?EdC}@Qu:Od3PTCTUI@7]c' );
define( 'LOGGED_IN_KEY',    '$y{v^Pxqd67c@oq!X?j!]f[U&dydN0honjXp=U>A$^Xc4c3u(aT=:H~q0^|_R4@+' );
define( 'NONCE_KEY',        '}Cf6u21ykm+tsi=bPGa13ZRjQ]w$WB%aV]=lH3,qX}c!-CEpKk=)vbD_Q!1X0*~J' );
define( 'AUTH_SALT',        'hY^JZ[6K+FfC#`,rP9spQvA#/~%Bd1$>a=L!_I|ZBHNz*1rEYp4Ui+rNK`<u zOY' );
define( 'SECURE_AUTH_SALT', '^~VJ]Z<BXH65F N14.<Q,c6?j! wl^A5k!k{nV!RC]G7y%mWOyUL_9E@%F]w_oD9' );
define( 'LOGGED_IN_SALT',   'rFl}]Jhq:;tr~IMCgI&9`8nM-7Qs9gsWT(b@-p8YwDtqFRL,dN w^hw,$gO-L_YV' );
define( 'NONCE_SALT',       '1SaiOB&VMz;cSyiHmY^_[J!`(1S-MFYe^^<txxt_|Ktcr%$1s/{>]_+nIm}4KO,J' );

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
