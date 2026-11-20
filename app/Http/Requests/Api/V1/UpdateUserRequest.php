<?php

namespace App\Http\Requests\Api\V1;

use Illuminate\Validation\Rule;

/**
 * Validates the body of PATCH /users/{user}.
 */
class UpdateUserRequest extends BaseUserRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'data' => 'sometimes|required|array',
            'data.attributes' => 'sometimes|required|array',
            'data.attributes.name' => 'sometimes|required|string',
            'data.attributes.email' => [
                'sometimes',
                'required',
                'email',
                Rule::unique('users', 'email')->ignore($this->route('user')),
            ],
            'data.attributes.isManager' => 'sometimes|required|boolean',
            'data.attributes.password' => 'sometimes|required|string|min:8',
        ];
    }
}
