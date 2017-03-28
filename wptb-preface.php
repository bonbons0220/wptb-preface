<?php
/*
Plugin Name: WPTB-Preface Core Plugin
Plugin URI: http://zendgame.ocm
Description: Add Options page for textbook preface materials
Version: 1.0.0
Author: Bonnie Souter
Author URI: http://zendgame.com
License: GPLv2

    Copyright 2015 Bonnie Souter  (email : bonnie@zendgame.com)

    This program is free software; you can redistribute it and/or modify
    it under the terms of the GNU General Public License as published by
    the Free Software Foundation; either version 2 of the License, or
    (at your option) any later version.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with this program; if not, write to the Free Software
    Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
*/

/**
 * Singleton class for setting up the plugin.
 *
 */
final class WPTB_Preface_Plugin {

	public $dir_path = '';
	public $dir_uri = '';
	public $admin_dir = '';
	public $lib_dir = '';
	public $templates_dir = '';
	public $css_uri = '';
	public $js_uri = '';

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
		
		//Add Scripts
		//add_action( 'wp_enqueue_scripts', array( $this , 'register_wptb_preface_script' ) );
		
		//Add Shortcodes
		//add_shortcode( 'WPTBPREFACE' , array( $this , 'wptb_preface_shortcode' ) );
		
		//Add page(s) to the Admin Menu
		add_action( 'admin_menu' , array( $this , 'wptb_menu' ) );

	}
	
	 /**
	 * Add shortcodes menu
	**/
	function wptb_menu() {

		// Add a main menu item and page Admin  Menu
		add_menu_page( 'WP TextBook Options' , 'WP TextBook Options' , 'activate_plugins' , 'wptb-options' , array( $this , 'wptb_options_page' ) );
		add_submenu_page( 'wptb-options' , 'WP TextBook Options' , 'Options' , 'wptb-options-page' , 'wptb-options-page' , 'wptb_options_page' );

		// Add submenu items to other pages
		
		// Dashboard 
		//add_dashboard_page( $page_title, $menu_title, $capability, $menu_slug, $function); 
		
		// Posts 
		//add_posts_page( $page_title, $menu_title, $capability, $menu_slug, $function); 
		
		// Media 
		//add_media_page( $page_title, $menu_title, $capability, $menu_slug, $function); 
		// Pages 
		//add_pages_page( $page_title, $menu_title, $capability, $menu_slug, $function); 
		// Comments 
		//add_comments_page( $page_title, $menu_title, $capability, $menu_slug, $function); 
		// Tools
		//add_management_page( $page_title, $menu_title, $capability, $menu_slug, $function); 
		// Appearance 
		//add_theme_page( $page_title, $menu_title, $capability, $menu_slug, $function); 
		// Plugins 
		//add_plugins_page( $page_title, $menu_title, $capability, $menu_slug, $function); 
		// Users 
		//add_users_page( $page_title, $menu_title, $capability, $menu_slug, $function); 
		// Settings 
		//add_options_page( $page_title, $menu_title, $capability, $menu_slug, $function); 

		// Add top level page to admin menu & add submenu item to it
		//add_menu_page( $page_title , $menu_title , $capability , $menu_slug , $function);
		//add_submenu_page( $menu_slug, $page_title , $sub_menu_title , $capability , $sub_menu_slug, $function);
		
	}

	/**
	 * Add shortcodes page
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
	 * Add shortcodes page
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
		//wp_register_script( 'zz-script', $this->js_uri . "wptb-preface.js", array( 'jquery' ), '1.0.0', true );
		
		//Styles to be Registered, but not enqueued
		//wp_register_style( 'zz-style', $this->css_uri . "wptb-preface.css" );
		
		//Scripts and Styles to be Enqueued on every page.
		//wp_enqueue_script( 'zz-script' );
		//wp_enqueue_style( 'zz-style' );

	}

	public function wptb_preface_shortcode( $atts, $content = null, $tagname = null ) {

		//Shortcode loads scripts and styles
		//wp_enqueue_script( 'zz-script' );
		//wp_enqueue_style( 'zz-style' );
		
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
		$this->lib_dir       = trailingslashit( $this->dir_path . 'lib'       );
		$this->admin_dir     = trailingslashit( $this->dir_path . 'admin'     );
		$this->templates_dir = trailingslashit( $this->dir_path . 'templates' );

		// Plugin directory URIs.
		$this->css_uri = trailingslashit( $this->dir_uri . 'css' );
		$this->js_uri  = trailingslashit( $this->dir_uri . 'js'  );
	}

	/**
	 * Loads files needed by the plugin.
	 */
	private function includes() {

		// Load class files.
		//require_once( $this->lib_dir . 'class-role.php'         );

		// Load include files.
		//require_once( $this->lib_dir . 'functions.php'                     );
		//require_once( $this->lib_dir . 'functions-admin-bar.php'           );
		//require_once( $this->lib_dir . 'functions-options.php'             );
		//require_once( $this->lib_dir . 'functions-shortcodes.php'          );
		//require_once( $this->lib_dir . 'functions-widgets.php'             );

		// Load template files.
		//require_once( $this->lib_dir . 'template.php' );

		// Load admin/backend files.
		if ( is_admin() ) {

			// General admin functions.
			//require_once( $this->admin_dir . 'functions-admin.php' );
		
			// Plugin settings.
			//require_once( $this->admin_dir . 'class-settings.php' );

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

/**
 * Gets the instance of the `WPTB_Preface_Plugin` class.  This function is useful for quickly grabbing data
 * used throughout the plugin.
 */
function wptb_preface_plugin() {
	return WPTB_Preface_Plugin::get_instance();
}

// Let's roll!
wptb_preface_plugin();