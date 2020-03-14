<?php
/**
 * Bootstrap file for setting the ABSPATH constant
 * and loading the wp-config.php file. The wp-config.php
 * file will then load the wp-settings.php file, which
 * will then set up the WordPress environment.
 *
 * If the wp-config.php file is not found then an error
 * will be displayed asking the visitor to set up the
 * wp-config.php file.
 *
 * Will also search for wp-config.php in WordPress' parent
 * directory to allow the WordPress directory to remain
 * untouched.
 *
 * @package WordPress
 */

if ( ! defined( 'DS' ) ) {
    define('DS', DIRECTORY_SEPARATOR);
}

if ( ! defined( 'ABSPATH' ) ) {
    define( 'ABSPATH', dirname(dirname( __FILE__ )). DS);
}

if ( ! defined( 'WPINC' ) ) {
    define( 'WPINC', 'includes' );
}

if ( ! defined( 'WP_PUBLIC' ) ) {
    define( 'WP_PUBLIC', ABSPATH. 'public' );
}

if ( ! defined( 'WP_CONTENT_DIR' ) ) {
    define( 'WP_CONTENT_DIR', ABSPATH . 'content' );
}

if ( ! defined( 'CORE' ) ) {
    define( 'CORE', ABSPATH . WPINC . DS . 'core'. DS );
}

if ( ! defined( 'ENGINE' ) ) {
    define( 'ENGINE', ABSPATH . WPINC . DS . 'engine' . DS );
}

if ( ! defined( 'THEMES' ) ) {
    define( 'THEMES', ABSPATH. DS. WP_PUBLIC .DS .'themes'. DS );
}

if ( ! defined( 'JS' ) ) {
    define( 'JS', ABSPATH . WPINC . DS . 'js' . DS );
}

if ( ! defined( 'CSS' ) ) {
    define( 'CSS', ABSPATH . WPINC . DS . 'css' . DS );
}

if ( ! defined( 'WP_SITEURL' ) ) {
    define( 'WP_SITEURL', get_option('siteurl').'/');
}

if(!defined('WP_CONTENT_URL')) {
    define('WP_CONTENT_URL', WP_URL . 'wp-content');
}

if(!defined('WP_LANG_DIR')) {
    define('WP_LANG_DIR', WP_CONTENT_DIR . DS . 'languages');
}

if(!defined('WP_PLUGIN_DIR')) {
    define('WP_PLUGIN_DIR', WP_CONTENT_DIR . DS . 'plugins');
}

if(!defined('WP_PLUGIN_URL')) {
    define('WP_PLUGIN_URL', WP_CONTENT_URL . DS . 'plugins');
}

if(!defined('WPMU_PLUGIN_DIR')) {
    define('WPMU_PLUGIN_DIR', WP_CONTENT_DIR . DS . 'mu-plugins');
}

if(!defined('WPMU_PLUGIN_URL')) {
    define('WPMU_PLUGIN_URL', WP_CONTENT_URL . DS . 'mu-plugins');
}



error_reporting(  E_CORE_ERROR |
                        E_CORE_WARNING |
                        E_COMPILE_ERROR |
                        E_ERROR |
                        E_WARNING |
                        E_PARSE |
                        E_USER_ERROR |
                        E_USER_WARNING |
                        E_RECOVERABLE_ERROR );

/*
 * If wp-config.php exists in the WordPress root, or if it exists in the root and wp-settings.php
 * doesn't, load wp-config.php. The secondary check for wp-settings.php has the added benefit
 * of avoiding cases where the current directory is a nested installation, e.g. / is WordPress(a)
 * and /blog/ is WordPress(b).
 *
 * If neither set of conditions is true, initiate loading the setup process.
 */
if ( file_exists( WP_PUBLIC . 'wp-config.php' ) ) {

	/** The config file resides in ABSPATH */
	require_once(WP_PUBLIC . 'wp-config.php');

} elseif (
    @file_exists( WP_PUBLIC. 'wp-config.php' )
    && ! @file_exists( WP_PUBLIC . 'wp-settings.php' ) ) {

	/** The config file resides one level above ABSPATH but is not part of another installation */
	require_once(WP_PUBLIC . 'wp-config.php');

} else {

	// A config file doesn't exist


	//require_once( ENGINE . 'load.php' );

	// Standardize $_SERVER variables across setups.
	wp_fix_server_vars();

	//require_once( ENGINE . 'functions.php' );

	$path = wp_guess_url() . '/wp-admin/setup-config.php';

	/*
	 * We're going to redirect to setup-config.php. While this shouldn't result
	 * in an infinite loop, that's a silly thing to assume, don't you think? If
	 * we're traveling in circles, our last-ditch effort is "Need more help?"
	 */
	if ( false === strpos( $_SERVER['REQUEST_URI'], 'setup-config' ) ) {
		header( 'Location: ' . $path );
		exit;
	}

	require_once( WPINC . 'version.php' );

	wp_check_php_mysql_versions();
	wp_load_translations_early();

	// Die with an error message
	$die = sprintf(
		/* translators: %s: wp-config.php */
		__( "There doesn't seem to be a %s file. I need this before we can get started." ),
		'<code>wp-config.php</code>'
	) . '</p>';
	$die .= '<p>' . sprintf(
		/* translators: %s: Codex URL */
		__( "Need more help? <a href='%s'>We got it</a>." ),
		__( 'https://codex.wordpress.org/Editing_wp-config.php' )
	) . '</p>';
	$die .= '<p>' . sprintf(
		/* translators: %s: wp-config.php */
		__( "You can create a %s file through a web interface, but this doesn't work for all server setups. The safest way is to manually create the file." ),
		'<code>wp-config.php</code>'
	) . '</p>';
	$die .= '<p><a href="' . $path . '" class="button button-large">' . __( 'Create a Configuration File' ) . '</a>';

	wp_die( $die, __( 'WordPress &rsaquo; Error' ) );
}
