<?php

namespace App\Services;

use App\Models\User;
use App\Models\UserToken;
use Illuminate\Http\Request;

class RequestLoggerService
{
    public function logRequest(User $user, Request $request): void
    {
        $token = $request->access_token ?? $this->extractBearerToken($request);

        $userToken = UserToken::where('access_token', $token)->firstOrFail();

        $user->requests()->create([
            'token_id' => $userToken->id,
            'request_method' => $request->method(),
            'request_params' => json_encode($request->all()),
        ]);

        $user->increment('requests_count');
    }

    private function extractBearerToken(Request $request): string
    {
        $authorizationHeader = $request->header('Authorization');

        if (!$authorizationHeader || !str_starts_with($authorizationHeader, 'Bearer ')) {
            throw new \Exception("Invalid or missing token.");
        }

        return substr($authorizationHeader, 7);
    }
}
