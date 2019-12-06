<?php


namespace App;


use App\Formatter\Path;

class Router
{
    private static $currentPath = '';
    private $defaultRedirectPath = PATH_DEFAULT;
    private $routes = [];

    public static function getCurrentPath(): string
    {
        return self::$currentPath;
    }

    public static function isActivePath(string $path): string
    {
        return preg_match(Route::getMatchExpression($path), self::getCurrentPath()) ? 'active' : '';
    }

    public function setRest(Rest $rest)
    {
        foreach ($rest->getRoutes() as $route) {
            $this->routes[] = new Route($route['method'], $route['path'], $route['controllerMethod']);
            if (isset($route['groups'])) {
                $this->setAccessForLastRoute($route['groups'], $route['redirectPath']);
            }
        }
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

    public function put($path, $callback): self
    {
        $this->routes[] = new Route('put', $path, $callback);
        return $this;
    }

    public function delete($path, $callback): self
    {
        $this->routes[] = new Route('delete', $path, $callback);
        return $this;
    }

    /**
     * @return mixed
     * @throws \Exception
     */
    public function dispatch()
    {
        $method = $this->getRequestType();
        $keys = $this->getKeysFromRequest($method);

        foreach ($keys as $uri) {
            if ($route = $this->findCurrentRoute($method, $uri = (new Path())->format($uri))) {
                self::$currentPath = $uri;
                return $route->run($uri);
            }
        }

        return new Http\NotFoundResponse();
    }

    public function setDefaultRedirectPath(string $defaultRedirectPath): void
    {
        $this->defaultRedirectPath = $defaultRedirectPath;
    }

    public function setAccessForLastRoute(array $groups, string $redirectPath = ''): void
    {
        if ($route = $this->getLastRoute()) {
            $route->setAccess($groups, $redirectPath ?: $this->defaultRedirectPath);
        }
    }

    /**
     * @return string post|get|''
     */
    private function getRequestType(): string
    {
        $method = 'get';

        if($_SERVER['REQUEST_METHOD'] == 'POST') {
            if(isset($_POST['_method']) && ($_POST['_method'] == 'PUT' || $_POST['_method'] == 'DELETE')) {
                $method = strtolower($_POST['_method']);
            } else {
                $method = 'post';
            }
        }

        return $method;
    }

    /**
     * @param string $method post|get
     * @return array
     */
    private function getKeysFromRequest(string $method): array
    {
        if ($method == 'get') {
            return [$_GET['path'] ?? ''];
        } else {
            return array_keys($_POST);
        }

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