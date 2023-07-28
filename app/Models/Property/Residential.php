<?php

namespace App\Models\Property;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @method static create($data)
 */
class Residential extends Property
{
    use HasFactory;

    public $fillable = [
        'property_id',
        'num_of_bedrooms',
        'num_of_bathrooms',
        'num_of_balconies',
        'num_of_living_rooms',
        'floor',
        'specialAttributes',
    ];


    public function property(): BelongsTo
    {
        return $this->belongsTo(Property::class);
    }

    public function scopeSortByPriority(){


    }
}
