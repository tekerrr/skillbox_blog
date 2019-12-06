<?php


namespace App\Controller\Controller;


use App\Controller\Auth;
use App\Formatter\StringToBoolean;
use App\Http\NotFoundResponse;
use App\Http\Response;
use App\Renderable;
use App\View\FlashMessage;
use App\View\View;
use App\Controller\Form;
use App\Model;

class UserController extends AbstractRestController
{
    public function edit(string $id): Renderable
    {
        if (! $user = Model\User::findById($id)) {
            return new NotFoundResponse();
        }

        return new View('users.edit', [
            'fields' => $this->getFields($user->attributes()),
            'user' => $user->attributes(),
        ]);
    }

    public function update(string $id): Renderable
    {
        /** @var Model\User $user */
        if (! $user = Model\User::findById($id)) {
            return Response::redirectBack();
        }

        if (! $this->checkForm(new Form\EditUser($id))) {
            return Response::redirectBack();
        }

        $user->updateAccount($_POST['email'], htmlentities($_POST['name']), htmlentities($_POST['about']));

        FlashMessage::push('Успех!', 'Данные пользователя обновлены');
        return Response::redirectBack();
    }

    public function destroy(string $id): Renderable
    {
        if (! $user = Model\User::findById($id)) {
            return new NotFoundResponse();
        }

        $user->delete();

        FlashMessage::push('', 'Пользователь ' . $user->name . ' удален');
        return Response::redirectBack();
    }

    public function activate(string $id): Renderable
    {
        /** @var Model\User $user */
        if (! $user = Model\User::findById($id)) {
            return Response::redirectBack();
        }

        $user->setActive(true);

        FlashMessage::push('', 'Пользователь ' . $user->name . ' активирован');
        return Response::redirectBack();
    }

    public function deactivate(string $id): Renderable
    {
        /** @var Model\User $user */
        if (! $user = Model\User::findById($id)) {
            return Response::redirectBack();
        }

        $user->setActive(false);

        FlashMessage::push('', 'Пользователь ' . $user->name . ' деактивирован');
        return Response::redirectBack();
    }

    public function updateAvatar(string $id): Renderable
    {
        /** @var Model\User $user */
        if (! $user = Model\User::findById($id)) {
            return Response::redirectBack();
        }

        $avatar = new Model\Image($user);
        if (! $avatar->save()) {
            foreach (($errors = $avatar->getErrors()) as $error) {
                FlashMessage::push('Ошибка!', $error, true);
            }

            return Response::redirectBack();
        }

        FlashMessage::push('', 'Аватар обновлён');
        return Response::redirectBack();
    }

    public function deleteAvatar(string $id): Renderable
    {
        /** @var Model\User $user */
        if (! $user = Model\User::findById($id)) {
            return Response::redirectBack();
        }

        $avatar = new Model\Image($user);
        if (! $avatar->delete()) {
            foreach (($errors = $avatar->getErrors()) as $error) {
                FlashMessage::push('Ошибка!', $error, true);
            }

            return Response::redirectBack();
        }

        FlashMessage::push('', 'Аватар удалён');
        return Response::redirectBack();
    }

    public function joinGroup(string $id): Renderable
    {
        /** @var Model\User $user */
        if (! $user = Model\User::findById($id)) {
            return Response::redirectBack();
        }

        $user->joinGroup($_POST['group']);

        return Response::redirectBack();
    }

    public function leaveGroup(string $id): Renderable
    {
        /** @var Model\User $user */
        if (! $user = Model\User::findById($id)) {
            return Response::redirectBack();
        }

        $user->leaveGroup($_POST['group']);

        return Response::redirectBack();
    }
}