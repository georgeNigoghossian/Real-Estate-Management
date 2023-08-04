<?php

namespace App\Models\Property;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tag extends Model
{
    use HasFactory;

    public $fillable = [
        'name',
        'active',
        'parent_id',
        'num_of_properties',
        'file',
    ];


    public function parent()
    {
        return $this->belongsTo(Tag::class, 'parent_id');
    }

    public function children()
    {
        return $this->hasMany(Tag::class, 'parent_id', 'id');
    }

    public function scopeSearch($query, $search = '')
    {
        return $query->where('name', 'LIKE', '%' . $search . '%');
    }

    public function scopeActive($query, $active)
    {
        return $query->where('active', $active);
    }
}
