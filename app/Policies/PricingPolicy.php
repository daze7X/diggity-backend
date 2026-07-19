<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Pricing;
use Illuminate\Auth\Access\Response;

class PricingPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $user->isSuperAdmin();
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Pricing $model): bool
    {
        return $user->isSuperAdmin();
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return $user->isSuperAdmin();
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Pricing $model): bool
    {
        return $user->isSuperAdmin();
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Pricing $model): bool
    {
        return $user->isSuperAdmin();
    }
}
