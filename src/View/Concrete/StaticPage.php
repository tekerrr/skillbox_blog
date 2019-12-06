<?php


namespace App\View\Concrete;

use App\Exception\NotFoundException;
use App\Router;
use App\View\View;

/**
 * optional config:
 *
 * Class SignUp
 * @package App\View\Concrete
 */
class StaticPage extends AbstractConcreteView
{
    /**
     * StaticPage constructor.
     * @param string $id
     * @param bool $onlyActive
     * @throws NotFoundException
     */
    public function __construct(string $id, bool $onlyActive = true)
    {
        if (! $staticPage = \App\Model\StaticPage::findByIdAndOnlyActive($id, $onlyActive)) {
            throw new NotFoundException();
        }

        $this->setView(new View('static_page', [
            'title' => $staticPage->title,
            'staticPage' => $staticPage->attributes(),
            'admin_header' => Router::isActivePath(PATH_ADMIN_VIEW),
        ]));
    }
}