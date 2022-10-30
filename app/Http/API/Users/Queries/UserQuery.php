<?php

namespace App\Http\API\Users\Queries;

use App\Domain\Users\Models\User;
use App\Http\API\BaseQuery;
use Spatie\QueryBuilder\AllowedFilter;
use Spatie\QueryBuilder\AllowedInclude;
use Spatie\QueryBuilder\AllowedSort;

class UserQuery extends BaseQuery
{
    public function __construct()
    {
        $subject = User::query();

        parent::__construct($subject);

        $this->allowedFilters([
            AllowedFilter::exact('id'),
            AllowedFilter::scope('search')
        ]);

        $this->allowedIncludes([
            AllowedInclude::relationship('documents'),
            AllowedInclude::relationship('documents.attachments')
        ]);

        $this->allowedSorts([
            AllowedSort::field('created_at')
        ]);
    }
}
