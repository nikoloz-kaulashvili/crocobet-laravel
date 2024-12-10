<?php

namespace App\Http\Controllers;

use App\Models\UserToken;
use App\Services\UserTokenService;

class UserTokenController extends Controller
{
    protected $userTokenService;

    public function __construct(UserTokenService $userTokenService)
    {
        $this->userTokenService = $userTokenService;
    }

    public function store()
    {
        return $this->userTokenService->createToken();
    }

    public function delete(UserToken $token)
    {
        return $this->userTokenService->deleteToken($token);
    }
}