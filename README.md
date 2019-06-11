# ssphp/sskey - 加解密

## Directory structure

```
├── CHANGELOG.md           # CHANGELOG
├── README.md              # README
├── src
│    └── ssphp
│          ├── Aes.php     # 加密方式
│          └── sskey.php   # 封装函数
└─── tests                 # 示例

```

## Installation

Install the latest version with

```bash
$ composer require ssphp/sskey
```

## Basic Usage

```php
<?php
require_once __DIR__ . "/vendor/autoload.php";

//初始化key和iv,路径由运维配置
sskey_init(__DIR__.'/vendor/ssphp/sskey/tests/sskeyStarter.php');

$password = sskey_encrypt('ssphp');
var_dump($password);
$key = sskey_decrypt($password);
var_dump($key);

$password = sskey_encrypt('sskey');
var_dump($password);
$key = sskey_decrypt($password);
var_dump($key);
```

## msvc Usage
```php

//在config.php或user_config.php的最后添加以下代码
sskey_init(__DIR__.'/lib/sskey/tests/sskeyStarter.php');
sskey_decrypt_msvc($config);

```

## lumen Usage
```php
//在bootstrap/app.php脚本的引入配置文件之后添加以下代码
sskey_init(__DIR__.'/../vendor/ssphp/sskey/tests/sskeyStarter.php');
sskey_decrypt_lumen($config);	//$config是引入的配置文件，例如：$config = ['app', 'database'];

```

## 参考
<a href="https://github.com/ssgo/tool/tree/master/sskey">go sskey</a>