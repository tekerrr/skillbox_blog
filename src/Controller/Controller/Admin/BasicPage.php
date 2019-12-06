<?php


namespace App\Controller\Controller\Admin;


use App\Config;
use App\Controller\Paginator;
use App\Http\Response;
use App\Renderable;
use App\Model;
use App\View\View;

class BasicPage extends AbstractController
{
    // Pages

    public function getArticles(string $currentPage): Renderable
    {
        return $this->getListView('articles', $currentPage);
    }

    public function getComments(string $currentPage): Renderable
    {
        return $this->getListView('comments', $currentPage);
    }

    public function getStaticPages(string $currentPage): Renderable
    {
        return $this->getListView('static_pages', $currentPage);
    }

    public function getUsers(string $currentPage): Renderable
    {
        return $this->getListView('users', $currentPage);
    }

    public function getSubscribers(string $currentPage): Renderable
    {
        return $this->getListView('subscribers', $currentPage);
    }

    public function setItemsPerPage(): Renderable
    {
        $params = $_GET;
        unset($params['items']);
        $params['items'] = $_POST['submit_items_per_page'];

        return Response::redirect(urldecode(http_build_query($params)));
    }

    private function getListView(string $type, string $currentPage): Renderable
    {
        if (! $className = $this->getClassName($type)) {
            return Response::notFound();
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
        $paginator->setPath(PATH_ADMIN_LIST . '/' . $type);

        if ($currentPage > ($lastPage = $paginator->getLastPage())) {
            return Response::redirect(PATH_ADMIN_LIST . $type . '/' . $lastPage . '&items=' . $itemsPerPage);
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
}