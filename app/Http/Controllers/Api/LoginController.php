<?php

namespace App\Http\Controllers\Api;

use App\Constants\AppSettings;
use App\Constants\Roles;
use App\Constants\Themes;
use App\Helpers\UrlHelper;
use App\Http\Controllers\Controller;
use App\Http\Requests\LoginRequest;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use App\Models\User;
use App\Models\Restaurant;
class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {

    }
    public function login(Request $request)
    {
        if (Auth::attempt(['email' => $request["email"], 'password' => $request["password"]])) {
            
            $user = User::query()->where('email','=',$request["email"])->get();
            $restautrant = Restaurant::query()->where('manager_id','=',$user[0]["id"])->get();    
            $response = array(
                "user" => $user , 
                "restautrant" => $restautrant
            );
            return json_encode($response);
         }
         $returnData = array(
            'status' => 'error',
            'message' => 'An error occurred!'
        );
         return Response::json($returnData, 500);
       
    }
}
