<?php

namespace App\Http\API\Documents\Queries;

use App\Domain\Documents\Models\Document;
use App\Http\API\BaseQuery;

class DocumentQuery extends BaseQuery
{
    public function __construct()
    {
        $subject = Document::query();

        parent::__construct($subject);
    }
}
