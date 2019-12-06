<?php


namespace App\Controller;


use App\Config;
use App\Model\Subscriber;
use App\Model\User;

class Session
{
    public static function start(): void
    {
        $config = Config::getInstance()->get('session');

        session_name($config['name']);
        ini_set('session.gc_maxlifetime', $config['session_lifetime']);
        session_start();

        Cookies::set(session_name(),session_id(),$config['session_lifetime']);
    }

    public static function update(User $user = null): void
    {
        self::clean();

        if ($user) {
            $_SESSION['user'] = $user->attributes();
            if ($subscriber = Subscriber::find_by_email_and_active($user->email, true)) {
                $_SESSION['sub'] = $subscriber->attributes();
            }
        }
    }

    public static function destroy(): void
    {
        Cookies::clean([session_name()]);
        session_destroy();
        unset($_SESSION);
    }

    public static function clean(): void
    {
        $_SESSION = [];
    }

    public static function get(string $request)
    {
        return array_get($_SESSION, $request, null);
    }
}