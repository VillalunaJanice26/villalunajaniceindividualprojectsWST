<?php

namespace App\Http\Filters\V1;

class EquipmentFilter extends QueryFilter
{
    public function status($query, $value)
    {
        $statuses = explode(',', $value);

        return $query->whereIn('status', $statuses);
    }

    public function name($query, $value)
    {
        return $query->where('name', 'like', str_replace('*', '%', $value));
    }
}
