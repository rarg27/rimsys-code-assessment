<?php

namespace App\Domain\Documents\Actions;

use App\Domain\Documents\Models\Document;
use Plank\Mediable\Facades\MediaUploader;
use Symfony\Component\HttpFoundation\File\UploadedFile;

class UpsertDocumentAttachment
{
    public function do(array $data, Document $document, $id = null)
    {
        $rules = [
            'file' => ['file', 'required']
        ];

        $data = validator($data, $rules)->validate();

        $uploader = MediaUploader::fromSource($data['file'])
            ->toDirectory("media/documents/$document->id")
            ->onDuplicateIncrement();

        if ($id) {
            $media = $document->attachments()->wherePivot('media_id', $id)->firstOrFail();
            $file = $data['file'];
            $name = $file instanceof UploadedFile ? $file->getClientOriginalName() : $file->getFilename();
            $uploader->useFilename($name)->replace($media);
        } else {
            $media = $uploader->upload();
            $document->attachMedia($media, 'attachments');
        }

        return $document->attachments()->wherePivot('media_id', $media->id)->firstOrFail();
    }
}
