<?php

namespace App\Models\Property;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Commercial extends Model
{
    use HasFactory;

    public $fillable = [
        'property_id',
        'num_of_bathrooms',
        'num_of_balconies',
        'floor',
        'specialAttributes',
    ];


    public function property()
    {
        return $this->belongsTo(Property::class,'property_id');
    }
}
