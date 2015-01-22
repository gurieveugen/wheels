<?php
/**
 * The base configurations of the WordPress.
 *
 * This file has the following configurations: MySQL settings, Table Prefix,
 * Secret Keys, and ABSPATH. You can find more information by visiting
 * {@link http://codex.wordpress.org/Editing_wp-config.php Editing wp-config.php}
 * Codex page. You can get the MySQL settings from your web host.
 *
 * This file is used by the wp-config.php creation script during the
 * installation. You don't have to use the web site, you can just copy this file
 * to "wp-config.php" and fill in the values.
 *
 * @package WordPress
 */

// ** MySQL settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define('DB_NAME', 'dev_wp');

/** MySQL database username */
define('DB_USER', 'wp');

/** MySQL database password */
define('DB_PASSWORD', 'WcLqfUZUSumcuTKJ');

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
define('AUTH_KEY',         '|GhZurNB:oe@v-Sx<Al:&&Q{X;HD}bw2&mZ$pP V]Ix<Ymw3|v@FE--|] f_Uj9P');
define('SECURE_AUTH_KEY',  'VGI4]D,X!S9`[WP`>]?B(@a|i7kIDg-Hl]VaEA~&|^f#8|p.E2t]i^9q5E5`,U@?');
define('LOGGED_IN_KEY',    ']f;~8Xj6#<6qtLCj3z+_z<OxF3QK^-tIcy45;Tf@&^4>eHom_Q+E_y`a+v~[edg-');
define('NONCE_KEY',        'G}+OdaN;QzYl/<m^ +/I%&Y<?ELP%:GuFi?>,[N.Dx!M, $eYjVJb0g**5>QeNuP');
define('AUTH_SALT',        '8{#$s3^nE5WM>!z#>?X=%rv%Yyb]S?/G#Vm:2rfZ+(ClR?/[s{gt_D,O|+@ren+L');
define('SECURE_AUTH_SALT', 'Xjh&Gm6y;jH[]8+a[%H<ffa}PY_yr]&}EWn2D~DLldRYQexvfJ$xIp0i[cx[Ma22');
define('LOGGED_IN_SALT',   'wvxa-axlgMU$~f%v<JiRU>2@yoW0tA-4o>P}swm!MIg6LIzx*~PW K?v8~pHhV*0');
define('NONCE_SALT',       'kxIhk,[TJC5PdVB[bV5mZhJu83LZX/DduJ+}D}3|vCPU)0.Wr!-`6UK@&ge1Ehgh');



/**#@-*/

/**
 * WordPress Database Table prefix.
 *
 * You can have multiple installations in one database if you give each a unique
 * prefix. Only numbers, letters, and underscores please!
 */
$table_prefix  = 'wp_';

/**
 * For developers: WordPress debugging mode.
 *
 * Change this to true to enable the display of notices during development.
 * It is strongly recommended that plugin and theme developers use WP_DEBUG
 * in their development environments.
 */
// Development
define('SAVEQUERIES', true);
define('WP_DEBUG', true);
define('SCRIPT_DEBUG', true);

// Themosis framework
define('THEMOSIS_ERROR_DISPLAY', true);
define('THEMOSIS_ERROR_SHUTDOWN', true);
define('THEMOSIS_ERROR_REPORT', -1);

/* That's all, stop editing! Happy blogging. */

/** Absolute path to the WordPress directory. */
if ( !defined('ABSPATH') )
	define('ABSPATH', dirname(__FILE__) . '/');

/** Sets up WordPress vars and included files. */
require_once(ABSPATH . 'wp-settings.php');
