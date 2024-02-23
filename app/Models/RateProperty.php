<?php

namespace App\Models;

use App\Models\Property\Property;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RateProperty extends Model
{
    use HasFactory;

    protected $table = 'rate_property';

    protected $fillable = [
        'rate',
        'review',
        'property_id',
        'user_id'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function property()
    {
        return $this->belongsTo(Property::class);
    }
}
