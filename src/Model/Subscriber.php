<?php


namespace App\Model;


use App\View\Email;

class Subscriber extends AbstractModel
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

    public static function notifyAll(Article $article): void
    {
        if ($subscribers = self::all(['conditions' => ['active' => true]])) {
            /** @var self $subscriber */
            foreach ($subscribers as $subscriber) {
                $subscriber->notify($article);
            }
        }
    }

    private static function generateHash(): string
    {
        return rtrim(base64_encode(md5(microtime())), "=");
    }

    private function notify(Article $article): void
    {
        $sub = $this->attributes();
        $article = $article->attributes();

        $email = new Email('new_article', [
            'sub' => $sub,
            'article' => $article,
        ]);

        file_put_contents(APP_DIR . '/logs/email.txt', $email->render(), FILE_APPEND);
    }
}