<?php


namespace App\Controller;


use App\Http\Request;

class Paginator
{
    /** @var Request */
    private $request;
    private $pages = [];
    private $currentPage;
    private $lastPage;

    public function __construct(int $currentPage, int $maxItems, int $itemsPerPage)
    {
        $this->currentPage = $currentPage;
        $this->lastPage = ceil($maxItems / $itemsPerPage) ?: 1;
        $this->setPages();
        $this->request = new Request();
    }

    public function isNeeded(): bool
    {
        return $this->lastPage > 1;
    }

    public function getCurrentPage(): int
    {
        return $this->currentPage;
    }

    public function getFirstPagePath(): string
    {
        return $this->request->unsetGet('page')->getPath();
    }

    public function getLastPagePath(): string
    {
        return $this->request->setGet('page', $this->getLastPage())->getPath();
    }

    public function getPagesPath(): array
    {
        $paths = [];

        foreach ($this->pages as $page) {
            $paths[] = [
                'page' => $page,
                'path' => $page == 1
                    ? $this->getFirstPagePath()
                    : $this->request->setGet('page', $page)->getPath()
                ,
            ];
        }

        return $paths;
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
}