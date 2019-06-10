<?php

/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2019/5/23 0023
 * Time: 10:34
 */

class Aes
{
    protected static $key = '?GQ$0K0GgLdO=f+~L68PLm$uhKr4\'=tV';
    protected static $iv  = 'VFs7@sK61cj^f?HZ';
    protected static $cipher = 'AES-256-CBC';

    /**
     * 设置秘钥和偏移量
     * @param array $key
     * @param array $iv
     */
    public static function setKeyIv(array $key, array $iv) {
        $ivlen = openssl_cipher_iv_length(self::$cipher);
        $iv = array_slice($iv, 0, $ivlen);
        $aesKey = self::chrs($key);
        self::$key = $aesKey;
        self::$iv = self::chrs($iv);
    }

    /**
     * 加密
     * @param $clear
     * @return string
     */
    public static function encrypt($clear) {
        $encrypted = openssl_encrypt($clear, self::$cipher, self::$key, OPENSSL_RAW_DATA, self::$iv);
        //$data = strtolower(bin2hex($data));
        $encrypted = base64_encode($encrypted);
        return $encrypted;
    }

    /**
     * 解密
     * @param $input
     * @return string
     */
    public static function decrypt($encrypted) {
        $decrypted = openssl_decrypt(base64_decode($encrypted), self::$cipher, self::$key, OPENSSL_RAW_DATA, self::$iv);
        return $decrypted;
    }

    protected static function addpadding($string, $blocksize = 16) {
        $len = strlen($string);
        $pad = $blocksize - ($len % $blocksize);
        $string .= str_repeat(chr($pad), $pad);
        return $string;
    }

    protected static function strippadding($string) {
        $slast = ord(substr($string, -1));
        $slastc = chr($slast);
        $pcheck = substr($string, -$slast);
        if (preg_match("/$slastc{" . $slast . "}/", $string)) {
            $string = substr($string, 0, strlen($string) - $slast);
            return $string;
        } else {
            return false;
        }
    }

    /**
     * ascii码数组转化为字符串
     * @param array $kvs
     * @return string
     */
    protected static function chrs(array $kvs) {
        $string = '';
        foreach($kvs as $i=>$kv) {
            $string .= chr($kv);
        }
        return $string;
    }

    protected static function ords($string) {
        $len = strlen($string);
        $bytes = [];
        for($i=0;$i<$len;$i++) {
            $bytes[] = ord($string{$i});
        }
        return $bytes;
    }

    protected static function hexToStr($hex) {
        $string = '';
        $len = strlen($hex);
        for ($i=0; $i < $len-1; $i+=2) {
            $string .= chr(hexdec($hex[$i].$hex[$i+1]));
        }
        return $string;
    }
}
