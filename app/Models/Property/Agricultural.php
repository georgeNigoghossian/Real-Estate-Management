<?php

namespace App\Models\Property;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @method static create($data)
 */
class Agricultural extends Model
{
    use HasFactory;

    public $fillable =[
        'property_id',
        'specialAttributes',
    ];

    public function property(): BelongsTo
    {
        return $this->belongsTo(Property::class,'property_id');
    }
}
