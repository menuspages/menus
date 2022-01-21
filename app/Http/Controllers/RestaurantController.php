<?php

namespace App\Http\Controllers;

use App\Constants\Roles;
use App\Helpers\ImageUploader;
use App\Http\Requests\CreateRestaurantRequest;
use Illuminate\Http\Request;
use App\Http\Requests\UpdateRestaurantRequest;
use App\Models\Restaurant;
use App\Models\User;
use App\Models\City;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class RestaurantController extends Controller
{

    public function index()
    {
       
        try {

            $restaurants = Restaurant::notDeleted()->orderBy('created_at', 'desc')->latest()->paginate(10);

            return response()->view('admin.restaurants.index', [
                'restaurants' => $restaurants,
                'title' => 'كل المتاجر'
            ]);
          
          } catch (\Exception $e) {
          
              return $e->getMessage();
          }

      
    }

    public function add_cities()
    {
         $city = new City;
          if(isset($_GET["id"]))
          {
              $id = $_GET["id"];
              $city=City::find($id);
          }  
          return response()->view('admin.cities.add' , ['city'=>$city]);
    }

    public function delete_cities()
    {
        $id = $_GET["id"];
        City::where('id' , $id)->delete();
        $arr=[];
        $arr['message'] = "deleted successfully";  
        return response()->json($arr, 200);
    }

    public function add_cities_post(Request $request)
    {
        $this->validate($request, [
            'name' => 'required|max:255',
            'image' => 'required',
        ]);
        
        $image = base64_encode(file_get_contents($request->file('image')));
        $city = new City;
        if($request["id"] > 0)
        {
            $city=City::find($request["id"]);  
        }    

        $city->name = $request["name"];
        $city->image = $image;
        $city->save();
        
        return redirect('/cities/add-cities');
    }

    public function cities()
    {
     
     $cities = City::query()->get();   
    return response()->view('admin.cities.index' , ['cities' => $cities] );
    }

    public function create()
    {
        return response()->view('admin.restaurants.create', ['title' => 'انشاء متجر جديد']);
    }

    public function store(CreateRestaurantRequest $request)
    {
        DB::transaction(function () use ($request) {
            $restaurant = $this->createRestaurant($request);
            $user = User::create([
                'name' => ucwords($request->username),
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'restaurant_id' => $restaurant->id
            ]);
            $user->attachRole(Roles::RESTAURANT_MANAGER_ROLE);
            $restaurant->attachManager($user);
        });
        session()->flash('success', 'تم انشاء المتجر بنجاح');
        return redirect()->back();
    }

    private function createRestaurant(CreateRestaurantRequest $request)
    {
        $path = ImageUploader::handle($request->file('logo'), 'logos');
        return Restaurant::create($this->constructRestaurantFieldsArray($request, $path));
    }

    private function constructRestaurantFieldsArray($request, $path, $restaurant = null)
    {
        return [
            'name' => ucwords($request->input('name')),
            'description' => $request->input('description'),
            'subdomain' => strtolower($request->input('subdomain')),
            'logo_path' => $path,
            'evaluation_enabled' => $request->input('evaluation_enabled'),
            'enable_component' => (integer)$request->input('enable_component'),
            'is_active' => (integer)$request->input('is_active'),
            'available_themes' => json_encode($request->input('available_themes')),
            'current_theme' => ($restaurant && in_array($restaurant->current_theme, $request->input('available_themes')))? $restaurant->current_theme: intval($request->input('available_themes')[0]),
        ];
    }

    public function show($subdomain)
    {
        $restaurant = $this->getRestaurant($subdomain);
        return response()->view('admin.restaurants.show', ['title' => $restaurant->name, 'restaurant' => $restaurant]);
    }

    private function getRestaurant($subdomain)
    {
        $restaurant = Restaurant::notDeleted()->where('subdomain', $subdomain)->first();
        if (!$restaurant) {
            return abort(404);
        }
        return $restaurant;
    }

    public function edit($subdomain)
    {
        $restaurant = $this->getRestaurant($subdomain);
        return response()->view('admin.restaurants.edit', ['title' => $restaurant->name, 'restaurant' => $restaurant]);
    }

    public function update(UpdateRestaurantRequest $request, $subdomain)
    {
        $restaurant = $this->getRestaurant($subdomain);
        if ($request->file('logo')) {
            $path = ImageUploader::handle($request->file('logo'), 'logos');
            ImageUploader::deleteExistingImage($restaurant->logo_path);
        }
        $restaurant->update($this->constructRestaurantFieldsArray($request, isset($path) ? $path : $restaurant->logo_path, $restaurant));

        session()->flash('success', 'تم انشاء المتجر بنجاح');
        return redirect()->route('show-restaurant', $restaurant->subdomain);
    }

    public function destroy($subdomain)
    {
        $restaurant = $this->getRestaurant($subdomain);
        $restaurant->delete();
        session()->flash('success', 'تم حذف المتجر بنجاح');
        return redirect()->route('restaurants');
    }
}
