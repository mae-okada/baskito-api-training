<?php

namespace App\Http\Controllers\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\RegisterRequest;
use App\Models\User;
use Illuminate\Http\Request;

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
}
