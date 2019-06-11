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

if (!function_exists('sskey_decrypt_lumen')) {
	function sskey_decrypt_lumen($configs)
	{
	    $data = app('config')->get($configs);
	    sskey_handle_lumen_config($data);
	}
}

if (!function_exists('sskey_handle_lumen_config')) {
	function sskey_handle_lumen_config($data, $prefix = '')
	{
	    if (!is_array($data)) {
	    	return;
	    }

	    foreach ($data as $k => $v) {
	    	if (is_array($v)) {
	    		$tprefix = empty($prefix) ? '' : $prefix . '.';
	    		$tprefix .= $k;
	    		sskey_handle_lumen_config($v, $tprefix);
	    	}

	    	if (strpos($k, 'sskey:') !== false) {
	    		$kNew = str_replace('sskey:', '', $k);
	    		app('config')->set($prefix . '.' . $kNew, sskey_decrypt($v));
	    	}
	    }

	    return;
	}
}

if (!function_exists('sskey_decrypt_msvc')) {
	function sskey_decrypt_msvc(&$config)
	{
		//处理常量
		$constants = get_defined_constants(true);
		if (!empty($constants = $constants['user'])) {
			foreach ($constants as $k => $v) {
			    if (strpos($k, 'sskey:') !== false) {
			        $kNew = str_replace('sskey:', '', $k);
			        define($kNew, sskey_decrypt($v));
			    }
			}
		}

		if (!empty($config)) {
			sskey_handle_msvc_config($config);
		}
	}
}

if (!function_exists('sskey_handle_msvc_config')) {
	function sskey_handle_msvc_config(&$data)
	{
	    if (!is_array($data)) {
	    	return;
	    }

	    foreach ($data as $k => &$v) {
	    	if (is_array($v)) {
	    		sskey_handle_msvc_config($v);
	    	}

	    	if (strpos($k, 'sskey:') !== false) {
	    		$kNew = str_replace('sskey:', '', $k);
	    		unset($data[$k]);

	    		if (empty($kNew)) {
	    			$data[] = sskey_decrypt($v);
	    		} else {
	    			$data[$kNew] = sskey_decrypt($v);
	    		}
	    	}
	    }

	    return;
	}
}
