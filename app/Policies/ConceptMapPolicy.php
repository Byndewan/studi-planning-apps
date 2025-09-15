<?php

namespace App\Policies;

use App\Models\ConceptMap;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class ConceptMapPolicy
{
    use HandlesAuthorization;

    public function view(User $user, ConceptMap $conceptMap)
    {
        return $user->id === $conceptMap->user_id;
    }

    public function create(User $user)
    {
        return true;
    }

    public function update(User $user, ConceptMap $conceptMap)
    {
        return $user->id === $conceptMap->user_id;
    }

    public function delete(User $user, ConceptMap $conceptMap)
    {
        return $user->id === $conceptMap->user_id;
    }
}
