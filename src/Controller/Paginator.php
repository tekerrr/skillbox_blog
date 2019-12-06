<?php


namespace App\Controller;


class Paginator
{
    private $path;
    private $pages = [];
    private $currentPage;
    private $lastPage;

    public function __construct(int $currentPage, int $maxItems, int $itemsPerPage)
    {
        $this->currentPage = $currentPage;
        $this->lastPage = ceil($maxItems / $itemsPerPage) ?: 1;
        $this->setPages();
    }

    public function isNeeded(): bool
    {
        return $this->lastPage > 1;
    }

    public function getCurrentPage(): int
    {
        return $this->currentPage;
    }

    public function getPages(): array
    {
        return $this->pages;
    }

    public function getLastPage(): int
    {
        return $this->lastPage;
    }

    private function setPages(): void
    {
        $startPage = ($this->currentPage - 2) >= 1 ? ($this->currentPage - 2) : 1;
        $endPage = ($this->currentPage + 2) <= $this->lastPage ? ($this->currentPage + 2) : $this->lastPage;
        $this->pages = range($startPage, $endPage);
    }

    public function getPath()
    {
        return $this->path;
    }

    public function setPath(string $path): void
    {
        $this->path = $path;
    }
}