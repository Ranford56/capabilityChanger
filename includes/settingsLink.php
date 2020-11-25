<?php


class settingsLink
{

	public function settingsLinks( $links ){
		$settingsLink = '<a href="admin.php?page=capability_changer">Settings</a>';
		array_push( $links, $settingsLink );
		return $links;

	}

}