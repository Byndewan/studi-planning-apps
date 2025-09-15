<?php

namespace App\Policies;

use App\Models\SQ3RSession;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class SQ3RSessionPolicy
{
    use HandlesAuthorization;

    public function view(User $user, SQ3RSession $sq3rSession)
    {
        return $user->id === $sq3rSession->user_id;
    }

    public function create(User $user)
    {
        return true;
    }

    public function update(User $user, SQ3RSession $sq3rSession)
    {
        return $user->id === $sq3rSession->user_id;
    }

    public function delete(User $user, SQ3RSession $sq3rSession)
    {
        return $user->id === $sq3rSession->user_id;
    }
}
