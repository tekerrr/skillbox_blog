<?php


namespace App\Model;


use App\View\Email;

class Subscriber extends AbstractModel implements Recipient
{
    use CanBeListed;

    // ActiveRecord Validation
    static $validates_uniqueness_of = [
        ['email'],
    ];

    public static function subscribe(string $email): void
    {
        self::create([
            'email' => $email,
            'hash' => self::generateHash(),
            'active' => true,
        ]);
    }

    public static function unsubscribe($id, string $hash): bool
    {
        if ($subscriber = self::find_by_id_and_hash($id, $hash)) {
            $subscriber->delete();
            return true;
        }

        return false;
    }

    public function getAddress(): string
    {
        return $this->email;
    }

    private static function generateHash(): string
    {
        return rtrim(base64_encode(md5(microtime())), "=");
    }
}