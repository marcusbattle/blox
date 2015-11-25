<?php

class Blox_Block_CPT {

	protected static $single_instance = null;

	static function init() { 

		if ( self::$single_instance === null ) {
			self::$single_instance = new self();
		}

		return self::$single_instance;

	}

	public function __construct() {
		require_once dirname( dirname( __FILE__ ) ) . '/includes/CMB2/init.php';
	}

	public function hooks() { 
		
		add_action( 'init', array( $this, 'register_block_cpt' ) );
		add_action( 'admin_enqueue_scripts', array( $this, 'html_box_scripts' ) );

		add_action( 'cmb2_admin_init', array( $this, 'init_html_metabox' ) );
		add_action( 'cmb2_render_blox_block', array( $this, 'cmb2_render_callback_for_text_email' ), 10, 5 );

	}

	public function register_block_cpt() {

		$labels = array(
			'name'               => _x( 'Blocks', 'post type general name', 'blox' ),
			'singular_name'      => _x( 'Block', 'post type singular name', 'blox' ),
			'menu_name'          => _x( 'Blocks', 'admin menu', 'blox' ),
			'name_admin_bar'     => _x( 'Block', 'add new on admin bar', 'blox' ),
			'add_new'            => _x( 'Add New', 'block', 'blox' ),
			'add_new_item'       => __( 'Add New Block', 'blox' ),
			'new_item'           => __( 'New Block', 'blox' ),
			'edit_item'          => __( 'Edit Block', 'blox' ),
			'view_item'          => __( 'View Block', 'blox' ),
			'all_items'          => __( 'All Blocks', 'blox' ),
			'search_items'       => __( 'Search Blocks', 'blox' ),
			'parent_item_colon'  => __( 'Parent Blocks:', 'blox' ),
			'not_found'          => __( 'No blocks found.', 'blox' ),
			'not_found_in_trash' => __( 'No blocks found in Trash.', 'blox' )
		);

		$args = array(
			'public' 		=> true,
			'labels'  		=> $labels,
			'menu_icon'		=> 'dashicons-grid-view',
			'rewrite'		=> array( 'slug' => 'blocks' ),
			'supports'		=> array( 'title' )
		);
		
		register_post_type( 'block', $args );

	}

	public function html_box_scripts() {

		if ( get_post_type() == 'block' ) {
		
			wp_enqueue_script( 'ace', plugin_dir_url( dirname( __FILE__ ) ) . '/includes/ace/ace.js', array('jquery'), '', true );
			wp_enqueue_script( 'blox', plugin_dir_url( dirname( __FILE__ ) ) . '/assets/js/blox.js', array('jquery','ace'), '1.0.0', true );

		}

	}

	public function init_html_metabox() {

		$prefix = '_blox_';

		$blox_html_box = new_cmb2_box( array(
			'id'            	=> $prefix . 'html_metabox',
			'title'         	=> __( 'HTML', 'blox' ),
			'object_types'  	=> array( 'block' ), 
			'show_names'		=> false, 
		) );

		$blox_html_box->add_field( array(
			'name' 				=> __( 'Content', 'blox' ),
			'id'   				=> $prefix . 'html',
			'type' 				=> 'blox_block',
			'sanitization_cb' 	=> array( $this, 'keep_html' )
		) );

	}

	public function cmb2_render_callback_for_text_email( $field, $escaped_value, $object_id, $object_type, $field_type_object ) {
	    
	    echo '<pre id="blox-html" style="width: 100%; height: 250px;">' . $escaped_value . '</pre>';

	    echo $field_type_object->input( array( 
	    	'type' 	=> 'hidden',
	    	'value'	=> $escaped_value
	    ) );

	}

	public function keep_html( $original_value, $args, $cmb2_field ) {
		return $original_value;
	}
	
}

add_action( 'plugins_loaded', array( Blox_Block_CPT::init(), 'hooks' ) );