<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

/**
 * @method static create(array $array)
 */
class Notification extends Model
{
    use HasFactory;

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
