<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Equipment extends Model
{
    protected $fillable = [
        'name',
        'category',
        'serial_number',
        'location',
        'status',
        'description',
    ];
}