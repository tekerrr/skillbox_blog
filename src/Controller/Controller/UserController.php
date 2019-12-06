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
    public function create(): Renderable
    {
        return new View('users.create', [
            'title' => 'Регистрация',
            'fields' => $this->getFields(),
        ]);
    }

    public function store(): Renderable
    {
        if (! $this->checkForm($form = new Form\SignUp())) {
            return Response::redirectBack();
        }

        $user = Model\User::createUser($_POST['email'], $_POST['password'], htmlentities($_POST['name']));
        Auth::getInstance()->signIn($user);

        return Response::redirect(PATH_ACCOUNT);
    }

    public function edit(string $id): Renderable
    {
        if (! $user = Model\User::findById($id)) {
            return new NotFoundResponse();
        }

        return new View('users.edit', [
            'title' => 'Редактирование пользователя',
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

        if (isset($_POST['_active'])) {
            return $this->activate($user);
        }

        if (isset($_POST['_avatar'])) {
            return isset($_POST['_delete']) ? $this->deleteAvatar($user) : $this->updateAvatar($user);
        }

        if (isset($_POST['_group'])) {
            return $this->activateGroup($user);
        }

        if (! $this->checkForm(new Form\EditUser($id))) {
            return Response::redirectBack();
        }

        $user->updateAccount($_POST['email'], htmlentities($_POST['name']), htmlentities($_POST['about']));

        new FlashMessage('Успех!', 'Данные пользователя обновлены');
        return Response::redirectBack();
    }

    public function destroy(string $id): Renderable
    {
        if (! $user = Model\User::findById($id)) {
            return new NotFoundResponse();
        }

        $user->delete();

        new FlashMessage('', 'Пользователь ' . $user->name . ' удален');
        return Response::redirectBack();
    }

    private function activate(Model\User $user): Renderable
    {
        $user->setActive($active = (new StringToBoolean())->format($_POST['_active']));

        new FlashMessage('', 'Пользователь ' . $user->name . ($active ? ' активирован' : ' деактивирован'));
        return Response::redirectBack();
    }

    private function updateAvatar(Model\User $user): Renderable
    {
        $avatar = new Model\Image($user);
        if (! $avatar->save()) {
            foreach (($errors = $avatar->getErrors()) as $error) {
                new FlashMessage('Ошибка!', $error, true);
            }

            return Response::redirectBack();
        }

        new FlashMessage('', 'Аватар обновлён');
        return Response::redirectBack();
    }

    private function deleteAvatar(Model\User $user): Renderable
    {
        $avatar = new Model\Image($user);
        if (! $avatar->delete()) {
            foreach (($errors = $avatar->getErrors()) as $error) {
                new FlashMessage('Ошибка!', $error, true);
            }

            return Response::redirectBack();
        }

        new FlashMessage('', 'Аватар удалён');
        return Response::redirectBack();
    }

    private function activateGroup(Model\User $user): Renderable
    {
        if ($_POST['group_activate']) {
            $user->joinGroup($_POST['_group']);
        } else {
            $user->leaveGroup($_POST['_group']);
        }

        return Response::redirectBack();
    }
}