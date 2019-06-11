<?php
require_once __DIR__ . "/vendor/autoload.php";

sskey_init(__DIR__ . '/vendor/ssphp/sskey/tests/sskeyStarter.php');

$password = sskey_encrypt('ssphp');
var_dump($password);

$key = sskey_decrypt($password);
var_dump($key);

$password = sskey_encrypt('sskey');
var_dump($password);

$key = sskey_decrypt($password);
var_dump($key);
