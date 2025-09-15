<?php

namespace App\Policies;

use App\Models\Monitoring;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class MonitoringPolicy
{
    use HandlesAuthorization;

    public function view(User $user, Monitoring $monitoring)
    {
        return $user->id === $monitoring->user_id;
    }

    public function create(User $user)
    {
        return true;
    }

    public function update(User $user, Monitoring $monitoring)
    {
        return $user->id === $monitoring->user_id;
    }

    public function delete(User $user, Monitoring $monitoring)
    {
        return $user->id === $monitoring->user_id;
    }
}
