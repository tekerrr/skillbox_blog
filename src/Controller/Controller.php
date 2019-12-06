<?php


namespace App\Controller;


use App\Config;
use App\Exception\NotFoundException;
use App\Model;
use App\Renderable;
use App\Router;
use App\View;

class Controller
{
    //
    // MAIN SITE
    //

    // Actions with Form

    public function signIn()
    {
        if ($formView = $this->isWrongForm($form = new Form\SignIn(), new View\Concrete\SignIn())) {
            return $formView;
        }

        if (! $user = Model\User::signIn($_POST['email'], $_POST['password'])) {
            $formView = new View\Concrete\SignIn();
            $formView->addToConfig(['status' => $form->getFieldValidStatuses(),'error' => 'Неверный email или пароль']);
            return $formView;
        }

        Auth::getInstance()->signIn($user);
        Router::redirectTo(PATH_DEFAULT);
    }

    public function signUp()
    {
        if ($formView = $this->isWrongForm(new Form\SignUp(), new View\Concrete\SignUp())) {
            return $formView;
        }

        $user = Model\User::createUser($_POST['email'], $_POST['password'], htmlentities($_POST['name']));
        Auth::getInstance()->signIn($user);
        Router::redirectTo(PATH_ACCOUNT);
    }

    /**
     * @return Renderable
     * @throws NotFoundException
     */
    public function subscribe()
    {
        $currentPage = $_POST['current_main_page'] ?? 1;

        if ($formView = $this->isWrongForm(new Form\Subscribe(), new View\Concrete\Main($currentPage))) {
            return $formView;
        }

        Model\Subscriber::subscribe($_POST['email']);
        Auth::getInstance()->update();

        $messageView =  new View\Concrete\Message(
            'Успех',
            'Успех',
            'Подписка на email "' . $_POST['email'] . '" успешно оформлена.'
        );
        $messageView->setPathToReturn(PATH_MAIN . '/' . $currentPage);
        return $messageView;
    }

    /**
     * @return Renderable
     * @throws NotFoundException
     */
    public function addComment()
    {
        if ($formView = $this->isWrongForm(new Form\AddComment(), new View\Concrete\Article($_POST['article_id']))) {
            return $formView;
        }

        if (! $id = Auth::getInstance()->get('user.id')) {
            $header = 'Ошибка!';
            $message = 'Для отравки комментария необходимо авторизироваться.';
        } else {
            Model\Comment::add(
                $id,
                $_POST['article_id'],
                htmlentities($_POST['comment']),
                $confirmed = Auth::getInstance()->isPriorityUser()
            );
            $header = 'Успех!';
            $message = 'Комментарий добавлен. ' . ($confirmed ? '' : ' Он будет виден после одобрения модератора.');
        }

        $messageView =  new View\Concrete\Message('Добавление комментария', $header, $message);
        $messageView->setPathToReturn(PATH_ARTICLE . '/' . $_POST['article_id']);
        return $messageView;
    }

    public function updateAccount()
    {
        if ($formView = $this->isWrongForm(new Form\UpdateAccount(), new View\Concrete\Account())) {
            return $formView;
        }

        $user = Auth::getInstance()->getUser();
        $user->updateAccount($_POST['email'], htmlentities($_POST['name']), htmlentities($_POST['about']));
        Auth::getInstance()->signIn($user);

        $messageView =  new View\Concrete\Message('Успех', 'Успех', 'Данные успешно обновлены');
        $messageView->setPathToReturn(PATH_ACCOUNT);
        return $messageView;
    }

    public function changePassword()
    {
        if ($formView = $this->isWrongForm($form = new Form\ChangePassword(), new View\Concrete\ChangePassword())) {
            return $formView;
        }

        $user = Auth::getInstance()->getUser();
        if (! $user->changePassword($_POST['password'], $_POST['new_password'])) {
            $formView = new View\Concrete\ChangePassword();
            $formView->addToConfig([
                'status'    => $form->getFieldValidStatuses(),
                'error'     => 'Неверный старый пароль',
            ]);
            return $formView;
        }

        $messageView =  new View\Concrete\Message('Успех', 'Успех', 'Пароль успешно изменён');
        $messageView->setPathToReturn(PATH_ACCOUNT);
        return $messageView;
    }

    // Actions without Form

    public function signOut(): void
    {
        Auth::getInstance()->signOut();
        Router::redirectTo($_GET['from'] ?? PATH_DEFAULT);
    }

    /**
     * @param string $id
     * @param string $hash
     * @return View\Concrete\Message
     * @throws NotFoundException
     */
    public function unsubscribe(string $id, string $hash)
    {
        if (! Model\Subscriber::unsubscribe($id, $hash)) {
            throw new NotFoundException();
        }

        Auth::getInstance()->update();

        return new View\Concrete\Message(
            'Успех',
            'Успех',
            'Вы отписались от получения сообщений о новых статьях '
        );
    }

    public function uploadAvatar()
    {
        $avatar = new Model\Image(Auth::getInstance()->getUser(), 'avatar');
        $avatar->save();
        Auth::getInstance()->update();

        $accountView = new View\Concrete\Account();
        $accountView->addToConfig([
            'errorAlerts' => $avatar->getErrors(),
        ]);
        return $accountView;
    }

    public function deleteAvatar()
    {
        $avatar = new Model\Image(Auth::getInstance()->getUser(), 'avatar');

        if ($avatar->delete()) {
            Auth::getInstance()->update();
            Router::redirectTo(PATH_ACCOUNT);
        } else {
            $accountView = new View\Concrete\Account();
            $accountView->addToConfig([
                'errorAlerts' => $avatar->getErrors(),
            ]);
            return $accountView;
        }
    }

    public function setItemsPerPage()
    {
        $params = $_GET;
        unset($params['items']);
        $params['items'] = $_POST['submit_items_per_page'];
        Router::redirectTo(urldecode(http_build_query($params)));
    }

    //
    // ADMIN SITE
    //

    // Actions with Form

    public function addStaticPage()
    {
        if ($formView = $this->isWrongForm(new Form\AddStaticPage(), new View\Concrete\Admin\AddStaticPage())) {
            return $formView;
        }

        Model\StaticPage::add(htmlentities($_POST['title']), $_POST['text']);

        $messageView = new View\Concrete\Message(
            'Успех',
            'Успех',
            'Статичная страница добавлнеа добавлена'
        );
        $messageView->setPathToReturn(PATH_ADMIN_LIST . '/static_pages/1');
        $messageView->setAdminHeader();
        return $messageView;
    }

    /**
     * @return Renderable
     * @throws NotFoundException
     */
    public function editStaticPage()
    {
        if ($formView = $this->isWrongForm(new Form\EditStaticPage(), new View\Concrete\Admin\EditStaticPage($_POST['id']))) {
            return $formView;
        }

        if ($staticPage = Model\StaticPage::findById($_POST['id'])) {
            $staticPage->edit(htmlentities($_POST['title']), $_POST['text']);
            $title = 'Успех';
            $message = 'Страница успешно сохранена';
        } else {
            $title = 'Ошибка';
            $message = 'Ошибка при сохранении статичной страницы. Страница не найдена';
        }

        $messageView = new View\Concrete\Message($title, $title, $message);
        $messageView->setPathToReturn(PATH_ADMIN_LIST . '/static_pages/1');
        $messageView->setAdminHeader();
        return $messageView;
    }

    /**
     * @return Renderable
     * @throws \ActiveRecord\ActiveRecordException
     */
    public function addArticle()
    {
        if ($formView = $this->isWrongForm(new Form\AddArticle(), new View\Concrete\Admin\AddArticle())) {
            return $formView;
        }

        $article = Model\Article::add(htmlentities($_POST['title']), $_POST['abstract'], $_POST['text']);

        $image = new Model\Image($article, 'article');
        $image->save();
        if ($errors = $image->getErrors()) {
            $article->delete();

            $formView = new View\Concrete\Admin\AddArticle();
            $formView->addToConfig([
                'errorAlerts' => $errors,
            ]);
            return $formView;
        }

        $messageView = new View\Concrete\Message(
            'Успех',
            'Успех',
            'Статья добавлена'
        );
        $messageView->setPathToReturn(PATH_ADMIN_LIST . '/articles/1');
        $messageView->setAdminHeader();
        return $messageView;
    }

    /**
     * @return Renderable
     * @throws NotFoundException
     * @throws \ActiveRecord\ActiveRecordException
     */
    public function editArticle()
    {
        if ($formView = $this->isWrongForm(new Form\EditArticle(), new View\Concrete\Admin\EditArticle($_POST['id']))) {
            return $formView;
        }

        if (! $article = Model\Article::findById($_POST['id'])) {
            $messageView = new View\Concrete\Message(
                'Ошибка',
                'Ошибка',
                'Ошибка при сохранении статьи. Статья не найдена'
            );
            $messageView->setPathToReturn(PATH_ADMIN_LIST . '/articles/1');
            return $messageView;
        }

        $article->edit(htmlentities($_POST['title']), $_POST['abstract'], $_POST['text']);

        if ($_FILES && $_FILES['article']['error'] !== UPLOAD_ERR_NO_FILE) {
            $image = new Model\Image($article, 'article');
            $image->save();

            if ($errors = $image->getErrors()) {
                $formView = new View\Concrete\Admin\EditArticle($_POST['id']);
                $formView->addToConfig([
                    'errorAlerts' => $errors,
                ]);
                return $formView;
            }
        }

        $messageView = new View\Concrete\Message(
            'Успех',
            'Успех',
            'Статья успешно сохранена'
        );
        $messageView->setPathToReturn(PATH_ADMIN_LIST . '/articles/1');
        $messageView->setAdminHeader();
        return $messageView;
    }

    public function editUser()
    {
        if ($formView = $this->isWrongForm(new Form\EditUser($_POST['id']), new View\Concrete\Admin\EditUser($_POST['id']))) {
            return $formView;
        }

        $user = Model\User::findById($_POST['id']);
        $user->updateAccount($_POST['email'], htmlentities($_POST['name']), htmlentities($_POST['about']));

        $messageView =  new View\Concrete\Message('Успех', 'Успех', 'Данные успешно обновлены');
        $messageView->setPathToReturn(PATH_ADMIN_EDIT . '/user/' . $_POST['id']);
        $messageView->setAdminHeader();
        return $messageView;
    }

    public function editSettings()
    {
        if ($formView = $this->isWrongForm(new Form\EditAdminSettings(), new View\Concrete\Admin\Settings())) {
            return $formView;
        }

        Config::getInstance()->set('admin_settings', [
            'articles_per_page' => $_POST['articles_per_page'],
            'items_per_page' => $_POST['items_per_page'],
        ]);

        Router::redirectTo(PATH_ADMIN_SETTINGS);
    }

    // Actions without Form

    /**
     * @throws NotFoundException
     */
    public function activate()
    {
        if ($anyPublic = $this->getCanBeListed($_POST['type'], $_POST['id'])) {
            $anyPublic->activate();
        }

        Router::redirectTo(Router::getFullGetRequest() ?? PATH_DEFAULT);
    }

    /**
     * @throws NotFoundException
     */
    public function deactivate()
    {
        if ($anyPublic = $this->getCanBeListed($_POST['type'], $_POST['id'])) {
            $anyPublic->deactivate();
        }

        Router::redirectTo(Router::getFullGetRequest() ?? PATH_DEFAULT);
    }

    /**
     * @throws NotFoundException
     */
    public function delete()
    {
        if ($anyPublic = $this->getCanBeListed($_POST['type'], $_POST['id'])) {
            if ($anyPublic instanceof Model\HasImage) {
                $anyPublic->deleteWithImage();
            } else {
                $anyPublic->delete();
            }
        }

        Router::redirectTo(Router::getFullGetRequest() ?? PATH_DEFAULT);
    }

    public function publishArticleAndNotify()
    {
        if ($article = Model\Article::findById($_POST['id'])) {
            $article->activate();
            Model\Subscriber::notifyAll($article);
        }

        Router::redirectTo(Router::getFullGetRequest() ?? PATH_DEFAULT);
    }

    public function editUserGroup()
    {
        $user = Model\User::findById($_POST['id']);

        if ($_POST['active']) {
            $user->leaveGroup($_POST['group']);
        } else {
            $user->joinGroup($_POST['group']);
        }

        return new View\Concrete\Admin\EditUser($_POST['id']);
    }

    public function uploadAvatarForUser()
    {
        $avatar = new Model\Image(Model\User::findById($_POST['id']), 'avatar');
        $avatar->save();

        $userView = new View\Concrete\Admin\EditUser($_POST['id']);
        $userView->addToConfig([
            'errorAlerts' => $avatar->getErrors(),
        ]);
        return $userView;
    }

    public function deleteAvatarForUser($id)
    {
        $avatar = new Model\Image(Model\User::findById($id), 'avatar');
        $avatar->delete();

        $userView = new View\Concrete\Admin\EditUser($id);
        if ($avatar->getErrors()) {
            $userView->addToConfig(['errorAlerts' => $avatar->getErrors()]);
        }

        return $userView;
    }

    // Specials

    /**
     * @param string $type
     * @param string $id
     * @return mixed
     * @throws NotFoundException
     */
    private function getCanBeListed(string $type, string $id)
    {
        if (! $className = $this->getClassName($type)) {
            throw new NotFoundException();
        }

        return call_user_func_array([$className, 'findById'], [$id]);
    }

    private function getClassName(string $type): string
    {
        switch ($type) {
            case 'article':
                $className = Model\Article::class;
                break;
            case 'comment':
                $className = Model\Comment::class;
                break;
            case 'static_page':
                $className = Model\StaticPage::class;
                break;
            case 'user':
                $className = Model\User::class;
                break;
            case 'subscriber':
                $className = Model\Subscriber::class;
                break;
            default:
                $className = '';
                break;
        }

        return $className;
    }

    private function getFormConfig(Form $form): array
    {
        return [
            'status'    => $form->getFieldValidStatuses(),
            'message'   => $form->getFieldErrorMessages(),
        ];
    }

    private function isWrongForm(Form $form, Renderable $formView): ?Renderable
    {
        if ($form->check()) {
            return null;
        }

        $formView->addToConfig($this->getFormConfig($form));
        return $formView;
    }
}