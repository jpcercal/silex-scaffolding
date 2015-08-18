<?php

define('ROOT_PATH', realpath(__DIR__ . DIRECTORY_SEPARATOR . '..'));

define('PUBLIC_PATH',  realpath(ROOT_PATH . DIRECTORY_SEPARATOR . 'public'));
define('APP_PATH',     realpath(ROOT_PATH . DIRECTORY_SEPARATOR . 'src'));
define('VENDOR_PATH',  realpath(ROOT_PATH . DIRECTORY_SEPARATOR . 'vendor'));
define('CONFIG_PATH',  realpath(ROOT_PATH . DIRECTORY_SEPARATOR . 'config'));
define('STORAGE_PATH', realpath(ROOT_PATH . DIRECTORY_SEPARATOR . 'storage'));

define('STORAGE_PATH_CACHE', realpath(STORAGE_PATH . DIRECTORY_SEPARATOR . 'cache'));
define('STORAGE_PATH_LOG',   realpath(STORAGE_PATH . DIRECTORY_SEPARATOR . 'logs'));

$filename = __DIR__ . preg_replace('#(\?.*)$#', '', $_SERVER['REQUEST_URI']);

if (php_sapi_name() === 'cli-server' && is_file($filename)) {
    return false;
}

require VENDOR_PATH . DIRECTORY_SEPARATOR . 'autoload.php';

$app = require CONFIG_PATH . DIRECTORY_SEPARATOR . 'app.php';

$app->run();
