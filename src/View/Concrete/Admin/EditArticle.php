<?php


namespace App\View\Concrete\Admin;

use App\Exception\NotFoundException;
use App\View\Concrete\AbstractConcreteView;
use App\View\View;

/**
 * optional config:
 *      $errorAlerts
 *      $status, $message: title, abstract, text, image
 *
 * Class EditArticle
 * @package App\View\Concrete\Admin
 */
class EditArticle extends AbstractConcreteView
{
    /**
     * EditArticle constructor.
     * @param string $id
     * @throws NotFoundException
     */
    public function __construct(string $id)
    {
        if (! $article = \App\Model\Article::findById($id)) {
            throw new NotFoundException();
        }

        $this->setView(new View('admin.edit.article', [
            'title' => 'Редактировать статью',
            'article' => $article->attributes(),
        ]));
    }
}