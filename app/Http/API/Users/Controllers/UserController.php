<?php

namespace App\Http\API\Users\Controllers;

use App\Domain\Users\Actions\DeleteUser;
use App\Domain\Users\Actions\UpsertUser;
use App\Domain\Users\Models\User;
use App\Http\API\BaseController;
use App\Http\API\Users\Queries\UserQuery;
use Symfony\Component\HttpFoundation\Response;

/**
 * @group Users
 *
 * APIs for managing Users
 */
class UserController extends BaseController
{
    /**
     * List users
     *
     * @queryParam filter[id] int User ID. Example: 1
     * @queryParam filter[search] string Search by user's name. No-example
     * @queryParam include string Include comma-separated related resource. Example: documents.attachments
     * @queryParam cursor string Page cursor. No-example
     * @queryParam page int Page number. Example: 1
     * @queryParam limit int Page size. Example: 5
     */
    public function all(UserQuery $query)
    {
        return responder()->success($query->smartPaginate())->respond();
    }

    /**
     * Fetch a user
     *
     * @urlParam id int required User ID. Example: 1
     */
    public function get($id, UserQuery $query)
    {
        return responder()->success($query->findOrFail($id))->respond();
    }

    /**
     * Create a user
     *
     * @bodyParam name string required User's name. Example: Juan
     */
    public function store(UpsertUser $upsertUser)
    {
        return responder()->success($upsertUser->do(request()->all()))->respond();
    }

    /**
     * Update a user
     *
     * @urlParam user int required User ID. Example: 1
     *
     * @bodyParam name string required User's name. Example: Juan
     */
    public function update(User $user, UpsertUser $upsertUser)
    {
        return responder()->success($upsertUser->do(request()->all(), $user))->respond();
    }

    /**
     * Delete a user
     *
     * @urlParam user int required User ID. Example: 1
     */
    public function delete(User $user, DeleteUser $deleteUser)
    {
        $deleteUser->do($user);

        return responder()->success()->respond(Response::HTTP_NO_CONTENT);
    }
}
