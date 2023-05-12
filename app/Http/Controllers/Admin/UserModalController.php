<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Resources\UserResource;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;
use Spatie\QueryBuilder\AllowedFilter;
use Spatie\QueryBuilder\QueryBuilder;

class UserModalController extends Controller
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

        return Inertia::render('admin.user.modal.index', [
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
}
