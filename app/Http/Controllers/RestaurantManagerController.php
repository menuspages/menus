<?php

namespace App\Http\Controllers;

use App\Helpers\ImageUploader;
use App\Helpers\UrlHelper;
use App\Http\Requests\ManagerUpdateRestaurantRequest;
use Carbon\Carbon;
use App\Models\Restaurant;
use App\Models\Link;

use App\Models\Rating;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

class RestaurantManagerController extends Controller
{
    public function index()
    {
        $restaurant = Auth::user()->restaurant;
        return response()->view('restaurant-manager.restaurants.index', ['title' => $restaurant->name, 'restaurant' => $restaurant]);
    }
    public function Rating()
    {
        $rating = Auth::user()->restaurant->rating;
        return response()->view('restaurant-manager.rating', ['rating' => $rating]);
    }
    
    public function editRestaurant()
    {
        $restaurant = Auth::user()->restaurant;
        return response()->view('restaurant-manager.restaurants.edit', ['title' => $restaurant->name, 'restaurant' => $restaurant]);
    }
    public function getRestaurantLinks($name)
    {
        $links = $this->getRestaurant($name)->links;
        if($links == null)
        {
            return "no links available"; 
        }        
        if($links->count() == 0)
        {
            return "no links available"; 
        }
        return $links;
    }
    public function getRestaurant($name)
    {

        try {

            return  Auth::user()->restaurant;
          
          } catch (\Exception $e) {
          
                return Restaurant::where('subdomain',$name)->first();
          }
    }
    public function LinksExplore()
    {
        $name = "";
        if(isset($_GET["name"]))
        {
            $name = $_GET["name"];
        }
        if($this->getRestaurantLinks($name) == "no links available") 
        {
            return "no links available";
        }
        $links =$this->getRestaurantLinks($name) == "no links available" ? array() : $this->getRestaurantLinks($name);
        return response()->view('restaurant-manager.links.explore',['rastuarant'=>$this->getRestaurant($name),'links'=>$links,'logo'=> $this->getRestaurant($name)->logoUrl()]);
    }
    public function delete()
    {
        $id = $_GET['id'];
        $item =  Link::all()->where('restaurant_id',Auth::user()->restaurant->id)->first();
        $data = json_decode($item->links);
        unset($data[$id]);
        $data = array_values($data);
        $item->links = $data;
        $item->save();
        $res = array(
            'code' =>"200"
        );
        return response()->json($res);  
    }
    public function Links(Request $request)
    {
        $links = Auth::user()->restaurant->links ;
        
        if(Auth::user()->restaurant->links == '')
        {
            $links = new Link();
            $links->id=0;
            $links->features = array(
            'bg_image' => "",
            'bg_color' => "",
            'selected' => "",   
            );
            $links->links = json_encode(array());
        }
        return response()->view('restaurant-manager.links.create',['links' =>$links]);
    }
    public function AddLinksFeature(Request $request)
    {
        $selected = $request->input('selected');
        
        $bgImagePath = $request->input('image_path') != '' ? $request->input('image_path') : null;
        if ($request->file('bgImage')) {
            $bgImagePath = ImageUploader::handle($request->file('bgImage'), 'links');
        }

        if($selected == "image")
        {
            $selected = $bgImagePath;
        }
        else 
        {
            $selected =  $request->input('bgColor');
        }
        if($request->input('id') > 0)
        {
           
            Link::where('restaurant_id' , Auth::user()->restaurant->id)->update([
                'features->bg_image' =>$bgImagePath,
                'features->bg_color' => $request->input('bgColor'),   
                'features->selected' =>  $selected                   
            ]);
        }
        else 
        {

            Link::create([
                'features->bg_image' =>$bgImagePath,
                'features->bg_color' => $request->input('bgColor'),
                'restaurant_id' => Auth::user()->restaurant->id,  
                'features->selected' =>  $selected 
            ]);
        }
       
        return redirect()->to('/dashboard/links');   
    }
    public function AddLinksLink(Request $request)
    {

        $data = array() ;  
        $link = array();
        array_push($link ,$request->input('name') );
        array_push($link ,$request->input('url') );
        
        if($request->input('id') > 0)
        {
            $item =  Link::all()->where('restaurant_id',Auth::user()->restaurant->id)->first();
            if($item->links == "")
            {
                array_push($data, $link);         
            }
            else 
            {
                $data = json_decode($item->links); 
                array_push($data , $link);
            }
            $item->links = $data;
            $item->save();
        }
        else 
        {
           
            array_push($data, $link);         
            Link::create([
                'features->bg_image' =>"",
                'features->bg_color' => "",
                'features->selected' => "",
                
                'restaurant_id' => Auth::user()->restaurant->id,  
                'links'=> json_encode($data)
            ]);
        }
       
        return redirect()->to('/dashboard/links');   
    }
    public function GetContacts(Request $request)
    {
        $id = $_GET["id"];
        $res = Restaurant::where('id', $id)->pluck('contacts')->all();
        return response()->json(json_decode($res[0], true));
    }
    public function GetOtherAccounts(Request $request)
    {
        $id = $_GET["id"];
        $res = Restaurant::where('id', $id)->pluck('accounts')->all();
        return response()->json(json_decode($res[0], true));
    }
    public function AddOtherAccounts(Request $request)
    {
        $id = $request->input('Id');
        $data = $request->input('data');
        $res = Restaurant::where('id', $id)->update(['accounts' => json_encode($data)]);
        return response()->json($res);
    }
    public function GetAccounts(Request $request)
    {
        $id = $_GET["id"];
        $res = Restaurant::where('id', $id)->pluck('accounts')->all();
        return response()->json(json_decode($res[0], true));
    }
    public function AddAccounts(Request $request)
    {
        $id = $request->input('Id');
        $data = $request->input('data');
        $res = Restaurant::where('id', $id)->update(['accounts' => json_encode($data)]);
        return response()->json($res);
    }
    public function AddContacts(Request $request)
    {
        $id = $request->input('Id');
        $data = $request->input('data');
        $res = Restaurant::where('id', $id)->update(['contacts' => json_encode($data)]);
        return response()->json($res);
    }
    public function saveIcon(Request $request)
    {
        if ($request->file('file')) {

            $file = $request->file('file');
            $imageName = $request->input('name');
            $ext = $file->extension();
            $path = $request->file('file')->storeAs('images', $imageName, 'public');
            return response()->json($ext);
        }
    }
    public function generateQRCode()
    {
        $restaurant = Auth::user()->restaurant;
        $restaurantUrl = UrlHelper::constructRestaurantUrl($restaurant->subdomain);
        $QRCode = QrCode::size('400')->generate($restaurantUrl);
        return response()->view('restaurant-manager.qr-code', ['QRCode' => $QRCode]);
    }
    public function updateRestaurant(ManagerUpdateRestaurantRequest $request)
    {    
        try {
            $restaurant = Auth::user()->restaurant;

            if ($request->file('logo')) {
                $logoPath = ImageUploader::handle($request->file('logo'), 'logos');
                ImageUploader::deleteExistingImage($restaurant->logo_path);
            }

            $imagePaths = array();
            if ($request->hasfile('background_image')) {
                foreach ($request->file('background_image') as $file) {
                    $path = ImageUploader::handle($file, 'background_images');
                    array_push($imagePaths , $path);
                }
            }

            $restaurant->update($this->constructRestaurantFieldsArray(count($imagePaths) > 0 ? $imagePaths : '',$request, $restaurant, isset($logoPath) ? $logoPath : null));
            session()->flash('success', 'تم تعديل المتجر بنجاح');
        } catch (\Exception $e) {
            // do task when error
            session()->flash('error',  $e->getMessage());
        }

        return redirect()->back();
    }

    private function constructRestaurantFieldsArray($imagePaths,ManagerUpdateRestaurantRequest $request, $restaurant, $logoPath = null)
    {
            $back_theme_ele = array();
            if($request->back_theme_select == '0')
            {
                $back_theme_ele = array(
                    "type" => 0 ,
                    "value" => $request->input("back_theme_input"),
                    "input_ele_id" => "#back_theme_color_code_text"
                ) ;
            }
            else 
            {
                    $path = null;
                    if($request->input("back_image_hide_val") != false)
                    {
                        $path = $request->input("back_image_hide_val");
                    }
                    else 
                    {
                        $path = ImageUploader::handle($request->file('back_image'), 'background_images');
                    }
                    $back_theme_ele = array(
                        "type" => 1 ,
                        "value" =>   $path ,
                        "input_ele_id" => "#input_back_image"
                    ) ;
            }
        
        $fields = [
            'name' => ucwords($request->input('name')),
            'cart_options' => json_encode($request->input('cartOptinos')),
            'user_email' => $request->input('user_email'),
            'notes1' => $request->input('notes1'),
            'notes2' => $request->input('notes2'),
            'font_style' => $request->input('font_style'),
            'colors' => $request->input('colors'),
            'admin_note' => $request->input('money_trasnfer_note'),
            'description' => $request->input('description'),
            'current_theme' => $request->input('current_theme'),
            'open_from' => $request->input('open_from'),
            'open_to' => $request->input('open_to'),
            'currency' => $request->input('currency'),
            'phone_code' => $request->input('phone_code'),
            'phone' => $request->input('phone'),
            'is_logo_active' => $request->input('is_logo_active') == 'on' ? '1' : '0',


            'whatsapp_number' => $request->input('whatsapp_number'),
            'google_map_location_link' => $request->input('google_map_location_link'),
            'facebook_link' => $request->input('facebook_link'),
            'twitter_link' => $request->input('twitter_link'),
            'instagram_link' => $request->input('instagram_link'),
            'snapchat_link' => $request->input('snapchat_link'),
            'main_theme_color_code' => $request->input('main_theme_color_code') ?? null,
            'background_image_path' => json_encode($imagePaths),
            'back_theme_color_code' => json_encode($back_theme_ele),

        ];

        if ($logoPath) {
            $fields['logo_path'] = $logoPath;
        }
      
        if ($imagePaths == '') {
            $fields['background_image_path'] = $restaurant->background_image_path;
        }


        return $fields;
    }
}
