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
define('DB_NAME', 'magis_wp');

/** MySQL database username */
define('DB_USER', 'magis');

/** MySQL database password */
define('DB_PASSWORD', 'To/*magis321');

/** MySQL hostname */
define('DB_HOST', 'localhost');

/** Database Charset to use in creating database tables. */
define('DB_CHARSET', 'utf8');

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
define('AUTH_KEY', 'UaH5d0MV65zvCerylQaGzLcvyjnhonxViCS1SSdSSiI0i2M87fRsvZlmZ7gKhyYH');
define('SECURE_AUTH_KEY', 'Fb14DCWAxwNXZHH2NyFBoZXFXixgvXKUDO9PheDB2j7usUPwz7ZbjseHD3cvj8rH');
define('LOGGED_IN_KEY', 'Yxk0xxoK82SBbPq4sumgn72oqz6BtThBYEfgXVInbgfAFsXiilLVy1MPjo2ieSWa');
define('NONCE_KEY', '5pyhOPOBIE6b1fwqAmF70dMq2kPn5TeXjADSGDsSra9g3HNhuPsFK84ji7l9Nz11');
define('AUTH_SALT', '3V8txcW4OItI7Ni2TwoBH7vIr2pxr0tZ16PIZJdibRCIFj9sSxU7UbrXt74uNZ9M');
define('SECURE_AUTH_SALT', 'OsAS3cSOappdLDCXT2KvO5GWDckdufjiytQwwTI4ix0BgcqhJqTSrT8j0slJ5st9');
define('LOGGED_IN_SALT', 'DzQ4Vwej2NswBxpYAgDshiMMjYNupnJrd29I8AbJMpiUmLYnPRg5PlyqHqgtatOZ');
define('NONCE_SALT', 'QBvZ3AEcpJ3NEXpVE9NDbjg9sid0LaG5GpYYtlCKZPxntgGfknDQ7puGZney92oM');

define('WP_HOME','http://localhost');
define('WP_SITEURL','http://localhost');

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
