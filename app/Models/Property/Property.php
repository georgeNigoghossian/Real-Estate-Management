<?php

namespace App\Models\Property;

use App\Models\Location\Region;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

/**
 * @method static create($data)
 * @method static find($id)
 */
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

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function region(): BelongsTo
    {
        return $this->belongsTo(Region::class, 'region_id');
    }

    public function tags(): BelongsToMany
    {
        return $this->belongsToMany(Tag::class, 'property_tags');
    }

    public function amenities(): BelongsToMany
    {
        return $this->belongsToMany(Amenity::class, 'property_amenities');
    }

    public function agricultural(): HasOne
    {
        return $this->hasOne(Agricultural::class);
    }

    public function residential(): HasOne
    {
        return $this->hasOne(Residential::class);
    }

    public function commercial(): HasOne
    {
        return $this->hasOne(Commercial::class);
    }
}
