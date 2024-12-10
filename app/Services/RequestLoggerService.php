<?php

namespace App\Services;

use App\Models\User;
use Illuminate\Http\Request;

class RequestLoggerService
{
    public function logRequest(User $user, Request $request): void
    {
        $user->requests()->create([
            'token_id' => 1,
            'request_method' => $request->method(),
            'request_params' => json_encode($request->all()),
        ]);
        
        $user->increment('requests_count');
    }
}