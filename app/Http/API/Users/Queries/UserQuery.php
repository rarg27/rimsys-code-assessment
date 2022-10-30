<?php

namespace App\Http\API\Users\Queries;

use App\Domain\Users\Models\User;
use App\Http\API\BaseQuery;

class UserQuery extends BaseQuery
{
    public function __construct()
    {
        $subject = User::query();

        parent::__construct($subject);
    }
}
