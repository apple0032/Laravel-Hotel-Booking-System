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

        $user = User::find($user_id);
        $user->name = $request->name;
        $user->email = $request->email;
        $user->phone = $request->phone;
        $user->gender = $request->gender;

        if($request->password != null){
            if($request->password != $request->password_confirmation){
                Session::flash('danger', '密碼不相符!');
                return redirect('account/edit');
            }

            $password = bcrypt($request->password);
            $user->password = $password;
        }

        if ($request->hasFile('profile_img')) {

            if (!is_dir(public_path('images/users/profile_img/'.$user_id))) {
                mkdir(public_path('images/users/profile_img/'.$user_id), 0777);
            }

            if($user->profile_image != null){
                unlink('images/users/profile_img/'.$user_id.'/'.$user->profile_image);
            }

            $image = $request->file('profile_img');
            $filename = time() . '.' . $image->getClientOriginalExtension();
            $location = public_path('images/users/profile_img/'.$user_id.'/' . $filename);
            Image::make($image)->save($location);
            $user->profile_image = $filename;
        }

        $user->save();

        if($user->save()){
            Session::flash('success', '已成功更新!');
            return redirect('account/edit');
        }


        return view('account.account')->with('user',$user);
    }

}
