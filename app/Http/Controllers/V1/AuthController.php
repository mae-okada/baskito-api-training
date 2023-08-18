<?php

namespace App\Http\Controllers\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\RegisterRequest;
use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    /**
     * Create user
     *
     */
    public function register(RegisterRequest $request)
    {
        $user = User::create($request->validated());
        return new UserResource($user);
    }

    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials)) {
            $user = Auth::user();
            $accessToken = $user->createToken('authToken');

            return response()->json([
                'token' => $accessToken->plainTextToken,
            ]);
        }

        return response()->json(['error' => 'Unauthorized'], 401);
    }
}
