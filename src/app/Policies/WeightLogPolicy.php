<?php

namespace App\Policies;

use App\Models\User;
use App\Models\WeightLog;
use Illuminate\Auth\Access\HandlesAuthorization;

class WeightLogPolicy
{
    use HandlesAuthorization;

    public function create(User $user)
    {
        return $user !== null;
    }

    public function update(User $user, WeightLog $weightLog)
    {
        return $user->id === $weightLog->user_id;
    }

    public function delete(User $user, WeightLog $weightLog)
    {
        return $user->id === $weightLog->user_id;
    }

    public function view(User $user, WeightLog $weightLog)
    {
        return $user->id === $weightLog->user_id;
    }
}
