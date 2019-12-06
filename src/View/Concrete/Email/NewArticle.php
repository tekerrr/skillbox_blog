<?php


namespace App\View\Concrete\Email;


use App\Model\Article;
use App\Model\Subscriber;
use App\View\Concrete\AbstractConcreteView;
use App\View\View;

/**
 * optional config:
 *
 * Class NewArticle
 * @package App\View\Concrete\Email
 */
class NewArticle extends AbstractConcreteView
{
    public function __construct(Article $article, Subscriber $subscriber)
    {
        $this->setView(new View('admin.settings', [
            'article' => $article->attributes(),
            'sub' => $subscriber->attributes(),
        ]));
    }
}