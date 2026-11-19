<?php

namespace App\Http\Requests\Api\V1;

use App\Permissions\V1\Abilities;

class UpdateEquipmentRequest extends BaseEquipmentRequest
{
    public function rules(): array
    {
        $rules = [
            'data.attributes.name' => ['sometimes', 'required', 'string', 'max:255'],
            'data.attributes.category' => ['sometimes', 'required', 'string', 'max:255'],
            'data.attributes.serial_number' => ['sometimes', 'nullable', 'string', 'max:255'],
            'data.attributes.location' => ['sometimes', 'required', 'string', 'max:255'],
            'data.attributes.status' => [
                'sometimes',
                'required',
                'in:Available,In Use,Under Maintenance'
            ],
            'data.attributes.description' => ['sometimes', 'nullable', 'string'],
        ];

        // Users who may only update their own equipment cannot change the owner.
        if (auth('api')->user()?->tokenCan(Abilities::UpdateOwnEquipment)) {
            $rules['data.attributes.user_id'] = 'prohibited';
        }

        return $rules;
    }
}
