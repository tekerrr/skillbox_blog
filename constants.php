<?php

// App's root
define('NS_PREFIX', 'App\\');
define('APP_DIR', $_SERVER['DOCUMENT_ROOT']);
define('BASE_DIR', '/src/');
define('MODEL_DIR', APP_DIR . BASE_DIR . 'Model/');
define('CONFIG_DIR', APP_DIR . '/configs/');

// View's root
define('VIEW_DIR', APP_DIR . '/view/');
define('VIEW_LAYOUT_DIR', VIEW_DIR . 'layout/');
define('VIEW_LAYOUT_BASE_DIR', VIEW_LAYOUT_DIR . 'base/');

// Vendor's root
define('VENDOR_DIR', APP_DIR . '/vendor/');
define('ACTIVE_RECORD_DIR', VENDOR_DIR . 'ActiveRecord/');

// Pages
define('HTTP_PAGE_404', '404');