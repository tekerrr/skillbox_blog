<?php


namespace App\Sender\Message;


use App\Model\Article;
use App\Model\Recipient;
use App\Model\Subscriber;
use App\Sender\Sendable;
use App\View\Email;

class NewArticleByPseudoEmail implements Sendable
{
    /** @var Article */
    private $article;

    public function __construct(Article $article)
    {
        $this->article = $article;
    }

    public function sendTo(Recipient $recipient)
    {
        /** @var Subscriber $recipient */
        $subscriber = $recipient->attributes();
        $article = $this->article->attributes();

        $email = new Email('new_article', [
            'sub' => $subscriber,
            'article' => $article,
        ]);

        $text = 'mailto: ' . $recipient->getAddress() . PHP_EOL . $email->render();

        file_put_contents(APP_DIR . '/logs/email.txt', $text, FILE_APPEND);
    }

}