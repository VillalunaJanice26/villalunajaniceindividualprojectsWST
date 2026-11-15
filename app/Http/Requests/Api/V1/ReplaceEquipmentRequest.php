<?php

namespace App\Http\Requests\Api\V1;

class ReplaceEquipmentRequest extends BaseEquipmentRequest
{
    public function rules(): array
    {
        return [
            'data.attributes.name' => ['required', 'string', 'max:255'],
            'data.attributes.category' => ['required', 'string', 'max:255'],
            'data.attributes.serial_number' => ['required', 'nullable', 'string', 'max:255'],
            'data.attributes.location' => ['required', 'string', 'max:255'],
            'data.attributes.status' => [
                'required',
                'in:Available,In Use,Under Maintenance'
            ],
            'data.attributes.description' => ['required', 'nullable', 'string'],
        ];
    }
}