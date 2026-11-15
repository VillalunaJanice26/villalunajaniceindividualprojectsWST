<?php

namespace App\Http\Controllers\Api\V1;

use App\Models\Equipment;
use App\Http\Resources\V1\EquipmentResource;

class EquipmentController extends APIController
{
    public function index()
    {
        $equipments = Equipment::query();

        if ($this->include('author')) {
            $equipments->with('author');
        }

        return EquipmentResource::collection(
            $equipments->paginate(10)
        );
    }
}
