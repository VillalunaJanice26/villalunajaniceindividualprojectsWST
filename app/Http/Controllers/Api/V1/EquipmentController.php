<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Filters\V1\EquipmentFilter;
use App\Http\Resources\V1\EquipmentResource;
use App\Models\Equipment;

class EquipmentController extends APIController
{
    public function index(EquipmentFilter $filters)
    {
        $equipments = Equipment::filter($filters);

        if ($this->include('author')) {
            $equipments->with('author');
        }

        return EquipmentResource::collection(
            $equipments->paginate(10)
        );
    }
}
