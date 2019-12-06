<?php

use App\Application;
use App\Config;
use App\Controller\Controller;
use App\Http\Response;
use App\Rest;
use App\Router;


require_once $_SERVER['DOCUMENT_ROOT'] . '/bootstrap.php';

$router = new Router();

// Basic views location
$views = Config::getInstance()->get('views');

// Default Path
$router->setDefaultRedirectPath(PATH_DEFAULT);

// Redirects
$router->get('', function () {
    return Response::redirect(PATH_DEFAULT);
});

$router->get(PATH_ADMIN, function () {
    return Response::redirect(PATH_ADMIN_LIST . '/articles');
})->setAccessForLastRoute([ADMINS, AUTHORS], PATH_SIGN_IN);

// Main Paths

$articleRest = new Rest('articles', Controller\ArticleController::class);
$articleRest->setSameAccessFroRoutes(['create', 'store', 'edit', 'update', 'destroy'], [ADMINS, AUTHORS], '403');
$router->setRest($articleRest);

$staticPageRest = new Rest('static_pages', Controller\StaticPageController::class);
$staticPageRest->except(['index']);
$staticPageRest->setSameAccessFroRoutes(['create', 'store', 'edit', 'update', 'destroy'], [ADMINS, AUTHORS], '403');
$router->setRest($staticPageRest);

$commentRest = new Rest('comments', Controller\CommentController::class);
$commentRest->only(['store', 'update', 'destroy']);
$commentRest->setSameAccessFroRoutes(['update', 'destroy'], [ADMINS, AUTHORS], '403');
$router->setRest($commentRest);

$subscriberRest = new Rest('subscribers', Controller\SubscriberController::class);
$subscriberRest->only(['store', 'destroy']);
$subscriberRest->setAccessForRoute('destroy', [ADMINS, AUTHORS], '403');
$router->setRest($subscriberRest);
$router->get(PATH_UNSUBSCRIBE . '/*/*', Controller\SubscriberController::class . '@unsubscribe');

$userRest = new Rest('users', Controller\UserController::class);
$userRest->except(['index', 'show']);
$userRest->setSameAccessFroRoutes(['create', 'store'], ['none']);
$userRest->setSameAccessFroRoutes(['edit', 'update', 'destroy'], [ADMINS], '403');
$router->setRest($userRest);

$router
    ->get(PATH_ACCOUNT, Controller\Account::class . '@edit')
    ->setAccessForLastRoute(['all'])
;
$router
    ->put(PATH_ACCOUNT, Controller\Account::class . '@update')
    ->setAccessForLastRoute(['all'], '403')
;
$router
    ->get(PATH_PASSWORD, Controller\Account::class . '@editPassword')
    ->setAccessForLastRoute(['all'])
;
$router
    ->put(PATH_PASSWORD, Controller\Account::class . '@updatePassword')
    ->setAccessForLastRoute(['all'], '403')
;
$router
    ->get(PATH_SIGN_IN, Controller\Account::class . '@showSignIn')
    ->setAccessForLastRoute(['none'])
;
$router->post(PATH_SIGN_IN, Controller\Account::class . '@signIn');
$router->get(PATH_SIGN_OUT, Controller\Account::class . '@signOut');

// Admin Paths

$router
    ->get(PATH_ADMIN_LIST . PATH_ARTICLES, Controller\Admin::class . '@articles')
    ->setAccessForLastRoute([ADMINS, AUTHORS], '403')
;
$router
    ->get(PATH_ADMIN_LIST . PATH_COMMENTS, Controller\Admin::class . '@comments')
    ->setAccessForLastRoute([ADMINS, AUTHORS], '403')
;
$router
    ->get(PATH_ADMIN_LIST . PATH_STATIC_PAGES, Controller\Admin::class . '@staticPages')
    ->setAccessForLastRoute([ADMINS, AUTHORS], '403')
;
$router
    ->get(PATH_ADMIN_LIST . PATH_USERS, Controller\Admin::class . '@users')
    ->setAccessForLastRoute([ADMINS], '403')
;
$router
    ->get(PATH_ADMIN_LIST . PATH_SUBSCRIBERS, Controller\Admin::class . '@subscribers')
    ->setAccessForLastRoute([ADMINS], '403')
;
$router
    ->get(PATH_ADMIN_SETTINGS, Controller\Admin::class . '@editSettings')
    ->setAccessForLastRoute([ADMINS], '403')
;
$router
    ->put(PATH_ADMIN_SETTINGS, Controller\Admin::class . '@updateSettings')
    ->setAccessForLastRoute([ADMINS], '403')
;
$router
    ->put('items_per_page', Controller\Admin::class . '@updateItemsPerPage')
    ->setAccessForLastRoute([ADMINS, AUTHORS], '403')
;

$application = new Application($router);

$application->run();

