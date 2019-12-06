<?php


namespace App\View\Concrete\Admin;

use App\View\Concrete\AbstractConcreteView;
use App\View\View;

/**
 * optional config:
 *      $errorAlerts
 *      $status, $message: title, abstract, text, image
 *
 * Class AddArticle
 * @package App\View\Concrete\Admin
 */
class AddArticle extends AbstractConcreteView
{
    public function __construct()
    {
        $this->setView(new View('admin.add.article', ['title' => 'Создать статью']));
    }
}