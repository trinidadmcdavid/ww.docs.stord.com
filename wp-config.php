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
 * @link https://wordpress.org/documentation/article/editing-wp-config-php/
 *
 * @package WordPress
 */

// ** Database settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define( 'DB_NAME', 'ww.docs.stord.com' );

/** Database username */
define( 'DB_USER', 'root' );

/** Database password */
define( 'DB_PASSWORD', '' );

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
define( 'AUTH_KEY',         'CMqZ!I*WBUF]]G8hJpTg?wA)EI%,J7bd`E&RSxsqL@Eja~Xv!Zn[_^, GDiNIuU~' );
define( 'SECURE_AUTH_KEY',  'zKsMewHs]E3Zf#TEqLjWs`s]0vdZiRt(9sQIs&^U@O^#k7[WMLsVOdLJMdM9m=4I' );
define( 'LOGGED_IN_KEY',    '+8I1bxG4Yp9}u=u{|)[ghL/:>YU$,Q~QBMiA?[MFTGEOnv2xBc4Pv!aPB>=t!Tj9' );
define( 'NONCE_KEY',        'T[h$<[(cz~[4IqM|j&-SpPayAQ6|{>2C4h[],p!bap[~@[#CD*o/_NF?<f$[y8Bg' );
define( 'AUTH_SALT',        'P;vvk; c8>XdG=L&2|t##n)wC^_-^R)l;Jc7vum`,^~edZ*(P+`? _0IW#BkS)Js' );
define( 'SECURE_AUTH_SALT', '4S,&m=<-Je.Y+/AM3TrHf|_5#r,(P/6R&miIkq[ll`Oc*4Z87V3>IRea2%s5SK}&' );
define( 'LOGGED_IN_SALT',   'Q_7441 gz(ML]`4H5b4*rLSQ`v/6oOFZc>9VSHdrd*vl16TGRlh24S)b6w-iqk>s' );
define( 'NONCE_SALT',       'H&4jL-WU>c&BWI6kGzp]|N#}/X#$SGdh5HxIV^L$lnI4/4&RM[A?M^{]8H{P.O+B' );

/**#@-*/

/**
 * WordPress database table prefix.
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
 * @link https://wordpress.org/documentation/article/debugging-in-wordpress/
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
