<?php

namespace App\Models;

use App\Http\Filters\V1\EquipmentFilter;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Equipment extends Model
{
    protected $fillable = [
        'name',
        'category',
        'serial_number',
        'location',
        'status',
        'description',
        'user_id',
    ];

    // Author Relationship
    public function author(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    // Filter Scope
    public function scopeFilter($query, EquipmentFilter $filters)
    {
        return $filters->apply($query);
    }
}
