<?php


namespace App;


use App\Exception\NotFoundException;

class Router
{
    private $routes = [];

    public function get($path, $callback)
    {
        $this->routes[] = new Route('get', $path, $callback);
    }

    public function post($path, $callback)
    {
        $this->routes[] = new Route('post', $path, $callback);
    }

    /**
     * @return mixed
     * @throws NotFoundException
     * @throws \Exception
     */
    public function dispatch()
    {
        $method = $this->getRequestType();
        $keys = $this->getKeysFromRequest($method);

        foreach ($keys as $uri) {
            if ($route = $this->findCurrentRoute($method, $uri)) {
                return $route->run($uri);
            }
        }

        throw new NotFoundException();
    }

    /**
     * @return string post|get|''
     */
    private function getRequestType(): string
    {
        return empty($_POST) ? (empty($_GET) ? '' : 'get') : 'post';
    }

    /**
     * @param string $method post|get|''
     * @return array
     */
    private function getKeysFromRequest(string $method): array
    {
        return $method ? array_keys($method == 'post' ? $_POST : $_GET) : [];
    }

    private function findCurrentRoute($method, $path): ?Route
    {
        foreach ($this->getRoutes() as $route) {
            if ($route->match($method, $path)) {
                return $route;
            }
        }
        return null;
    }

    private function getRoutes(): array
    {
        return $this->routes;
    }
}