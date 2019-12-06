<?php


namespace App\Controller\Controller;


use App\Controller\Auth;
use App\Controller\Form;
use App\Http\Response;
use App\Renderable;
use App\Model;

class Subscriber extends AbstractController
{
    // Actions

    /**
     * @return Renderable
     */
    public function subscribe(): Renderable
    {
        $currentPage = $_POST['current_main_page'] ?? 1;

        if (! $this->checkForm(new Form\Subscribe(), $pageController = new BasicPage())) {
            return $pageController->getMainPage($currentPage);
        }

        Model\Subscriber::subscribe($_POST['email']);
        Auth::getInstance()->update();

        $messageController = new Special\Message(
            'Успех',
            'Успех',
            'Подписка на email "' . $_POST['email'] . '" успешно оформлена.'
        );
        $messageController->setReturnPath(PATH_MAIN . '/' . $currentPage);

        return $messageController->getMessagePage();
    }

    /**
     * @param string $id
     * @param string $hash
     * @return Renderable
     */
    public function unsubscribe(string $id, string $hash): Renderable
    {
        if (! Model\Subscriber::unsubscribe($id, $hash)) {
            return Response::notFound();
        }

        Auth::getInstance()->update();

        $messageController = new Special\Message(
            'Успех',
            'Успех',
            'Вы отписались от получения сообщений о новых статьях '
        );

        return $messageController->getMessagePage();
    }
}