<?php

use App\Config;

// Warnings
error_reporting(E_ALL);
ini_set('display_errors',true);

// Requires
require_once $_SERVER['DOCUMENT_ROOT'] . '/constants.php';
require_once APP_DIR . '/helpers.php';
require_once ACTIVE_RECORD_DIR . 'ActiveRecord.php';

// Autoloader
spl_autoload_register(function ($class) {

    $prefix = NS_PREFIX;
    $base_dir = __DIR__ . BASE_DIR;

    $len = strlen($prefix);
    if (strncmp($prefix, $class, $len) !== 0) {
        return;
    }

    $relative_class = substr($class, $len);
    $file = $base_dir . str_replace('\\', '/', $relative_class) . '.php';

    if (file_exists($file)) {
        require $file;
    }
});
