<?php


class adminIndex
{

	function adminPages(){
		add_menu_page( 'Capability Changer', 'Changer', 'manage_options', 'capability_changer', array( $this, 'admin_index' ), 'dashicons-store', 110 );
	}

	function admin_index(){
		require_once plugin_dir_path( __FILE__ ) . '../template/admin.php';
	}
}