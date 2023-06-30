<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Amenity extends Model
{
    use HasFactory;

    public $fillable = [
        'name',
        'description',
        'active',
        'amenity_type_id',
    ];

    public function type()
    {
        return $this->belongsTo(AmenityType::class,'amenity_type_id');
    }

}
