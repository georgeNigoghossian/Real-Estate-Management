<?php

namespace App\Models\Location;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Country extends Model
{
    use HasFactory;

    public $fillable = [
      'name',
    ];
    public function cities()
    {
        return $this->hasMany(City::class);
    }
}
