<?php


namespace App\View;


use App\Controller\Session;

class FlashMessage
{
    private $title;
    private $text;
    private $error;

    public static function push(string $title, string $text, bool $error = false): self
    {
        $message = new self($title, $text, $error);
        $message->save();

        return $message;
    }

    public static function getAll(): array
    {
        $messages = [];

        foreach ((new Session())->get('messages', []) as $message) {
            $messages[] = new self($message['title'], $message['text'], $message['error']);
        }

        return $messages;
    }

    public static function showAll()
    {
        if ($messages = self::getAll()) {
            includeView('template.flash_messages', ['messages' => $messages]);
        }
    }

    public function __construct(string $title, string $text, bool $error = false)
    {
        $this->title = $title;
        $this->text = $text;
        $this->error = $error;
    }

    public function getTitle(): string
    {
        return $this->title;
    }

    public function getText(): string
    {
        return $this->text;
    }

    public function isError(): bool
    {
        return $this->error;
    }

    public function save(): void
    {
        (new Session())->pushFlash('messages', [
            'title' => $this->title,
            'text' => $this->text,
            'error' => $this->error
        ]);
    }
}