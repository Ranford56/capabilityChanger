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

if( file_exists( dirname( __FILE__ ) . '/vendor/autoload.php' ) ) {
	require_once dirname( __FILE__ ) . '/vendor/autoload.php';
}

use includes\Activate;
use includes\Deactivate;

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

	function activateHome() {
		Activate::activate();
	}

	function deactivateHome() {
		Deactivate::deactivate();
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
//require_once plugin_dir_path( __FILE__ ) . 'includes/Activate.php';
register_activation_hook( __FILE__, array( $roleTimerOOP, 'activateHome' ) );

//deactivate
//require_once plugin_dir_path( __FILE__ ) . 'includes/deactivate.php';
register_deactivation_hook( __FILE__, array( $roleTimerOOP, 'deactivateHome') );

//uninstall
register_uninstall_hook( __FILE__, array( $roleTimerOOP, 'uninstall') );


//Create settings fields (change to autoloader)
