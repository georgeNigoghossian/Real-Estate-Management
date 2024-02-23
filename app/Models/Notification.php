<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

/**
 * @method static create(array $array)
 */
class Notification extends Model implements HasMedia
{
    use HasFactory, InteractsWithMedia;

    public $fillable = [
        'title',
        'body',
        'image'
    ];

    public function users(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'user_notifications');
    }
}
