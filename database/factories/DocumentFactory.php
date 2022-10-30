<?php

namespace Database\Factories;

use App\Domain\Documents\Actions\UpsertDocumentAttachment;
use App\Domain\Documents\Models\Document;
use Illuminate\Database\Eloquent\Factories\Factory;
use Symfony\Component\HttpFoundation\File\File;

class DocumentFactory extends Factory
{
    protected $model = Document::class;

    public function definition()
    {
        return [
            'name' => fake()->word().'.pdf',
        ];
    }

    public function configure()
    {
        $upsertDocumentAttachment = app()->make(UpsertDocumentAttachment::class);

        return $this->afterCreating(function (Document $document) use ($upsertDocumentAttachment) {
            $data = [];
            $data['file'] = new File(storage_path('sample.pdf'));
            $upsertDocumentAttachment->do($data, $document);
        });
    }
}
