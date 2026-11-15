<?php

namespace App\Http\Filters\V1;

use Illuminate\Http\Request;

class QueryFilter
{
    protected $request;

    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    public function apply($query)
    {
        foreach ($this->request->all() as $name => $value) {
            if (method_exists($this, $name)) {
                $this->$name($query, $value);
            }
        }

        return $query;
    }
}
