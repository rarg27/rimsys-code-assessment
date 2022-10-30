<?php

namespace App\Http\API\Documents\Controllers;

use App\Domain\Documents\Actions\DeleteDocumentAttachment;
use App\Domain\Documents\Actions\UpsertDocumentAttachment;
use App\Domain\Documents\Models\Document;
use App\Http\API\BaseController;
use App\Http\API\Documents\Queries\DocumentAttachmentQuery;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\HttpFoundation\Response;

/**
 * @group Document Attachments
 *
 * APIs for managing Document Attachments
 */
class DocumentAttachmentController extends BaseController
{
    /**
     * List document's attachments
     *
     * @urlParam document int required Document ID. Example: 1
     *
     * @queryParam filter[search] string Filter by Document name. No-example
     * @queryParam sort string Sort by field. Example: filename
     * @queryParam cursor string Page cursor. No-example
     * @queryParam page int Page number. Example: 1
     * @queryParam limit int Page size. Example: 5
     */
    public function all(DocumentAttachmentQuery $query)
    {
        return responder()->success($query->smartPaginate())->respond();
    }

    /**
     * Create an attachment for document
     *
     * @urlParam document int required Document ID. Example: 1
     *
     * @bodyParam file file required Attachment for document. No-example
     */
    public function store(Document $document, UpsertDocumentAttachment $upsertDocumentAttachment)
    {
        return responder()->success($upsertDocumentAttachment->do(request()->all(), $document))->respond();
    }

    /**
     * Update attachment of a document
     *
     * @urlParam document int required Document ID. Example: 1
     * @urlParam id int required Attachment ID. Example: 1
     *
     * @bodyParam file file required Attachment for document. No-example
     */
    public function update(Document $document, $id, UpsertDocumentAttachment $upsertDocumentAttachment)
    {
        return responder()->success($upsertDocumentAttachment->do(request()->all(), $document, $id))->respond();
    }

    /**
     * Delete attachment of a document
     *
     * @urlParam document int required Document ID. Example: 1
     * @urlParam id int required Attachment ID. Example: 1
     */
    public function delete(Document $document, $id, DeleteDocumentAttachment $deleteDocumentAttachment)
    {
        $deleteDocumentAttachment->do($document, $id);

        return responder()->success()->respond(Response::HTTP_NO_CONTENT);
    }

    /**
     * Download attachment of a document
     *
     * @urlParam document int required Document ID. Example: 2
     * @urlParam id int required Attachment ID. Example: 2
     */
    public function download(Document $document, $id)
    {
        $media = $document->attachments()->wherePivot('media_id', $id)->firstOrFail();

        return Storage::disk($media->disk)->download($media->getDiskPath(), $document->name);
    }
}
