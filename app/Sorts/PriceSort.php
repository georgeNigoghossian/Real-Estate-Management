<?php

namespace App\Sorts;

use Spatie\QueryBuilder\Sorts\Sort;
use Illuminate\Database\Eloquent\Builder;

class PriceSort implements Sort
{
    public function __invoke(Builder $query, bool $descending, string $property)
    {
        $direction = $descending ? 'DESC' : 'ASC';
        if ($property != 'properties') {
            $query->join('properties', 'properties.id', '=', $property . ".property_id")
                ->orderBy('properties.price', $direction);
        } else {
            $query->orderBy('price', $direction);
        }
    }
}
