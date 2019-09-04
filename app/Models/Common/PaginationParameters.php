<?php

namespace App\Models\Common;

class PaginationParameters {
    public $page;
    public $offset;
    public $limit;


    private $defaults = [
        'page' => 1,
        'limit' => 100
    ];

    function __construct(int $page, int $limit = null) {
        if ($page <= 0) $page = null;
        if ($limit <= 0) $limit = null;

        $this->page = $page ?? $this->defaults['page'];
        $this->limit = $limit ?? $this->defaults['limit'];
        $this->offset = ($this->page - 1) * $this->limit;
    }
}
