<?php


namespace App\Controller\Controller;


use App\Config;
use App\Controller\Form;
use App\Controller\Paginator;
use App\Http\NotFoundResponse;
use App\Http\Request;
use App\Http\Response;
use App\Renderable;
use App\View\FlashMessage;
use App\View\View;
use App\Model;

class Admin extends AbstractController
{
    public function editSettings(): Renderable
    {
        return new View('admin.edit_settings', [
            'title' => 'Настройки',
            'fields' => $this->getFields(Config::getInstance()->get('admin_settings')),
        ]);
    }

    public function updateSettings(): Renderable
    {
        if (! $this->checkForm(new Form\EditAdminSettings())) {
            return Response::redirectBack();
        }

        Config::getInstance()->set('admin_settings', [
            'articles_per_page' => $_POST['articles_per_page'],
            'articles_per_header' => $_POST['articles_per_header'],
            'items_per_page' => $_POST['items_per_page_value'],
        ]);

        new FlashMessage('', 'Настройки обновлены');
        return Response::redirectBack();
    }

    public function articles(): Renderable
    {
        return $this->getListView('articles');
    }

    public function comments(): Renderable
    {
        return $this->getListView('comments');
    }

    public function staticPAges(): Renderable
    {
        return $this->getListView('static_pages');
    }

    public function users(): Renderable
    {
        return $this->getListView('users');
    }

    public function subscribers(): Renderable
    {
        return $this->getListView('subscribers');
    }

    public function updateItemsPerPage(): Renderable
    {
        return Response::redirect((new Request())->setGet('items', $_POST['items_per_page'])->getPath());
    }

    private function getListView(string $type): Renderable
    {
        $currentPage = (int) ($_GET['page'] ?? 1);

        if ($currentPage <= 0 || ! $className = $this->getClassName($type)) {
            return new NotFoundResponse();
        }

        $itemsPerPage = $_GET['items'] ?? Config::getInstance()->get('admin_settings.items_per_page');

        if ($itemsPerPage == 'all') {
            $itemsPerPage = Config::getInstance()->get('admin_settings.items_per_page_max');
        } elseif ((int) $itemsPerPage <= 0) {
            $itemsPerPage = Config::getInstance()->get('admin_settings.items_per_page');
        }

        $paginator = new Paginator(
            (int) $currentPage,
            call_user_func_array([$className, 'countItems'], [false]),
            (int) $itemsPerPage,
        );

        if ($currentPage > ($lastPage = $paginator->getLastPage())) {
            return Response::redirect((new Request())->setGet('page', $lastPage)->getPath());
        }

        $items = call_user_func_array(
            [$className, 'findAllWithLimits'],
            [$itemsPerPage, ($currentPage - 1) * $itemsPerPage, ['order' => 'id DESC']]
        );
        $items = Model\AbstractModel::getModelsAttributes($items);

        return new View('admin.list.' . $type, [
            'title' => $this->getTitle($className),
            'items' => $items,
            'itemType' => mb_substr($type, 0, -1),
            'paginator' => $paginator,
            'paginatorItemsPerPage' => $itemsPerPage,
        ]);
    }

    private function getClassName(string $type, bool $singular = false): string
    {
        $classes = [
            'articles'      => Model\Article::class,
            'comments'      => Model\Comment::class,
            'static_pages'  => Model\StaticPage::class,
            'users'         => Model\User::class,
            'subscribers'   => Model\Subscriber::class,
        ];

        if ($singular) {
            $type .= 's';
        }

        return $classes[$type] ?? '';
    }

    private function getTitle(string $className): string
    {
        $titles = [
            Model\Article::class    => 'Статьи',
            Model\Comment::class    => 'Комментарии',
            Model\StaticPage::class => 'Статичные страницы',
            Model\User::class       => 'Пользователи',
            Model\Subscriber::class => 'Подсписчики',
        ];

        return $title[$className] ?? '';
    }
}