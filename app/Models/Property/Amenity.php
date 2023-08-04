<?php

namespace App\Models\Property;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @method static create($data)
 */
class Amenity extends Model
{
    use HasFactory;

    public $fillable = [
        'name',
        'description',
        'active',
        'amenity_type_id',
    ];

    public function type(): BelongsTo
    {
        return $this->belongsTo(AmenityType::class,'amenity_type_id');
    }

    public function scopeSearch($query, $search = '')
    {
        return $query->where('name', 'LIKE', '%' . $search . '%')
            ->orWhere('description', 'LIKE', '%' . $search . '%');
    }

    public function scopeActive($query)
    {
        return $query->where('active',true);
    }
}
