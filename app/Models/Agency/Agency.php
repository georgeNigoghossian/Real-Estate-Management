<?php

namespace App\Models\Agency;

use App\Models\Location\Region;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class Agency extends Model implements HasMedia
{
    use HasFactory, InteractsWithMedia;

    public $fillable = [
        'name',
        'region_id',
        'created_by',
        'rate',
        'is_verified',
        'contact_info',
        'latitude',
        'longitude',
    ];

    public $casts = [
        'contact_info' => 'array'
    ];

    public function creator()
    {
        return $this->belongsTo(User::class,'created_by');
    }

    public function region()
    {
        return $this->belongsTo(Region::class,'region_id');
    }
}
