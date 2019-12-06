<?php


namespace App\View;


use App\Renderable;

class View implements Renderable
{
    private $location;
    private $config;

    public function __construct(string $location, array $config = [])
    {
        $this->location = $location;
        $this->setConfig($config);
    }

    public function render()
    {
        if (file_exists($page = VIEW_DIR . $this->formatLocation($this->location))) {
            extract($this->config);
            include $page;
        }
    }

    public function setConfig(array $config): void
    {
        $this->config = $config;
    }

    public function addToConfig(array $additionalConfig): void
    {
        $this->config = array_merge($this->config, $additionalConfig);
    }

    private function formatLocation(string $path): string
    {
        return str_replace('.','/', trim($path)) . '.php';
    }
}