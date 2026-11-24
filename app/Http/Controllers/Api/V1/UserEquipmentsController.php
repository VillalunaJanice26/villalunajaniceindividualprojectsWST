<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Filters\V1\EquipmentFilter;
use App\Http\Requests\Api\V1\StoreEquipmentRequest;
use App\Http\Requests\Api\V1\ReplaceEquipmentRequest;
use App\Http\Requests\Api\V1\UpdateEquipmentRequest;
use App\Http\Resources\V1\EquipmentResource;
use App\Models\Equipment;
use App\Models\User;

class UserEquipmentsController extends APIController
{
    /**
     * @group User Equipment Management
     *
     * List equipment belonging to one user.
     *
     * @urlParam user required The ID of the user. Example: 1
     */
    public function index(User $user, EquipmentFilter $filters)
    {
        return EquipmentResource::collection(
            $user->equipments()
                ->filter($filters)
                ->paginate(10)
        );
    }

    /**
     * @group User Equipment Management
     * @authenticated
     *
     * Create equipment for the user in the URL.
     *
     * @urlParam user required The ID of the user. Example: 1
     * @bodyParam data.attributes.name string required Equipment name. Example: Laptop
     * @bodyParam data.attributes.category string required Equipment category. Example: Computer
     * @bodyParam data.attributes.location string required Equipment location. Example: Computer Laboratory
     */
    public function store(StoreEquipmentRequest $request, User $user)
    {
        if ($this->isAble('store', Equipment::class)) {
            $attributes = $request->mappedAttributes();

            return new EquipmentResource(
                $user->equipments()->create($attributes)
            );
        }

        return $this->notAuthorized(
            'You are not authorized to create that resource.'
        );
    }

    /**
     * @group User Equipment Management
     * @authenticated
     *
     * Replace equipment belonging to the specified user.
     *
     * @urlParam user required The ID of the user. Example: 1
     * @urlParam equipment required The ID of the equipment. Example: 1
     */
    public function replace(
        ReplaceEquipmentRequest $request,
        User $user,
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
     * @group User Equipment Management
     * @authenticated
     *
     * Update equipment belonging to the specified user.
     *
     * @urlParam user required The ID of the user. Example: 1
     * @urlParam equipment required The ID of the equipment. Example: 1
     */
    public function update(
        UpdateEquipmentRequest $request,
        User $user,
        Equipment $equipment
    ) {
        if ($this->isAble('update', $equipment)) {
            $equipment->update($request->mappedAttributes());

            return new EquipmentResource($equipment);
        }

        return $this->notAuthorized();
    }

    /**
     * @group User Equipment Management
     * @authenticated
     *
     * Delete equipment belonging to the specified user.
     *
     * @urlParam user required The ID of the user. Example: 1
     * @urlParam equipment required The ID of the equipment. Example: 1
     */
    public function destroy(User $user, Equipment $equipment)
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
}
