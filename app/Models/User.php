<?php

namespace App\Models;

use App\Http\Filters\V1\UserFilter;
use App\Permissions\V1\Abilities;
use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\Hidden;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use PHPOpenSourceSaver\JWTAuth\Contracts\JWTSubject;

#[Fillable(['name', 'email', 'password', 'is_manager'])]
#[Hidden(['password', 'remember_token'])]
class User extends Authenticatable implements JWTSubject
{
    /** @use HasFactory<UserFactory> */
    use HasFactory, Notifiable;

    // Equipment Relationship
    public function equipments(): HasMany
    {
        return $this->hasMany(Equipment::class);
    }

    // Singular Equipment Relationship for Scoped Binding
    public function equipment(): HasMany
    {
        return $this->hasMany(Equipment::class);
    }

    // Filter Scope
    public function scopeFilter($query, UserFilter $filters)
    {
        return $filters->apply($query);
    }

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'is_manager' => 'boolean',
        ];
    }

    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    public function getJWTCustomClaims(): array
    {
        return [
            'abilities' => Abilities::getAbilities($this),
        ];
    }

    public function tokenCan(string $ability): bool
    {
        try {
            $abilities = auth('api')->payload()->get('abilities') ?? [];
        } catch (\Throwable $e) {
            return false;
        }

        return in_array($ability, $abilities, true);
    }
}
