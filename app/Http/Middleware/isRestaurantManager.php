<?php

namespace App\Http\Middleware;

use App\Constants\Roles;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class isRestaurantManager
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        if(Auth::user()
            && Auth::user()->hasRole(Roles::RESTAURANT_MANAGER_ROLE)
            && $request->route('subdomain') === Auth::user()->restaurant->subdomain
            && !Auth::user()->restaurant->is_deleted
            && Auth::user()->restaurant->is_active
        ){
            return $next($request);
        }
        Auth::logout();
        return redirect()->to('/login');
    }
}
