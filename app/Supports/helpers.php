<?php

if (! function_exists('auth_user')) {
    /**
     * Get user model from auth.
     *
     * @return \App\Models\User|null
     */
    function auth_user()
    {
        return auth()->user();
    }
}
