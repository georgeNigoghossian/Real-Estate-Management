<?php

namespace App\Policies;

use App\Models\Property\Property;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Auth\Access\Response;

class PropertyPolicy
{
    use HandlesAuthorization;


    /**
     * Determine whether the user can create models.
     *
     * @return Response|bool
     */
    public static function create(): Response|bool
    {
        $user = auth()->user();
        return $user->hasRole('client') || $user->hasRole('agency');
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param Property $property
     * @return Response|bool
     */
    public static function update(Property $property): Response|bool
    {
        $user = auth()->user();
        return $user->hasRole('admin') || $property->user->id == $user->id;
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param Property $property
     * @return bool
     */
    public static function delete(Property $property): bool
    {
        $user = auth()->user();
        return $user->hasRole('admin') || $property->user->id == $user->id;
    }

}
