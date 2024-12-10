<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Services\RequestLoggerService;

class RequestLogger
{
    public function handle(Request $request, Closure $next)
    {
        $response = $next($request);
        $user = Auth::user();

        if ($user) {
            $logger = app(RequestLoggerService::class);
            $logger->logRequest($user, $request);
        }

        return $response;
    }
}
