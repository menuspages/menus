<?php

namespace App\Http\Middleware;

use App\Models\Restaurant;
use Closure;
use Illuminate\Http\Request;

class isOrderRestaurant
{
    /**
     * Handle an incoming request.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Closure $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        if ($subdomain = $request->route('subdomain')) {
            $restaurant = Restaurant::where('subdomain', $subdomain)->where('enable_component', 1)->first();
            if ($restaurant) {
                $request->attributes->add(['restaurant' => $restaurant]);
                return $next($request);
            }
        }
        return abort(404);
    }
}
