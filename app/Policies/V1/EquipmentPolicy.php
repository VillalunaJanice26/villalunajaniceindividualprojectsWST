<?php

namespace App\Policies\V1;

use App\Models\Equipment;
use App\Models\User;

/**
 * Authorization rules for equipment.
 */
class EquipmentPolicy
{
    /**
     * Check if the authenticated user owns the equipment.
     */
    public function update(User $user, Equipment $equipment): bool
    {
        // Allow update only if the user owns the equipment.
        return (int) $user->id === (int) $equipment->user_id;
    }
}
