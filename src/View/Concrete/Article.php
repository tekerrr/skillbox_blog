<?php


namespace App\View\Concrete;

use App\Exception\NotFoundException;
use App\Model\Article as ArticleModel;
use App\Router;
use App\View\View;

/**
 * optional config:
 *      $status, $message: comment
 *
 * Class Article
 * @package App\View\Concrete
 */
class Article extends AbstractConcreteView
{
    /**
     * Article constructor.
     * @param string $id
     * @param bool $onlyActive
     * @throws NotFoundException
     */
    public function __construct(string $id, bool $onlyActive = true)
    {
        if (! $article = \App\Model\Article::findByIdAndOnlyActive($id, $onlyActive)) {
            throw new NotFoundException();
        }

        $this->setView(new View('article', [
            'title' => $article->title,
            'article' => $article->attributes(),
            'comments' => $article->getCommentsWithUserAsAttributes($onlyActive),
            'previous' => $article->getNextArticleId(),
            'next' => $article->getPreviousArticleId(),
            'admin_header' => Router::isActivePath(PATH_ADMIN_VIEW),
        ]));
    }
}