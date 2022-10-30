<?php

namespace App\Http\API\Documents\Queries;

use App\Domain\Documents\Models\Document;
use App\Http\API\BaseQuery;
use Spatie\QueryBuilder\AllowedFilter;
use Spatie\QueryBuilder\AllowedSort;

class DocumentAttachmentQuery extends BaseQuery
{
    public function __construct(Document $document)
    {
        $subject = $document->attachments();

        parent::__construct($subject);

        $this->allowedFilters([
            AllowedFilter::callback('search', function ($query, string $keyWord) {
                $query->orWhere('filename', 'like', "%$keyWord")
                    ->orWhere('filename', 'like', "$keyWord%")
                    ->orWhere('filename', 'like', "%$keyWord%");
            })
        ]);

        $this->allowedSorts([
            AllowedSort::field('filename')
        ]);
    }
}
