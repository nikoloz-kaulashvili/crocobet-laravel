<?php

namespace App\Guards;

use App\Providers\AccessTokenProvider;
use Illuminate\Contracts\Auth\Guard;
use Illuminate\Http\Request;

class AccessTokenGuard implements Guard
{
    protected $request;
    protected $provider;
    protected $user;

    public function __construct(AccessTokenProvider $provider, Request $request)
    {
        $this->provider = $provider;
        $this->request = $request;
    }

    public function user()
    {
        if (!is_null($this->user)) {
            return $this->user;
        }

        $token = $this->getToken();

        if ($token) {
            $this->user = $this->provider->retrieveByToken(null, $token);
        }
        return $this->user;
        
        if (!$this->user) {
            return response()->json(['message' => 'User not authorized'], 401);
        }

        return $this->user;
    }

    public function validate(array $credentials = [])
    {
        $user = $this->provider->retrieveByCredentials($credentials);

        if ($user && $this->provider->validateCredentials($user, $credentials)) {
            $this->user = $user;
            return true;
        }

        return false;
    }

    public function check()
    {
        return !is_null($this->user());
    }

    public function guest()
    {
        return !$this->check();
    }

    public function id()
    {
        return optional($this->user())->getAuthIdentifier();
    }

    public function setUser($user)
    {
        $this->user = $user;
    }

    public function hasUser()
    {
        return !is_null($this->user);
    }

    protected function getToken()
    {
        $token = $this->request->bearerToken();

        if (!$token) {
            $token = $this->request->query('access_token');
        }

        return $token;
    }
}
