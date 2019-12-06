<?php


namespace App;


use App\Formatter\Path;

class Rest
{
    private $name;
    private $controllerName;

    const INDEX = 'index';
    const CREATE = 'create';
    const STORE = 'store';
    const SHOW = 'show';
    const EDIT = 'edit';
    const UPDATE = 'update';
    const DESTROY = 'destroy';

    private $routes = [
        self::INDEX     => true,
        self::CREATE    => true,
        self::STORE     => true,
        self::SHOW      => true,
        self::EDIT      => true,
        self::UPDATE    => true,
        self::DESTROY   => true,
    ];

    private $routesAccess = [
        self::INDEX     => [],
        self::CREATE    => [],
        self::STORE     => [],
        self::SHOW      => [],
        self::EDIT      => [],
        self::UPDATE    => [],
        self::DESTROY   => [],
    ];

    public function __construct(string $name, string $controllerName)
    {
        $this->name = $name;
        $this->controllerName = $controllerName;
    }

    public function only(array $routeNames): void
    {
        foreach ($this->routes as &$status) {
            $status = false;
        }

        $this->setRouteStatuses($routeNames, true);
    }

    public function except(array $routeNames): void
    {
        $this->setRouteStatuses($routeNames, false);
    }

    public function setAccessForRoute(string $routeName, array $groups, string $redirectPath = ''): void
    {
        $this->routesAccess[$routeName] = [
            'groups' => $groups,
            'redirectPath' => $redirectPath,
        ];
    }

    public function setAccessForRoutes(array $accesses): void
    {
        foreach ($accesses as $access) {
            $this->setAccessForRoute(...$access);
        }
    }

    public function setSameAccessFroRoutes(array $routeNames, array $groups, string $redirectPath = ''): void
    {
        foreach ($routeNames as $routeName) {
            $this->setAccessForRoute($routeName, $groups, $redirectPath);
        }
    }

    public function getRoutes(): array
    {
        $routes = [];

        foreach ($this->getActiveRouteNames() as $routeName) {
            $route = [
                'method'    => $this->getRouteMethod($routeName),
                'path'      => $this->getRoutePath($routeName),
                'controllerMethod' => $this->getControllerMethod($routeName),
            ];

            if ($access = $this->getRouteAccess($routeName)) {
                $route['groups'] = $access['groups'];
                $route['redirectPath'] = $access['redirectPath'];
            }

            $routes[] = $route;
        }

        return $routes;
    }

    private function setRouteStatuses(array $routeNames, bool $status): void
    {
        foreach ($routeNames as $routeName) {
            if (array_key_exists($routeName, $this->routes)) {
                $this->routes[$routeName] = $status;
            }
        }
    }

    private function getActiveRouteNames(): array
    {
        return array_keys($this->routes, true);
    }

    private function getRouteMethod(string $routeName): string
    {
        return $this->getMethods()[$routeName];
    }

    private function getRoutePath(string $routeName): string
    {
        return $this->name . $this->getPathSuffixes()[$routeName];
    }

    private function getControllerMethod(string $routeName): string
    {
        return $this->controllerName . '@' . $routeName;
    }

    private function getRouteAccess(string $routeName): array
    {
        return $this->routesAccess[$routeName];
    }

    private function getMethods(): array
    {
        return [
            self::INDEX     => 'get',
            self::CREATE    => 'get',
            self::STORE     => 'post',
            self::SHOW      => 'get',
            self::EDIT      => 'get',
            self::UPDATE    => 'put',
            self::DESTROY   => 'delete',
        ];
    }

    private function getPathSuffixes(): array
    {
        return [
            self::INDEX     => '',
            self::CREATE    => '/create',
            self::STORE     => '',
            self::SHOW      => '/*',
            self::EDIT      => '/*/edit',
            self::UPDATE    => '/*',
            self::DESTROY   => '/*',
        ];
    }

}