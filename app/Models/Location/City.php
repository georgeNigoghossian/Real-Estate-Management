<?php

namespace App\Models\Location;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class City extends Model
{
    use HasFactory;

    public $fillable = [
        'name',
        'country_id',
    ];
    public function country()
    {
        return $this->belongsTo(Country::class,'country_id');
    }

    public function regions()
    {
        return $this->hasMany(Region::class);
    }

}
