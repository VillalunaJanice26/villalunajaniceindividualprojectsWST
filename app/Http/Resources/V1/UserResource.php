<?php

namespace App\Http\Resources\V1;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'type' => 'user',
            'id' => $this->id,
            'attributes' => [
                'name' => $this->name,
                'email' => $this->email,
                'isManager' => $this->is_manager,

                $this->mergeWhen($request->routeIs(['users.*']), [
                    'emailVerifiedAt' => $this->email_verified_at,
                    'createdAt' => $this->created_at,
                    'updatedAt' => $this->updated_at,
                ]),
            ],

            // Equipment appears only when requested with ?include=equipments
            'includes' => EquipmentResource::collection(
                $this->whenLoaded('equipments')
            ),

            'links' => [
                'self' => route('users.show', ['user' => $this->id]),
            ],
        ];
    }
}
