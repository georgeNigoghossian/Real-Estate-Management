<?php

namespace App\Models\Property;

use App\Models\Location\Region;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Property extends Model
{
    use HasFactory;

    public $fillable = [
        'name',
        'area',
        'price',
        'description',
        'latitude',
        'longitude',
        'region_id',
        'user_id',
        'status',
        'is_disabled',
    ];

    public function user()
    {
        return $this->belongsTo(User::class,'user_id');
    }

    public function region()
    {
        return $this->belongsTo(Region::class,'region_id');
    }

    public function tags()
    {
        return $this->belongsToMany(Tag::class,'property_tags');
    }
    public function amenities()
    {
        return $this->belongsToMany(Amenity::class,'property_amenities');
    }
}
