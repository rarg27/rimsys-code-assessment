<?php

namespace App\Domain\Documents\Actions;

use App\Domain\Documents\Models\Document;
use Plank\Mediable\Media;

class DeleteDocument
{
    public function do(Document $document)
    {
        $document->attachments()
            ->each(function (Media $media) {
                $media->delete();
            });

        $document->delete();
    }
}
