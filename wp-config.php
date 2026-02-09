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
define( 'DB_NAME', 'wordpress' );

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
define( 'AUTH_KEY',         'A3;7}(JdnHizM*KhZ@ptIxYCVZ<Q+y|d*+[:t4sm94(Tpr.+UgWXTQg|!@!}CR$U' );
define( 'SECURE_AUTH_KEY',  's|$0ZyN93G~0n?Vh{g&P45!t=NotyD&BZ#]32`Bv[IJt)`je,=TxM}{gbRS%dZ?y' );
define( 'LOGGED_IN_KEY',    '`o1*Pz#HVhI)8c< >F|9lUQ!pziNyt_E-1wRl=lF>OGC@y&hQ7Rpl8<aLsVv4i|N' );
define( 'NONCE_KEY',        '7gOXC7x[9t[#H5)`2hry{e ]~q|Jjw!`$/g!OFZ7Ae>mR9$U>$YZD^H@H1sLAi)&' );
define( 'AUTH_SALT',        '_6[pMA2w^hm_rSlj]E@7TK9o=?d%)]?;Vko 42z]N9Zdu?F3?hcLAc0L}5NK;[T6' );
define( 'SECURE_AUTH_SALT', '&$W>&b+5R|7_71F96w)zG=*%v/*tg|i)UpfE&m{f-6VI*C&AUwpyfe7/wG?U2N32' );
define( 'LOGGED_IN_SALT',   '/Lp:4Hl#7:/dnzIUeIJqI.Rl>YeZ82vh*081P%5*g1;>L8^x[IV8?K}!b;`S`NwM' );
define( 'NONCE_SALT',       'o>*L4XJlQv*l[y{4mIBK[Id4,q02#lEHQka7m[t{U7Qbwz CU!6r.GN$Z0V4$3eL' );

/**#@-*/

/**
 * WordPress database table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
 *
 * At the installation time, database tables are created with the specified prefix.
 * Changing this value after WordPress is installed will make your site think
 * it has not been installed.
 *
 * @link https://developer.wordpress.org/advanced-administration/wordpress/wp-config/#table-prefix
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
 * @link https://developer.wordpress.org/advanced-administration/debug/debug-wordpress/
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
