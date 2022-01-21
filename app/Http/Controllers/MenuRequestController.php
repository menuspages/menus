<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateMenuRequestRequest;
use App\Models\MenuRequest;
use Illuminate\Http\Request;

class MenuRequestController extends Controller
{

    public function index()
    {
        $menuRequests = MenuRequest::latest()->paginate(20);
        return response()->view('admin.menu-requests.index', ['menuRequests' => $menuRequests, 'title'=> 'كل الطلبات']);
    }

    public function show($id)
    {
        $menuRequest = $this->getMenuRequest($id);
        return response()->view('admin.menu-requests.show', ['menuRequest' => $menuRequest, 'title'=> 'طلب رقم ' . $id]);
    }

    public function addNote(Request $request, $id)
    {
        $menuRequest = $this->getMenuRequest($id);
        $menuRequest->updateNote($request->input('admin_notes'));
        session()->flash('success', 'تم اضافة الملاحظة بنجاح');
        return redirect()->back();
    }
    public function markAsSeen($id)
    {
        $menuRequest = $this->getMenuRequest($id);
        $menuRequest->markAsSeen();
        return response()->json(['success' => true], 200);
    }


    public function store(CreateMenuRequestRequest $request)
    {
        $requestData = $this->constructMenuRequestData($request);
        MenuRequest::create($requestData);
        return response()->json(['success' => true], 201);
    }

    private function constructMenuRequestData(Request $request)
    {
        return [
            "restaurant_name" => $request->input("restaurant_name"),
            "subdomain" => $request->input("subdomain"),
            "full_name" => $request->input("full_name"),
            "phone" => $request->input("phone"),
            "email" => $request->input("email"),
            "discount_code" => $request->input("discount_code"),
        ];
    }

    private function getMenuRequest($id)
    {
        $menuRequest = MenuRequest::where('id', $id)->first();
        if (!$menuRequest) {
            return abort(404);
        }
        return $menuRequest;
    }

}
