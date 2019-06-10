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
sskey_init(__DIR__.'/vendor/ssphp/sskey/src/tests/sskeyStarter.php');

$password = sskey_encrypt('ssphp');
var_dump($password);
$key = sskey_decrypt($password);
var_dump($key);

$password = sskey_encrypt('sskey');
var_dump($password);
$key = sskey_decrypt($password);
var_dump($key);
```

## Log Content Standard
参考： <a href="https://github.com/ssgo/tool/tree/master/sskey">go sskey</a>