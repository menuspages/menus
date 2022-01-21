<?php

namespace App\Http\Controllers;

use App\Helpers\ImageUploader;
use App\Helpers\UrlHelper;
use App\Http\Requests\CreateCategoryRequest;
use App\Http\Requests\UpdateCategoryRequest;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CategoryController extends Controller
{
    public function index()
    {
        $categories = Auth::user()->restaurant->categories()->latest()->paginate(20);

        return response()->view('restaurant-manager.categories.index', ['title' => 'كل الاصناف', 'categories' => $categories]);
    }
    public function setPriority(Request $request)
    {
        $Items = $request->input('items');
        foreach($Items as $item)
        {
            $id = (int)$item["id"];
            $pr = (int)$item["pr"];
            Auth::user()->restaurant->categories()->where('id', $id)->update(['priority' => $pr]);
        }
        return response()->json([
            'data' => $Items
        ], 200);     
    }
    public function create()
    {
        return response()->view('restaurant-manager.categories.create', ['title' => 'انشاء صنف جديد']);
    }

    public function store(CreateCategoryRequest $request)
    {
	
        if ($request->hasFile('image')) {
            $path = ImageUploader::handle($request->file('image'), 'categories_images');
        }
        Category::create([
            'name' => $request->input('name').'---'.$request->input('language'),
            'restaurant_id' => Auth::user()->restaurant->id,
            'image_path' => isset($path) ? $path : null
        ]);
        session()->flash('success', 'تم انشاء الصنف بنجاح');

        return redirect()->route($this->getRedirectedRouteOrDefault(), $request->route('subdomain'));
    }

    private function getRedirectedRouteOrDefault($default = 'categories')
    {
        $queryParams = UrlHelper::getQueryParamsFromUrlString(request()->header('referer'));
        return (in_array('r', array_keys($queryParams)) && ($queryParams['r'] === 'create-item')) ? $queryParams['r'] : $default;

    }

    public function edit(Request $request)
    {
        $category = $this->getCategory($request->route('id'), $request);
        return response()->view('restaurant-manager.categories.edit', ['title' => 'تعديل صنف', 'category' => $category]);
    }

    private function getCategory($categoryId, Request $request)
    {
        $category = Category::where('id', $categoryId)->whereHas('restaurant', function ($query) use ($request) {
            return $query->where('subdomain', $request->route('subdomain'));
        })->first();
        if (!$category) {
            return abort(404);
        }
        return $category;
    }

    public function update(UpdateCategoryRequest $request)
    {
        $category = $this->getCategory($request->route('id'), $request);
        if ($request->hasFile('image')) {
            $path = ImageUploader::handle($request->file('image'), 'categories_images');
            ImageUploader::deleteExistingImage($category->image_path);
        }
        $category->update([
            'name' => $request->input('name').'---'.$request->input('language'),
            'restaurant_id' => Auth::user()->restaurant->id,
            'image_path' => isset($path) ? $path : $category->image_path
        ]);
        session()->flash('success', 'تم تعديل الصنف بنجاح');
        return redirect()->route('categories', $request->route('subdomain'));
    }

    public function destroy(Request $request)
    {
        // todo delete all its meals
        $category = $this->getCategory($request->route('id'), $request);

        $category->delete();
        session()->flash('success', 'تم حذف الصنف بنجاح');

        return redirect()->route('categories', $request->route('subdomain'));
    }
}
