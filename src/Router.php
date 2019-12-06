<?php


namespace App;


use App\Exception\NotFoundException;

class Router
{
    private static $currentPath = '';
    private $defaultPath = '';
    private $routes = [];

    public static function getCurrentPath(): string
    {
        return self::$currentPath;
    }

    public static function getFullGetRequest(): string
    {
        return $_SERVER['QUERY_STRING'] ?? '';
    }

    public static function isActivePath(string $path): string
    {
        return stristr(self::getCurrentPath(), $path) ? 'active' : '';
    }

    public static function redirectTo(string $path)
    {
        header('Location: /?' . $path);
        die();
    }

    public function get($path, $callback): self
    {
        $this->routes[] = new Route('get', $path, $callback);
        return $this;
    }

    public function post($path, $callback): self
    {
        $this->routes[] = new Route('post', $path, $callback);
        return $this;
    }

    /**
     * @return mixed
     * @throws NotFoundException
     * @throws \Exception
     */
    public function dispatch()
    {
        if (! $method = $this->getRequestType()) {
            self::redirectTo($this->defaultPath);
        }
        $keys = $this->getKeysFromRequest($method);

        foreach ($keys as $uri) {
            if ($route = $this->findCurrentRoute($method, $uri)) {
                self::$currentPath = $uri;
                return $route->run($uri);
            }
        }

        throw new NotFoundException();
    }

    public function setDefaultPath(string $defaultPath): void
    {
        $this->defaultPath = $defaultPath;
    }

    public function setGroupsForLastRoute(array $groups, string $redirectPath = ''): void
    {
        if ($route = $this->getLastRoute()) {
            $route->setGroups($groups);
            $this->setRedirectPathForLastRoute($redirectPath);
        }
    }

    private function setRedirectPathForLastRoute(string $path): void
    {
        if ($route = $this->getLastRoute()) {
            $route->setRedirectPath($path);
        }
    }

    /**
     * @return string post|get|''
     */
    private function getRequestType(): string
    {
        return empty($_POST) ? (empty($_GET) ? '' : 'get') : 'post';
    }

    /**
     * @param string $method post|get
     * @return array
     */
    private function getKeysFromRequest(string $method): array
    {
        return array_keys($method == 'post' ? $_POST : $_GET);
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

    private function getLastRoute(): ?Route
    {
        $routes = $this->getRoutes();
        return end($routes) ?: null;
    }


}