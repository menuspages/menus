<?php

namespace App\Http\Controllers\Auth;

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
        $this->middleware('guest')->except('logout');
    }

    public function showLoginForm()
    {
        $subdomain = is_null(request()->route('subdomain')) ? AppSettings::ADMIN_SUBDOMAIN : request()->route('subdomain');
           
        if ($subdomain === AppSettings::ADMIN_SUBDOMAIN) {
            
            return view('auth.login', [
                'backgroundImageUrl' => Themes::LOGIN_PAGE_BACKGROUND_IMAGE_PATH_ADMIN,
                'title' => 'المنيو الاليكتروني'
            ]);

        }
        
        return view('auth.login', [
            'backgroundImageUrl' => Themes::LOGIN_PAGE_BACKGROUND_IMAGE_PATH,
            'title' => 'المنيو الاليكتروني'
        ]);

    }

    protected function sendLoginResponse(Request $request)
    {
        $request->session()->regenerate();

        $this->clearLoginAttempts($request);

        $user = Auth::user();
        if ($user->hasRole(Roles::ADMIN_ROLE)) {
            return redirect()->intended(UrlHelper::constructRestaurantUrl(AppSettings::ADMIN_SUBDOMAIN));
        }
        if (!is_null($user->restaurant)) {
            if(is_null($request->route('subdomain'))){
                $user->generateTempToken();
                return redirect()->intended(UrlHelper::constructRestaurantUrl($user->restaurant->subdomain, '/dashboard?tk=' . $user->cross_domain_auth_token));
            }
            return redirect()->intended(UrlHelper::constructRestaurantUrl($user->restaurant->subdomain, '/dashboard'));

        }
        Auth::logout();
        $request->session()->flash('error', 'Invalid email or password');
        return response()->redirectTo('/login');
    }
}
