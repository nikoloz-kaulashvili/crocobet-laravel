<?php

namespace App\Http\Controllers;

use App\Models\UserToken;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Str;

class UserTokenController extends Controller
{
    public function create(Request $request)
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

    public function delete(Request $request, UserToken $token)
    {
        if (!Gate::allows('delete-token', $token)) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        $token->delete();

        return response()->json(['message' => 'Token deleted successfully']);
    }
}