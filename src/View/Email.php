<?php


namespace App\View;


class Email extends View
{
    public function render()
    {
        if (file_exists($page = VIEW_EMAILS . $this->formatLocation($this->location))) {
            extract($this->config);
            return include $page;
        }
    }

}