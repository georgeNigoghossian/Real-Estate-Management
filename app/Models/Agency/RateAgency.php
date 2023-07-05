<?php

namespace App\Models\Agency;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RateAgency extends Model
{
    use HasFactory;

    public $fillable = [
        'agency_id',
        'user_id',
        'rate',
        'rate_date',
    ];

    public function agency()
    {
        return $this->belongsTo(Agency::class,'agency_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class,'user_id');
    }
}
