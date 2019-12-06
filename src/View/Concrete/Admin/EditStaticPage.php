<?php


namespace App\View\Concrete\Admin;

use App\Exception\NotFoundException;
use App\View\Concrete\AbstractConcreteView;
use App\View\View;

/**
 * optional config:
 *      $status, $message: title, text
 *
 * Class EditStaticPage
 * @package App\View\Concrete\Admin
 */
class EditStaticPage extends AbstractConcreteView
{
    /**
     * EditStaticPage constructor.
     * @param string $id
     * @throws NotFoundException
     */
    public function __construct(string $id)
    {
        if (! $staticPage = \App\Model\StaticPage::findById($id)) {
            throw new NotFoundException();
        }

        $this->setView(new View('admin.edit.static_page', [
            'title' => 'Редактировать статичную страницу',
            'staticPage' => $staticPage->attributes(),
        ]));
    }
}