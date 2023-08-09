<?php

namespace App\Http\Controllers\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\RegisterRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    /**
     * Create user
     *
     * @param Request $request
     * @return void
     */
    public function register(RegisterRequest $request)
    {
        $request->validated();
        $name = explode(' ', $request['name'], 2);

        $user = User::create([
            'first_name'    => $name['0'],
            'last_name'     => $name['1'],
            'email'         => $request['email'],
            'password'      => $request['password'],
        ]);

        return response()->json($user);
    }

    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials)) {
            $user = Auth::user();
            $accessToken = $user->createToken('authToken')->accessToken;

            return response()->json([
                'access_token'  => $accessToken,
                'token_type'    => 'bearer',
                'user'          => $user,
            ]);
        }

        return response()->json(['error' => 'Unauthorized'], 401);
    }
}
