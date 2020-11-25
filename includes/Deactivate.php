<?php

namespace includes;

class deactivate
{
	public static function deactivate(){

		flush_rewrite_rules();

	}
}