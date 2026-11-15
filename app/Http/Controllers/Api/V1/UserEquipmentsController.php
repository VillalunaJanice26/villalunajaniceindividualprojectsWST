<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Filters\V1\EquipmentFilter;
use App\Http\Resources\V1\EquipmentResource;
use App\Models\Equipment;
use App\Models\User;

class UserEquipmentsController extends APIController
{
    /**
     * Equipments that belong to one user:
     * /api/v1/users/{user}/equipments
     */
    public function index(User $user, EquipmentFilter $filters)
    {
        return EquipmentResource::collection(
            Equipment::where('user_id', $user->id)
                ->filter($filters)
                ->paginate()
        );
    }
}
