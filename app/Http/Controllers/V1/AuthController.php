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
        $data = $request->validated();
        $name = explode(' ', $data['name']);

        User::create([
            'first_name'    => $name['0'],
            'last_name'     => $name['1'],
            'email'         => $data['email'],
            'password'      => $data['password'],
        ]);
    }
}
