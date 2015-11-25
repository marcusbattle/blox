<?php
/*
Plugin Name: Blox
Plugin URI: http://www.marcusbattle.com/
Version: 0.1.0
Author: Marcus Battle
Description: Creates reusable content sections to use on any theme
*/

class Blox {

	protected static $single_instance = null;

	static function init() { 

		if ( self::$single_instance === null ) {
			self::$single_instance = new self();
		}

		return self::$single_instance;

	}

	public function __construct() { 
		require_once plugin_dir_path( __FILE__ ) . '/core/cpt.php';
		require_once plugin_dir_path( __FILE__ ) . '/core/shortcode.php';
	}

	public function hooks() {

	}
	
}

add_action( 'plugins_loaded', array( Blox::init(), 'hooks' ) );