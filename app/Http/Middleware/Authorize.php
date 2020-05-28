<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

class Authorize
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $routeName =  Route::current()->getName();
        if (Auth::user()->hasPermissionTo($routeName))
        {
            return $next($request);
        }else {
            return redirect()->route('login');
        }
    }
}
