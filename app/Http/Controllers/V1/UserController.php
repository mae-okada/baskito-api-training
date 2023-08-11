<?php

namespace App\Http\Controllers\V1;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\Api\V1\UserResource;
use App\Models\User;

class UserController extends Controller
{
    /**
     * Get a list of users along with their addresses.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        $usersWithAddresses = User::with('addresses')->paginate(10);
        return UserResource::collection($usersWithAddresses)->whereIn('id', [1]);
    }
}
