<?php

namespace App\Http\API;

use Illuminate\Contracts\Pagination\CursorPaginator;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Spatie\QueryBuilder\QueryBuilder;

class BaseQuery extends QueryBuilder
{
    public function __construct($subject)
    {
        parent::__construct($subject, request());
    }

    /**
     * @return CursorPaginator|LengthAwarePaginator
     */
    public function smartPaginate(int $limit = null, string $cursor = null)
    {
        return $this->__call('smartPaginate', [$limit, $cursor]);
    }
}
