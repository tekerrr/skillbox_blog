<?php

// Site
define('HOST_NAME', 'http://blog');

// App's root
define('NS_PREFIX', 'App\\');
define('APP_DIR', $_SERVER['DOCUMENT_ROOT']);
define('BASE_DIR', '/src');
define('MODEL_DIR', APP_DIR . BASE_DIR . '/Model');
define('CONFIG_DIR', APP_DIR . '/configs');

// View's root
define('VIEW_DIR', APP_DIR . '/view');
define('VIEW_TEMPLATE', VIEW_DIR . '/template');
define('VIEW_LAYOUT_DIR', VIEW_DIR . '/layout');
define('VIEW_LAYOUT_BASE_DIR', VIEW_LAYOUT_DIR . '/base');
define('VIEW_EMAILS', VIEW_DIR . '/email');

define('VIEW_HEADER', VIEW_LAYOUT_DIR . '/header.php');
define('VIEW_HEADER_ADMIN', VIEW_LAYOUT_DIR . '/admin_header.php');
define('VIEW_FOOTER', VIEW_LAYOUT_DIR . '/footer.php');
define('VIEW_FOOTER_ADMIN', VIEW_LAYOUT_DIR . '/admin_footer.php');

// Vendor's root
define('VENDOR_DIR', APP_DIR . '/vendor');
define('ACTIVE_RECORD_DIR', VENDOR_DIR . '/ActiveRecord');

// GROUPS
define('ADMINS', 'admins');
define('AUTHORS', 'authors');
define('USERS', 'users');

// BASE_PATHS
define('PATH_ARTICLES', '/articles');
define('PATH_MAIN', PATH_ARTICLES);
define('PATH_DEFAULT', PATH_MAIN);
define('PATH_STATIC_PAGES', '/static_pages');
define('PATH_RULES', PATH_STATIC_PAGES . '/1');
define('PATH_COMMENTS', '/comments');
define('PATH_SUBSCRIBERS', '/subscribers');
define('PATH_UNSUBSCRIBE', '/unsubscribe');
define('PATH_USERS', '/users');

define('PATH_ACCOUNT', '/account');
define('PATH_SIGN_IN', '/sign_in');
define('PATH_SIGN_UP', '/sign_up');
define('PATH_SIGN_OUT', '/sign_out');
define('PATH_PASSWORD', '/password');

define('PATH_403', '/403');
define('PATH_404', '/404');


// ADMIN_PATHS
define('PATH_ADMIN', '/admin');
define('PATH_ADMIN_SETTINGS', PATH_ADMIN . '/settings');
define('PATH_ADMIN_LIST', PATH_ADMIN);

