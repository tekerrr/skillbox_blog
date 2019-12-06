<?php


namespace App\Controller\Controller;


use App\Http\NotFoundResponse;
use App\Http\Response;
use App\Renderable;
use App\Sender\Message\NewArticleByPseudoEmail;
use App\Sender\Sender;
use App\View\FlashMessage;
use App\Model;

class ContentModerationController extends AbstractController
{
    public function acceptComment(string $id): Renderable
    {
        /** @var Model\StaticPage $comment */
        if (! $comment = Model\Comment::findById($id)) {
            return new NotFoundResponse();
        }

        $comment->setActive(true);

        FlashMessage::push('', 'Комментарий id ' . $id . ' опубликован');
        return Response::redirectBack();
    }

    public function rejectComment(string $id): Renderable
    {
        /** @var Model\StaticPage $comment */
        if (! $comment = Model\Comment::findById($id)) {
            return new NotFoundResponse();
        }

        $comment->setActive(false);

        FlashMessage::push('', 'Комментарий id ' . $id . ' скрыт');
        return Response::redirectBack();
    }

    public function activateArticle(string $id): Renderable
    {
        /** @var Model\Article $article */
        if (! $article = Model\Article::findById($id)) {
            return Response::redirectBack();
        }

        $article->setActive(true);

        FlashMessage::push('', 'Статья id ' . $article->id . ' опубликована');

        return Response::redirectBack();
    }

    public function activateArticleWithNotify(string $id): Renderable
    {
        /** @var Model\Article $article */
        if (! $article = Model\Article::findById($id)) {
            return Response::redirectBack();
        }

        $article->setActive(true);
        $sender = new Sender(Model\Subscriber::class, new NewArticleByPseudoEmail($article));
        $sender->sendAll();

        FlashMessage::push('', 'Статья id ' . $article->id . ' опубликована  с рассылкой сообщение по email');
        return Response::redirectBack();
    }

    public function deactivateArticle(string $id): Renderable
    {
        /** @var Model\Article $article */
        if (! $article = Model\Article::findById($id)) {
            return Response::redirectBack();
        }

        $article->setActive(false);

        FlashMessage::push('', 'Статья id ' . $article->id . ' скрыта');
        return Response::redirectBack();
    }

    public function activateStaticPage(string $id): Renderable
    {
        /** @var Model\StaticPage $staticPage */
        if (! $staticPage = Model\StaticPage::findById($id)) {
            return Response::redirectBack();
        }

        $staticPage->setActive(true);

        FlashMessage::push('', 'Страница id ' . $staticPage->id . ' опубликована');
        return Response::redirectBack();
    }

    public function deactivateStaticPage(string $id): Renderable
    {
        /** @var Model\StaticPage $staticPage */
        if (! $staticPage = Model\StaticPage::findById($id)) {
            return Response::redirectBack();
        }

        $staticPage->setActive(false);

        FlashMessage::push('', 'Страница id ' . $staticPage->id . ' скрыта');
        return Response::redirectBack();
    }
}