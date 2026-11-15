<?php

namespace App\Http\Filters\V1;

use Illuminate\Http\Request;

class QueryFilter
{
    protected $request;

    // Allowed sortable columns
    protected $sortable = [];

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

    // Sort records
    public function sort($query, $value)
    {
        $sortAttributes = explode(',', $value);

        foreach ($sortAttributes as $sortAttribute) {
            $direction = 'asc';

            if (str_starts_with($sortAttribute, '-')) {
                $direction = 'desc';
                $sortAttribute = substr($sortAttribute, 1);
            }

            if (in_array($sortAttribute, $this->sortable)) {
                $query->orderBy($sortAttribute, $direction);
            }
        }

        return $query;
    }
}
