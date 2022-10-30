<?php

namespace App\Http\API\Documents\Controllers;

use App\Domain\Documents\Actions\DeleteDocumentAttachment;
use App\Domain\Documents\Actions\UpsertDocumentAttachment;
use App\Domain\Documents\Models\Document;
use App\Http\API\BaseController;
use App\Http\API\Documents\Queries\DocumentAttachmentQuery;
use Symfony\Component\HttpFoundation\Response;

class DocumentAttachmentController extends BaseController
{
    public function all(DocumentAttachmentQuery $query)
    {
        return responder()->success($query->smartPaginate())->respond();
    }

    public function store(Document $document, UpsertDocumentAttachment $upsertDocumentAttachment)
    {
        return responder()->success($upsertDocumentAttachment->do(request()->all(), $document))->respond();
    }

    public function update(Document $document, $id, UpsertDocumentAttachment $upsertDocumentAttachment)
    {
        return responder()->success($upsertDocumentAttachment->do(request()->all(), $document, $id))->respond();
    }

    public function delete(Document $document, $id, DeleteDocumentAttachment $deleteDocumentAttachment)
    {
        $deleteDocumentAttachment->do($document, $id);

        return responder()->success()->respond(Response::HTTP_NO_CONTENT);
    }
}
