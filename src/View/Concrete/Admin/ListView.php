<?php


namespace App\View\Concrete\Admin;

use App\Config;
use App\Controller\Paginator;
use App\Exception\NotFoundException;
use App\Router;
use App\View\Concrete\AbstractConcreteView;
use App\View\View;
use App\Model;

/**
 * optional config:
 *
 * Class ListView
 * @package App\View\Concrete\Admin
 */
class ListView extends AbstractConcreteView
{
    /**
     * ListView constructor.
     * @param string $type
     * @param string $currentPage
     * @throws NotFoundException
     */
    public function __construct(string $type, string $currentPage)
    {
        switch ($type) {
            case 'articles':
                $className = Model\Article::class;
                $title = 'Статьи';
                break;
            case 'comments':
                $className = Model\Comment::class;
                $title = 'Комментарии';
                break;
            case 'static_pages':
                $className = Model\StaticPage::class;
                $title = 'Статичные страницы';
                break;
            case 'users':
                $className = Model\User::class;
                $title = 'Пользователи';
                break;
            case 'subscribers':
                $className = Model\Subscriber::class;
                $title = 'Подсписчики';
                break;
            default:
                throw new NotFoundException();
        }

        $itemsPerPage = $_GET['items'] ?? Config::getInstance()->get('admin_settings.items_per_page');
        if ($itemsPerPage == 'all') {
            $itemsPerPage = 1000;
        } elseif (((int) $itemsPerPage <= 0)) {
            $itemsPerPage = 20;
        }

        $paginator = new Paginator((int) $currentPage, call_user_func_array([$className, 'countItems'], [false]), (int) $itemsPerPage);
        $paginator->setPath(PATH_ADMIN_LIST . '/' . $type);

        if ($currentPage > ($lastPage = $paginator->getLastPage())) {
            Router::redirectTo(PATH_ADMIN_LIST . $type . '/' . $lastPage . '&items=' . $itemsPerPage);
        }

        $items = call_user_func_array(
            [$className, 'findAllWithLimits'],
            [$itemsPerPage, ($currentPage - 1) * $itemsPerPage, ['order' => 'id DESC']]
        );
        $items = Model\AbstractModel::getModelsAttributes($items);

        $this->setView(new View('admin.list.' . $type, [
            'title' => $title,
            'items' => $items,
            'itemType' => mb_substr($type, 0, -1),
            'paginator' => $paginator,
            'paginatorItemsPerPage' => $itemsPerPage,
        ]));
    }
}