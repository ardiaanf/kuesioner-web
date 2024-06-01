<?php

namespace App\Policies;

use App\Models\User;
use Illuminate\Support\Facades\Auth;

class PermissionPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user)
    {
        $user = Auth::user();
        if ($user->hasRole('admin')) {
            return true;
        }
    }
}
