<?php

namespace App\Policies\V1;

use App\Models\Equipment;
use App\Models\User;
use App\Permissions\V1\Abilities;

/**
 * Authorization rules for equipment.
 * The rules read the abilities stored in the user's JWT.
 */
class EquipmentPolicy
{
    /**
     * May this user create equipment?
     * Needs the broad or the "own" create ability.
     */
    public function store(User $user): bool
    {
        return $user->tokenCan(Abilities::CreateEquipment)
            || $user->tokenCan(Abilities::CreateOwnEquipment);
    }

    /**
     * May this user update this equipment (PATCH)?
     */
    public function update(User $user, Equipment $equipment): bool
    {
        // Broad ability: any equipment
        if ($user->tokenCan(Abilities::UpdateEquipment)) {
            return true;
        }

        // "Own" ability: only equipment the user owns
        if ($user->tokenCan(Abilities::UpdateOwnEquipment)) {
            return (int) $user->id === (int) $equipment->user_id;
        }

        return false;
    }

    /**
     * May this user replace this equipment (PUT)? Managers only.
     */
    public function replace(User $user, Equipment $equipment): bool
    {
        return $user->tokenCan(Abilities::ReplaceEquipment);
    }

    /**
     * May this user delete this equipment?
     */
    public function delete(User $user, Equipment $equipment): bool
    {
        // Broad ability: any equipment
        if ($user->tokenCan(Abilities::DeleteEquipment)) {
            return true;
        }

        // "Own" ability: only equipment the user owns
        if ($user->tokenCan(Abilities::DeleteOwnEquipment)) {
            return (int) $user->id === (int) $equipment->user_id;
        }

        return false;
    }
}
