<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\City;

class HomeController extends Controller
{
    public function index()
    {
        $cities=City::query()->get();
        return view('landing-page.landing' , compact('cities'));
    }

    public function testTheme()
    {
        return view('landing-page.testTheme' );
    }
    public function download()
    {
        return view('landing-page.testTheme' );
    }
    

}
