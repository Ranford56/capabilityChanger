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

	public $pluginName;

	function __construct() {
		$this->pluginName = plugin_basename( __FILE__ );
	}

	function uninstall(){
		if( get_option( 'capabilityChanger' ) ){
			delete_option('capabilityChanger' );
		}
	}

	function register(){
		require plugin_dir_path( __FILE__ ) . 'includes/adminIndex.php';
		require plugin_dir_path( __FILE__ ) . 'includes/settingsLink.php';
		$adminIndex = new adminIndex();
		$settingsLink = new settingsLink();
		add_action( 'admin_menu', array( $adminIndex, 'adminPages' ) );
		add_filter( "plugin_action_links_$this->pluginName", array( $settingsLink, 'settingsLinks') );
	}

}

if ( class_exists('roleTimerOOP') ){
	$roleTimerOOP = new roleTimerOOP();
	$roleTimerOOP->register();
}

//activation
require_once plugin_dir_path( __FILE__ ) . 'includes/capabilityChangerActivate.php';
register_activation_hook( __FILE__, array( 'capabilityChangerActivate', 'activate' ) );

//deactivate
require_once plugin_dir_path( __FILE__ ) . 'includes/capabilityChangerDeactivate.php';
register_deactivation_hook( __FILE__, array( 'capabilityChangerDeactivate', 'deactivate') );

//uninstall
register_uninstall_hook( __FILE__, array( $roleTimerOOP, 'uninstall') );


//Create settings fields (change to autoloader)
