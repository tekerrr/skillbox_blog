<?php


namespace App\Controller\Controller\Admin;


use App\Controller\Form;
use App\Controller\Controller\Special;
use App\Formatter\Paragraph;
use App\Http\Response;
use App\Model;
use App\Renderable;
use App\Router;
use App\View\View;

class Content extends AbstractController
{
    // Pages

    /**
     * additionalConfig:
     *      $errorAlerts
     *      $status, $message: [title, abstract, text]
     * @param string $id
     * @return Renderable
     */
    public function getAddArticlePage(string $id = ''): Renderable
    {
        $attributes = [];

        if ($id) {
            if (! $article = Model\Article::findById($id)) {
                return Response::notFound();
            }

            $attributes = $article->attributes();
        }

        $view = new View('admin.edit.article', [
            'title' => $attributes ? 'Редактировать статью' : 'Создать статью',
            'article' => $attributes,
            'fieldValue' => $this->getFieldValues(['title', 'abstract', 'text'], $attributes),
        ]);
        $view->addToConfig($this->getAdditionalConfig());

        return $view;
    }

    /**
     * additionalConfig:
     *      $status, $message: [title, text]
     * @param string $id
     * @return Renderable
     */
    public function getAddStaticPagePage(string $id = ''): Renderable
    {
        $attributes = [];

        if ($id) {
            if (! $staticPage = Model\StaticPage::findById($id)) {
                return Response::notFound();
            }

            $attributes = $staticPage->attributes();
        }

        $view = new View('admin.edit.static_page', [
            'title' => $attributes ? 'Редактировать статичную страницу' : 'Создать статичную страницу',
            'staticPage' => $attributes,
            'fieldValue' => $this->getFieldValues(['title', 'text'], $attributes),
        ]);
        $view->addToConfig($this->getAdditionalConfig());

        return $view;
    }

    // Actions

    /**
     * @return Renderable
     * @throws \ActiveRecord\ActiveRecordException
     */
    public function addArticle(): Renderable
    {
        if (! $this->checkForm(new Form\AddArticle(), $this)) {
            return $this->getAddArticlePage();
        }

        $article = Model\Article::add(htmlentities($_POST['title']), $_POST['abstract'], $this->getFormattedAsParagraphText());

        $image = new Model\Image($article);
        $image->save();
        if ($errors = $image->getErrors()) {
            $article->delete();
            $this->setAdditionalConfig(['errorAlerts' => $errors]);

            return $this->getAddArticlePage();
        }

        $messageController = new Special\Message('Успех', 'Успех', 'Статья добавлена');
        $messageController->setReturnPath(PATH_ADMIN_LIST . '/articles/1');
        $messageController->setAdminHeader();

        return $messageController->getMessagePage();
    }

    /**
     * @return Renderable
     * @throws \App\Http\Exception\NotFound
     * @throws \ActiveRecord\ActiveRecordException
     */
    public function editArticle(): Renderable
    {
        if (! $this->checkForm(new Form\EditArticle(), $this)) {
            return $this->getAddArticlePage($_POST['id']);
        }

        if (! $article = Model\Article::findById($_POST['id'])) {
            $messageController = new Special\Message(
                'Ошибка',
                'Ошибка',
                'Ошибка при сохранении статьи. Статья не найдена'
            );
            $messageController->setReturnPath(PATH_ADMIN_LIST . '/articles/1');
            $messageController->setAdminHeader();

            return $messageController->getMessagePage();
        }

        $article->edit(htmlentities($_POST['title']), $_POST['abstract'], $this->getFormattedAsParagraphText());

        if ($_FILES && $_FILES['img_article']['error'] !== UPLOAD_ERR_NO_FILE) {
            $image = new Model\Image($article);
            $image->save();

            if ($errors = $image->getErrors()) {
                $this->setAdditionalConfig(['errorAlerts' => $errors]);

                return $this->getAddArticlePage($_POST['id']);
            }
        }

        $messageController = new Special\Message('Успех', 'Успех', 'Статья успешно сохранена');
        $messageController->setReturnPath(PATH_ADMIN_LIST . '/articles/1');
        $messageController->setAdminHeader();

        return $messageController->getMessagePage();
    }

    public function addStaticPage(): Renderable
    {
        if (! $this->checkForm(new Form\AddStaticPage(), $this)) {
            return $this->getAddStaticPagePage();
        }

        Model\StaticPage::add(htmlentities($_POST['title']), $this->getFormattedAsParagraphText());

        $messageController = new Special\Message('Успех', 'Успех', 'Статичная страница добавлнеа добавлена');
        $messageController->setReturnPath(PATH_ADMIN_LIST . '/static_pages/1');
        $messageController->setAdminHeader();

        return $messageController->getMessagePage();
    }

    public function editStaticPage(): Renderable
    {
        if (! $this->checkForm(new Form\EditStaticPage(), $this)) {
            return $this->getAddStaticPagePage($_POST['id']);
        }

        if ($staticPage = Model\StaticPage::findById($_POST['id'])) {
            $staticPage->edit(htmlentities($_POST['title']), $this->getFormattedAsParagraphText());
            $title = 'Успех';
            $message = 'Страница успешно сохранена';
        } else {
            $title = 'Ошибка';
            $message = 'Ошибка при сохранении статичной страницы. Страница не найдена';
        }

        $messageController = new Special\Message($title, $title, $message);
        $messageController->setReturnPath(PATH_ADMIN_LIST . '/static_pages/1');
        $messageController->setAdminHeader();

        return $messageController->getMessagePage();
    }

    public function activate(): Renderable
    {
        if (! $anyPublic = $this->getCanBeListed($_POST['type'], $_POST['id'])) {
            return Response::notFound();
        }

        $anyPublic->activate();

        return Response::redirect(Router::getFullGetRequest() ?? PATH_DEFAULT);
    }

    public function publishArticleAndNotify(): Renderable
    {
        if (! $article = Model\Article::findById($_POST['id'])) {
            return Response::notFound();
        }

        $article->activate();
        Model\Subscriber::notifyAll($article);

        return Response::redirect(Router::getFullGetRequest() ?? PATH_DEFAULT);
    }

   public function deactivate(): Renderable
    {
        if (! $anyPublic = $this->getCanBeListed($_POST['type'], $_POST['id'])) {
            return Response::notFound();
        }

        $anyPublic->deactivate();

        return Response::redirect(Router::getFullGetRequest() ?? PATH_DEFAULT);
    }

    public function delete(): Renderable
    {
        if (! $anyPublic = $this->getCanBeListed($_POST['type'], $_POST['id'])) {
            return Response::notFound();
        }

        $anyPublic->delete();

        return Response::redirect(Router::getFullGetRequest() ?? PATH_DEFAULT);
    }

    private function getFormattedAsParagraphText(): string
    {
        return isset($_POST['p_teg']) ? (new Paragraph())->format($_POST['text']) : $_POST['text'];
    }

    /**
     * @param string $type
     * @param string $id
     * @return mixed
     */
    private function getCanBeListed(string $type, string $id)
    {
        if (! $className = $this->getClassName($type, true)) {
            return null;
        }

        return call_user_func_array([$className, 'findById'], [$id]);
    }
}