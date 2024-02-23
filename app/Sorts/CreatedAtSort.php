<?php

namespace App\Sorts;

use Spatie\QueryBuilder\Sorts\Sort;
use Illuminate\Database\Eloquent\Builder;

class CreatedAtSort implements Sort
{
    public function __invoke(Builder $query, bool $descending, string $property)
    {
        $direction = $descending ? 'DESC' : 'ASC';
        if ($property != 'properties') {
            $query->orderBy('$property.created_at', $direction);
        } else {
            $query->orderBy('created_at', $direction);
        }
    }
}
