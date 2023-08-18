<?php

namespace App\Models\Property;

use App\Models\Location\City;
use App\Models\Location\Country;
use App\Models\Location\Region;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

/**
 * @method static create($data)
 * @method static find($id)
 */
class Property extends Model implements HasMedia
{
    use HasFactory, InteractsWithMedia;

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
        'service',
        'is_disabled',
    ];

    protected $appends = ['type'];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function city(): BelongsTo
    {
        return $this->belongsTo(City::class);
    }

    public function country(): BelongsTo
    {
        return $this->belongsTo(Country::class);
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

    public function savedUsers(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'saved_properties');
    }

    public function getTypeAttribute(): string
    {
        if ($this->commercial()->exists()) {
            return 'commercial';
        }
        if ($this->agricultural()->exists()) {
            return 'agricultural';
        }
        if ($this->residential()->exists()) {
            return 'residential';
        }
        return '';
    }

    public function scopeSearch($query, $search = '')
    {
        return $query->where('properties.name', 'LIKE', '%' . $search . '%')
            ->orWhere('properties.description', 'LIKE', '%' . $search . '%');
    }

    public function scopeRegion($query, $search = '')
    {
        return $query->whereHas('region', function ($q) use ($search) {
            return $q->where('name', 'LIKE', '%' . $search . '%');
        });
    }

    public function scopePriceLowerThan($query, $price)
    {
        return $query->where('price', '<', $price);
    }

    public function scopePriceHigherThan($query, $price)
    {
        return $query->where('price', '>', $price);
    }

    public function scopeAreaBiggerThan($query, $area)
    {
        return $query->where('area', '>', $area);
    }

    public function scopeAreaSmallerThan($query, $area)
    {
        return $query->where('area', '<', $area);
    }

    public function scopePropertyType($query, $type)
    {
        return $query->whereHas($type);
    }

    public function scopePropertyService($query, $service)
    {
        return $query->where('service', '=', $service);
    }

    public function scopeCity($query, $city_id)
    {
        return $query->whereHas('city', function ($q) use ($city_id) {
            $q->where('id', '=', $city_id);
        });
    }

    public function scopeCountry($query, $country_id)
    {
        return $query->whereHas('country', function ($q) use ($country_id) {
            $q->where('id', '=', $country_id);
        });
    }

    public function scopeMyProperties($query, $user)
    {
        return $query->whereRelation('user', 'id', '=', $user);
    }

    public function scopeMyFavorites($query, $user)
    {
        return $query->whereHas('savedUsers', function ($q) use ($user) {
            return $q->where('user_id', '=', $user);
        });
    }

    public function scopeWithTags($query, ...$tags)
    {
        return $query->whereHas('tags', function ($q) use ($tags) {
            $q->whereIn('tags.id', $tags);
        });
    }

    public function scopeWithAmenities($query, ...$tags)
    {
        return $query->whereHas('amenities', function ($q) use ($tags) {
            $q->whereIn('amenities.id', $tags);
        });
    }
}
