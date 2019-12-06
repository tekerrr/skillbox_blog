<?php


namespace App\Controller\Controller;


use App\Controller\Auth;
use App\Controller\Form;
use App\Renderable;
use App\View\View;

use App\Http\Response;
use App\Model;

class User extends AbstractController
{
    // Pages

    /**
     * additionalConfig:
     *      $errorAlerts
     *      $status, $message: [email, name]
     * @return Renderable
     */
    public function getAccountPage(): Renderable
    {
        $view = new View('account', [
            'title' => 'Личный кабинет',
            'user' => ($user = Auth::getInstance()->get('user')),
            'sub'  => Auth::getInstance()->get('sub'),
            'fieldValue' => $this->getFieldValues(['email', 'name', 'about'], $user),
        ]);
        $view->addToConfig($this->getAdditionalConfig());

        return $view;
    }

    /**
     * additionalConfig:
     *      $errorAlerts
     *      $status, $message: [password, new_password, new_password2]
     * @return Renderable
     */
    public function getChangePasswordPage(): Renderable
    {
        $view = new View('change_password', ['title' => 'Смена пароля']);
        $view->addToConfig($this->getAdditionalConfig());

        return $view;
    }

    /**
     * optional config:
     *      $status, $message: [email, password]
     *      $error
     * @return Renderable
     */
    public function getSignInPage(): Renderable
    {
        $view = new View('sign_in', [
            'title' => 'Авторизация',
            'fieldValue' => $this->getFieldValues(['email', 'password']),
        ]);
        $view->addToConfig($this->getAdditionalConfig());

        return $view;
    }

    /**
     * optional config:
     *      $status, $message: [email, name, password, password2, rules_agree]
     * @return Renderable
     */
    public function getSignUpPage(): Renderable
    {
        $fieldValues = $this->getFieldValues(['email', 'name', 'password', 'password2']);
        $fieldValues['rules_agree'] = isset($_POST['rules_agree']);

        $view = new View('sign_up', ['title' => 'Регистрация', 'fieldValue' => $fieldValues]);
        $view->addToConfig($this->getAdditionalConfig());

        return $view;
    }

    // Actions

    public function signIn(): Renderable
    {
        if (! $this->checkForm($form = new Form\SignIn(), $this)) {
            return $this->getSignInPage();
        }

        if (! $user = Model\User::signIn($_POST['email'], $_POST['password'])) {
            $this->setAdditionalConfig([
                'status' => $form->getFieldValidStatuses(),
                'error' => 'Неверный email или пароль'
            ]);
            return $this->getSignInPage();
        }

        Auth::getInstance()->signIn($user);
        return Response::redirect(PATH_DEFAULT);
    }

    public function signUp(): Renderable
    {
        if (! $this->checkForm($form = new Form\SignUp(), $this)) {
            return $this->getSignUpPage();
        }

        $user = Model\User::createUser($_POST['email'], $_POST['password'], htmlentities($_POST['name']));
        Auth::getInstance()->signIn($user);

        return Response::redirect(PATH_ACCOUNT);
    }

    public function signOut(): Renderable
    {
        Auth::getInstance()->signOut();
        return Response::redirect($_GET['from'] ?? PATH_DEFAULT);
    }

    public function updateAccount(): Renderable
    {
        if (! $this->checkForm(new Form\UpdateAccount(), $this)) {
            return $this->getAccountPage();
        }

        $user = Auth::getInstance()->getUser();
        $user->updateAccount($_POST['email'], htmlentities($_POST['name']), htmlentities($_POST['about']));
        Auth::getInstance()->signIn($user);

        $messageController = new Special\Message('Успех', 'Успех', 'Данные успешно обновлены');
        $messageController->setReturnPath(PATH_ACCOUNT);

        return $messageController->getMessagePage();
    }

    public function changePassword(): Renderable
    {
        if (! $this->checkForm($form = new Form\ChangePassword(), $this)) {
            return $this->getChangePasswordPage();
        }

        $user = Auth::getInstance()->getUser();
        if (! $user->changePassword($_POST['password'], $_POST['new_password'])) {
            $this->setAdditionalConfig([
                'status'    => $form->getFieldValidStatuses(),
                'error'     => 'Неверный старый пароль',
            ]);
            return $this->getChangePasswordPage();
        }

        $messageController = new Special\Message('Успех', 'Успех', 'Пароль успешно изменён');
        $messageController->setReturnPath(PATH_ACCOUNT);

        return $messageController->getMessagePage();
    }

    public function uploadAvatar(): Renderable
    {
        $avatar = new Model\Image(Auth::getInstance()->getUser());
        $avatar->save();
        Auth::getInstance()->update();

        $this->setAdditionalConfig(['errorAlerts' => $avatar->getErrors()]);

        return $this->getAccountPage();
    }

    public function deleteAvatar(): Renderable
    {
        $avatar = new Model\Image(Auth::getInstance()->getUser());

        if ($avatar->delete()) {
            Auth::getInstance()->update();
            return Response::redirect(PATH_ACCOUNT);
        }

        $this->setAdditionalConfig(['errorAlerts' => $avatar->getErrors()]);

        return $this->getAccountPage();
    }
}