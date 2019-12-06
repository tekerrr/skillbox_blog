<?php


namespace App\Controller\Controller;


use App\Controller\Auth;
use App\Http\NotFoundResponse;
use App\Http\Request;
use App\Http\Response;
use App\Renderable;
use App\View\FlashMessage;
use App\Controller\Form;
use App\Model;


class SubscriberController extends AbstractRestController
{
    public function store(): Renderable
    {
        if (! $this->checkForm(new Form\Subscribe())) {
            return Response::redirectBack();
        }

        Model\Subscriber::subscribe($_POST['email']);
        Auth::getInstance()->update();

        FlashMessage::push('Успех!', 'Подписка на email "' . $_POST['email'] . '" успешно оформлена.');
        return Response::redirectBack();
    }

    public function destroy(string $id): Renderable
    {
        if (! $subscriber = Model\Subscriber::findById($id)) {
            return new NotFoundResponse();
        }

        $subscriber->delete();

        FlashMessage::push('', 'Подписчик email ' . $subscriber->email . ' удален');
        return Response::redirectBack();
    }

    public function unsubscribe(string $id, string $hash): Renderable
    {
        if (! Model\Subscriber::unsubscribe($id, $hash)) {
            return new NotFoundResponse();
        }

        Auth::getInstance()->update();

        FlashMessage::push('Успех!', 'Вы отписались от получения сообщений о новых статьях ');
        return Response::redirect($_GET['from'] ?? PATH_MAIN);
    }
}