<?php

namespace App\Domain\Documents\Actions;

use App\Domain\Documents\Models\Document;

class DeleteDocumentAttachment
{
    public DeleteDocument $deleteDocument;

    public function __construct(DeleteDocument $deleteDocument)
    {
        $this->deleteDocument = $deleteDocument;
    }

    public function do(Document $document, $id)
    {
        $document->attachments()->wherePivot('media_id', $id)->firstOrFail()->delete();

        if (!$document->hasMedia('attachments')) $this->deleteDocument->do($document);
    }
}
