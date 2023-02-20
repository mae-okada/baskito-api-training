<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
{
    /**
     * The resource instance.
     *
     * @var \App\Models\User
     */
    public $resource;

    public static $wrap = null;

    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array<string, mixed>
     */
    public function toArray($request)
    {
        $user = $this->resource;

        return [
            'id'    => $user->id,
            'first_name' => $user->first_name,
            'last_name'  => $user->last_name,
            'name'  => $user->name,
            'email' => $user->email,
            'owner' => $user->owner,
            'created_at' => $user->created_at,
        ];
    }
}
