<?php

namespace HTTP;

class Redirect
{

	public static function redirect ($url, $code) 
	{
		header( 'Location: ' . $url, true, $code );
	}

}