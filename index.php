<?php

use App\Application;
use App\Config;
use App\Controller\Controller;
use App\Http\Response;
use App\Router;


require_once $_SERVER['DOCUMENT_ROOT'] . '/bootstrap.php';

$router = new Router();

// Basic views location
$views = Config::getInstance()->get('views');

// Default Path
$router->setDefaultRedirectPath(PATH_DEFAULT);

// Redirects
$router->get(PATH_MAIN, function () {
    return Response::redirect(PATH_DEFAULT);
});

$router->get('', function () {
    return Response::redirect(PATH_DEFAULT);
});

$router->get(PATH_ADMIN, function () {
    return Response::redirect(PATH_ADMIN_LIST . '/articles/1');
})->setAccessForLastRoute([ADMINS, AUTHORS], PATH_SIGN_IN);

//
// MAIN SITE
//

// Pages
$router->get(PATH_MAIN . '/*', Controller\BasicPage::class . '@getMainPage');
$router->get(PATH_ARTICLE . '/*', Controller\BasicPage::class . '@getArticle');
$router->get(PATH_STATIC_PAGE . '/*', Controller\BasicPage::class . '@getStaticPage');

$router
    ->get(PATH_ACCOUNT, Controller\User::class . '@getAccountPage')
    ->setAccessForLastRoute(['all'])
;
$router
    ->get(PATH_CHANGE_PASSWORD, Controller\User::class . '@getChangePasswordPage')
    ->setAccessForLastRoute(['all'])
;
$router
    ->get(PATH_SIGN_IN, Controller\User::class . '@getSignInPage')
    ->setAccessForLastRoute(['none'])
;
$router
    ->get(PATH_SIGN_UP, Controller\User::class . '@getSignUpPage')
    ->setAccessForLastRoute(['none'])
;
$router
    ->post('submit_update_account', Controller\User::class . '@updateAccount')
    ->setAccessForLastRoute(['all'], '403')
;


// Actions
$router->post('submit_new_comment', Controller\BasicPage::class . '@addComment');
$router->post('submit_sign_in', Controller\User::class . '@signIn');
$router->post('submit_sign_up', Controller\User::class . '@signUp');
$router->get('sign_out', Controller\User::class . '@signOut');
$router->post('submit_subscribe', Controller\Subscriber::class . '@subscribe');
$router->get('unsubscribe/*/*', Controller\Subscriber::class . '@unsubscribe');

$router
    ->post('submit_change_password', Controller\User::class . '@changePassword')
    ->setAccessForLastRoute(['all'], '403')
;
$router
    ->post('submit_upload_avatar', Controller\User::class . '@uploadAvatar')
    ->setAccessForLastRoute(['all'], '403')
;
$router
    ->get('delete_avatar', Controller\User::class . '@deleteAvatar')
    ->setAccessForLastRoute(['all'], '403')
;

//
// ADMIN SITE
//

// Pages
$router
    ->get(PATH_ADMIN_LIST . '/articles/*', Controller\Admin\BasicPage::class . '@getArticles')
    ->setAccessForLastRoute([ADMINS, AUTHORS], '403')
;
$router
    ->get(PATH_ADMIN_LIST . '/comments/*', Controller\Admin\BasicPage::class . '@getComments')
    ->setAccessForLastRoute([ADMINS, AUTHORS], '403')
;
$router
    ->get(PATH_ADMIN_LIST . '/static_pages/*', Controller\Admin\BasicPage::class . '@getStaticPages')
    ->setAccessForLastRoute([ADMINS, AUTHORS], '403')
;
$router
    ->get(PATH_ADMIN_LIST . '/users/*', Controller\Admin\BasicPage::class . '@getUsers')
    ->setAccessForLastRoute([ADMINS], '403')
;
$router
    ->get(PATH_ADMIN_LIST . '/subscribers/*', Controller\Admin\BasicPage::class . '@getSubscribers')
    ->setAccessForLastRoute([ADMINS], '403')
;
$router
    ->get(PATH_ADMIN_VIEW . '/static_page/*', function ($id) {
        return (new Controller\BasicPage)->getStaticPage($id, false);
    })
    ->setAccessForLastRoute([ADMINS, AUTHORS], '403')
;
$router
    ->get(PATH_ADMIN_VIEW . '/article/*', function ($id) {
        return (new Controller\BasicPage)->getArticle($id, false);
    })
    ->setAccessForLastRoute([ADMINS, AUTHORS], '403')
;
$router
    ->get(PATH_ADMIN_ADD . '/article', Controller\Admin\Content::class . '@getAddArticlePage')
    ->setAccessForLastRoute([ADMINS, AUTHORS], '403')
;
$router
    ->get(PATH_ADMIN_ADD . '/static_page', Controller\Admin\Content::class . '@getAddStaticPagePage')
    ->setAccessForLastRoute([ADMINS, AUTHORS], '403')
;
$router
    ->get(PATH_ADMIN_EDIT . '/article/*', Controller\Admin\Content::class . '@getAddArticlePage')
    ->setAccessForLastRoute([ADMINS, AUTHORS], '403')
;
$router
    ->get(PATH_ADMIN_EDIT . '/static_page/*', Controller\Admin\Content::class . '@getAddStaticPagePage')
    ->setAccessForLastRoute([ADMINS, AUTHORS], '403')
;
$router
    ->get(PATH_ADMIN_EDIT . '/user/*', Controller\Admin\Admin::class . '@getEditUserPage')
    ->setAccessForLastRoute([ADMINS], '403')
;
$router
    ->get(PATH_ADMIN_SETTINGS, Controller\Admin\Admin::class . '@getSettingsPage')
    ->setAccessForLastRoute([ADMINS], '403')
;


// Actions
$router
    ->post('submit_items_per_page', Controller\Admin\BasicPage::class . '@setItemsPerPage')
    ->setAccessForLastRoute([ADMINS, AUTHORS], '403')
;
$router
    ->post('submit_add_article', Controller\Admin\Content::class . '@addArticle')
    ->setAccessForLastRoute([ADMINS, AUTHORS], '403')
;
$router
    ->post('submit_edit_article', Controller\Admin\Content::class . '@editArticle')
    ->setAccessForLastRoute([ADMINS, AUTHORS], '403')
;
$router
    ->post('submit_add_static_page', Controller\Admin\Content::class . '@addStaticPage')
    ->setAccessForLastRoute([ADMINS, AUTHORS], '403')
;
$router
    ->post('submit_edit_static_page', Controller\Admin\Content::class . '@editStaticPage')
    ->setAccessForLastRoute([ADMINS, AUTHORS], '403')
;
$router
    ->post('submit_publish', Controller\Admin\Content::class . '@activate')
    ->setAccessForLastRoute([ADMINS, AUTHORS], '403')
;
$router
    ->post('submit_publish_article_and_notify', Controller\Admin\Content::class . '@publishArticleAndNotify')
    ->setAccessForLastRoute([ADMINS, AUTHORS], '403')
;
$router
    ->post('submit_unpublish', Controller\Admin\Content::class . '@deactivate')
    ->setAccessForLastRoute([ADMINS, AUTHORS], '403')
;
$router
    ->post('submit_delete', Controller\Admin\Content::class . '@delete')
    ->setAccessForLastRoute([ADMINS, AUTHORS], '403')
;
$router
    ->post('submit_edit_user', Controller\Admin\Admin::class . '@editUser')
    ->setAccessForLastRoute([ADMINS], '403')
;
$router
    ->post('submit_edit_user_group', Controller\Admin\Admin::class . '@editUserGroup')
    ->setAccessForLastRoute([ADMINS], '403')
;
$router
    ->post('submit_upload_avatar_for_user', Controller\Admin\Admin::class . '@uploadAvatarForUser')
    ->setAccessForLastRoute([ADMINS], '403')
;
$router
    ->get('delete_avatar_for_user/*', Controller\Admin\Admin::class . '@deleteAvatarForUser')
    ->setAccessForLastRoute([ADMINS], '403')
;
$router
    ->post('submit_edit_settings', Controller\Admin\Admin::class . '@editSettings')
    ->setAccessForLastRoute([ADMINS], '403')
;

$application = new Application($router);

$application->run();
