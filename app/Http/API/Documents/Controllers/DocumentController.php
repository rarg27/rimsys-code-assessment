<?php

namespace App\Http\API\Documents\Controllers;

use App\Domain\Documents\Actions\DeleteDocument;
use App\Domain\Documents\Actions\UpsertDocument;
use App\Domain\Documents\Models\Document;
use App\Http\API\BaseController;
use App\Http\API\Documents\Queries\DocumentQuery;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\HttpFoundation\Response;

/**
 * @group Documents
 *
 * APIs for managing Documents
 */
class DocumentController extends BaseController
{
    /**
     * List documents
     *
     * @queryParam filter[id] string Filter by comma-separated ID. Example: 1
     * @queryParam filter[user_id] string Filter by comma-separated User ID. Example: 1
     * @queryParam filter[search] string Search by document's name. No-example
     * @queryParam sort string Sort by field. Example: -created_at
     * @queryParam include string Include comma-separated related resource. Example: attachments
     * @queryParam cursor string Page cursor. No-example
     * @queryParam page int Page number. Example: 1
     * @queryParam limit int Page size. Example: 5
     */
    public function all(DocumentQuery $query)
    {
        return responder()->success($query->smartPaginate())->respond();
    }

    /**
     * Fetch a document
     *
     * @urlParam id int required Document ID. Example: 1
     *
     * @queryParam include string Include comma-separated related resource. Example: attachments
     */
    public function get($id, DocumentQuery $query)
    {
        return responder()->success($query->findOrFail($id))->respond();
    }

    /**
     * Create document
     *
     * @bodyParam name string Document name. Example: sample
     * @bodyParam user_id int User ID. Example: 1
     * @bodyParam file file required Attachment for document. No-example
     */
    public function store(UpsertDocument $upsertDocument)
    {
        return responder()->success($upsertDocument->do(request()->all()))->respond();
    }

    /**
     * Update document
     *
     * @urlParam document int required Document ID. Example: 1
     *
     * @bodyParam name string Document name. Example: sample
     * @bodyParam user_id int User ID. Example: 1
     * @bodyParam file file Attachment for document. No-example
     */
    public function update(Document $document, UpsertDocument $upsertDocument)
    {
        return responder()->success($upsertDocument->do(request()->all(), $document))->respond();
    }

    /**
     * Delete document
     *
     * @urlParam document int required Document ID. Example: 1
     */
    public function delete(Document $document, DeleteDocument $deleteDocument)
    {
        $deleteDocument->do($document);

        return responder()->success()->respond(Response::HTTP_NO_CONTENT);
    }

    /**
     * Download a document
     *
     * @urlParam document int required Document ID. Example: 2
     */
    public function download(Document $document)
    {
        $media = $document->lastMedia('attachments');

        return Storage::disk($media->disk)->download($media->getDiskPath(), $document->name);
    }
}
