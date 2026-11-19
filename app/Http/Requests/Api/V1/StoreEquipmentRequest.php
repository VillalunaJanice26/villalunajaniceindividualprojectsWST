<?php

namespace App\Http\Requests\Api\V1;

use App\Permissions\V1\Abilities;
use Illuminate\Validation\Rule;

class StoreEquipmentRequest extends BaseEquipmentRequest
{
    public function rules(): array
    {
        $rules = [
            'data.attributes.name' => ['required', 'string', 'max:255'],
            'data.attributes.category' => ['required', 'string', 'max:255'],
            'data.attributes.serial_number' => ['nullable', 'string', 'max:255'],
            'data.attributes.location' => ['required', 'string', 'max:255'],
            'data.attributes.status' => [
                'nullable',
                'in:Available,In Use,Under Maintenance'
            ],
            'data.attributes.description' => ['nullable', 'string'],
        ];

        if (auth('api')->user()?->tokenCan(Abilities::CreateOwnEquipment)) {
            $rules['data.attributes.user_id'] = [
                'sometimes',
                'integer',
                Rule::in([auth('api')->id()])
            ];
        }

        return $rules;
    }
}
