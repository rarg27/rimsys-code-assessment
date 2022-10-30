<?php

namespace App\Http\API\Documents\Queries;

use App\Domain\Documents\Models\Document;
use App\Http\API\BaseQuery;

class DocumentAttachmentQuery extends BaseQuery
{
    public function __construct(Document $document)
    {
        $subject = $document->attachments();

        parent::__construct($subject);
    }
}
