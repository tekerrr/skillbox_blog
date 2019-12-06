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
            FlashMessage::push('Ошибка!', 'Для отравки комментария необходимо авторизироваться.', true);
        } else {
            Model\Comment::add(
                $id,
                $_POST['article_id'],
                htmlentities($_POST['comment']),
                $confirmed = Auth::getInstance()->isPriorityUser()
            );
            FlashMessage::push('Успех!', 'Комментарий добавлен.' . ($confirmed ? '' : ' Он будет видет после модерации.'));
        }

        return Response::redirectBack();
    }

    public function destroy(string $id): Renderable
    {
        if (! $comment = Model\Comment::findById($id)) {
            return new NotFoundResponse();
        }

        $comment->delete();
        FlashMessage::push('', 'Комментарий id ' . $id . ' удален');

        return Response::redirectBack();
    }

}