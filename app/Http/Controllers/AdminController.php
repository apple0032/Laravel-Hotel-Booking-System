<?php

namespace App\Http\Controllers;

use App\BookingGuest;
use App\BookingPayment;
use App\PaymentMethod;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Hotel;
use App\Tag;
use App\Category;
use App\PostTag;
use App\HotelRoom;
use App\RoomType;
use App\HotelFacility;
use App\HotelRoomFacility;
use App\HotelImage;
use App\Booking;
use App\User;
use App\HotelComment;
use Session;
use Purifier;
use Image;
use Auth;
use Redirect;
use DB;

class AdminController extends Controller
{

    public function __construct() {
        $this->middleware(['auth.admin']);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {

        $name = $request->input('name');

        if($name != ''){
            $users = User::where('role','=','user')->Where('name', 'like', '%' . $name . '%')->orderBy('id', 'asc')->paginate(10);
        } else {
            $users = User::where('role','=','user')->orderBy('id', 'asc')->paginate(10);
        }

        if($users->count() == 0){
            return redirect('admin');
        }

        //print_r($users);die();


        //die('This is laravel admin.');
        

        return view('admin.index')
            ->with('users',$users)
            ->with('name',$name);
    }


}
