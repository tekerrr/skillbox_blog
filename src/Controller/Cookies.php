<?php


namespace App\Controller;


use App\Config;

class Cookies
{
    public function get(string $key): ?string
    {
        return $_COOKIE[$key] ?? null;
    }

    public function set(string $key, string $value, int $lifetime = 0): void
    {
        setcookie(
            $key,
            $value,
            time() + ($lifetime ?: Config::getInstance()->get('session.cookie_lifetime')),
            '/'
        );
    }

    public function clean(array $keys): void
    {
        foreach ($keys as $key) {
            $this->delete($key);

            if (isset($_COOKIE[$key])) {
                unset($_COOKIE[$key]);
            }
        }
    }

    private function delete(string $name): void
    {
        setcookie($name, '', time() - 3600 * 24 * 30, '/');
    }
}