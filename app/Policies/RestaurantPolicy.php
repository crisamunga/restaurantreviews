<?php

namespace App\Policies;

use App\Models\Restaurant;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Support\Facades\Log;

class RestaurantPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any models.
     *
     * @param User $user
     * @return mixed
     */
    public function viewAny(User $user): bool
    {
        return true;
    }

    /**
     * Determine whether the user can view the model.
     *
     * @param User $user
     * @param Restaurant $restaurant
     * @return mixed
     */
    public function view(User $user, Restaurant $restaurant): bool
    {
        return true;
    }

    /**
     * Determine whether the user can create models.
     *
     * @param User $user
     * @return mixed
     */
    public function create(User $user): bool
    {
        return $user->is_owner || $user->is_admin;
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param User $user
     * @param Restaurant $restaurant
     * @return mixed
     */
    public function update(User $user, Restaurant $restaurant): bool
    {
        return $user->is_admin || ($user->is_owner && $restaurant->user_id == $user->id);
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param User $user
     * @param Restaurant $restaurant
     * @return mixed
     */
    public function delete(User $user, Restaurant $restaurant): bool
    {
        return $user->is_admin || ($user->is_owner && $restaurant->user_id == $user->id);
    }

    /**
     * Determine whether the user can restore the model.
     *
     * @param User $user
     * @param Restaurant $restaurant
     * @return mixed
     */
    public function restore(User $user, Restaurant $restaurant): bool
    {
        return $user->is_admin || ($user->is_owner && $restaurant->user_id == $user->id);
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @param User $user
     * @param Restaurant $restaurant
     * @return mixed
     */
    public function forceDelete(User $user, Restaurant $restaurant)
    {
        return $user->is_admin;
    }
}
