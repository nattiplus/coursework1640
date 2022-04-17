<?php

namespace App\Http\Middleware;

use Illuminate\Auth\Middleware\Authenticate as Middleware;
use Illuminate\Support\Facades\Auth;
use Closure;

class Authenticate extends Middleware
{
    /**
     * Get the path the user should be redirected to when they are not authenticated.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return string|null
     */
    // protected function redirectTo($request)
    // {
    //     if (! $request->expectsJson()) {
    //         return route('login');
    //     }
    // }

    public function handle($request, Closure $next, ...$guards)
    {
        // Check if user not login then redirect user to login page
        if(! Auth::check())
        {
            return \redirect()->route('login');
        }
        // If User login then get all user data
        $user = Auth::user();
        // Get Current Route
        $route = $request->route()->getName();
        // Check whether user have permission to access that route or not
        //dd(Auth::user()->can($route));
        if(Auth::user()->can($route))
        {
            return $next($request);
        }
        else
        {
            abort(403, 'Unauthorized action.');
        }
    }
}
