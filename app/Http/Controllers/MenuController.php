<?php

namespace App\Http\Controllers;
use App\Constants\Translation;
use App\Constants\Themes;
use App\Models\Item;
use App\Models\Restaurant;
use Illuminate\Http\Request;

class MenuController extends Controller
{
    public function viewMenu($subdomain)
    {
        
        $current_url= url()->current();
        $restaurant = $this->getRestaurant($subdomain);

        $mystring = $restaurant->backgroundImageUrl();
        $mystring;
      
        $findme   = '---';
        $pos = strpos($mystring, $findme);
        if($pos !== false)
        {
            $imagePaths = array();
            foreach(explode('---', $restaurant->backgroundImageUrl() ) as $index => $info)
            {
                array_push($imagePaths , $info);
            }
            
            if(count($imagePaths) > 0)
            {
                $restaurant->background_image_path=json_encode($imagePaths);
                $restaurant->save();
            }
        }
        else 
        {
            try {

                count(json_decode($mystring));
              
              } catch (\Exception $e) {
                  
              
                $imagePaths = array();
                array_push($imagePaths , $mystring);
                $restaurant->background_image_path=json_encode($imagePaths);
                $restaurant->save();
              }
        }

       
        $lang = "arb";
        if ((!in_array($restaurant->current_theme, Themes::AVAILABLE_THEMES)) || (!view()->exists('menu.theme-' . $restaurant->current_theme))) {
            return abort(404);
        }
        if (in_array($restaurant->current_theme, Themes::THEMES_NEEDS_ALL_ITEMS)) {
            $restaurant->load('categories.items');
        }

        if(isset($_GET['lang']))
        {
            $lang = $_GET['lang'];
    	}
        else
        {
            $_GET['lang'] = $lang;
        }
            
          return response()->view('menu.theme-' . $restaurant->current_theme, ['lang' => $lang , 'language'=>  Translation::getTranslation()[$lang],'restaurant' => $restaurant, 'current_url'=>$current_url ,'title' => $restaurant->name]);
  }

    private function getRestaurant($subdomain, $withItems = false)
    {
        $query = Restaurant::active()->notDeleted()->with('categories')->where('subdomain', $subdomain);
        if ($withItems) {
            $query->with('categories.items');
        }
        $restaurant = $query->first();
        if (!$restaurant) {
            return abort(404);
        }
        return $restaurant;
    }

    public function getItemsOfCategory(Request $request)
    {
        if (!$request->query('category_id')) {
            return abort(404);
        }
        $restaurant = $this->getRestaurant($request->route('subdomain'));
        return Item::OfRestaurantId($restaurant->id)->whereHas('category', function ($query) use ($request) {
            return $query->where('categories.id', $request->query('category_id'));
        })->visible()->latest()->get();
    }
}
