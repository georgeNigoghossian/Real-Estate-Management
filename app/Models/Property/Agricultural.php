<?php

namespace App\Models\Property;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Agricultural extends Model
{
    use HasFactory;

    public $fillable =[
        'property_id',
        'specialAttributes',
    ];

    public function property()
    {
        return $this->belongsTo(Property::class,'property_id');
    }
}
