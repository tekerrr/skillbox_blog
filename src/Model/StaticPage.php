<?php


namespace App\Model;


class StaticPage extends AbstractModel
{
    use CanBeListed;

    public static function activePagesWithIdAndTitle(): array
    {
        return self::all([
            'select'        => 'id, title',
            'conditions'    => ['active' => true],
            'order'         => 'id asc',
        ]) ?? [];
    }

    public static function add(string $title, string $text): self
    {
        return self::create([
            'title'         => $title,
            'text'          => (new Formatter\Paragraph())->format($text),
            'active'        => false,
        ]);
    }

    public function edit(string $title, string $text): void
    {
        $this->title = $title;
        $this->text = (new Formatter\Paragraph())->format($text);
        $this->save();
    }
}