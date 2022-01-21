<?php

namespace App\Http\Controllers;

use App\Http\Requests\UpdateUserRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use App\Constants\Roles;

class UserController extends Controller
{
    public function index(Request $request)
    {
        $users = User::with('roles')->paginate(20);
        return response()->view('admin.users.index', ['title' => 'كل المستخدمين', 'users' => $users]);
    }

    public function edit($userId)
    {
        $user = $this->getUser($userId);
        return response()->view('admin.users.edit', ['title' => $user->name, 'user' => $user]);
    }
    public function create()
    {
        return response()->view('admin.users.create');
    }
    public function store(Request $request)
    {
        try {

            DB::transaction(function () use ($request) {
                $user = User::create([
                    'name' => ucwords($request->input('name')),
                    'email' => $request->input('email'),
                    'password' => Hash::make($request->input('password')),
                    'restaurant_id' => 0
                ]);
                if($request->input('role') == 1)
                {
                    $user->attachRole(Roles::ADMIN_ROLE);        
                }
                else 
                {
                    $user->attachRole(Roles::RESTAURANT_MANAGER_ROLE);
                }
    
                session()->flash('success', 'تم تعديل المستخدم بنجاح');
            });    
          
          } catch (\Exception $e) {
          
            session()->flash('error', 'تم العثور على مستخدم مكرر');
          }
        return response()->view('admin.users.create');
    }
    private function getUser($userId)
    {
        $user = User::where('id', $userId)->first();
        if (!$user) {
            return abort(404);
        }
        return $user;
    }

    public function update(UpdateUserRequest $request, $userId)
    {
        $user = $this->getUser($userId);
        $user->update([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);
        $user->roles()->sync($request->input('role'));
        session()->flash('success', 'تم تعديل المستخدم بنجاح');
        return redirect()->route('users');
    }

    public function destroy($userId)
    {
        $user = $this->getUser($userId);
        $user->delete();
        session()->flash('success', 'تم حذف المستخدم بنجاح');
        return redirect()->route('users');
    }

    public function show($userId)      
    {
        $user = $this->getUser($userId);
        return response()->view('admin.users.show', ['title' => $user->name,'user' => $user]);
    }
}
