<?php

namespace App\Models\Property;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SavedProperty extends Model
{
    use HasFactory;

    public $fillable = [
        'property_id',
        'user_id',
    ];


    public function property()
    {
        return $this->belongsTo(Property::class,'property_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class,'user_id');
    }
}
