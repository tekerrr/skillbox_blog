<?php


namespace App\View;


use App\Renderable;

class View implements Renderable
{
    private $path;
    private $config;

    public function __construct(string $path, array $config = [])
    {
        $this->path = $path;
        $this->config = $config;
    }

    /**
     * @throws \Exception
     */
    public function render()
    {
        if (file_exists($page = VIEW_DIR . $this->formatPath($this->path))) {
            extract($this->config);
            include $page;
        } else {
            throw new \Exception('Не сущетсует страница по указанному пути : ' . $this->path);
        }
    }

    private function formatPath(string $path): string
    {
        return str_replace('.','/', $path) . '.php';
    }
}