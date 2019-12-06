<?php


namespace App\Model;


trait CanBeListed
{
    public static function findAllWithLimits(int $limit, int $offset, array $config = []): array
    {
        return (array) self::all(array_merge($config, ['limit' => $limit, 'offset'=> $offset]));
    }

    public static function countItems($onlyActive = true): int
    {
        return self::count($onlyActive ? ['conditions'=> ['active' => true]] : []);
    }

    /**
     * @param string $id
     * @param bool $active
     * @return mixed
     */
    public static function findByIdAndOnlyActive(string $id, bool $onlyActive = true)
    {
        $conditions = ['id' => $id];

        if ($onlyActive) {
            $conditions['active'] = true;
        }

        return static::first(['conditions' => $conditions]);
    }

    public function isActive(): bool
    {
        return (bool) $this->active;
    }

    public function activate(): void
    {
        $this->active = true;
        $this->save();
    }

    public function deactivate(): void
    {
        $this->active = false;
        $this->save();
    }
}