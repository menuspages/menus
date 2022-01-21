<?php

namespace App\Http\Controllers\City;

use App\Helpers\ImageUploader;
use App\Helpers\UrlHelper;
use App\Http\Controllers\Controller;
use App\Http\Requests\CreateCategoryRequest;
use App\Http\Requests\UpdateCategoryRequest;
use App\Models\City\Citycategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CategoryController extends Controller
{
    public function index()
    {
        $category = Citycategory::all();
        return response()->view('admin.cities.category.index' , ["category"=>$category]);     
    }

  
    public function add_category()
    {
         $category = new Citycategory;
          if(isset($_GET["id"]))
          {
              $id = $_GET["id"];
              $category=Citycategory::find($id);
          }  
          return response()->view('admin.cities.category.add' , ['category'=>$category]);
    }

    public function delete_category()
    {
        $id = $_GET["id"];
        Citycategory::where('id' , $id)->delete();
        $arr=[];
        $arr['message'] = "deleted successfully";  
        return response()->json($arr, 200);
    }

    public function add_category_post(Request $request)
    {
        $this->validate($request, [
            'name' => 'required|max:255',
        ]);
      
        $category = new Citycategory;
        if($request["id"] > 0)
        {
            $category=Citycategory::find($request["id"]);  
        }    

        $category->name = $request["name"];
        $category->save();
        
        return redirect('/category/add-category');
    }
}
