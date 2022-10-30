<?php

namespace App\Http\API\Documents\Queries;

use App\Domain\Documents\Models\Document;
use App\Http\API\BaseQuery;
use Spatie\QueryBuilder\AllowedFilter;
use Spatie\QueryBuilder\AllowedInclude;
use Spatie\QueryBuilder\AllowedSort;

class DocumentQuery extends BaseQuery
{
    public function __construct()
    {
        $subject = Document::query();

        parent::__construct($subject);

        $this->allowedFilters([
            AllowedFilter::exact('id'),
            AllowedFilter::exact('user_id'),
            AllowedFilter::scope('search')
        ]);

        $this->allowedIncludes([
            AllowedInclude::relationship('attachments'),
            AllowedInclude::relationship('user')
        ]);

        $this->allowedSorts([
            AllowedSort::field('created_at')
        ]);
    }
}
