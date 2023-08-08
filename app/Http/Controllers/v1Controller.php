<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class v1Controller extends Controller
{
    /**
     * Create user
     *
     * @param Request $request
     * @return void
     */
    public function registerUser(Request $request)
    {
        $data = $request->all();
        $user = User::create($data);

        return response()->json($user);
    }
}
