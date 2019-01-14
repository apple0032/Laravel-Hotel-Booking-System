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

class HotelController extends Controller
{

    public function __construct() {
        //$this->middleware(['auth']); //open to public
    }

 
    public function show($id)
    {
        $hotel = Hotel::find($id);
        $rate = Hotel::rate($id);

        $data = self::HotelGrid();

        $categories = $data['categories'];
        $tags = $data['tags'];
        $stars = $data['stars'];
        $room_types = $data['room_types'];
        $people_limits = $data['people_limits'];
        $cat_list = $data['cat_list'];
        $tag_list = $data['tag_list'];
        $hotel_facility_list = $data['hotel_facility_list'];
        $hotel_facility_label = $data['hotel_facility_label'];
        $hotel_fontawesome = $data['hotel_fontawesome'];
        $room_type_list = $data['room_type_list'];

        $facility_table = new HotelRoomFacility;
        $room_facility_list = $facility_table->getTableColumns();
        $temp_fontawesome = $facility_table->getFontAwesome();

        $room_facility_label = array();
        foreach ($room_facility_list as $facilities){
            $facilities = str_replace("_"," ",$facilities);
            $room_facility_label[] = ucwords($facilities);
        }

        //print_r($room_type_list);die();

        $user = User::all();
        $user_list = \App\Helpers\AppHelper::instance()->ObjectToArrayMap($user,'id','name');
        
        return view('hotel.show')
            ->withHotel($hotel)
            ->with('categories',$categories)
            ->withTags($tags)
            ->withStars($stars)
            ->withRoomTypes($room_types)
            ->with('people_limits', $people_limits)
            ->with('cat_list',$cat_list)
            ->with('tag_list',$tag_list)
            ->with('hotel_facility_list',$hotel_facility_list)
            ->with('hotel_facility_label',$hotel_facility_label)
            ->with('hotel_fontawesome', $hotel_fontawesome)
            ->with('room_type_list', $room_type_list)
            ->with('room_facility_list',$room_facility_list)
            ->with('temp_fontawesome',$temp_fontawesome)
            ->with('user_list',$user_list)
            ->with('rate',$rate)
            ->with('room_facility_label',$room_facility_label);
    }

    
    public function allhotels()
    {
        $data = self::HotelGrid();

        $hotels = Hotel::select('*')->where('soft_delete', '=', 0);
        $hotels = $hotels->paginate(10);
        foreach($hotels as $k => $hotel){
            $rate[] = Hotel::rate($hotel->id);
        }

        $categories = $data['categories'];
        $tags = $data['tags'];
        $stars = $data['stars'];
        $room_types = $data['room_types'];
        $people_limits = $data['people_limits'];
        $cat_list = $data['cat_list'];
        $tag_list = $data['tag_list'];
        $hotel_facility_list = $data['hotel_facility_list'];
        $hotel_facility_label = $data['hotel_facility_label'];
        $hotel_fontawesome = $data['hotel_fontawesome'];
        $room_type_list = $data['room_type_list'];
        $search_small = true;
        $daterange = null;

        return view('pages.welcome')
            ->with('hotels', $hotels)
            ->with('categories',$categories)
            ->withTags($tags)
            ->withStars($stars)
            ->withRoomTypes($room_types)
            ->with('people_limits', $people_limits)
            ->with('cat_list',$cat_list)
            ->with('tag_list',$tag_list)
            ->with('hotel_facility_list',$hotel_facility_list)
            ->with('hotel_facility_label',$hotel_facility_label)
            ->with('hotel_fontawesome', $hotel_fontawesome)
            ->with('room_type_list', $room_type_list)
            ->with('rate',$rate)
            ->with('daterange',$daterange)
            ->with('search_small', $search_small);
    }


    public function HotelGrid(){
        $data = app('App\Http\Controllers\PagesController')->HotelGrid();

        return $data;
    }
    
    
    public function Comment(Request $request,$id)
    {        
        $this->validate($request, [
            'comment' => 'required',
            'rating' => 'required',
        ]);

        //Check if no login, request it.
        if(!Auth::check()){
            return redirect('auth/login');
        } else {
            $user_id = Auth::user()->id;
        };

        $comment = new HotelComment();
        $comment->hotel_id = $id;
        $comment->user_id = $user_id;
        $comment->comment = trim($request->comment);
        $comment->star = $request->rating;
        $comment->status = 1;
        $comment->save();

        if($comment->save()){
            Session::flash('success', 'Comment successful!');
            return redirect('hotel/'.$id);
        }
    }

}
