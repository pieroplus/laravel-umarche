<?php

namespace App\Http\Middleware;

use Illuminate\Auth\Middleware\Authenticate as Middleware;
use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;

class Authenticate extends Middleware
{
    protected $userRoute = 'user.login';
    protected $ownerRoute = 'owner.login';
    protected $adminRoute = 'admin.login';

    /**
     * Get the path the user should be redirected to when they are not authenticated.
     */
    protected function redirectTo(Request $request): ?string
    {
        if (!$request->expectsJson()) {
            if (Route::is('owner.*')) {
                return route($this->ownerRoute);
            }
            if (Route::is('admin.*')) {
                return route($this->adminRoute);
            }
            return route($this->userRoute);
        }
        // return $request->expectsJson() ? null : route('login');
    }
}
