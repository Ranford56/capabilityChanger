<?php


class capabilityChangerDeactivate
{
	public static function deactivate(){

		flush_rewrite_rules();

	}
}