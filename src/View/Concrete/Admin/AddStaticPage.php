<?php


namespace App\View\Concrete\Admin;

use App\View\Concrete\AbstractConcreteView;
use App\View\View;

/**
 * optional config:
 *      $status, $message: title, text
 *
 * Class AddStaticPage
 * @package App\View\Concrete\Admin
 */
class AddStaticPage extends AbstractConcreteView
{
    public function __construct()
    {
        $this->setView(new View('admin.add.static_page', ['title' => 'Создать статичную страницу']));
    }
}