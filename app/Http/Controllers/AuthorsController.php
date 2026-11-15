<?php

namespace App\Http\Controllers;

use App\Http\Filters\V1\UserFilter;
use App\Http\Resources\V1\UserResource;
use App\Models\User;

class AuthorsController extends Controller
{
    public function index(UserFilter $filters)
    {
        return UserResource::collection(
            User::filter($filters)->paginate(10)
        );
    }
}
