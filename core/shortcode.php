<?php

class Blox_Block_Shortcode {
	
	protected static $single_instance = null;

	static function init() { 

		if ( self::$single_instance === null ) {
			self::$single_instance = new self();
		}

		return self::$single_instance;

	}

	public function hooks() {
		add_shortcode( 'blox', array( $this, 'blox_block_shortcode' ) );	
	}

	public function blox_block_shortcode( $atts = array() ) {
		
		$atts = shortcode_atts( array(
			'id' => 0,
		), $atts, 'blox' );

		$block_id = $atts['id'];

		if ( ! $block_id ) {
			return;
		}

		return get_post_meta( $block_id, '_blox_html', true );

	}	

}

add_action( 'plugins_loaded', array( Blox_Block_Shortcode::init(), 'hooks' ) );