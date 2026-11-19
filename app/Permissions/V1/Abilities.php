<?php

namespace App\Permissions\V1;

use App\Models\User;

/**
 * Every ability name in one place, plus the rule that decides who receives which.
 * Format: resource:action. "own" means only for things I own.
 */
final class Abilities
{
    // Equipment abilities
    public const CreateEquipment = 'equipment:create';
    public const CreateOwnEquipment = 'equipment:own:create';
    public const UpdateEquipment = 'equipment:update';
    public const UpdateOwnEquipment = 'equipment:own:update';
    public const ReplaceEquipment = 'equipment:replace';
    public const DeleteEquipment = 'equipment:delete';
    public const DeleteOwnEquipment = 'equipment:own:delete';

    // User management abilities (managers only)
    public const CreateUser = 'user:create';
    public const UpdateUser = 'user:update';
    public const ReplaceUser = 'user:replace';
    public const DeleteUser = 'user:delete';

    /**
     * Returns the list of abilities a user receives.
     * The list is written into the JWT at login.
     */
    public static function getAbilities(User $user): array
    {
        // Managers may act on anything
        if ($user->is_manager) {
            return [
                self::CreateEquipment,
                self::UpdateEquipment,
                self::ReplaceEquipment,
                self::DeleteEquipment,
                self::CreateUser,
                self::UpdateUser,
                self::ReplaceUser,
                self::DeleteUser,
            ];
        }

        // Regular users may only act on their own equipment
        return [
            self::CreateOwnEquipment,
            self::UpdateOwnEquipment,
            self::DeleteOwnEquipment,
        ];
    }
}

