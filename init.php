<?php

/*
 * Plugin Name: YITH Clubs Cristian
 * Description: Clubs for YITH Plugins
 * Version: 1.0.0
 * Author: Facundo Benitez
 * Author URI: https://yithemes.com/
 * Text Domain: yith-plugin-cristian
 */

! defined( 'ABSPATH' ) && exit;   //Before all, check if defined ABSPATH.

/*Create some constant where defined PATH for Style, Assets, Templates, Views */

if ( ! defined( 'YITH_PS_VERSION' ) ) {
	define( 'YITH_PS_VERSION', '1.0.0' );
}

if ( ! defined( 'YITH_PS_DIR_URL' ) ) {
	define( 'YITH_PS_DIR_URL', plugin_dir_url( __FILE__ ) );
}

if ( ! defined( 'YITH_PS_DIR_ASSETS_URL' ) ) {
	define( 'YITH_PS_DIR_ASSETS_URL', YITH_PS_DIR_URL . 'assets' );
}

if ( ! defined( 'YITH_PS_DIR_ASSETS_CSS_URL' ) ) {
	define( 'YITH_PS_DIR_ASSETS_CSS_URL', YITH_PS_DIR_ASSETS_URL . '/css' );
}

if ( ! defined( 'YITH_PS_DIR_ASSETS_JS_URL' ) ) {
	define( 'YITH_PS_DIR_ASSETS_JS_URL', YITH_PS_DIR_ASSETS_URL . '/js' );
}

if ( ! defined( 'YITH_PS_DIR_PATH' ) ) {
	define( 'YITH_PS_DIR_PATH', plugin_dir_path( __FILE__ ) );
}

if ( ! defined( 'YITH_PS_DIR_INCLUDES_PATH' ) ) {
	define( 'YITH_PS_DIR_INCLUDES_PATH', YITH_PS_DIR_PATH . '/includes' );
}

if ( ! defined( 'YITH_PS_DIR_TEMPLATES_PATH' ) ) {
	define( 'YITH_PS_DIR_TEMPLATES_PATH', YITH_PS_DIR_PATH . '/templates' );
}

if ( ! defined( 'YITH_PS_DIR_VIEWS_PATH' ) ) {
	define( 'YITH_PS_DIR_VIEWS_PATH', YITH_PS_DIR_PATH . '/views' );
}

/**
 * Include the scripts
 */
if ( ! function_exists( 'yith_cr_init_classes' ) ) {

	function yith_cr_init_classes() {

		load_plugin_textdomain( 'yith-clubs-cristian', false, basename( dirname( __FILE__ ) ) . '/languages' );

		//Require all the files you include on your plugins. Example
		require_once YITH_PS_DIR_INCLUDES_PATH . '/class-yith-clubs-cris.php';

		if ( class_exists( 'YITH_CR_Plugin_clubs' ) ) {
			/*
			*	Call the main function
			*/
			yith_cr_plugin_clubs();
		}
	}
}


add_action( 'plugins_loaded', 'yith_cr_init_classes', 11 );




