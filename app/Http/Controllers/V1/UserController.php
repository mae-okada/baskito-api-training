<?php

namespace App\Http\Controllers\V1;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\LoginRequest;
use App\Http\Resources\Api\V1\UserResource;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

use Illuminate\Support\Facades\DB;

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

    public function update(LoginRequest $request)
    {
        $user = Auth::user();
        $user->update($request->validated());

        return response()->json($user);
    }

    public function delete()
    {
        DB::beginTransaction();
        $user = Auth::user();
        try {
            $deleted = $user->delete();

            if ($deleted) {
                DB::commit();
                return response()->json(["message" => "User deleted successfully"]);
            } else {
                DB::rollBack();
                return response()->json(["message" => "User deletion failed"]);
            }
        } catch (\Throwable $th) {
            DB::rollBack();

            return response()->json(["Delete user failed"]);
        }
    }

    public function userDetail()
    {
        $user = Auth::user();
        if ($user) {
            $userWithAddresses = User::with('addresses')->where('id', $user->id)->get();
            return UserResource::collection($userWithAddresses);
        } else {
            return response()->json(["message" => "User not found"], 404);
        }
    }
}
