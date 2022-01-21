<?php

namespace App\Http\Middleware;

use App\Models\Restaurant;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;

class isValidSubdomain
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

//        Log::info('This is some useful information.'.$request->getHttpHost());
        $restaurant = Restaurant::notDeleted()->active()->where('subdomain', $request->route('subdomain'))->first();

       if($restaurant) {
            View::share ( 'favIcon', $restaurant->logoUrl());
            return $next($request);
        }else{

          $url_host = $request->getHttpHost();
          $url_split_array = explode(".",$url_host)  ;
	  $url_name = $url_split_array[1];
          if(count( $url_split_array) == 2){
              $url_name = $url_split_array[0];
          }

         $restaurant = Restaurant::notDeleted()->active()->where('subdomain', $url_name)->first();
         if($restaurant) {
            View::share ( 'favIcon', $restaurant->logoUrl());
            return $next($request);
        }

   }
      return abort(404);
    }
}
