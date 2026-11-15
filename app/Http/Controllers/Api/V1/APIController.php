<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;

class APIController extends Controller
{
    protected function include(string $relationship): bool
    {
        $includes = request()->query('include', '');

        $includes = array_map('trim', explode(',', $includes));

        return in_array($relationship, $includes, true);
    }
}
