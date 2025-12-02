<?php
/**
 * WordPress Configuration Template for Lumina International School
 * 
 * This file contains the recommended WordPress configuration settings
 * for the Lumina International School website.
 * 
 * INSTRUCTIONS:
 * 1. Copy this file to your WordPress root directory
 * 2. Rename it to wp-config.php
 * 3. Fill in your actual database credentials
 * 4. Generate new security keys from https://api.wordpress.org/secret-key/1.1/salt/
 * 5. Adjust any settings as needed for your hosting environment
 */

// ** Database settings - Fill these in with your actual values ** //
/** The name of the database for WordPress */
define( 'DB_NAME', 'lumina_wp_db' );

/** Database username */
define( 'DB_USER', 'lumina_wp_user' );

/** Database password */
define( 'DB_PASSWORD', 'your_secure_password_here' );

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
 */
define( 'AUTH_KEY',         'put your unique phrase here' );
define( 'SECURE_AUTH_KEY',  'put your unique phrase here' );
define( 'LOGGED_IN_KEY',    'put your unique phrase here' );
define( 'NONCE_KEY',        'put your unique phrase here' );
define( 'AUTH_SALT',        'put your unique phrase here' );
define( 'SECURE_AUTH_SALT', 'put your unique phrase here' );
define( 'LOGGED_IN_SALT',   'put your unique phrase here' );
define( 'NONCE_SALT',       'put your unique phrase here' );

/**#@-*/

/**
 * WordPress database table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
 */
$table_prefix = 'lum_';

/**
 * For developers: WordPress debugging mode.
 *
 * Change this to true to enable the display of notices during development.
 * It is strongly recommended that plugin and theme developers use WP_DEBUG
 * in their development environments.
 */
define( 'WP_DEBUG', false );
define( 'WP_DEBUG_LOG', true );
define( 'WP_DEBUG_DISPLAY', false );

/**
 * Security Settings
 */

// Disable file editing in WordPress admin
define( 'DISALLOW_FILE_EDIT', true );

// Force SSL for admin and login
define( 'FORCE_SSL_ADMIN', true );

// Increase memory limit for better performance
define( 'WP_MEMORY_LIMIT', '256M' );
define( 'WP_MAX_MEMORY_LIMIT', '512M' );

/**
 * Performance Settings
 */

// Enable automatic database optimization
define( 'WP_AUTO_UPDATE_CORE', 'minor' );

// Limit post revisions
define( 'WP_POST_REVISIONS', 5 );

// Set autosave interval (in seconds)
define( 'AUTOSAVE_INTERVAL', 300 );

// Increase PHP execution time for large operations
@ini_set( 'max_execution_time', 300 );

/**
 * File Upload Settings
 */

// Maximum file upload size (adjust based on hosting limits)
@ini_set( 'upload_max_size', '64M' );
@ini_set( 'post_max_size', '64M' );
@ini_set( 'max_execution_time', '300' );

/* That's all, stop editing! Happy publishing. */

/** Absolute path to the WordPress directory. */
if ( ! defined( 'ABSPATH' ) ) {
	define( 'ABSPATH', __DIR__ . '/' );
}

/** Sets up WordPress vars and included files. */
require_once ABSPATH . 'wp-settings.php';
