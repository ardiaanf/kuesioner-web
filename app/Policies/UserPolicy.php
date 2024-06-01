<?php

namespace App\Policies;

use Spatie\Permission\Models\Role;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class UserPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user)
    {
        if (Auth::user()->hasRole('admin') || Auth::user()->hasPermissionTo('read_users')) {
            return true;
        }
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, User $model)
    {
        if (Auth::user()->hasRole('admin') || Auth::user()->hasPermissionTo('show_users')) {
            return true;
        }
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user)
    {
        if (Auth::user()->hasRole('admin') || Auth::user()->hasPermissionTo('create_users')) {
            return true;
        }
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, User $model)
    {
        if (Auth::user()->hasRole('admin') || Auth::user()->hasPermissionTo('update_users')) {
            return true;
        }
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, User $model)
    {
        if (Auth::user()->hasRole('admin') || Auth::user()->hasPermissionTo('delete_users')) {
            return true;
        }
    }
}
