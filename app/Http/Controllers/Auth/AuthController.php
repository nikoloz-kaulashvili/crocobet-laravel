<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;

use App\Http\Requests\RegisterRequest;
use App\Http\Requests\LoginRequest;
use App\Services\AuthService;
use Illuminate\Http\JsonResponse;

class AuthController extends Controller
{
    protected $authService;

    public function __construct(AuthService $authService)
    {
        $this->authService = $authService;
    }

    public function register(RegisterRequest $request): JsonResponse
    {
        $response = $this->authService->register($request->validated());
        return response()->json($response, 201);
    }

    public function login(LoginRequest $request): JsonResponse
    {
        $response = $this->authService->login($request->validated());

        if (isset($response['error'])) {
            return response()->json(['message' => $response['error']], $response['status']);
        }

        return response()->json($response);
    }
}
