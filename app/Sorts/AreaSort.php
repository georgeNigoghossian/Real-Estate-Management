<?php

namespace App\Sorts;

use Spatie\QueryBuilder\Sorts\Sort;
use Illuminate\Database\Eloquent\Builder;

class AreaSort implements Sort
{
    public function __invoke(Builder $query, bool $descending, string $property)
    {
        $direction = $descending ? 'DESC' : 'ASC';
        if ($property != 'properties') {
            $query->join('properties', 'properties.id', '=', $property . ".property_id")
                ->orderBy('properties.area', $direction);
        } else {
            $query->orderBy('area', $direction);
        }
    }
}
