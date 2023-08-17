<?php

namespace App\Models;

use App\Models\Agency\Agency;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class AgencyRequest extends Model
{
    use HasFactory;

    protected $fillable = ['reason', 'user_id'];

    public $timestamps = false;

    public function user(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function agencies(): \Illuminate\Database\Eloquent\Relations\BelongsToMany
    {
        return $this->belongsToMany(Agency::class, 'agency_requests', 'agency_request_id','agency_id');
    }
}
