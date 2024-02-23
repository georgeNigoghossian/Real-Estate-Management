<?php

namespace App\Models\Property;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tag extends Model
{
    use HasFactory;

    public $fillable = [
        'name_en',
        'name_ar',
        'active',
        'property_type',
        'num_of_properties',
        'file',
    ];


    public $validation_rules = [
        'name_en'=>'required',
        'name_ar'=>'required',
        'property_type'=>'required',
        'document'=>'required',
    ];

}
