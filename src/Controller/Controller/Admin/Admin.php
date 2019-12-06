<?php


namespace App\Controller\Controller\Admin;


use App\Controller\Form;
use App\Controller\Controller\Special;
use App\Config;
use App\Http\Response;
use App\Model;
use App\Renderable;
use App\View\View;

class Admin extends AbstractController
{
    // Pages

    /**
     * additionalConfig:
     *      $errorAlerts
     *      $status, $message: [email, name]
     * @param string $id
     * @return Renderable
     */
    public function getEditUserPage(string $id): Renderable
    {
        if (! $user = Model\User::findById($id)) {
            return Response::notFound();
        }

        $view = new View('admin.edit.user', [
            'title' => 'Редактирование пользователя',
            'fieldValue' => $this->getFieldValues(['email', 'name', 'about'], $user->attributes()),
            'user' => $user->attributes(),
        ]);
        $view->addToConfig($this->getAdditionalConfig());

        return $view;
    }

    /**
     * additionalConfig:
     *      $status, $message: [articles_per_page, articles_per_header]
     * @return Renderable
     */
    public function getSettingsPage(): Renderable
    {
        $view = new View('admin.settings', [
            'title' => 'Настройки',
            'fieldValue' => $this->getFieldValues(
                ['articles_per_page', 'articles_per_header', 'items_per_page'],
                Config::getInstance()->get('admin_settings'),
            ),
        ]);
        $view->addToConfig($this->getAdditionalConfig());

        return $view;
    }

    // Actions

    public function editUser(): Renderable
    {
        if (! $this->checkForm(new Form\EditUser($_POST['id']), $this)) {
            return $this->getEditUserPage($_POST['id']);
        }

        $user = Model\User::findById($_POST['id']);
        $user->updateAccount($_POST['email'], htmlentities($_POST['name']), htmlentities($_POST['about']));

        $messageController = new Special\Message('Успех', 'Успех', 'Данные успешно обновлены');
        $messageController->setReturnPath(PATH_ADMIN_EDIT . '/user/' . $_POST['id']);
        $messageController->setAdminHeader();

        return $messageController->getMessagePage();
    }

    public function editUserGroup(): Renderable
    {
        if (! $user = Model\User::findById($_POST['id'])) {
            return Response::notFound();
        }

        if ($_POST['active']) {
            $user->leaveGroup($_POST['group']);
        } else {
            $user->joinGroup($_POST['group']);
        }

        return $this->getEditUserPage($_POST['id']);
    }

    public function uploadAvatarForUser(): Renderable
    {
        if (! $user = Model\User::findById($_POST['id'])) {
            return Response::notFound();
        }

        $avatar = new Model\Image($user);
        $avatar->save();
        $this->setAdditionalConfig(['errorAlerts' => $avatar->getErrors()]);

        return $this->getEditUserPage($_POST['id']);
    }

    public function deleteAvatarForUser($id): Renderable
    {
        if (! $user = Model\User::findById($id)) {
            return Response::notFound();
        }

        $avatar = new Model\Image($user);
        $avatar->delete();
        $this->setAdditionalConfig(['errorAlerts' => $avatar->getErrors()]);

        return $this->getEditUserPage($id);
    }

    public function editSettings(): Renderable
    {
        if (! $this->checkForm(new Form\EditAdminSettings(), $this)) {
            return $this->getSettingsPage();
        }

        Config::getInstance()->set('admin_settings', [
            'articles_per_page' => $_POST['articles_per_page'],
            'articles_per_header' => $_POST['articles_per_header'],
            'items_per_page' => $_POST['items_per_page'],
        ]);

        return Response::redirect(PATH_ADMIN_SETTINGS);
    }
}