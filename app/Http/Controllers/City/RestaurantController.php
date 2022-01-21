<?php

namespace App\Http\Controllers\City;

use App\Helpers\ImageUploader;
use App\Helpers\UrlHelper;
use App\Http\Controllers\Controller;
use App\Http\Requests\CreateCategoryRequest;
use App\Http\Requests\UpdateCategoryRequest;
use App\Models\City\Cityrestaurant;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RestaurantController extends Controller
{
    public function index()
    {
        $restaurant =  Cityrestaurant::all();    
        return response()->view('admin.cities.resturant.index' , ["restaurant"=>$restaurant]);     
    }

  
    public function add()
    {
         $restaurant = new Cityrestaurant;
          if(isset($_GET["id"]))
          {
              $id = $_GET["id"];
              $restaurant=Cityrestaurant::find($id);
          }  
          return response()->view('admin.cities.resturant.add' , ['restaurant'=>$restaurant]);
    }

    public function delete()
    {
        $id = $_GET["id"];
        Cityrestaurant::where('id' , $id)->delete();
        $arr=[];
        $arr['message'] = "deleted successfully";  
        return response()->json($arr, 200);
    }

    public function add_post(Request $request)
    {
        $this->validate($request, [
            'name' => 'required',
            'description' => 'required',
            'menu_link' => 'required',
            'map_link' => 'required',
            'phone' => 'required',
            
        ]);
      
        $restaurant = new Cityrestaurant;
        if($request["id"] > 0)
        {
            $restaurant=Cityrestaurant::find($request["id"]);  
        }    

        $restaurant->name = $request["name"];
        $restaurant->description = $request["description"];
        $restaurant->menu_link = $request["menu_link"];
        $restaurant->map_link = $request["map_link"];
        $restaurant->phone = $request["phone"];
        $restaurant->image = base64_encode(file_get_contents($request->file('image'))); 
        
        $restaurant->save();
        
        return redirect('/city-restaurants/add-city-restaurants');
    }
}
