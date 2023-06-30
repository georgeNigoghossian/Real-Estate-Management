<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Agency extends Model
{
    use HasFactory;

    public $fillable = [
        'region_id',
        'created_by',
        'rate',
        'is_verified',
        'latitude',
        'longitude',
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
