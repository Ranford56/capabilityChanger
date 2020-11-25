<?php

namespace includes;

class Activate
{
	public static function activate(){
		//Creates table in the database
		if( get_option( 'capabilityChanger' ) === false ) {
			add_option( 'capabilityChanger', array() );
		}

		flush_rewrite_rules();

	}
}