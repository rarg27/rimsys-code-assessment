<?php

namespace App\Http\API\Documents\Controllers;

use App\Domain\Documents\Actions\DeleteDocument;
use App\Domain\Documents\Actions\UpsertDocument;
use App\Domain\Documents\Models\Document;
use App\Http\API\BaseController;
use App\Http\API\Documents\Queries\DocumentQuery;
use Symfony\Component\HttpFoundation\Response;

class DocumentController extends BaseController
{
    public function all(DocumentQuery $query)
    {
        return responder()->success($query->smartPaginate())->respond();
    }

    public function get($id, DocumentQuery $query)
    {
        return responder()->success($query->findOrFail($id))->respond();
    }

    public function store(UpsertDocument $upsertDocument)
    {
        return responder()->success($upsertDocument->do(request()->all()))->respond();
    }

    public function update(Document $document, UpsertDocument $upsertDocument)
    {
        return responder()->success($upsertDocument->do(request()->all(), $document))->respond();
    }

    public function delete(Document $document, DeleteDocument $deleteDocument)
    {
        $deleteDocument->do($document);

        return responder()->success()->respond(Response::HTTP_NO_CONTENT);
    }
}
