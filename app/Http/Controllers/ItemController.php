<?php

namespace App\Http\Controllers;

use App\Helpers\ImageUploader;
use App\Http\Requests\CreateItemRequest;
use App\Http\Requests\UpdateItemRequest;
use App\Models\Category;
use App\Models\Item;
use Illuminate\Http\Request;

class ItemController extends Controller
{

    public function index()
    {
        $restaurant = auth()->user()->restaurant;

        $items = Item::with('category')->OfRestaurantId(auth()->user()->restaurant->id)->latest()->paginate(20);
        // return $items;
        return response()->view('restaurant-manager.items.index', ['restaurant'=>$restaurant,'title' => 'كل المنتجات', 'items' => $items]);
    }

    public function setPriority(Request $request)
    {
        $Items = $request->input('items');
        foreach($Items as $item)
        {
            $id = (int)$item["id"];
            $pr = (int)$item["pr"];
            Item::query()->where('id', $id)->update(['priority' => $pr]);
        }
        return response()->json([
            'data' => $Items
        ], 200);     
    }

    public function create()
    {
        $categories = Category::where('restaurant_id', auth()->user()->restaurant->id)->get();
        return response()->view('restaurant-manager.items.create', ['title' => 'انشاء منتج جديد', 'categories' => $categories]);
    }


    public function store(CreateItemRequest $request)
    {
        
        $imagePath = ImageUploader::handle($request->file('image'), 'items_images');
        Item::create($this->constructItemsFieldsArr($request, $imagePath));
        session()->flash('success', 'تم انشاء المنتج بنجاح');
        return redirect()->back();
    }

    private function constructItemsFieldsArr($request, $imagePath = null)
    {
       
        $fieldsArr = [
            'name' => $request->input('name'),
            'description' => $request->input('description'),
            'category_id' => $request->input('category_id'),
            'current_price' => $request->input('current_price'),
            'old_price' => $request->input('old_price'),
            'calories' => $request->input('calories'),
            'is_visible' => is_null($request->input('is_visible'))? 1 : $request->input('is_visible'),
            'is_available' => is_null($request->input('is_available'))? 1 : $request->input('is_available'),
            'new' => is_null($request->input('new')) == 1? 0 : 1 ,
            'quantity_summary->target' => $request->input('input_quantity_summary') == 1 ? $request->input('input_target_quantity') : null ,
            'quantity_summary->total' =>  $request->input('input_quantity_summary') == 1 ? $request->input('input_total_quantity') : null,
            'quantity_summary->remaining' =>  $request->input('input_quantity_summary') == 1 ? $request->input('input_total_quantity') - $request->input('input_target_quantity') : null,
            'quantity_summary->input_quantity_summary' =>  $request->input('input_quantity_summary') == 1 ? $request->input('input_quantity_summary') : null,
             'allergens' => json_encode($request->input('allergens'))
        ];
        if ($imagePath) {
            $fieldsArr['image_path'] = $imagePath;
        }
        return $fieldsArr;
    }


    public function getSubDetails()
    {
        $id=$_GET["id"]; 
        $res_new=Item::where('id',$id)->pluck('sub_details_new')->all();
        $res=Item::where('id',$id)->pluck('sub_details')->all();
      
        try {

            if(count(json_decode($res[0])) > 0)
            {
                $items = array();
                $subject_items=array();

                foreach(json_decode($res[0]) as $item)
                {
                    $data = array(
                        "label" => $item[0],
                        "price" => $item[1],
                        "desc" => $item[2],
                    );
                    array_push($subject_items,$data);
                }
                $subject=array(
                    "subject"=>"not defined"
                );
                $subject_data=array(
                    "items" => $subject_items
                );
                array_push($items,$subject);
                array_push($items,$subject_data);
                
                $main = array();
                array_push($main ,$items);
                Item::where('id',$id)->update(['sub_details_new'=> $main]);
                return response()->json($main); 
            }
          
          } catch (\Exception $e) {
            return response()->json($res_new[0]); 
          }
        return response()->json($res_new[0]); 
    }

    public function AddSubDetails(Request $request)
    {

        $id = $request->input('Id');
        $data = $request->input('data');
        $res=Item::where('id',$id)->update(['sub_details_new'=> $data]);
        return response()->json($res); 
    }

    public function edit(Request $request)
    {
        $item = $this->getItem($request->route('id'));
        $categories = Category::where('restaurant_id', auth()->user()->restaurant->id)->get();
        return response()->view('restaurant-manager.items.edit', ['title' => 'تعديل منتج', 'categories' => $categories, 'item' => $item]);
    }

    private function getItem($id)
    {
        $item = Item::where('id', $id)->OfRestaurantId(auth()->user()->restaurant->id)->first();
        if (!$item) {
            return abort(404);
        }
        return $item;
    }

    public function update(UpdateItemRequest $request)
    {
        $item = $this->getItem($request->route('id'));
        if ($request->hasFile('image')) {
            $imagePath = ImageUploader::handle($request->file('image'), 'items_images');
        }
        $item->update($this->constructItemsFieldsArr($request, isset($imagePath) ? $imagePath : null));
        session()->flash('success', 'تم تعديل المنتج بنجاح');
        return redirect()->back();
    }

    public function destroy(Request $request)
    {
        $item = $this->getItem($request->route('id'));
        $item->delete();
        session()->flash('success', 'تم حذف المنتج بنجاح');
        return redirect()->back();
    }
}
