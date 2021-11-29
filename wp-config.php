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
define('DB_NAME', 'dual_enrollment');

/** MySQL database username */
define('DB_USER', 'root');

/** MySQL database password */
define('DB_PASSWORD', '');

/** MySQL hostname */
define('DB_HOST', '127.0.0.1:3307');

/** Database Charset to use in creating database tables. */
define('DB_CHARSET', 'utf8mb4');

/** The Database Collate type. Don't change this if in doubt. */
define('DB_COLLATE', '');
// define('WP_ALLOW_REPAIR', true);
define('FS_METHOD', 'direct');
/**#@+
 * Authentication Unique Keys and Salts.
 *
 * Change these to different unique phrases!
 * You can generate these using the {@link https://api.wordpress.org/secret-key/1.1/salt/ WordPress.org secret-key service}
 * You can change these at any point in time to invalidate all existing cookies. This will force all users to have to log in again.
 *
 * @since 2.6.0
 */
define('AUTH_KEY',         'pM=_yI5O_%z7w&V9K1.v_mekcUlm&,3nC@Y2(qV;Kc,Nr0?Kkj!iYj,(v:n^PLEL');
define('SECURE_AUTH_KEY',  'er=^>=GCRFSW~(*bC T2VDUXixEI4K_JV?rvk=q_.4J&(lXv;_y+p+}TBZp#=iNt');
define('LOGGED_IN_KEY',    'ZA `}E^t6}}xg70fs/H:h]!s1FZG>U%Qe#-/Xjd-wF6fHB$+=@#cLi~-jevU>)ea');
define('NONCE_KEY',        '3K9hQPUfB8 0>]8^Jh?8MC{XMbl8,@>`=|VP>13*7V4i.O?!LPW?o!fs+ky%|}B~');
define('AUTH_SALT',        ' Z#v/<%RCbu{dcKltP00E^HnE=)M5,0&}G(|AE@PmyKVud*gqHIhRy=06PfY6DF,');
define('SECURE_AUTH_SALT', 'A[UbKbbPC$+kF[2(1=I53%$cgU+|3]6wjCd&-&a,4Jkkk_:,YC#hz[ubV=_<>JLp');
define('LOGGED_IN_SALT',   '~W)>6 aLC``WCx]Khvt* RV{O(y&w%E {SpY_6zoo>;[P_`PC-3e(Pgt@11l)1Ct');
define('NONCE_SALT',       'IgwkZ@E*$_0y1Uy neB1wv0XPlyk1/|[c6I97%hnx{Nv3|B)wPSrItB+^&e*f3|b');
define('AUTOSAVE_INTERVAL', 300);
define('WP_POST_REVISIONS', 5);
define('EMPTY_TRASH_DAYS', 7);
define('WP_CRON_LOCK_TIMEOUT', 120);
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
define('WP_DEBUG', false);
define('ALLOW_UNFILTERED_UPLOADS', true);

/* That's all, stop editing! Happy publishing. */

/** Absolute path to the WordPress directory. */
if (!defined('ABSPATH')) {
	define('ABSPATH', __DIR__ . '/');
}

/** Sets up WordPress vars and included files. */
require_once ABSPATH . 'wp-settings.php';
