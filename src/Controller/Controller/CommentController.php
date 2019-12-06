<?php


namespace App\Controller\Controller;


use App\Controller\Auth;
use App\Formatter\StringToBoolean;
use App\Http\NotFoundResponse;
use App\Http\Response;
use App\Renderable;
use App\View\FlashMessage;
use App\Controller\Form;
use App\Model;

class CommentController extends AbstractRestController
{
    public function store(): Renderable
    {
        if (! $this->checkForm(new Form\AddComment())) {
            return Response::redirectBack();
        }

        if (! $id = Auth::getInstance()->get('user.id')) {
            new FlashMessage('Ошибка!', 'Для отравки комментария необходимо авторизироваться.', true);
        } else {
            Model\Comment::add(
                $id,
                $_POST['article_id'],
                htmlentities($_POST['comment']),
                $confirmed = Auth::getInstance()->isPriorityUser()
            );
            new FlashMessage('Успех!', 'Комментарий добавлен.' . ($confirmed ? '' : ' Он будет видет после модерации.'));
        }

        return Response::redirectBack();
    }

    public function update(string $id): Renderable
    {
        /** @var Model\StaticPage $comment */
        if (! $comment = Model\Comment::findById($id)) {
            return new NotFoundResponse();
        }

        if (isset($_POST['_active'])) {
            $comment->setActive($active = (new StringToBoolean())->format($_POST['_active']));
            new FlashMessage('', 'Комментарий id ' . $id . ($active ? ' опубликован' : ' скрыт'));
        }
        return Response::redirectBack();
    }

    public function destroy(string $id): Renderable
    {
        if (! $comment = Model\Comment::findById($id)) {
            return new NotFoundResponse();
        }

        $comment->delete();
        new FlashMessage('', 'Комментарий id ' . $id . ' удален');

        return Response::redirectBack();
    }

}