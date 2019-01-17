<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\User;
use Session;
use Purifier;
use Image;
use Auth;
use Redirect;
use DB;

class AccountController extends Controller
{

    public function __construct() {
        $this->middleware(['auth']);
    }
    
    public function AccountCenter()
    {
        
        $user_id = Auth::user()->id;
        $user = User::where('id','=',$user_id)->first();

        return view('account.account')->with('user',$user);
    }

    public function AccountUpdate(Request $request)
    {
        $user_id = Auth::user()->id;

        $this->validate($request, [
            'name' => 'required|max:255',
            'email' => 'required|email|max:255|unique:users,id,'.$user_id,  //check duplicate member
            //'password' => 'required|confirmed|min:6'
        ]);

        if($request->password != null){
            if($request->password != $request->password_confirmation){
                Session::flash('danger', '密碼不相符!');
                return redirect('account/edit');
            }
        }

        $password = bcrypt($request->password);

        $user = User::find($user_id);
        $user->name = $request->name;
        $user->email = $request->email;
        $user->phone = $request->phone;
        $user->gender = $request->gender;
        $user->password = $password;
        $user->save();

        if($user->save()){
            Session::flash('success', '已成功更新!');
            return redirect('account/edit');
        }


        return view('account.account')->with('user',$user);
    }

}
