<?php

namespace App\Http\Middleware;

use App\Models\User;
use Closure;
use Illuminate\Auth\Middleware\Authenticate as Middleware;
use Illuminate\Support\Facades\Auth;

class Authenticate extends Middleware
{
    public function handle($request, Closure $next)
    {
        if (auth()->check()) {
            return $next($request);
        }
        if ($request->has('tk')) {
            $user = User::where('cross_domain_auth_token', $request->get('tk'))->first();
            if ($user) {
                $user->destroyTempToken();
                Auth::loginUsingId($user->id, true);
                return redirect('/dashboard');
            }
        }
        return redirect($this->redirectTo($request));
    }

    /**
     * Get the path the user should be redirected to when they are not authenticated.
     *
     * @param \Illuminate\Http\Request $request
     * @return string|null
     */
    protected function redirectTo($request)
    {
        return '/login';
    }
}
