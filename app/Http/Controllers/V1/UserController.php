<?php

namespace App\Http\Controllers\V1;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\User;

class UserController extends Controller
{
    /**
     * Get a list of users along with their addresses.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function getUsersWithAddresses()
    {
        $usersWithAddresses = User::with('addresses')->get();
        dd($usersWithAddresses);
        return
    }
}
