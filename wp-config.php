<?php
/**
 * The base configuration for WordPress
 *
 * The wp-config.php creation script uses this file during the installation.
 * You don't have to use the website, you can copy this file to "wp-config.php"
 * and fill in the values.
 *
 * This file contains the following configurations:
 *
 * * Database settings
 * * Secret keys
 * * Database table prefix
 * * ABSPATH
 *
 * @link https://developer.wordpress.org/advanced-administration/wordpress/wp-config/
 *
 * @package WordPress
 */

// ** Database settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define( 'DB_NAME', 'testsite' );

/** Database username */
define( 'DB_USER', 'root' );

/** Database password */
define( 'DB_PASSWORD', '1111' );

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
define( 'AUTH_KEY',         'mJHS(?#5}Rn.733;WUF}`}`!?yB._~|i<TAD.jmDNWUK~ghHHK#,EAULg/kj-d!W' );
define( 'SECURE_AUTH_KEY',  '5j9B:i%za%XtPs0d?Mx f 9e:i8a~3S; Knhf<PUBHBbi#EZ9 s/y7pF)n8a EGn' );
define( 'LOGGED_IN_KEY',    '&6&Iy|`6zY<RQoz}tO63 &]`@[p(ffen[cDQ+_s~g2),Hp9pxe3lm*D9YIozR_y(' );
define( 'NONCE_KEY',        ')2ujG =M^Or?/ zyaL*|M!v.}A^%., 4Sv^{)/ :}* nvW}=85MeuiN3=dxEj{gV' );
define( 'AUTH_SALT',        '~k^nq^JradlG7~QCRkU15(hGl[&M*RW6-YN1d&a0TLPcZ+-fWq*ST!zG_}9`1w_x' );
define( 'SECURE_AUTH_SALT', 'T/n{4Ob9Q4vr7qRF3C=?1#lNNX`dc9Xt5|+Lzx2PbA0!Nb{<Bh)R)2?=|]$yD%z[' );
define( 'LOGGED_IN_SALT',   'T$GgLCsmJuu1M^ke]!m;*Y8VM=2IpQ(/q0=q@(ci!6[q ez=oLE0ut)G1`,gJBrg' );
define( 'NONCE_SALT',       'v5iDV`j}ubAYIGxz:#Hw*d^bs`RN<%I?.CNaXe;Zaz#1<a0>CCJExR[luV0-VHi.' );

/**#@-*/

/**
 * WordPress database table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
 */
$table_prefix = 'nx_';

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
 * @link https://developer.wordpress.org/advanced-administration/debug/debug-wordpress/
 */
define( 'WP_DEBUG', false );

/* Add any custom values between this line and the "stop editing" line. */

define('FS_METHOD', 'direct');



/* That's all, stop editing! Happy publishing. */

/** Absolute path to the WordPress directory. */
if ( ! defined( 'ABSPATH' ) ) {
	define( 'ABSPATH', __DIR__ . '/' );
}

/** Sets up WordPress vars and included files. */
require_once ABSPATH . 'wp-settings.php';
