<?php


namespace App;


use App\Controller\Auth;
use App\Http\Response;

class Access
{
    private $groups;
    private $redirectPath;

    public function __construct(array $groups, string $redirectPath)
    {
        $this->groups = $groups;
        $this->redirectPath = $redirectPath;
    }

    public function check(): bool
    {
       $userGroups = Auth::getInstance()->get('user.groups');

        if (in_array('all', $this->groups)) {
            return ! empty($userGroups);
        }

        if (in_array('none', $this->groups)) {
            return empty($userGroups);
        }

        return Auth::getInstance()->checkGroups($this->groups);
    }

    public function getResponse(): Renderable
    {
        switch ($this->redirectPath) {
            case '403':
                return Response::forbidden();
            case '404':
                return Response::notFound();
            default:
                return Response::redirect($this->redirectPath);
        }
    }
}