<?php

namespace App\Services;

use App\Models\User;
use App\Models\UserToken;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class AuthService
{
    public function register(array $data)
    {
        $user = User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
        ]);
        
        $token = UserToken::create([
            'user_id' => $user->id,
            'access_token' => bin2hex(random_bytes(UserToken::TOKEN_LENGTH)),
            'expires_at' => now()->addDays(UserToken::DAY_LENGTH),
        ]);

        return [
            'message' => 'User registered successfully',
            'access_token' => $token->access_token,
        ];
    }

    public function login(array $data)
    {
        $user = User::where('email', $data['email'])->first();

        if (!$user || !Hash::check($data['password'], $user->password)) {
            return [
                'error' => 'Invalid credentials',
                'status' => 401,
            ];
        }

        $token = UserToken::create([
            'user_id' => $user->id,
            'access_token' => bin2hex(random_bytes(UserToken::TOKEN_LENGTH)),
            'expires_at' => now()->addDays(UserToken::DAY_LENGTH),
        ]);

        return [
            'message' => 'Login successful',
            'access_token' => $token->access_token,
        ];
    }
}
