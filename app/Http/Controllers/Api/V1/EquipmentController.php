<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Filters\V1\EquipmentFilter;
use App\Http\Resources\V1\EquipmentResource;
use App\Http\Requests\Api\V1\StoreEquipmentRequest;
use App\Http\Requests\Api\V1\ReplaceEquipmentRequest;
use App\Http\Requests\Api\V1\UpdateEquipmentRequest;
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

    // GET - Retrieve one equipment by ID
    public function show(Equipment $equipment)
    {
        return new EquipmentResource($equipment);
    }

    /**
     * POST /api/v1/equipments
     * Creates equipment, but only if the policy allows this user to do so.
     */
    public function store(StoreEquipmentRequest $request)
    {
        if ($this->isAble('store', Equipment::class)) {
            $attributes = $request->mappedAttributes();

            $attributes['user_id'] = auth('api')->id();

            return new EquipmentResource(
                Equipment::create($attributes)
            );
        }

        return $this->notAuthorized(
            'You are not authorized to create that resource.'
        );
    }

    /**
     * DELETE /api/v1/equipments/{equipment}
     * Deletes the equipment, but only if the policy allows it.
     */
    public function destroy(Equipment $equipment)
    {
        if ($this->isAble('delete', $equipment)) {
            $equipment->delete();

            return response()->json([
                'success' => true,
                'message' => 'Equipment successfully deleted'
            ], 200);
        }

        return $this->notAuthorized(
            'You are not authorized to delete that resource.'
        );
    }

    /**
     * PUT /api/v1/equipments/{equipment}
     * Replaces the whole equipment, but only if the policy allows it.
     */
    public function replace(
        ReplaceEquipmentRequest $request,
        Equipment $equipment
    ) {
        if ($this->isAble('replace', $equipment)) {
            $equipment->update($request->mappedAttributes());

            return new EquipmentResource($equipment);
        }

        return $this->notAuthorized(
            'You are not authorized to replace that resource.'
        );
    }

    /**
     * PATCH /api/v1/equipments/{equipment}
     * Updates selected equipment fields only if authorized.
     */
    public function update(
        UpdateEquipmentRequest $request,
        Equipment $equipment
    ) {
        if ($this->isAble('update', $equipment)) {
            $equipment->update(
                $request->mappedAttributes()
            );

            return new EquipmentResource($equipment);
        }

        return $this->notAuthorized();
    }
}
