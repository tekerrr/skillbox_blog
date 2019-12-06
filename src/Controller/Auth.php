<?php


namespace App\Controller;


use App\Model\User;

class Auth // Singleton
{
    /*** @var Auth */
    private static $instance;

    private function __construct() {}
    private function __clone() {}
    private function __wakeup() {}

    public static function getInstance(): Auth
    {
        if (null === static::$instance) {
            static::$instance = new static();
        }

        return static::$instance;
    }

    public function run(): void
    {
        ($session = new Session())->start();
        if ($this->isAuthorized()) {
            $this->setCookies();
        } else {
            $this->cleanCookies();
        }
    }

    public function update(): void
    {
        if ($user = $this->getUser()) {
            $this->signIn($user);
        }
    }

    public function get(string $request)
    {
        return (new Session())->get($request);
    }

    public function getUser(): ?User
    {
        if ($id = $this->get('user.id')) {
            return User::findByIdAndOnlyActive($id);
        }

        return null;
    }

    public function isPriorityUser(): bool
    {
        return $this->checkGroups([ADMINS, AUTHORS]);
    }

    public function checkGroups(array $groups): bool
    {
        if (is_array($usersGroups = (new Session())->get('user.groups'))) {
            foreach ($usersGroups as $userGroup) {
                if (in_array($userGroup, $groups)) {
                    return true;
                }
            }
        }

        return false;
    }

    public function signIn(User $user): void
    {
        (new Session())->updateUser($user);
        $this->setCookies();
    }

    public function signOut(): void
    {
        (new Session())->destroy();
        $this->cleanCookies();
    }

    private function isAuthorized(): bool
    {
        return (($email = (new Session())->get('user.email')) && ($email2 = (new Cookies())->get('email')) && $email === $email2);
    }

    private function setCookies(): void
    {
        (new Cookies())->set('email', $this->get('user.email'));
    }

    private function cleanCookies(): void
    {
        (new Cookies())->clean(['email']);
    }
}