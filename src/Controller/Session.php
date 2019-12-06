<?php


namespace App\Controller;


use App\Config;
use App\Model\Subscriber;
use App\Model\User;

class Session
{
    public function start(): void
    {
        $config = Config::getInstance()->get('session');

        session_name($config['name']);
        ini_set('session.gc_maxlifetime', $config['session_lifetime']);
        session_start();

        (new Cookies())->set(session_name(), session_id(), $config['session_lifetime']);
    }

    public function updateUser(User $user = null): void
    {
        $this->clean();

        if ($user) {
            $this->put('user', $user->attributes());
            if ($subscriber = Subscriber::find_by_email_and_active($user->email, true)) {
                $this->put('sub', $subscriber->attributes());
            }
        }
    }

    public function destroy(): void
    {
        (new Cookies())->clean([session_name()]);
        session_destroy();
        unset($_SESSION);
    }

    public function clean(): void
    {
        $_SESSION = [];
    }

    public function get(string $key, $default = null)
    {
        $result = array_get($_SESSION, $key, $default);

        if ($this->checkFlash($key)) {
            $this->deleteFlash($key);
        }

        return $result;
    }

    public function put(string $key, $value): void
    {
        $_SESSION[$key] = $value;
    }

    public function push(string $key, $value): void
    {
        $_SESSION[$key][] = $value;
    }

    public function flash(string $key, $value): void
    {
        $this->put($key, $value);

        if (! $this->checkFlash($key)) {
            $this->push('flash' , $key);
        }
    }

    public function pushFlash(string $key, $value): void
    {
        $this->push($key, $value);

        if (! $this->checkFlash($key)) {
            $this->push('flash' , $key);
        }
    }

    private function checkFlash(string $key): bool
    {
        return isset($_SESSION['flash']) && in_array($key, $_SESSION['flash']);
    }

    private function deleteFlash(string $key): void
    {
        unset($_SESSION[$key]);
        unset($_SESSION['flash'][array_search($key, $_SESSION['flash'])]);
    }
}