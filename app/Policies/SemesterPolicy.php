<?php

namespace App\Policies;

use App\Models\Semester;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class SemesterPolicy
{
    use HandlesAuthorization;

    public function viewAny(User $user)
    {
        return true;
    }

    public function view(User $user, Semester $semester)
    {
        return $user->id === $semester->user_id;
    }

    public function create(User $user)
    {
        return true;
    }

    public function update(User $user, Semester $semester)
    {
        return $user->id === $semester->user_id;
    }

    public function delete(User $user, Semester $semester)
    {
        return $user->id === $semester->user_id;
    }

    public function generateSchedule(User $user, Semester $semester)
    {
        return $user->id === $semester->user_id;
    }
}
