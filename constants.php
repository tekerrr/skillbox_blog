<?php

// Site
define('HOST_NAME', 'http://blog/');

// App's root
define('NS_PREFIX', 'App\\');
define('APP_DIR', $_SERVER['DOCUMENT_ROOT']);
define('BASE_DIR', '/src/');
define('MODEL_DIR', APP_DIR . BASE_DIR . 'Model/');
define('CONFIG_DIR', APP_DIR . '/configs/');

// View's root
define('VIEW_DIR', APP_DIR . '/view/');
define('VIEW_ADMIN_FOLDER', 'admin/');
define('VIEW_TEMPLATE', VIEW_DIR . 'template/');
define('VIEW_LAYOUT_DIR', VIEW_DIR . 'layout/');
define('VIEW_LAYOUT_BASE_DIR', VIEW_LAYOUT_DIR . 'base/');
define('VIEW_EMAILS', VIEW_DIR . 'email/');

// Vendor's root
define('VENDOR_DIR', APP_DIR . '/vendor/');
define('ACTIVE_RECORD_DIR', VENDOR_DIR . 'ActiveRecord/');

// GROUPS
define('ADMINS', 'admins');
define('AUTHORS', 'authors');
define('USERS', 'users');

// BASE_PATHS
define('PATH_MAIN', 'main');
define('PATH_DEFAULT', PATH_MAIN . '/1');
define('PATH_STATIC_PAGE', 'static_page');
define('PATH_RULES', 'static_page/1');
define('PATH_ARTICLE', 'article');
define('PATH_SIGN_IN', 'sign_in');
define('PATH_SIGN_UP', 'sign_up');
define('PATH_ACCOUNT', 'account');
define('PATH_CHANGE_PASSWORD', 'change_password');
define('PATH_MESSAGE', 'message');
define('PATH_403', '403');
define('PATH_404', '404');

// ADMIN_PATHS
define('PATH_ADMIN', 'admin');
define('PATH_ADMIN_PREFIX', 'admin/');
define('PATH_ADMIN_SETTINGS', PATH_ADMIN_PREFIX . 'settings');
define('PATH_ADMIN_LIST', PATH_ADMIN_PREFIX . 'list');
define('PATH_ADMIN_VIEW', PATH_ADMIN_PREFIX . 'view');
define('PATH_ADMIN_ADD', PATH_ADMIN_PREFIX . 'add');
define('PATH_ADMIN_EDIT', PATH_ADMIN_PREFIX . 'edit');

