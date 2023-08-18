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
    public function index(Request $request)
    {
        $query = $request->input('query');

        $usersWithAddresses = User::when($query, function ($queryBuilder) use ($query) {
            $queryBuilder->whereHas('addresses', function ($addressQuery) use ($query) {
                $addressQuery->where('street', 'like', '%' . $query . '%');
            });
        })->with('addresses')->paginate(10);

        return UserResource::collection($usersWithAddresses);
    }


    public function update(LoginRequest $request)
    {
        $user = Auth::user();
        $user->update($request->validated());

        return response()->json($user);
    }

    public function delete(Request $request)
    {
        DB::beginTransaction();
        $user = $request->user();
        // dd($user->loadMissing('addresses'));
        try {
            $user->delete();
            DB::commit();
            return response()->json(["message" => "User deleted successfully"]);
        } catch (\Throwable $th) {
            DB::rollBack();
            return response()->throw();
        }
    }

    public function userDetail()
    {
        $user = Auth::user();
        if ($user) {
            $userWithAddresses = User::with('addresses')->where('id', $user->id)->first();
            return new UserResource($userWithAddresses);
        } else {
            return response()->json(["message" => "User not found"], 404);
        }
    }
}
