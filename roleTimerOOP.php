<?php
/*
 * Plugin Name: Capability Changer
 * Plugin URI: hhtps://jag.media
 * Description: wp-capabilities changer
 * Version: 1.0.0
 * Contributors: jag.media
 * Author: Ranford
 * Author URI: https://jag.media
 * License: GPLv2 or later
 * License URI: https://www.gnu.org/licenses/gpl-2.0.html
 */

//If called directly, abort
if ( ! defined( 'WPINC') ) {
	die;
}

class roleTimerOOP {

	function uninstall(){
		if( get_option( 'capabilityChanger ' ) ){
			delete_option('capabilityChanger' );
		}
	}

}

if ( class_exists('roleTimerOOP') ){
	$roleTimerOOP = new roleTimerOOP();
}

//activation
//require_once (plugin_dir_path( __FILE__ ) . 'includes/capabilityChangerActivate.php');
register_activation_hook( __FILE__, array( $roleTimerOOP, 'activate' ) );

//deactivate
register_deactivation_hook( __FILE__, array( $roleTimerOOP, 'deactivate') );

//uninstall
register_uninstall_hook( __FILE__, array( $roleTimerOOP, 'uninstall') );


//Create settings fields (change to autoloader)
