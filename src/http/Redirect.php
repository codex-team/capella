<?php

namespace HTTP;

class Redirect
{

	public static function __invoke ($url, $code) 
	{
		header( 'Location: ' . $url, true, $code );
	}

}