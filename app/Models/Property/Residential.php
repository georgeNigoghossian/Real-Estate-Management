<?php

namespace App\Models\Property;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @method static create($data)
 */
class Residential extends Model
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


    public function property()
    {
        return $this->belongsTo(Property::class,'property_id');
    }
}
