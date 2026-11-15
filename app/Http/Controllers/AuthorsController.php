<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Http\Resources\V1\UserResource;

class AuthorsController extends Controller
{
    public function index()
    {
        $authors = User::paginate(10);

        return UserResource::collection($authors);
    }
}
