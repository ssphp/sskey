<?php

require_once __DIR__ . "/Aes.php";

if (!function_exists('set_sskey')) {
    /**
     * 设置加密key和初始化向量
     *
     * @param array $key
     * @param array $iv
     */
    function set_sskey($key, $iv)
    {
        Aes::setKeyIv($key, $iv);
    }
}

if (!function_exists('sskey_init')) {
    /**
     * 初始化加解密类
     *
     * @param  string $file
     *
     * @return array
     *
     */
    function sskey_init($file = '')
    {
        if (!is_file($file)) {
            return [
                'code'    => '0x000010',
                'message' => 'file is no exist',
            ];
        }

        require_once $file;

        return [
            'code' => '0x000000',
            'data' => 'ok',
        ];
    }
}

if (!function_exists('sskey_encrypt')) {
    /**
     * 加密
     *
     * @param  string $key
     *
     * @return string
     */
    function sskey_encrypt($key)
    {
        return Aes::encrypt($key);
    }
}

if (!function_exists('sskey_decrypt')) {
    /**
     * 解密
     *
     * @param  string $password
     *
     * @return string
     */
    function sskey_decrypt($password)
    {
        return Aes::decrypt($password);
    }
}

if (!function_exists('sskey_decrypt_lumen')) {
    /**
     * lumen框架配置文件解密
     *
     * @param  array $configs
     *
     * @return null
     */
    function sskey_decrypt_lumen($configs)
    {
        $data = app('config')->get($configs);
        sskey_handle_lumen_config($data);
        return;
    }
}

if (!function_exists('sskey_handle_lumen_config')) {
    /**
     * 过滤配置
     *
     * @param  array $data
     * @param  string $prefix
     *
     * @return null
     */
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
    /**
     * msvc 框架配置文件解密
     *
     * @param  array &$config
     */
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
    /**
     * 过滤配置文件
     *
     * @param  array &$data
     *
     * @return
     */
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
