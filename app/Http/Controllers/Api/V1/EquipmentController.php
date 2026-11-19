<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Filters\V1\EquipmentFilter;
use App\Http\Resources\V1\EquipmentResource;
use App\Http\Requests\Api\V1\StoreEquipmentRequest;
use App\Http\Requests\Api\V1\ReplaceEquipmentRequest;
use App\Http\Requests\Api\V1\UpdateEquipmentRequest;
use App\Models\Equipment;
use App\Permissions\V1\Abilities;

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

    // POST - Create equipment
    public function store(StoreEquipmentRequest $request)
    {
        if ($this->isAble('store', Equipment::class)) {
            $attributes = $request->mappedAttributes();

            if (auth('api')->user()->tokenCan(
                Abilities::CreateOwnEquipment
            )) {
                $attributes['user_id'] = auth('api')->id();
            }

            return new EquipmentResource(
                Equipment::create($attributes)
            );
        }

        return $this->notAuthorized(
            'You are not authorized to create that resource.'
        );
    }

    // DELETE - Delete equipment
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

    // PUT - Replace equipment
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

    // PATCH - Update equipment
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
