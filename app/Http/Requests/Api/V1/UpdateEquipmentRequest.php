<?php

namespace App\Http\Requests\Api\V1;

class UpdateEquipmentRequest extends BaseEquipmentRequest
{
    public function rules(): array
    {
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
        ];
    }
}
