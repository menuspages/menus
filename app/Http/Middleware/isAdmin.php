<?php

namespace App\Http\Middleware;

use App\Constants\MenuRequestStatus;
use App\Constants\Roles;
use App\Models\MenuRequest;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\View;

class isAdmin
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
        if(Auth::user() && Auth::user()->hasRole(Roles::ADMIN_ROLE)){
            $newMenuRequests = MenuRequest::where('status', MenuRequestStatus::NEW)->count();
            View::share ( 'newMenuRequests', $newMenuRequests);
            return $next($request);
        }
        Auth::logout();
        return redirect()->to('/login');
    }
}
