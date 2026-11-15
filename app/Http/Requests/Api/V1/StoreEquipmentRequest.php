<?php

namespace App\Http\Requests\Api\V1;

class StoreEquipmentRequest extends BaseEquipmentRequest
{
    /**
     * Get the validation rules that apply to the request.
     */
    public function rules(): array
    {
        return [
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
    }
}
