<?php


namespace App\Model;


class User extends AbstractModel implements HasImage
{
    use HasImageTrait, CanBeListed;

    // ActiveRecord Association
    static $has_many = [
        ['memberships'],
        ['groups', 'through' => 'memberships'],
    ];

    // ActiveRecord Validation
    static $validates_uniqueness_of = [
        ['email'],
    ];

    public static function createUser(string $email, string $password, string $name): User
    {
        $user = self::create([
            'email' => $email,
            'password_hash' => self::getPasswordHash($password),
            'name' => $name,
            'active' => true,
        ]);

        $user->setDefaultGroup();

        return $user;
    }

    public static function signIn(string $email, string $password): ?User
    {
        if (($user = self::find_by_email_and_active($email, true)) && $user->passwordVerify($password)) {
            return $user;
        }

        return null;
    }

    public function attributes(): array
    {
        return array_merge(parent::attributes(), ['groups' => $this->getGroups()]);
    }

    /**
     * @return bool|void
     * @throws \ActiveRecord\ActiveRecordException
     */
    public function delete()
    {
        (new Image($this))->delete();
        /** @var Subscriber $subscriber */
        if ($subscriber = Subscriber::find_by_email($this->email)) {
            $subscriber->delete();
        }
        parent::delete();
    }

    public function updateAccount(string $email, string $name, string $about): void
    {
        $this->email = $email;
        $this->name = $name;
        $this->about = $about;
        $this->save();
    }

    public function changePassword(string $oldPassword, string $newPassword): bool
    {
        if (! $this->passwordVerify($oldPassword)) {
            return false;
        }

        $this->setPassword($newPassword);
        return true;
    }

    public function getGroups(): array
    {
        $groups = [];

        foreach ($this->groups as $group) {
            $groups[] = $group->name;
        }

        return $groups;
    }

    public function joinGroup(string $groupName): void
    {
        if (! $this->checkGroup($groupName)) {
            $this->create_membership(['group_id' => Group::find_by_name($groupName)->id]);
        }
    }

    public function leaveGroup(string $groupName): void
    {
        if ($this->checkGroup($groupName)) {
            $membership = Membership::find_by_user_id_and_group_id($this->getId(), Group::find_by_name($groupName)->id);
            if ($membership) {
                $membership->delete();
            }
        }
    }

    private static function getPasswordHash(string $password): string
    {
        return password_hash($password, PASSWORD_DEFAULT);
    }

    private function passwordVerify(string $password): bool
    {
        return password_verify($password, $this->password_hash);
    }

    private function setPassword(string $password): void
    {
        $this->password_hash = self::getPasswordHash($password);
        $this->save();
    }

    private function setDefaultGroup(): void
    {
        $this->joinGroup(USERS);
    }

    private function checkGroup(string $groupName): bool
    {
        return null !== Membership::find_by_user_id_and_group_id($this->getId(), Group::find_by_name($groupName)->id);
    }
}