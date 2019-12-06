<?php


namespace App\Controller\Controller;


use App\Controller\Auth;
use App\Controller\Paginator;
use App\Controller\Form;
use App\View\View;
use App\Http\Response;
use App\Config;
use App\Model;
use App\Renderable;
use App\Router;

class BasicPage extends AbstractController
{
    // Pages

    /**
     * @param int $currentPage
     * additionalConfig:
     *      $status, $message: [email]
     * @return Renderable
     */
    public function getMainPage(int $currentPage = 1): Renderable
    {
        $articlesPerPage = Config::getInstance()->get('admin_settings.articles_per_page');

        $paginator = new Paginator($currentPage, Model\Article::countItems(), $articlesPerPage);
        $paginator->setPath(PATH_MAIN);

        if ($currentPage > ($lastPage = $paginator->getLastPage())) {
            return Response::notFound();
        }

        $articles = Model\Article::articlesWithoutText($articlesPerPage,($currentPage - 1) * $articlesPerPage);

        if (! $articles) {
            return Response::notFound();
        }

        $view = new View('main', [
            'title' => 'Главная',
            'articles' => Model\Article::getModelsAttributes($articles),
            'paginator' => $paginator,
            'userEmail' => Auth::getInstance()->get('user.email'),
            'fieldValue' => $this->getFieldValues(['email']),
            'sub' => Auth::getInstance()->get('sub'),
        ]);
        $view->addToConfig($this->getAdditionalConfig());

        return $view;
    }

    /**
     * @param string $id
     * @param bool $onlyActive
     * additionalConfig:
     *      $status, $message: [comment]
     * @return Renderable
     */
    public function getArticle(string $id, bool $onlyActive = true): Renderable
    {
        if (! $article = Model\Article::findByIdAndOnlyActive($id, $onlyActive)) {
            return Response::notFound();
        }

        $view = new View('article', [
            'title' => $article->title,
            'article' => $article->attributes(),
            'comments' => $article->getCommentsWithUserAsAttributes($onlyActive),
            'previous' => $article->getNextArticleId(),
            'next' => $article->getPreviousArticleId(),
            'admin_header' => Router::isActivePath(PATH_ADMIN_VIEW),
        ]);
        $view->addToConfig($this->getAdditionalConfig());

        return $view;
    }

    /**
     * @param string $id
     * @param bool $onlyActive
     * @return Renderable
     */
    public function getStaticPage(string $id, bool $onlyActive = true): Renderable
    {
        if (! $staticPage = Model\StaticPage::findByIdAndOnlyActive($id, $onlyActive)) {
            return Response::notFound();
        }

        return new View('static_page', [
            'title' => $staticPage->title,
            'staticPage' => $staticPage->attributes(),
            'admin_header' => Router::isActivePath(PATH_ADMIN_VIEW),
        ]);
    }

    // Actions

    public function addComment(): Renderable
    {
        if (! $this->checkForm(new Form\AddComment(), $this)) {
            return $this->getArticle($_POST['article_id']);
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

        $messageController = new Special\Message('Добавление комментария', $header, $message);
        $messageController->setReturnPath(PATH_ARTICLE . '/' . $_POST['article_id']);

        return $messageController->getMessagePage();
    }
}