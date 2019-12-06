<?php


namespace App\Model;


use ActiveRecord\DateTime;

class Article extends AbstractModel implements HasImage
{
    use HasImageTrait, CanBeListed;

    // ActiveRecord Association
    static $has_many = [
        ['comments'],
    ];

    public static function add(string $title, string $abstract, string $text): self
    {
        return self::create(['title' => $title,
            'abstract' => $abstract,
            'text' => (new \App\Formatter\Paragraph())->format($text),
            'active' => false,
            'create_time' => (new DateTime())]);
    }

    public static function articlesWithoutText(int $limit = 10, int $offset = 0): array
    {
        return self::findAllWithLimits($limit, $offset, [
            'select'        => 'id, title, abstract, image, create_time',
            'conditions'    => ['active' => true],
            'order'         => 'create_time desc',
        ]);
    }

    public static function lastArticlesWithIdAndTitle(int $limit = 4): array
    {
        return self::all([
            'select'        => 'id, title',
            'conditions'    => ['active' => true],
            'order'         => 'create_time desc',
            'limit'         => $limit,
        ]) ?? [];
    }

    public function update(string $title, string $abstract, string $text): void
    {
        $this->title = $title;
        $this->abstract = $abstract;
        $this->text = (new \App\Formatter\Paragraph())->format($text);
        $this->save();
    }

    public function getCommentsWithUserAsAttributes(bool $onlyActive = true): array
    {
        $comments = [];

        foreach ($this->getComments($onlyActive) as $comment) {
            $comments[] = array_merge($comment->attributes(), ['user' => $comment->user->attributes()]);
        }

        return $comments;
    }

    public function getNextArticleId(): string
    {
        $article = self::first([
            'select'        => 'id',
            'conditions'    => ['id > ? AND active = true', $this->getId()],
        ]);

         return $article ? $article->id : '';
    }

    public function getPreviousArticleId(): string
    {
        $article = self::last([
            'select'        => 'id',
            'conditions'    => ['id < ? AND active = true', $this->getId()],
        ]);

        return $article ? $article->id : '';
    }

    /**
     * @return bool|void
     * @throws \ActiveRecord\ActiveRecordException
     */
    public function delete()
    {
        (new Image($this))->delete();
        parent::delete();
    }

    private function getComments(bool $onlyActive = true): array
    {
        $conditions = ['article_id' => $this->id];

        if ($onlyActive) {
            $conditions['active'] = true;
        }

        return Comment::all(['conditions' => $conditions]);
    }
}