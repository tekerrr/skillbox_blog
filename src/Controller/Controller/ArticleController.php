<?php


namespace App\Controller\Controller;


use App\Config;
use App\Controller\Form;
use App\Controller\Auth;
use App\Controller\Paginator;
use App\Formatter\Paragraph;
use App\Formatter\StringToBoolean;
use App\Http\NotFoundResponse;
use App\Http\Response;
use App\Renderable;
use App\Sender\Message\NewArticleByPseudoEmail;
use App\Sender\Sender;
use App\View\FlashMessage;
use App\View\View;
use App\Model;

class ArticleController extends AbstractRestController
{
    public function index(): Renderable
    {
        $currentPage = (int) ($_GET['page'] ?? 1);

        if ($currentPage <= 0) {
            return new NotFoundResponse();
        }

        $articlesPerPage = Config::getInstance()->get('admin_settings.articles_per_page');
        $paginator = new Paginator($currentPage, Model\Article::countItems(), $articlesPerPage);

        if ($currentPage > ($lastPage = $paginator->getLastPage())) {
            return new NotFoundResponse();
        }

        $articles = Model\Article::articlesWithoutText($articlesPerPage,($currentPage - 1) * $articlesPerPage);

        if (! $articles) {
            return new NotFoundResponse();
        }

        return new View('articles.index', [
            'title' => 'Главная',
            'articles' => Model\Article::getModelsAttributes($articles),
            'paginator' => $paginator,
            'userEmail' => Auth::getInstance()->get('user.email'),
            'fields' => $this->getFields(),
            'sub' => Auth::getInstance()->get('sub'),
        ]);
    }

    public function create(): Renderable
    {
        return new View('articles.create', [
            'title' => 'Создать статью',
            'fields' => $this->getFields(),
        ]);
    }

    /**
     * @return Renderable
     * @throws \ActiveRecord\ActiveRecordException
     */
    public function store(): Renderable
    {
        if (! $this->checkForm($form = (new Form\AddArticle()))) {
            return Response::redirectBack();
        }

        $article = Model\Article::add(
            htmlentities($_POST['title']),
            $_POST['abstract'],
            isset($_POST['p_teg']) ? (new Paragraph())->format($_POST['text']) : $_POST['text'],
        );

        $image = new Model\Image($article);
        $image->save();
        if ($errors = $image->getErrors()) {
            $article->delete();

            $this->saveFieldsForFlashSession($form->getFields());

            foreach ($errors as $error) {
                new FlashMessage('Ошибка!', $error, true);
            }

            return Response::redirectBack();
        }

        new FlashMessage('Успех!', 'Статья добавлена');
        return Response::redirect(PATH_ADMIN_LIST . '/articles');
    }

    public function show(string $id): Renderable
    {
        $preview = (isset($_GET['preview']) && Auth::getInstance()->isPriorityUser());

        if (! $article = Model\Article::findByIdAndOnlyActive($id, ! $preview)) {
            return new NotFoundResponse();
        }

        return new View('articles.show', [
            'title' => $article->title,
            'article' => $article->attributes(),
            'comments' => $article->getCommentsWithUserAsAttributes(! $preview),
            'fields' => $this->getFields(),
            'previous' => $article->getNextArticleId(),
            'next' => $article->getPreviousArticleId(),
            'preview' => $preview,
        ]);
    }

    public function edit(string $id): Renderable
    {
        if (! $article = Model\Article::findById($id)) {
            return Response::redirectBack();
        }

        $attributes = $article->attributes();

        return new View('articles.edit', [
            'title' => 'Редактировать статью',
            'article' => $attributes,
            'fields' => $this->getFields($attributes),
        ]);
    }

    public function update(string $id): Renderable
    {
        /** @var Model\Article $article */
        if (! $article = Model\Article::findById($id)) {
            return Response::redirectBack();
        }

        if (isset($_POST['_active'])) {
            return $this->activate($article);
        }

        if (! $this->checkForm($form = (new Form\EditArticle()))) {
            return (Response::redirectBack());
        }

        $article->update(
            htmlentities($_POST['title']),
            $_POST['abstract'],
            isset($_POST['p_teg']) ? (new Paragraph())->format($_POST['text']) : $_POST['text'],
        );

        if ($_FILES && $_FILES['img_article']['error'] !== UPLOAD_ERR_NO_FILE) {
            $image = new Model\Image($article);
            $image->save();

            if ($errors = $image->getErrors()) {
                $this->saveFieldsForFlashSession($form->getFields());

                foreach ($errors as $error) {
                    new FlashMessage('Ошибка!', $error, true);
                }

                return Response::redirectBack();
            }
        }

        new FlashMessage(' Успех!', 'Статья сохранена');
        return (Response::redirect(PATH_ADMIN_LIST . '/articles'));
    }

    public function destroy(string $id): Renderable
    {
        if (! $article = Model\Article::findById($id)) {
            return new NotFoundResponse();
        }

        $article->delete();

        new FlashMessage('', 'Статья id ' . $id . ' удалена');
        return Response::redirectBack();
    }

    private function activate(Model\Article $article): Renderable
    {
        $article->setActive($active = (new StringToBoolean())->format($_POST['_active']));

        if (isset($_POST['notify'])) {
            $sender = new Sender(Model\Subscriber::class, new NewArticleByPseudoEmail($article));
            $sender->sendAll();
        }

        new FlashMessage('', 'Статья id ' . $article->id . ($active ? ' опубликована' : ' скрыта')
            . (isset($_POST['notify']) ? ' с рассылкой сообщение по email' : ''));

        return Response::redirectBack();
    }
}