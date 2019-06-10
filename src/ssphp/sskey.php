<?php

require_once(__DIR__ . "/Aes.php");

if (!function_exists('set_sskey')) {
	function set_sskey($key, $iv)
	{
	    Aes::setKeyIv($key, $iv);
	}
}

if (!function_exists('sskey_init')) {
    function sskey_init($file = '')
    {
        if (!is_file($file)) {
        	return [
        		'code' => '0x000010',
        		'message' => 'file is no exist'
        	];
        }

        require_once($file);
    }
}


if (!function_exists('sskey_encrypt')) {
	function sskey_encrypt($key)
	{
	    return Aes::encrypt($key);
	}
}

if (!function_exists('sskey_decrypt')) {
	function sskey_decrypt($password)
	{
	    return Aes::decrypt($password);
	}
}