<?php

namespace App\Providers;

use Illuminate\Contracts\Auth\UserProvider;
use Illuminate\Contracts\Auth\Authenticatable;

class AccessTokenProvider implements UserProvider
{
    protected $model;

    public function __construct($model)
    {
        $this->model = $model;
    }

    public function retrieveById($identifier)
    {
        return $this->createModel()->newQuery()->find($identifier);
    }

    public function retrieveByToken($identifier, $token)
    {
        return $this->createModel()->newQuery()
            ->where('access_token', $token)
            ->first();
    }

    public function updateRememberToken(Authenticatable $user, $token)
    {
        // 
    }

    public function retrieveByCredentials(array $credentials)
    {
        return $this->createModel()->newQuery()
            ->where('email', $credentials['email'])
            ->first();
    }

    public function validateCredentials(Authenticatable $user, array $credentials)
    {
        return password_verify($credentials['password'], $user->getAuthPassword());
    }

    protected function createModel()
    {
        return new $this->model;
    }
}