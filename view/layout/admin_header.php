<?php

include VIEW_LAYOUT_BASE_DIR . '/header.php';

use App\Controller\Auth;
use App\Model\Article;
use App\Model\StaticPage;
use App\Router;

?>
<body>
<header class="navbar sticky-top navbar-expand-md navbar-dark bg-primary">
    <div class="container">
        <a class="navbar-brand" href="<?=PATH_MAIN?>">
            <img src="/img/ico.png" class="d-inline-block align-top" alt="icon">
            MyBlog
        </a>

        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNavAltMarkup"
                aria-controls="navbarNavAltMarkup" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse justify-content-end" id="navbarNavAltMarkup">
            <ul class="navbar-nav">
                <li>
                    <a class="nav-item nav-link <?=Router::isActivePath(PATH_ADMIN_LIST . '/articles')?>"
                       href="<?=PATH_ADMIN_LIST?>/articles">Статьи</a>
                </li>
                <li>
                    <a class="nav-item nav-link <?=Router::isActivePath(PATH_ADMIN_LIST . '/comments')?>"
                       href="<?=PATH_ADMIN_LIST?>/comments">Комментарии</a>
                </li>
                <li>
                    <a class="nav-item nav-link <?=Router::isActivePath(PATH_ADMIN_LIST . '/static_pages')?>"
                       href="<?=PATH_ADMIN_LIST?>/static_pages">Страницы</a>
                </li>

                <?php if(Auth::getInstance()->checkGroups([ADMINS])): ?>
                    <li class="dropdown">
                        <a class="nav-link dropdown-toggle ml-3
                            <?=Router::isActivePath(PATH_ADMIN_LIST . '/subscribers')?>
                            <?=Router::isActivePath(PATH_ADMIN_LIST . '/users')?>"
                           href="#" data-toggle="dropdown">
                            Users
                        </a>
                        <div class="dropdown-menu">
                            <a class="dropdown-item" href="<?=PATH_ADMIN_LIST?>/users">Пользователи</a>
                            <a class="dropdown-item" href="<?=PATH_ADMIN_LIST?>/subscribers">Подписчики</a>
                        </div>
                    </li>

                    <li>
                        <a class="nav-item nav-link <?=Router::isActivePath(PATH_ADMIN_SETTINGS)?>"
                           href="<?=PATH_ADMIN_SETTINGS?>">Настройки</a>
                    </li>
                <?php endif; ?>

                <li class="dropdown">
                    <a class="nav-link dropdown-toggle ml-3" href="#" data-toggle="dropdown">
                        <?=Auth::getInstance()->get('user.name')?>
                    </a>
                    <div class="dropdown-menu">
                        <a class="dropdown-item" href="<?=PATH_ACCOUNT?>">Профиль</a>
                        <div class="dropdown-divider"></div>
                        <a class="dropdown-item" href="<?=PATH_MAIN?>">Основной сайт</a>
                        <div class="dropdown-divider"></div>
                        <a class="dropdown-item" href="<?=PATH_SIGN_OUT?>?from=<?=PATH_MAIN?>">Выйти</a>
                    </div>
                </li>

            </ul>
        </div>

    </div>
</header>
<?php include VIEW_TEMPLATE . '/flash_messages.php'?>