<?php

namespace App\Domain\Users\Actions;

use App\Domain\Documents\Models\Document;
use App\Domain\Users\Models\User;

class DeleteUser
{
    public function do(User $user)
    {
        Document::query()
            ->where('user_id', $user->id)
            ->update([
                'user_id' => null
            ]);

        $user->delete();
    }
}
