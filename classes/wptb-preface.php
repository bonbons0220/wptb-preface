<?php
/**
 * WPTB-Preface Plugin Class
 *
 * @link git@github.com:bonbons0220/wptb-preface.git
 *
 * @package WPTB-Preface Plugin
 * @since 1.0.0 
 */

/**
 * Singleton class for setting up the plugin.
 *
 */
final class WPTB_Preface_Plugin {

	public $dir_path = '';
	public $dir_uri = '';
	public $admin_dir = '';
	public $classes_dir = '';
	public $lib_dir = '';
	public $templates_dir = '';
	public $css_uri = '';
	public $js_uri = '';

	public $options = array();
	
	/**
	 * Returns the instance.
	 */
	public static function get_instance() {

		static $instance = null;

		if ( is_null( $instance ) ) {
			$instance = new WPTB_Preface_Plugin;
			$instance->setup();
			$instance->includes();
			$instance->setup_actions();
		}

		return $instance;
	}
	
	/**
	 * Constructor method.
	 */
	private function __construct() {
		
		//Add page(s) to the Admin Menu
		add_action( 'admin_menu' , array( $this , 'wptb_menu' ) );
		
		$this->get_options();

	}
	
	 /**
	 * Get WPTB_Preface Options
	**/
	function get_options(){
		
		// Get Options
		$my_options = get_option( 'wptb_preface_options', "" );
		
		// Parse Options
	}
	
	 /**
	 * Add shortcodes menu
	**/
	function wptb_menu() {

		// Add a main menu item and page Admin  Menu
		add_submenu_page( 'wptb-options' , 'WP TextBook Options' , 'Options' , 'wptb-options-page' , 'wptb-options-page' , 'wptb_options_page' );
		
	}

	/**
	 * Wrap HTML elements as tags with elements.
	**/
	function wptb_html( $tag="" , $content="", $atr=array() , $self=false ) {
		if ( empty( $tag ) ) return $content;
		
		$atts = "";
		foreach ( $atr as $key=>$value ) {
			$atts = "$key='$value' ";
		}
		$content = ( $self ) ? "<$tag $atts/>" : "<$tag $atts>$content</$tag>" ;
		return $content;
	}

	/**
	 * Show Dashboard page 
	**/
	function wptb_options_page() {
		
		if ( !current_user_can( 'activate_plugins' ) )  {
				wp_die( __( 'You do not have sufficient permissions to access this page.' ) );
		}

		$page_title = 	$this->wptb_html( "h2" , "TextBook Options" );
		
		$title_row = $this->wptb_html( "tr" , 
							$this->wptb_html( "th" , "TextBook Title" ) .
							$this->wptb_html( "td" ,
								$this->wptb_html( "h3" , get_bloginfo( "name" ) ) ) );
		
		$author_rows = $this->wptb_html( "tr" , 
							$this->wptb_html( "th" , 
								$this->wptb_html( "label" , "Author" , array( "for"=>"author1") ) .
							$this->wptb_html( "td" ,
								$this->wptb_html( "input" , "" , array( "type"=>"text" , "name"=>"author1" , "size"=>"60" ) , true ) ) ) );
		
		$form_table = 	$this->wptb_html( "form" , 
							$this->wptb_html( "table" , $title_row . $author_rows , 
							array( "class"=>"form-table" ) ) ) ;
		
		$result = $this->wptb_html( "div" , 
									$page_title . 
									$form_table , array( "class"=>"wrap" ) );
		
		echo $result;
	}


	//
	function register_wptb_preface_script() {
		
		//Scripts to be Registered, but not enqueued
		//This example requires jquery 
		//wp_register_script( 'wptb-script', $this->js_uri . "wptb-preface.js", array( 'jquery' ), '1.0.0', true );
		
		//Styles to be Registered, but not enqueued
		//wp_register_style( 'wptb-style', $this->css_uri . "wptb-preface.css" );
		
		//Scripts and Styles to be Enqueued on every page.
		//wp_enqueue_script( 'wptb-script' );
		//wp_enqueue_style( 'wptb-style' );

	}

	public function wptb_preface_shortcode( $atts, $content = null, $tagname = null ) {

		//Shortcode loads scripts and styles
		//wp_enqueue_script( 'wptb-script' );
		//wp_enqueue_style( 'wptb-style' );
		
		//Content is unchanged
		
		return '';
	}

	/**
	 * Magic method to output a string if trying to use the object as a string.
	 */
	public function __toString() {
		return 'wptb_preface';
	}

	/**
	 * Magic method to keep the object from being cloned.
	 */
	public function __clone() {
		_doing_it_wrong( __FUNCTION__, esc_html__( 'Sorry, no can do.', 'wptb_preface' ), '1.0' );
	}

	/**
	 * Magic method to keep the object from being unserialized.
	 */
	public function __wakeup() {
		_doing_it_wrong( __FUNCTION__, esc_html__( 'Sorry, no can do.', 'wptb_preface' ), '1.0' );
	}

	/**
	 * Magic method to prevent a fatal error when calling a method that doesn't exist.
	 */
	public function __call( $method = '', $args = array() ) {
		_doing_it_wrong( "WPTB_Preface_Plugin::{$method}", esc_html__( 'Method does not exist.', 'wptb_preface' ), '1.0' );
		unset( $method, $args );
		return null;
	}

	/**
	 * Sets up globals.
	 */
	private function setup() {

		// Main plugin directory path and URI.
		$this->dir_path = trailingslashit( plugin_dir_path( __FILE__ ) );
		$this->dir_uri  = trailingslashit( plugin_dir_url(  __FILE__ ) );

		// Plugin directory paths.
		$this->class_dir     = trailingslashit( $this->dir_path . 'classes'   );
		$this->lib_dir       = trailingslashit( $this->dir_path . 'lib'       );
		$this->admin_dir     = trailingslashit( $this->dir_path . 'admin'     );
		$this->templates_dir = trailingslashit( $this->dir_path . 'templates' );

		// Plugin directory URIs.
		$this->js_uri  = trailingslashit( $this->dir_uri . 'js'  );
	}

	/**
	 * Loads files needed by the plugin.
	 */
	private function includes() {


		// Load admin/backend files.
		if ( is_admin() ) {

		}
	}

	/**
	 * Sets up main plugin actions and filters.
	 */
	private function setup_actions() {

		// Register activation hook.
		register_activation_hook( __FILE__, array( $this, 'activation' ) );
	}

	/**
	 * Method that runs only when the plugin is activated.
	 */
	public function activation() {

	}
	
}
