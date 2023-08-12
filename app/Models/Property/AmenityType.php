<?php

namespace App\Models\Property;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AmenityType extends Model
{
    use HasFactory;

    public $fillable = [
        'name_en',
        'name_ar',
    ];

    public $validation_rules =[
        'name_en'=>'required',
        'name_ar'=>'required',
    ];
}
