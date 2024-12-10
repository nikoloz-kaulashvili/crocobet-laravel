<?php

namespace App\Services;

use App\Models\UserToken;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Str;
use Illuminate\Http\JsonResponse;

class UserTokenService
{
    /**
     * Create a new access token for the authenticated user.
     *
     * @return JsonResponse
     */
    public function createToken(): JsonResponse
    {
        if (!Gate::allows('create-token')) {
            return response()->json(['message' => 'User not verified'], 403);
        }

        $token = UserToken::create([
            'user_id' => Auth::id(),
            'access_token' => Str::random(30),
            'expires_at' => now()->addDays(30),
        ]);

        return response()->json(['token' => $token], 201);
    }

    /**
     * Delete an access token if authorized.
     *
     * @param UserToken $token
     * @return JsonResponse
     */
    public function deleteToken(UserToken $token): JsonResponse
    {
        if (!Gate::allows('delete-token', $token)) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        $token->delete();

        return response()->json(['message' => 'Token deleted successfully']);
    }
}
