<?php

namespace App\Policies;

use Spatie\Permission\Models\Role;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class RolePolicy
{

    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user)
    {
        $user = Auth::user();
        if ($user->hasRole('admin') || $user->hasPermissionTo('read_roles')) {
            return true;
        }
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Role $role)
    {
        if (Auth::user()->hasRole('admin') || Auth::user()->hasPermissionTo('show_roles')) {
            return true;
        }
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user)
    {
        if (Auth::user()->hasRole('admin') || Auth::user()->hasPermissionTo('create_roles')) {
            return true;
        }
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Role $role)
    {
        if (Auth::user()->hasRole('admin') || Auth::user()->hasPermissionTo('update_roles')) {
            return true;
        }
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Role $role)
    {
        if (Auth::user()->hasRole('admin') || Auth::user()->hasPermissionTo('delete_roles')) {
            return true;
        }
    }
}
