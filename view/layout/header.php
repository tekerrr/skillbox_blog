<?php

include VIEW_LAYOUT_BASE_DIR . '/header.php';

use App\Config;
use App\Controller\Auth;
use App\Model\Article;
use App\Model\StaticPage;
use App\Router;

$articlesPerHeader = Config::getInstance()->get('admin_settings.articles_per_header');

?>
<body>
<header class="navbar sticky-top navbar-expand-md navbar-dark bg-primary">
    <div class="container">
        <a class="navbar-brand" href="<?=PATH_DEFAULT?>">
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
                    <a class="nav-item nav-link <?=Router::isActivePath(PATH_MAIN)?>"
                       href="<?=PATH_MAIN?>">Главная</a>
                </li>

                <li class="dropdown">
                    <a class="nav-link dropdown-toggle <?=Router::isActivePath(PATH_ARTICLES . '/*')?>"
                       href="" data-toggle="dropdown">Статьи</a>
                    <div class="dropdown-menu">
                        <?php foreach (Article::lastArticlesWithIdAndTitle($articlesPerHeader) as $lastArticle): ?>
                            <a class="dropdown-item" href="<?=PATH_ARTICLES?>/<?=$lastArticle->id?>">
                                <?=$lastArticle->title?>
                            </a>
                        <?php endforeach; ?>
                        <div class="dropdown-divider"></div>
                        <a class="dropdown-item" href="<?=PATH_DEFAULT?>">Все</a>
                    </div>
                </li>

                <?php foreach (StaticPage::activePagesWithIdAndTitle() as $staticPageForHeader): ?>
                    <li>
                        <a class="nav-item nav-link  <?=Router::isActivePath(PATH_STATIC_PAGES . '/' . $staticPageForHeader->id)?>"
                           href="<?=PATH_STATIC_PAGES?>/<?=$staticPageForHeader->id?>">
                            <?=$staticPageForHeader->title?>
                        </a>
                    </li>
                <?php endforeach; ?>

                <?php if ($userName = Auth::getInstance()->get('user.name')): ?>
                    <li class="dropdown">
                        <a class="nav-link dropdown-toggle ml-3 <?=Router::isActivePath(PATH_ACCOUNT)?>"
                           href="#" data-toggle="dropdown">
                            <?=$userName?>
                        </a>
                        <div class="dropdown-menu">
                            <a class="dropdown-item" href="<?=PATH_ACCOUNT?>">Профиль</a>
                            <div class="dropdown-divider"></div>
                            <?php if (Auth::getInstance()->isPriorityUser()): ?>
                                <a class="dropdown-item" href="<?=PATH_ADMIN?>">Админка</a>
                                <div class="dropdown-divider"></div>
                            <?php endif; ?>
                            <a class="dropdown-item" href="<?=PATH_SIGN_OUT?>?from=<?=Router::getCurrentPath() ?? ''?>">Выйти</a>
                        </div>
                    </li>
                <?php else: ?>
                    <a class="btn btn-success rounded-0 ml-3" href="<?=PATH_SIGN_IN?>">Войти</a>
                <?php endif; ?>

            </ul>
        </div>

    </div>

</header>
<?php include VIEW_TEMPLATE . '/flash_messages.php'?>