<?php

use App\Application;
use App\Config;
use App\Controller\Controller;
use App\Router;
use App\View\Concrete\Account;
use App\View\Concrete\Admin\AddArticle;
use App\View\Concrete\Admin\AddStaticPage;
use App\View\Concrete\Admin\EditArticle;
use App\View\Concrete\Admin\EditStaticPage;
use App\View\Concrete\Admin\EditUser;
use App\View\Concrete\Admin\ListView;
use App\View\Concrete\Admin\Settings;
use App\View\Concrete\Article;
use App\View\Concrete\ChangePassword;
use App\View\Concrete\Main;
use App\View\Concrete\SignIn;
use App\View\Concrete\SignUp;
use App\View\Concrete\StaticPage;

require_once $_SERVER['DOCUMENT_ROOT'] . '/bootstrap.php';

$router = new Router();

// Basic views location
$views = Config::getInstance()->get('views');

// Default Path
$router->setDefaultPath(PATH_DEFAULT);

// Redirects
$router->get(PATH_MAIN, function () {
    Router::redirectTo(PATH_DEFAULT);
});

$router->get('', function () {
    Router::redirectTo(PATH_DEFAULT);
});

$router->get(PATH_ADMIN, function () {
    Router::redirectTo(PATH_ADMIN_LIST . '/articles/1');
})->setGroupsForLastRoute([ADMINS, AUTHORS], PATH_SIGN_IN);

//
// MAIN SITE
//

// Pages
$router->get(PATH_MAIN . '/*', function ($currentPage) {
    return new Main($currentPage);
});

$router->get(PATH_ARTICLE . '/*', function ($id) {
    return new Article($id);
});

$router->get(PATH_STATIC_PAGE . '/*', function ($id) {
    return new StaticPage($id);
});

$router->get(PATH_ACCOUNT, function () {
    return new Account();
})->setGroupsForLastRoute(['all']);

$router->get(PATH_CHANGE_PASSWORD, function () {
    return new ChangePassword();
})->setGroupsForLastRoute(['all']);

$router->get(PATH_SIGN_IN, function () {
    return new SignIn();
})->setGroupsForLastRoute(['none']);

$router->get(PATH_SIGN_UP, function ()  {
    return new SignUp();
})->setGroupsForLastRoute(['none']);

// Actions
$router->post('submit_sign_up', Controller::class . '@signUp');
$router->post('submit_sign_in', Controller::class . '@signIn');
$router->post('submit_subscribe', Controller::class . '@subscribe');
$router->get('unsubscribe/*/*', Controller::class . '@unsubscribe');
$router->get('sign_out', Controller::class . '@signOut');
$router->post('submit_new_comment', Controller::class . '@addComment');
$router->post('submit_update_account', Controller::class . '@updateAccount')
    ->setGroupsForLastRoute(['all'], '403');
$router->post('submit_upload_avatar', Controller::class . '@uploadAvatar')
    ->setGroupsForLastRoute(['all'], '403');
$router->get('delete_avatar', Controller::class . '@deleteAvatar')
    ->setGroupsForLastRoute(['all'], '403');
$router->post('submit_change_password', Controller::class . '@changePassword')
    ->setGroupsForLastRoute(['all'], '403');

//
// ADMIN SITE
//

// Pages

$router->get(PATH_ADMIN_VIEW . '/static_page/*', function ($id) {
    return new StaticPage($id, false);
})->setGroupsForLastRoute([ADMINS, AUTHORS], '403');

$router->get(PATH_ADMIN_VIEW . '/article/*', function ($id) {
    return new Article($id, false);
})->setGroupsForLastRoute([ADMINS, AUTHORS], '403');

$router->get(PATH_ADMIN_ADD . '/article', function () {
    return new AddArticle();
})->setGroupsForLastRoute([ADMINS, AUTHORS], '403');

$router->get(PATH_ADMIN_ADD . '/static_page', function () {
    return new AddStaticPage();
})->setGroupsForLastRoute([ADMINS, AUTHORS], '403');

$router->get(PATH_ADMIN_EDIT . '/article/*', function ($id) {
    return new EditArticle($id);
})->setGroupsForLastRoute([ADMINS, AUTHORS], '403');

$router->get(PATH_ADMIN_EDIT . '/static_page/*', function ($id) {
    return new EditStaticPage($id);
})->setGroupsForLastRoute([ADMINS, AUTHORS], '403');

$router->get(PATH_ADMIN_LIST . '/articles/*', function ($currentPage) {
    return new ListView('articles', $currentPage);
})->setGroupsForLastRoute([ADMINS, AUTHORS], '403');

$router->get(PATH_ADMIN_LIST . '/comments/*', function ($currentPage) {
    return new ListView('comments', $currentPage);
})->setGroupsForLastRoute([ADMINS, AUTHORS], '403');

$router->get(PATH_ADMIN_LIST . '/static_pages/*', function ($currentPage) {
    return new ListView('static_pages', $currentPage);
})->setGroupsForLastRoute([ADMINS, AUTHORS], '403');

$router->get(PATH_ADMIN_LIST . '/users/*', function ($currentPage) {
    return new ListView('users', $currentPage);
})->setGroupsForLastRoute([ADMINS], '403');

$router->get(PATH_ADMIN_LIST . '/subscribers/*', function ($currentPage) {
    return new ListView('subscribers', $currentPage);
})->setGroupsForLastRoute([ADMINS], '403');

$router->get(PATH_ADMIN_EDIT . '/user/*', function ($id) {
    return new EditUser($id);
})->setGroupsForLastRoute([ADMINS], '403');

$router->get(PATH_ADMIN_SETTINGS, function () {
    return new Settings();
})->setGroupsForLastRoute([ADMINS], '403');

// Actions
$router->post('submit_items_per_page', Controller::class . '@setItemsPerPage')
    ->setGroupsForLastRoute([ADMINS, AUTHORS], '403');
$router->post('submit_publish', Controller::class . '@activate')
    ->setGroupsForLastRoute([ADMINS, AUTHORS], '403');
$router->post('submit_publish_article_and_notify', Controller::class . '@publishArticleAndNotify')
    ->setGroupsForLastRoute([ADMINS, AUTHORS], '403');
$router->post('submit_unpublish', Controller::class . '@deactivate')
    ->setGroupsForLastRoute([ADMINS, AUTHORS], '403');
$router->post('submit_delete', Controller::class . '@delete')
    ->setGroupsForLastRoute([ADMINS, AUTHORS], '403');
$router->post('submit_add_article', Controller::class . '@addArticle')
    ->setGroupsForLastRoute([ADMINS, AUTHORS], '403');
$router->post('submit_add_static_page', Controller::class . '@addStaticPage')
    ->setGroupsForLastRoute([ADMINS, AUTHORS], '403');
$router->post('submit_edit_article', Controller::class . '@editArticle')
    ->setGroupsForLastRoute([ADMINS, AUTHORS], '403');
$router->post('submit_edit_static_page', Controller::class . '@editStaticPage')
    ->setGroupsForLastRoute([ADMINS, AUTHORS], '403');
$router->post('submit_edit_user', Controller::class . '@editUser')
    ->setGroupsForLastRoute([ADMINS], '403');
$router->post('submit_edit_user_group', Controller::class . '@editUserGroup')
    ->setGroupsForLastRoute([ADMINS], '403');
$router->post('submit_upload_avatar_for_user', Controller::class . '@uploadAvatarForUser')
    ->setGroupsForLastRoute([ADMINS], '403');
$router->get('delete_avatar_for_user/*', Controller::class . '@deleteAvatarForUser')
    ->setGroupsForLastRoute([ADMINS], '403');
$router->post('submit_edit_settings', Controller::class . '@editSettings')
    ->setGroupsForLastRoute([ADMINS], '403');

$application = new Application($router);

$application->run();
