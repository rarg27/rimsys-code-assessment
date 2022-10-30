<?php

namespace App\Domain\Documents\Actions;

use App\Domain\Documents\Models\Document;
use Illuminate\Support\Arr;
use Illuminate\Validation\Rule;
use Symfony\Component\HttpFoundation\File\File;

class UpsertDocument
{
    public UpsertDocumentAttachment $upsertDocumentAttachment;

    public function __construct(UpsertDocumentAttachment $upsertDocumentAttachment)
    {
        $this->upsertDocumentAttachment = $upsertDocumentAttachment;
    }

    public function do(array $data, ?Document $document = null)
    {
        $rules = [
            'name' => ['string'],
            'user_id' => ['nullable', 'int', 'exists:users,id'],
            'file' => ['file', Rule::requiredIf(is_null($document))]
        ];

        $data = validator($data, $rules)->validate();

        $document ??= new Document;
        if (!$document->exists && empty(Arr::get($data, 'name'))) {
            /** @var File $file */
            $file = $data['file'];
            $data['name'] = $file->getFilename().'.'.$file->getExtension();
        }
        $document->fill($data)->save();

        if (Arr::get($data, 'file')) {
            $this->upsertDocumentAttachment->do($data, $document);
        }

        return $document;
    }
}
