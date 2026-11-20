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
     * List equipment belonging to one user.
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
     * Create equipment for the user in the URL.
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
     * Replace equipment belonging to the specified user.
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
     * Update equipment belonging to the specified user.
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
     * Delete equipment belonging to the specified user.
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
