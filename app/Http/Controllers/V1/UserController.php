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
        $query = '123 Main Street';
        $usersWithAddresses = User::with('addresses')->paginate(10);
        return UserResource::collection($usersWithAddresses);
    }

    public function search(Request $request)
    {
        // $query = '123 Main Street';
        $query = $request->input('query');

        $usersWithAddresses = User::whereHas('addresses', function ($addressQuery) use ($query) {
            $addressQuery->where('street', 'like', '%' . $query . '%');
        })->with(['addresses' => function ($addressQuery) use ($query) {
            $addressQuery->where('street', 'like', '%' . $query . '%');
        }])->get();

        return UserResource::collection($usersWithAddresses);
    }
}
