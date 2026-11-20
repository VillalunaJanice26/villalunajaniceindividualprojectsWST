<?php

namespace App\Http\Requests\Api\V1;

use App\Permissions\V1\Abilities;

class UpdateEquipmentRequest extends BaseEquipmentRequest
{
    public function rules(): array
    {
        // Default: nobody can change the equipment owner.
        $userIdRule = 'prohibited';

        // Only managers with the broad ability can change the owner.
        if (auth('api')->user()?->tokenCan(Abilities::UpdateEquipment)) {
            $userIdRule = [
                'sometimes',
                'integer',
                'exists:users,id',
            ];
        }

        return [
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
            'data.attributes.user_id' => $userIdRule,
        ];
    }
}
