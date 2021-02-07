<?php

namespace App\Policies;

use App\Models\Review;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class ReviewPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any models.
     *
     * @param User $user
     * @return mixed
     */
    public function viewAny(User $user) : bool
    {
        return true;
    }

    /**
     * Determine whether the user can view the model.
     *
     * @param User $user
     * @param Review $review
     * @return mixed
     */
    public function view(User $user, Review $review) : bool
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
        return true;
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param User $user
     * @param Review $review
     * @return mixed
     */
    public function update(User $user, Review $review)
    {
        return $user->is_admin;
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param User $user
     * @param Review $review
     * @return mixed
     */
    public function uncomment(User $user, Review $review)
    {
        return $user->is_admin;
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param User $user
     * @param Review $review
     * @return mixed
     */
    public function reply(User $user, Review $review)
    {
        return $user->is_owner && $review->restaurant->user_id == $user->id;
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param User $user
     * @param Review $review
     * @return mixed
     */
    public function delete(User $user, Review $review)
    {
        return $user->is_admin;
    }

    /**
     * Determine whether the user can restore the model.
     *
     * @param User $user
     * @param Review $review
     * @return mixed
     */
    public function restore(User $user, Review $review)
    {
        return $user->is_admin;
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @param User $user
     * @param Review $review
     * @return mixed
     */
    public function forceDelete(User $user, Review $review)
    {
        return $user->is_admin;
    }
}
