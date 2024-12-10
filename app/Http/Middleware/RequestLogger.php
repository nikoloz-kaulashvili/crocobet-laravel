<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\UserRequestLog;

class RequestLogger
{
    public function handle(Request $request, Closure $next)
    {
        $response = $next($request);
        $user = Auth::user();

        if ($user) {
            UserRequestLog::create([
                'user_id' => $user->id,
                'token_id' => 1, 
                'request_method' => $request->method(),
                'request_params' => json_encode($request),
            ]);

            $user->increment('requests_count');
        }

        return $response;
    }
}
