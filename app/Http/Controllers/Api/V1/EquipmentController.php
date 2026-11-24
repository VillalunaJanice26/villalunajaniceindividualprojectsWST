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
    /**
     * @group Equipment Management
     *
     * Retrieve all equipment records.
     *
     * @queryParam filter[name] Filter by equipment name. Use * as a wildcard. Example: Laptop*
     * @queryParam filter[status] Filter by status. Multiple values may be comma-separated. Example: Available,In Use
     * @queryParam sort Sort by name, category, location, status, or created_at. Example: name
     * @queryParam include Include related author information. Example: author
     */
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
     * @group Equipment Management
     *
     * Retrieve one equipment record by ID.
     *
     * @urlParam equipment required The ID of the equipment. Example: 1
     */
    public function show(Equipment $equipment)
    {
        return new EquipmentResource($equipment);
    }

    /**
     * @group Equipment Management
     * @authenticated
     *
     * Create a new equipment record.
     *
     * Requires authentication and permission to create equipment.
     *
     * @bodyParam data.attributes.name string required Equipment name. Example: Laptop
     * @bodyParam data.attributes.category string required Equipment category. Example: Computer
     * @bodyParam data.attributes.serial_number string Serial number. Example: SN-001
     * @bodyParam data.attributes.location string required Equipment location. Example: Computer Laboratory
     * @bodyParam data.attributes.status string Equipment status. Example: Available
     * @bodyParam data.attributes.description string Equipment description. Example: Office laptop
     * @bodyParam data.attributes.user_id integer required Owner user ID. Example: 1
     */
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

    /**
     * @group Equipment Management
     * @authenticated
     *
     * Delete an equipment record.
     *
     * Requires authentication and permission to delete the equipment.
     *
     * @urlParam equipment required The ID of the equipment. Example: 1
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
     * @group Equipment Management
     * @authenticated
     *
     * Replace all editable fields of an equipment record.
     *
     * Requires authentication and permission to replace the equipment.
     *
     * @urlParam equipment required The ID of the equipment. Example: 1
     * @bodyParam data.attributes.name string required Equipment name. Example: Laptop
     * @bodyParam data.attributes.category string required Equipment category. Example: Computer
     * @bodyParam data.attributes.serial_number string required Serial number. Example: SN-001
     * @bodyParam data.attributes.location string required Equipment location. Example: Computer Laboratory
     * @bodyParam data.attributes.status string required Equipment status. Example: Available
     * @bodyParam data.attributes.description string required Equipment description. Example: Office laptop
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
     * @group Equipment Management
     * @authenticated
     *
     * Partially update an equipment record.
     *
     * Requires authentication and permission to update the equipment.
     *
     * @urlParam equipment required The ID of the equipment. Example: 1
     * @bodyParam data.attributes.name string Equipment name. Example: Laptop
     * @bodyParam data.attributes.category string Equipment category. Example: Computer
     * @bodyParam data.attributes.serial_number string Serial number. Example: SN-001
     * @bodyParam data.attributes.location string Equipment location. Example: Computer Laboratory
     * @bodyParam data.attributes.status string Equipment status. Example: Available
     * @bodyParam data.attributes.description string Equipment description. Example: Office laptop
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
