<?php


namespace App\View\Concrete;

use App\Config;
use App\Controller\Auth;
use App\Controller\Paginator;
use App\Exception\NotFoundException;
use App\View\View;

/**
 * optional config:
 *      $status, $message: email
 *
 * Class AbstractConcreteView
 * @package App\View\Concrete
 */
class Main extends AbstractConcreteView
{
    /**
     * Main constructor.
     * @param int $currentPage
     * @throws NotFoundException
     */
    public function __construct(int $currentPage = 1)
    {
        $articlesPerPage = Config::getInstance()->get('admin_settings.articles_per_page');

        $paginator = new Paginator($currentPage, \App\Model\Article::countItems(), $articlesPerPage);
        $paginator->setPath(PATH_MAIN);

        if ($currentPage > ($lastPage = $paginator->getLastPage())) {
            throw new NotFoundException();
        }

        $articles = \App\Model\Article::articlesWithoutText($articlesPerPage,($currentPage - 1) * $articlesPerPage);
        $articles = \App\Model\Article::getModelsAttributes($articles);

        $this->setView(new View('main', [
            'title' => 'Главная',
            'articles' => $articles,
            'paginator' => $paginator,
            'userEmail' => Auth::getInstance()->get('user.email'),
            'sub' => Auth::getInstance()->get('sub'),
        ]));
    }
}