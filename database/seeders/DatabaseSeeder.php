<?php

namespace Database\Seeders;

use App\Domain\Documents\Models\Document;
use App\Domain\Users\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        User::factory(5)
            ->has(Document::factory()->count(rand(1, 3)))
            ->create();
    }
}
