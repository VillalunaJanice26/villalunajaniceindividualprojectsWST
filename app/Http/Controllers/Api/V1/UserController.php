<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Filters\V1\UserFilter;
use App\Http\Requests\Api\V1\ReplaceUserRequest;
use App\Http\Requests\Api\V1\StoreUserRequest;
use App\Http\Requests\Api\V1\UpdateUserRequest;
use App\Http\Resources\V1\UserResource;
use App\Models\User;

/**
 * User management for managers: list, create, show, replace, update and delete users.
 */
class UserController extends APIController
{
    /**
     * @group User Management
     * @authenticated
     *
     * GET /api/v1/users
     * Lists every user with filters and sorting from the URL.
     */
    public function index(UserFilter $filters)
    {
        return UserResource::collection(
            User::filter($filters)->paginate()
        );
    }

    /**
     * @group User Management
     * @authenticated
     *
     * POST /api/v1/users
     * Creates a user (needs the user:create ability).
     */
    public function store(StoreUserRequest $request)
    {
        if ($this->isAble('store', User::class)) {
            return new UserResource(
                User::create($request->mappedAttributes())
            );
        }

        return $this->notAuthorized(
            'You are not authorized to create that resource.'
        );
    }

    /**
     * @group User Management
     * @authenticated
     *
     * GET /api/v1/users/{user}
     * Shows one user. ?include=equipments loads the user's equipments.
     */
    public function show(User $user)
    {
        if ($this->include('equipments')) {
            return new UserResource($user->load('equipments'));
        }

        return new UserResource($user);
    }

    /**
     * @group User Management
     * @authenticated
     *
     * PATCH /api/v1/users/{user}
     * Updates only the fields that were sent.
     */
    public function update(UpdateUserRequest $request, User $user)
    {
        if ($this->isAble('update', $user)) {
            $user->update($request->mappedAttributes());

            return new UserResource($user);
        }

        return $this->notAuthorized(
            'You are not authorized to update that resource.'
        );
    }

    /**
     * @group User Management
     * @authenticated
     *
     * PUT /api/v1/users/{user}
     * Replaces the whole user: every field is required.
     */
    public function replace(ReplaceUserRequest $request, User $user)
    {
        if ($this->isAble('replace', $user)) {
            $user->update($request->mappedAttributes());

            return new UserResource($user);
        }

        return $this->notAuthorized(
            'You are not authorized to replace that resource.'
        );
    }

    /**
     * @group User Management
     * @authenticated
     *
     * DELETE /api/v1/users/{user}
     * Deletes the user (needs user:delete).
     */
    public function destroy(User $user)
    {
        if ($this->isAble('delete', $user)) {
            $user->delete();

            return response()->json([
                'message' => 'User successfully deleted'
            ]);
        }

        return $this->notAuthorized(
            'You are not authorized to delete that resource.'
        );
    }
}
