<?php
/*
Plugin Name: WPTB-Preface Plugin
Plugin URI: git@github.com:bonbons0220/wptb-preface.git
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

// Only allow this script to be run within WordPress
defined('ABSPATH') or die("Unknown Access Error");

// load the class file
if ( ! defined( 'WPTB_DIR_PATH' ) ) die('WPTB-Core is required to run WPTB-Preface.');

/**
 * Gets the instance of the `WPTB_Preface_Plugin` class.  This function is useful for quickly grabbing data
 * used throughout the plugin.
 */
function wptb_preface_plugin() {
	return WPTB_Preface_Plugin::get_instance();
}
require_once( plugin_dir_path( __FILE__ ) . 'classes/wptb-preface.php' );
wptb_preface_plugin();