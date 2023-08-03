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
        'file',
    ];

    public function type(): BelongsTo
    {
        return $this->belongsTo(AmenityType::class,'amenity_type_id');
    }

}
