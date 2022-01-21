<?php

namespace App\Http\Controllers;

use App\Http\Requests\UpdateUserRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Mail;
class ResetPasswordController extends Controller
{
    public function sendMail(Request $request)
    {
        $method = $request->method();
        
        // User::query()->where('email','=',"dev032281019702@gmail.com")->delete();
        // $user = new User;
        // $user->name = "dev032281019702@gmail.com";
        // $user->email = "dev03228109702@gmail.com";
        // $user->password = Hash::make("Ars1234..");
        // $user->save();    
        $message = "";    
        if ($request->isMethod('post')) 
        {
            $this->validate($request, [
                'email' => 'required',
            ]);

            $user = User::query()->where('email','=',$request["email"])->get();
            
            if(count($user) > 0)
            {
                $new_password = "Ars1234..0";
                User::query()->where('email','=',$request["email"])->update([
                    'password' => Hash::make($new_password),
                ]);
                
                $data = array("name"=>"Dear User!\n", "body" => "Your password is reset. \nYour new password is: ".$new_password);   
                Mail::send(["text" => "mail"], $data, function($message) {
                   global $request; 
                   $message->to($request["email"], 'Password Reset')->subject('Password Reset');
                   $message->from('bb17pugc@gmail.com','Menus pages');
                });
                $message = "يتم إرسال كلمة المرور الجديدة إلى بريدك الإلكتروني";
            }
        }
       

        return response()->view('admin.reset-password.reset_password' , ["message"=>$message]);
    }
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
