<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class File extends Model
{
    use HasFactory;

    public $fillable = [
        'module_type',
        'module_id',
        'url',
        'field',
    ];
}
