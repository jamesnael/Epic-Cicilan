<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

class CheckUserAccess
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
        if (! $request->expectsJson()) {
            $route_name = Route::currentRouteName();
            $route_name = str_replace('table', 'index', $route_name);
            $route_name = str_replace('store', 'create', $route_name);
            $route_name = str_replace('data', 'edit', $route_name);

            if (!in_array($route_name, Auth::user()->role ? Auth::user()->role->user_access : []) && !Auth::user()->is_admin) {
                abort(401);
            }

        } else {
            $route_name = Route::currentRouteName();
            $route_name = str_replace('api.', '', $route_name);
            $route_name = str_replace('table', 'index', $route_name);
            $route_name = str_replace('store', 'create', $route_name);
            $route_name = str_replace('data', 'edit', $route_name);
            
            if (!in_array($route_name, Auth::user()->role ? Auth::user()->role->user_access : [])) {
                abort(404);;
            }

        }
        
        return $next($request);
    }
}
