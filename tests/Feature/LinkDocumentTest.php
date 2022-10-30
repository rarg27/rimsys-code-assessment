<?php

namespace Tests\Feature;

use App\Domain\Documents\Actions\UpsertDocument;
use App\Domain\Users\Actions\UpsertUser;
use Symfony\Component\HttpFoundation\File\File;
use Tests\TestCase;

class LinkDocumentTest extends TestCase
{
    /**
     * Can link/unlink documents to users
     *
     * @return void
     */
    public function test_can_link_unlink_documents_to_users()
    {
        $upsertUser = app()->make(UpsertUser::class);
        $user = $upsertUser->do(['name' => 'Juan']);

        $upsertDocument = app()->make(UpsertDocument::class);
        $document = $upsertDocument->do(['file' => new File(storage_path('sample.pdf'))]);

        $response = $this->putJson("/api/documents/$document->id", [
            'user_id' => $user->id
        ]);

        $response
            ->assertSuccessful()
            ->assertJsonFragment([
                'user_id' => $user->id
            ]);

        $response = $this->putJson("/api/documents/$document->id", [
            'user_id' => null
        ]);

        $response
            ->assertSuccessful()
            ->assertJsonFragment([
                'user_id' => null
            ]);
    }
}
