<?php

namespace App\Policies;

use App\Models\Lawyer;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class LawyerPolicy
{
    public function update(User $user, Lawyer $lawyer): bool
    {
        return $user->id === $lawyer->user_id || $user->isAdmin();
    }

    public function delete(User $user, Lawyer $lawyer): bool
    {
        return $user->isAdmin();
    }

    public function view(User $user, Lawyer $lawyer): bool
    {
        return $lawyer->is_published || $user->isAdmin() || $user->id === $lawyer->user_id;
    }
}
