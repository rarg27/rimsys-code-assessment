<?php

namespace App\Http\API\Users\Controllers;

use App\Domain\Users\Actions\UpsertUser;
use App\Domain\Users\Models\User;
use App\Http\API\BaseController;
use App\Http\API\Users\Queries\UserQuery;
use Symfony\Component\HttpFoundation\Response;

class UserController extends BaseController
{
    public function all(UserQuery $query)
    {
        return responder()->success($query->smartPaginate())->respond();
    }

    public function get($id, UserQuery $query)
    {
        return responder()->success($query->findOrFail($id))->respond();
    }

    public function store(UpsertUser $upsertUser)
    {
        return responder()->success($upsertUser->do(request()->all()))->respond();
    }

    public function update(User $user, UpsertUser $upsertUser)
    {
        return responder()->success($upsertUser->do(request()->all(), $user))->respond();
    }

    public function delete(User $user)
    {
        $user->delete();

        return responder()->success()->respond(Response::HTTP_NO_CONTENT);
    }
}
