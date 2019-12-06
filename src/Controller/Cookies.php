<?php


namespace App\Controller;


use App\Config;

class Cookies
{
    public static function get(string $key): ?string
    {
        return $_COOKIE[$key] ?? null;
    }

    public static function set(string $key, string $value, int $lifetime = 0): void
    {
        setcookie(
            $key,
            $value,
            time() + ($lifetime ?: Config::getInstance()->get('session.cookie_lifetime')),
            '/'
        );
    }

    public static function clean(array $keys): void
    {
        foreach ($keys as $key) {
            self::delete($key);

            if (isset($_COOKIE[$key])) {
                unset($_COOKIE[$key]);
            }
        }
    }

    private static function delete(string $name): void
    {
        setcookie($name, '', time() - 3600 * 24 * 30, '/');
    }
}