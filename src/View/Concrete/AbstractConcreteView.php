<?php


namespace App\View\Concrete;


use App\Renderable;
use App\View\View;

abstract class AbstractConcreteView implements Renderable
{
    /*** @var View */
    private $view;

    public function render()
    {
        $this->view->render();
    }

    protected function setView(View $view): void
    {
        $this->view = $view;
    }

    public function addToConfig(array $additionalConfig): void
    {
        $this->view->addToConfig($additionalConfig);
    }
}