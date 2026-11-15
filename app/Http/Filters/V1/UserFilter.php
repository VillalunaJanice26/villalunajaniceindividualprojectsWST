<?php

namespace App\Http\Filters\V1;

class UserFilter extends QueryFilter
{
    protected $sortable = [
        'name',
        'email',
        'created_at',
    ];
}
