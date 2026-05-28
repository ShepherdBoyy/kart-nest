<?php

declare(strict_types=1);

namespace App\Core;

class Paginator
{
    private int $total;
    private int $perPage;
    private int $currentPage;
    private int $totalPages;

    public function __construct(int $total, int $perPage, int $currentPage)
    {
        $this->total = max(0, $total);
        $this->perPage = max(1, $perPage);
        $this->totalPages = (int) ceil($this->total / $this->perPage);
        $this->currentPage = max(1, min($currentPage, max(1, $this->totalPages)));
    }

    public function currentPage(): int
    {
        return $this->currentPage;
    }

    public function totalPages(): int
    {
        return $this->totalPages;
    }

    public function total(): int
    {
        return $this->total;
    }

    public function perPage(): int
    {
        return $this->perPage;
    }

    public function hasNextPage(): bool
    {
        return $this->currentPage < $this->totalPages;
    }

    public function hasPrevPage(): bool
    {
        return $this->currentPage > 1;
    }

    public function shouldPaginate(): bool
    {
        return $this->totalPages > 1;
    }

    public function offset(): int
    {
        return ($this->currentPage - 1) * $this->perPage;
    }

    public function from(): int
    {
        if ($this->total === 0) {
            return 0;
        }

        return $this->offset() + 1;
    }

    public function to(): int
    {
        return min(
            $this->offset() + $this->perPage,
            $this->total
        );
    }

    public function pages(): array
    {
        if ($this->totalPages <= 1) {
            return [];
        }

        if ($this->totalPages <= 7) {
            return range(1, $this->totalPages);
        }

        $pages = [];
        $current = $this->currentPage;
        $last = $this->totalPages;
        $pages[] = 1;

        if ($current - 2 > 2) {
            $pages[] = null;
        }
        
        $windowStart = max(2, $current - 2);
        $windowEnd = min($last - 1, $current + 2);

        for($i = $windowStart; $i <= $windowEnd; $i++) {
            $pages[] = $i;
        }

        if ($current + 2 < $last - 1) {
            $pages[] = null;
        }

        $pages[] = $last;
        
        return $pages;
    }

    public function url(int $page): string
    {
        $params = $_GET;
        $params["page"] = $page;
        $path = strtok($_SERVER["REQUEST_URI"], "?");

        return $path . "?" . http_build_query($params);
    }

    public function links(): string
    {
        if (!$this->shouldPaginate()) {
            return '';
        }

        $html = '<div class="flex flex-col items-center gap-4 mt-8">';
        $html .= '<p class="text-sm text-base-content/60">';
        $html .= 'Showing '
            . $this->from()
            . '–'
            . $this->to()
            . ' of '
            . number_format($this->total)
            . ' results';
        $html .= '</p>';
        $html .= '<div class="join">';

        if ($this->hasPrevPage()) {
            $html .= '<a href="'
                . e($this->url($this->currentPage - 1))
                . '" class="join-item btn btn-sm">'
                . '←'
                . '</a>';
        } else {
            $html .= '<button class="join-item btn btn-sm" '
                . 'disabled>←</button>';
        }

        foreach ($this->pages() as $page) {
            if ($page === null) {
                $html .= '<button class="join-item btn btn-sm '
                    . 'btn-disabled">…</button>';
            } elseif ($page === $this->currentPage) {
                $html .= '<button class="join-item btn btn-sm '
                    . 'btn-active btn-primary">'
                    . $page
                    . '</button>';
            } else {
                $html .= '<a href="'
                    . e($this->url($page))
                    . '" class="join-item btn btn-sm">'
                    . $page
                    . '</a>';
            }
        }

        if ($this->hasNextPage()) {
            $html .= '<a href="'
                . e($this->url($this->currentPage + 1))
                . '" class="join-item btn btn-sm">'
                . '→'
                . '</a>';
        } else {
            $html .= '<button class="join-item btn btn-sm" '
                . 'disabled>→</button>';
        }

        $html .= '</div>';
        $html .= '</div>';

        return $html;
    }
}