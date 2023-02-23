<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\User\UpdateProfileRequest;
use Illuminate\Http\RedirectResponse;
use Inertia\Inertia;
use Inertia\Response;

class ProfileController extends Controller
{
    public function show(): Response
    {
        return Inertia::render('admin.profile.show', [
            'profile' => auth_user()?->only(['first_name', 'last_name', 'email', 'owner']),
        ]);
    }

    public function update(UpdateProfileRequest $request): RedirectResponse
    {
        auth_user()?->update($request->only([
            'first_name', 'last_name', 'email', 'owner',
        ]));

        return back()->with('message', 'Profile updated.');
    }
}
