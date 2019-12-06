<?php


namespace App;


use App\Controller\Auth;
use App\Controller\Controller;
use App\Exception\ForbiddenException;

class Route
{
    private $method;
    private $path;
    private $callback;
    private $groups = ['everybody'];
    private $redirectPath;

    /**
     * Route constructor.
     * @param string $method get|post
     * @param string $path uri
     * @param $callback
     */
    public function __construct(string $method, string $path, $callback)
    {
        $this->method = $method;
        $this->path = $this->preparePath($path);
        $this->callback = $callback;
        $this->redirectPath = PATH_DEFAULT;
    }

    /**
     * @param array $groups
     */
    public function setGroups(array $groups): void
    {
        $this->groups = $groups;
    }

    /**
     * @param string $path
     */
    public function setRedirectPath(string $path): void
    {
        $this->redirectPath = $path;
    }

    /**
     * @return string
     */
    public function getPath(): string
    {
        return $this->path;
    }

    /**
     * @param string $method get|post
     * @param string $uri
     * @return bool
     */
    public function match(string $method, string $uri): bool
    {
        return ($method == $this->method) && preg_match($this->getMatchExpression(), $this->preparePath($uri));
    }

    /**
     * @param $uri
     * @return mixed
     * @throws \Exception
     */
    public function run($uri)
    {
        if ($this->checkGroups()) {
            return call_user_func_array(
                $this->prepareCallback($this->callback),
                $this->getParams($this->preparePath($uri))
            );
        }

        $this->redirect();
    }

    /**
     * @throws ForbiddenException
     */
    private function redirect(): void
    {
        if (($redirectPath = $this->redirectPath) == '403') {
            throw new ForbiddenException();
        }
        Router::redirectTo($this->redirectPath);
    }

    /**
     * @return bool
     */
    private function checkGroups(): bool
    {
        if (in_array('everybody', $this->groups)) {
            return true;
        }

        $userGroups = Auth::getInstance()->get('user.groups');
        if (in_array('all', $this->groups)) {
            return ! empty($userGroups);
        }

        if (in_array('none', $this->groups)) {
            return empty($userGroups);
        }

        return Auth::getInstance()->checkGroups($this->groups);
    }

    /**
     * Format '/about/', '/about', 'about/', 'about' to '/about'
     * @param string $path
     * @return string
     */
    private function preparePath(string $path): string
    {
        return '/' . trim($path, ' /');
    }

    /**
     * @param $callback
     * @return callable
     * @throws \Exception
     */
    private function prepareCallback($callback)
    {
        if (is_string($callback)) {
            $callback = $this->getCallbackFromString($callback);
        }

        if (is_callable($callback)) {
            return $callback;
        }

        throw new \Exception('Callback ' . (string)$callback . ' не может быть вызван');
    }

    /**
     * @param $string
     * @return array
     * @throws \Exception
     */
    private function getCallbackFromString($string): array
    {
        $array = explode('@', $string);
        if (Controller::class === $array[0] && method_exists($controller = new $array[0], $array[1])) {
            return [$controller, $array[1]];
        }

        throw new \Exception('Не сущестсует метод "' . $array[1] . '" класса "' . $array[0] . '"');
    }

    private function getParams(string $uri): array
    {
        $paths = explode('/', $this->getPath());
        $uris = explode('/', $uri);
        $params = [];

        for ($i = 0; $i < count($paths); $i++) {
            if ($paths[$i] == '*') {
                $params[] = $uris[$i];
            }
        }

        return $params;
    }

    private function getMatchExpression(): string
    {
        return '/^' . str_replace(['*', '/'], ['\w+', '\/'], $this->getPath()) . '$/';
    }

}