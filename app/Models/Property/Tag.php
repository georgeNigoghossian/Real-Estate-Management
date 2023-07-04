<?php

namespace App\Models\Property;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tag extends Model
{
    use HasFactory;

    public $fillable = [
        'name',
        'active',
        'parent_id',
        'num_of_properties',
    ];


    public function parent()
    {
        return $this->belongsTo(Tag::class,'parent_id');
    }
}
