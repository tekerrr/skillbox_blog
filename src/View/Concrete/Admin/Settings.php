<?php


namespace App\View\Concrete\Admin;


use App\Config;
use App\View\Concrete\AbstractConcreteView;
use App\View\View;

/**
 * optional config:
 *      $status, $message: articles_per_page
 *
 * Class Settings
 * @package App\View\Concrete\Admin
 */
class Settings extends AbstractConcreteView
{
    public function __construct()
    {
        $this->setView(new View('admin.settings', [
            'title' => 'Настройки',
            'settings' => Config::getInstance()->get('admin_settings'),
        ]));
    }
}