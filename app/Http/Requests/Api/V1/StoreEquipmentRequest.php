<?php

namespace App\Http\Requests\Api\V1;

use App\Permissions\V1\Abilities;
use Illuminate\Validation\Rule;

class StoreEquipmentRequest extends BaseEquipmentRequest
{
    protected function prepareForValidation(): void
    {
        $user = $this->route('user');

        if ($user) {
            $attributes = $this->input('data.attributes', []);

            $attributes['user_id'] = $user->id;

            $this->merge([
                'data' => array_merge(
                    $this->input('data', []),
                    ['attributes' => $attributes]
                ),
            ]);
        }
    }

    public function rules(): array
    {
        $user = auth('api')->user();

        $userIdRule = [
            'required',
            'integer',
            'exists:users,id',
            Rule::in([$user->id]),
        ];

        // Only managers with the broad ability can assign equipment to anyone.
        if ($user->tokenCan(Abilities::CreateEquipment)) {
            $userIdRule = [
                'required',
                'integer',
                'exists:users,id',
            ];
        }

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
            'data.attributes.user_id' => $userIdRule,
        ];
    }
}
