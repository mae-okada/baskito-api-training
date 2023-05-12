<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\User\StoreRequest;
use App\Http\Requests\Admin\User\UpdateRequest;
use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response as HttpResponse;
use Illuminate\Support\Facades\DB;
use Inertia\Inertia;
use Inertia\Response;
use Spatie\QueryBuilder\AllowedFilter;
use Spatie\QueryBuilder\QueryBuilder;

class UserController extends Controller
{
    public function index(Request $request): Response
    {
        $user  = auth_user();
        $users = collect();

        if ($user && $user->account) {
            $users = QueryBuilder::for($user->account->users())
                        ->allowedFilters($this->filters())
                        ->whereNotIn('id', [$user->id])
                        ->latest('id')
                        ->fastPaginate();
        }

        return Inertia::render('admin.user.index', [
            'users'  => UserResource::collection($users),
            'filter' => $request->query('filter', []),
        ]);
    }

    /**
     * @return array<int, string|\Spatie\QueryBuilder\AllowedFilter>
     */
    protected function filters(): array
    {
        return [
            AllowedFilter::callback('search', function ($query, string $value) {
                $value = trim($value);

                $query->where(function ($query) use ($value) {
                    $query->where('full_name', 'like', "%{$value}%");
                    $query->orWhere('email', 'like', "%{$value}%");
                });
            }),
        ];
    }

    public function create(): Response
    {
        return Inertia::render('admin.user.create');
    }

    public function store(StoreRequest $request): RedirectResponse
    {
        $user = new User($request->only([
            'first_name',
            'last_name',
            'email',
            'password',
            'owner',
        ]));

        $user->account()->associate(auth_user()?->account);
        $user->saveOrFail();

        if ($request->has('reload')) {
            return back();
        }

        return to_route('admin.user.edit', ['user' => $user->id]);
    }

    public function edit(User $user): Response
    {
        return Inertia::render('admin.user.edit', [
            'user' => UserResource::make($user),
        ]);
    }

    public function update(UpdateRequest $request, User $user): RedirectResponse
    {
        $user->fill($request->only([
            'first_name',
            'last_name',
            'email',
            'owner',
        ]));

        if ($request->filled('password')) {
            $user->fill($request->only(['password']));
        }

        $user->saveOrFail();

        return back();
    }

    public function destroy(User $user): HttpResponse
    {
        DB::transaction(function () use ($user) {
            $user->delete();
        });

        return response()->noContent();
    }
}
