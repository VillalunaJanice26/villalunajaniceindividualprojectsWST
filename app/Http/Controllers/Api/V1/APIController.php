<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Traits\ApiResponses;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

/**
 * Base class for the version 1 API controllers.
 */
class APIController extends Controller
{
    use ApiResponses, AuthorizesRequests;

    protected function include(string $relationship): bool
    {
        $includes = request()->query('include', '');

        $includes = array_map('trim', explode(',', $includes));

        return in_array($relationship, $includes, true);
    }

    /**
     * Check authorization without throwing an exception directly.
     */
    protected function isAble(string $ability, $arguments = []): bool
    {
        try {
            $this->authorize($ability, $arguments);

            return true;
        } catch (AuthorizationException $e) {
            return false;
        }
    }
}
