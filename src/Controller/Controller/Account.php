<?php


namespace App\Controller\Controller;


use App\Controller\Auth;
use App\Http\Response;
use App\Renderable;
use App\View\FlashMessage;
use App\View\View;
use App\Model;
use App\Controller\Form;

class Account extends AbstractController
{
    public function edit(): Renderable
    {
        return new View('account.edit', [
            'title' => 'Личный кабинет',
            'user' => ($user = Auth::getInstance()->get('user')),
            'sub'  => Auth::getInstance()->get('sub'),
            'fields' => $this->getFields($user),
        ]);
    }

    public function update(): Renderable
    {
        if (isset($_POST['_avatar'])) {
            return isset($_POST['_delete']) ? $this->deleteAvatar() : $this->updateAvatar();
        }

        if (! $this->checkForm(new Form\UpdateAccount())) {
            return Response::redirectBack();
        }

        $user = Auth::getInstance()->getUser();
        $user->updateAccount($_POST['email'], htmlentities($_POST['name']), htmlentities($_POST['about']));
        Auth::getInstance()->signIn($user);

        new FlashMessage('Успех!', 'Данные успешно обновлены');
        return (Response::redirect(PATH_ACCOUNT));
    }

    public function editPassword(): Renderable
    {
        return new View('account.password.edit', [
            'title' => 'Смена пароля',
            'fields' => $this->getFields(),
        ]);
    }

    public function updatePassword(): Renderable
    {
        if (! $this->checkForm($form = new Form\ChangePassword())) {
            return Response::redirectBack();
        }

        $user = Auth::getInstance()->getUser();
        if (! $user->changePassword($_POST['password'], $_POST['new_password'])) {
            $this->saveFieldsForFlashSession($form->getFields());
            new FlashMessage('Ошибка!', 'Неверный старый пароль', true);
            return Response::redirectBack();
        }

        new FlashMessage('Успех!', 'Пароль успешно изменён');
        return (Response::redirect(PATH_ACCOUNT));
    }

    public function showSignIn(): Renderable
    {
        return new View('account.sign_in', [
            'title' => 'Авторизация',
            'fields' => $this->getFields(),
        ]);
    }

    public function signIn(): Renderable
    {
        if (! $this->checkForm($form = new Form\SignIn())) {
            return Response::redirectBack();
        }

        if (! $user = Model\User::signIn($_POST['email'], $_POST['password'])) {
            $this->saveFieldsForFlashSession($form->getFields());
            new FlashMessage('Ошибка!', 'Неверный email или пароль', true);
            return Response::redirectBack();
        }

        Auth::getInstance()->signIn($user);
        return Response::redirect(PATH_DEFAULT);
    }

    public function signOut(): Renderable
    {
        Auth::getInstance()->signOut();
        return Response::redirect($_GET['from'] ?? PATH_DEFAULT);
    }

    private function updateAvatar(): Renderable
    {
        $avatar = new Model\Image(Auth::getInstance()->getUser());
        if (! $avatar->save()) {
            foreach (($errors = $avatar->getErrors()) as $error) {
                new FlashMessage('Ошибка!', $error, true);
            }

            return Response::redirectBack();
        }

        Auth::getInstance()->update();
        new FlashMessage('', 'Аватар обновлён');
        return Response::redirectBack();
    }

    private function deleteAvatar(): Renderable
    {
        $avatar = new Model\Image(Auth::getInstance()->getUser());

        if (! $avatar->delete()) {
            foreach (($errors = $avatar->getErrors()) as $error) {
                new FlashMessage('Ошибка!', $error, true);
            }

            return Response::redirectBack();
        }

        Auth::getInstance()->update();
        new FlashMessage('', 'Аватар удалён');
        return Response::redirectBack();
    }
}