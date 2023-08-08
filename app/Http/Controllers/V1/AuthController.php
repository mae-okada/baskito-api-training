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
        // dd($request);

        // pakai validasi foarm request
        // pakai validated()
        $data = $request->validated();
        dd($data);
        $user = User::create($data);

        // tidak perlu pakai return data (sesuai dengan contoh)
        return response()->json($user);

        // nanti ganti nama folder sama router nya jadi V1 (huruf kapital)
    }
}
