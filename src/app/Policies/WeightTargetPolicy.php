<?php

namespace App\Policies;

use App\Models\User;
use App\Models\WeightTarget;
use Illuminate\Auth\Access\HandlesAuthorization;

class WeightTargetPolicy
{
    use HandlesAuthorization;

    /**
     * Create a new policy instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }
}
