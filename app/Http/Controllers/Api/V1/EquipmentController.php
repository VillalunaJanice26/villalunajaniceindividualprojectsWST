<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Filters\V1\EquipmentFilter;
use App\Http\Resources\V1\EquipmentResource;
use App\Http\Requests\Api\V1\StoreEquipmentRequest;
use App\Http\Requests\Api\V1\ReplaceEquipmentRequest;
use App\Models\Equipment;

class EquipmentController extends APIController
{
    // GET - Retrieve all equipments
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

    /**
     * POST /api/v1/equipments
     * Create a new equipment.
     */
    public function store(StoreEquipmentRequest $request)
    {
        $equipment = Equipment::create(
            $request->mappedAttributes()
        );

        return (new EquipmentResource($equipment))
            ->response()
            ->setStatusCode(201);
    }

    /**
     * DELETE /api/v1/equipments/{equipment}
     * Deletes the equipment.
     */
    public function destroy(Equipment $equipment)
    {
        $equipment->delete();

        return $this->successResponse(
            [],
            'Equipment successfully deleted',
            200
        );
    }

    /**
     * PUT /api/v1/equipments/{equipment}
     * Replaces the equipment.
     */
    public function replace(
        ReplaceEquipmentRequest $request,
        Equipment $equipment
    ) {
        $equipment->update(
            $request->mappedAttributes()
        );

        return new EquipmentResource($equipment);
    }
}
