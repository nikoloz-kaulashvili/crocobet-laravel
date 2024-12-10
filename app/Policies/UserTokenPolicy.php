<?php

namespace App\Policies;

use App\Models\User;
use App\Models\UserToken;

class UserTokenPolicy
{
    public function delete(User $user, UserToken $token)
    {
        return $user->id === $token->user_id;
    }
}