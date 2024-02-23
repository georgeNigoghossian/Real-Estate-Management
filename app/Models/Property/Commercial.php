<?php

namespace App\Models\Property;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @method static create($data)
 */
class Commercial extends Model
{
    use HasFactory;

    public $fillable = [
        'property_id',
        'num_of_bathrooms',
        'num_of_balconies',
        'floor',
        'specialAttributes',
    ];

    protected $casts = [
        'specialAttributes' => 'array',
    ];

    public function property(): BelongsTo
    {
        return $this->belongsTo(Property::class,'property_id');
    }

    public function scopeSearch($query, $search = '')
    {
        return $query->whereHas('properties.property', function ($q) use ($search) {
            return $q->where('properties.name', 'LIKE', '%' . $search . '%');
        });
    }

    public function scopePriceLowerThan($query, $price)
    {
        return $query->whereHas('property', function ($q) use ($price) {
            return $q->where('price', '<', $price);
        });
    }

    public function scopePriceHigherThan($query, $price)
    {
        return $query->whereHas('property', function ($q) use ($price) {
            return $q->where('price', '>', $price);
        });
    }

    public function scopeAreaBiggerThan($query, $area)
    {
        return $query->whereHas('property', function ($q) use ($area) {
            return $q->where('area', '>', $area);
        });
    }

    public function scopeAreaSmallerThan($query, $area)
    {
        return $query->whereHas('property', function ($q) use ($area) {
            return $q->where('area', '<', $area);
        });
    }
}
