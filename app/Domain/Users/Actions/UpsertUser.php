<?php

namespace App\Domain\Users\Actions;

use App\Domain\Users\Models\User;
use Illuminate\Validation\Rule;

class UpsertUser
{
    public function do(array $data, ?User $user = null)
    {
        $rules = [
            'name' => ['string', Rule::requiredIf(is_null($user))]
        ];

        $data = validator($data, $rules)->validate();

        $user ??= new User;
        $user->fill($data)->save();

        return $user;
    }
}
