<?php
/*
Plugin Name: WP Doge
Plugin URI: http://rami.nu/wpdoge
Description: Displays either post categories or tags in doge-speak using the [wpdoge] shortcode.
Version: 0.1
Author: ramiabraham
Contributors: ramiabraham
Author URI: http://ramiabraham.com 
License: GPL v3 or later
		
	This program is free software; you can redistribute it and/or modify
	it under the terms of the GNU General Public License, version 2, as 
	published by the Free Software Foundation.
	
	This program is distributed in the hope that it will be useful,
	but WITHOUT ANY WARRANTY; without even the implied warranty of
	MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
	GNU General Public License for more details.
	
	You should have received a copy of the GNU General Public License
	along with this program; if not, write to the Free Software
	Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
  
*/

if ( ! class_exists('WPDoge') ) {

class WPDoge {

	/*--------------------------------------------*
	 * Constants
	 *--------------------------------------------*/
	const name = 'WP_Doge';
	const slug = 'wp_doge';
	
	/**
	 * Constructor
	 */
	function __construct() {
		// Register an activation hook for WP Doge
		register_activation_hook( __FILE__, array( &$this, 'install_wp_doge' ) );

		// Hook up to the init action
		add_action( 'init', array( &$this, 'init_wp_doge' ) );
	}
  
	/**
	 * Runs when WP Doge is activated
	 */  
	function install_wp_doge() {
		// much quiet
			//	so silence
	}
  
	/**
	 * Runs when WP Doge is initialized
	 */
	function init_wp_doge() {
		// Setup localization requested in teh future for some bizarre reason
		load_plugin_textdomain( self::slug, false, dirname( plugin_basename( __FILE__ ) ) . '/lang' );
		// Load WP Doge css
		$this->register_scripts_and_styles();

		// Register the shortcode [wpdoge]
		add_shortcode( 'wpdoge', array( &$this, 'wp_doge_shortcode' ) );
		  
	}

	// What am I doing with my life

	function wp_doge_shortcode($atts, $content = "" ) {
		
		extract( shortcode_atts(
		
		array(
			'use' => 'cats',
			), $atts )
		);
		
			if ( $use == 'cats' ) {
			
				return '<div class="wp_doge_content">' . get_the_category_list() . '</div>';
			
			} else {
			
				return '<div class="wp_doge_content">' . get_the_tag_list('<ul><li>','</li><li>','</li></ul>') . '</div>';
			
			}
	}
  
	/**
	 * Registers and enqueues WPDoge css
	 * 
	 */
	private function register_scripts_and_styles() {
		if ( is_admin() ) {
			// No options presently
		} else {
			$this->load_file( self::slug . '-style', 'inc/css/wpdoge.css' );
		} // end if/else
	} // end register_scripts_and_styles
	
	/**
	 * WP Doge css. Just css for now.
	 *
	 * @name			wpdoge-css
	 * @file_path		/inc/css/wpdoge.css
	 * @is_script		false
	 * @return 			string
	 */
	private function load_file( $name, $file_path, $is_script = false ) {

		$url = plugins_url($file_path, __FILE__);
		$file = plugin_dir_path(__FILE__) . $file_path;

		if( file_exists( $file ) ) {

				wp_register_style( $name, $url );
				wp_enqueue_style( $name );
			
			} // end if

	} // end load_file
  
  } // end WPDoge class

} // exists check

new WPDoge();

?>