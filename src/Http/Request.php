<?php


namespace App\Http;


use App\Formatter\Path;

class Request
{
    private $path = '';
    private $get = [];

    public function __construct()
    {
        $this->path = (new Path())->format(($_GET['path'] ?? ''));
        $this->get = $_GET;
        unset($this->get['path']);
    }

    public static function getRequestUri(): string
    {
        return $_SERVER['REQUEST_URI'] ?? '';
    }

    public function setGet(string $key, string $value): self
    {
        $this->get[$key] = $value;
        return $this;
    }

    public function unsetGet(string $key): self
    {
        unset($this->get[$key]);
        return $this;
    }

    public function getPath(): string
    {
        $path = $this->path;
        $path .= $this->get ? '?' . http_build_query($this->get) : '';
        return $path;
    }


}