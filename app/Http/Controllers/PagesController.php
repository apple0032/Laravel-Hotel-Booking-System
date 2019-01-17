<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Post;
use App\Hotel;
use App\Category;
use App\Tag;
use App\PostTag;
use App\RoomType;
use App\HotelRoom;
use App\HotelFacility;
use App\User;
use Mail;
use Session;
use Purifier;
use Image;
use Auth;
use Redirect;
use Illuminate\Support\Facades\Input;
use DateTime;
use DatePeriod;
use DateInterval;
use DB;

class PagesController extends Controller
{

    public function getIndex()
    {
        $data = self::HotelGrid();

        //$posts = Post::orderBy('created_at', 'desc')->limit(4)->get();

        $all_hotels = Hotel::select('id')->get();
        foreach ($all_hotels as $all_hotel){
            $hotel_array[] = $all_hotel->id;
        }
        $random_keys=array_rand($hotel_array,5);

        $hotels = Hotel::select('*');
        foreach ($random_keys as $key =>$rk) {
            $hotels = $hotels->orwhere('id','=',$hotel_array[$rk]);
        }

        $hotels = $hotels->paginate(5);

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
        $search_small = false;
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

    public function search(Request $request)
    {

        $this->validate($request, array(
            //'name' => 'required',
            //'category_id' => 'required',
        ));

        //print_r($request->room_type);die();

        $price_low = floor($request->price_lower);
        $price_up = floor($request->price_upper);

        if ($price_low == 0) {
            $price_low = '';
        }

        if ($price_up == 0) {
            $price_up = '';
        }

        //Session::flash('success', 'Search successful!');
        $request->name = str_replace(" "," ",$request->name);
        
        $range = $request->daterange;

        if($range != '') {
            $range = explode("-", $range);
            $start = trim($range[0]) . '-' . trim($range[1]) . '-' . trim($range[2]);
            $end = trim($range[3]) . '-' . trim($range[4]) . '-' . trim($range[5]);
        } else {
            $start = '';
            $end = '';
        }

        return redirect()->route('pages.search', [
            'name' => $request->name,
            'category' => $request->category_id,
            'tags' => $request->tags,
            'star' => $request->star,
            'room_type' => $request->room_type,
            'people_limit' => $request->people_limit,
            'price_low' => $price_low,
            'price_up' => $price_up,
            'start' => $start,
            'end' => $end,
        ]);
    }

    public function getsearch()
    {

        $name = Input::get('name');
        $category = Input::get('category');
        $tags = Input::get('tags');
        $star = Input::get('star');
        $room_type = Input::get('room_type');
        $people_limit = Input::get('people_limit');
        $price_low = Input::get('price_low');
        $price_up = Input::get('price_up');
        $start = Input::get('start');
        $end = Input::get('end');
        
        //print_r($start);print_r($end);die();

        $hotels = DB::table('hotel')
            ->select('hotel.id')
            ->leftJoin('hotel_room', 'hotel.id', '=', 'hotel_room.hotel_id')
            ->leftJoin('post_tag', 'hotel.id', '=', 'post_tag.hotel_id');

        if ($name != null) {
            $hotels->Where('hotel.name', 'like', '%' . $name . '%');
        }

        if ($category != null) {
            $hotels->Where('hotel.category_id', '=', $category);
        }

        if ($star != null) {
            $hotels->where('hotel.star', '=', $star);
        }

        if ($room_type != null) {
            $hotels->where('hotel_room.room_type_id','=', $room_type);
        }

        if ($people_limit != null) {
            $hotels->where('hotel_room.ppl_limit','>=', $people_limit);
        }

        if (($price_low != null) || ($price_up != null)) {
            if($price_low != '10'){
                $hotels->where('hotel_room.price', '>=', $price_low);
                $hotels->where('hotel_room.price', '<=', $price_up);
            }
        }

        if ($tags != null) {
                $hotels->where(function ($query) use ($tags) {
                    foreach ($tags as $tag) {
                        $query->orWhere('post_tag.tag_id', '=', $tag);
                    }
                });
        }

        $hotels = $hotels->where('soft_delete','=','0');
        $hotels = $hotels->distinct('hotel.id')->get();

        $hotels_arr = array();
        foreach ($hotels as $hotel){
            $hotels_arr[]['id'] = $hotel->id;
        }

        $hotels = $hotels_arr;

        //print_r($hotels);die();
        
        if( $start != null ){
            $date_range = self::getDatesFromRange($start, $end);

            $room_hotel = array();
            foreach ($hotels_arr as $k => $ht){
                $room = HotelRoom::select('*')
                    ->where('hotel_id', '=', $ht['id'])->get()->toArray();

                if ($room != null) {
                    $room_hotel[$k]['hotel_id'] = $ht['id'];
                    $room_hotel[$k]['room'] = $room;
                }
            }
            
            //print_r($room_hotel);die();

            $can_book_hotel = array();
            $c = 0;
            foreach($room_hotel as $k1 => $hot){
                $can_book = true;
                
                foreach ($hot['room'] as $k2 => $rh){
                    foreach($date_range as $date){
                        $re[$c]['hotel'] = $hot['hotel_id'];
                        $re[$c]['room'] = $rh['id'];
                        $re[$c]['date'] = $date;
                        $re[$c]['valid'] = Hotel::validateBooking($hot['hotel_id'],$rh['id'], $date);
                        $valid = $re[$c]['valid'];
                        $c++;
                        
                        if($valid == false){
                            $can_book = false;
                            break;
                        }
                    }
                    
                    if($can_book == false){
                        break;
                    }
                }
                
                //print_r($re);die();
                
                if($can_book == true){
                    $can_book_hotel[]['id'] = $hot['hotel_id'];
                } 
            }
            
            //print_r($re);die();

            if($can_book_hotel != null) {
                $hotels = $can_book_hotel;
            } else {
                $hotels = null;
            }
        }

        //print_r($hotels);die();

        if($hotels != null) {
            $hotels_result = Hotel::select('*');

            foreach ($hotels as $hotel) {
                $hotels_result = $hotels_result->orwhere('id', '=', $hotel['id']);
            }
            $hotels_result = $hotels_result->paginate(10);

            $hotels = $hotels_result;
        }

        $rate = null;

        if($hotels != null) {
            foreach ($hotels as $k => $hotel) {
                $rate[] = Hotel::rate($hotel->id);
            }
        }

        //static
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
        $search_small = true;
        
        $input_start = Input::get('start');
        $input_end = Input::get('end');
        
        $daterange = $input_start.' - '.$input_end;

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

    public function getAbout()
    {
        $first = 'Alex';
        $last = 'Curtis';

        $fullname = $first . " " . $last;
        $email = 'alex@jacurtis.com';
        $data = [];
        $data['email'] = $email;
        $data['fullname'] = $fullname;
        return view('pages.about')->withData($data);
    }

    public function getArticle()
    {

        $data = 'example';

        return view('pages.article')->withData($data);
    }

    public function getContact()
    {
        return view('pages.contact');
    }

    public function postContact(Request $request)
    {
        $this->validate($request, [
            'email' => 'required|email',
            'subject' => 'min:3',
            'message' => 'min:10']);

        $data = array(
            'email' => $request->email,
            'subject' => $request->subject,
            'bodyMessage' => $request->message
        );

        Mail::send('emails.contact', $data, function ($message) use ($data) {
            $message->from($data['email']);
            $message->to('hello@devmarketer.io');
            $message->subject($data['subject']);
        });

        Session::flash('success', 'Your Email was Sent!');

        return redirect('/');
    }

    public function HotelGrid(){

        $categories = Category::all();
        $tags = Tag::all();
        $stars = Hotel::hotelstar();
        $room_types = RoomType::all();
        $people_limits = $stars;

        $cat_list = \App\Helpers\AppHelper::instance()->ObjectToArrayMap($categories,'id','name');
        $tag_list = \App\Helpers\AppHelper::instance()->ObjectToArrayMap($tags,'id','name');
        $room_type_list = \App\Helpers\AppHelper::instance()->ObjectToArrayMap($room_types,'id','type');

        //Hotel Facility

        $facility_table = new HotelFacility;
        $hotel_facility_list = $facility_table->getTableColumns();

        $hotel_facility_label = array();
        foreach ($hotel_facility_list as $facilities){
            $facilities = str_replace("_"," ",$facilities);
            $hotel_facility_label[] = ucwords($facilities);
        }

        $hotel = new Hotel();
        $hotel_fontawesome = $hotel->getFontAwesome();


        $data['categories'] = $categories;
        $data['tags'] = $tags;
        $data['stars'] = $stars;
        $data['room_types'] = $room_types;
        $data['people_limits'] = $people_limits;
        $data['cat_list'] = $cat_list;
        $data['tag_list'] = $tag_list;
        $data['hotel_facility_list'] = $hotel_facility_list;
        $data['hotel_facility_label'] = $hotel_facility_label;
        $data['hotel_fontawesome'] = $hotel_fontawesome;
        $data['room_type_list'] = $room_type_list;

        return $data;
    }


    public function searchbyajax(Request $request){
        
        //Replaced by ajax load.();
        //Search engine handled in self::getsearch();
        
        $range = trim($request->daterange);

        if($range == '-' || $range == '' || $range == NULL) {
            $start = '';
            $end = '';
        } else {
            $range = explode("-", $range);
            $start = trim($range[0]) . '-' . trim($range[1]) . '-' . trim($range[2]);
            $end = trim($range[3]) . '-' . trim($range[4]) . '-' . trim($range[5]);
        }

        $response = array(
            'status' => 'success',
            'start' => $start,
            'end' => $end,
        );

        return response()->json($response);
    }


    public function searchname(Request $request){

        $name = $request->name;

        if($name == ''){
            $hotels = null;
            $status = 'error';
        } else {
            $status = 'success';
            $hotels = Hotel::select('id', 'name', 'default_image','image');
            $hotels = $hotels->Where('name', 'like', '%' . $name . '%');
            $hotels = $hotels->limit(5)->get()->toArray();
        }


        $response = array(
            'status' => $status,
            'hotels' => $hotels,
            'keyword' => $name,
        );

        return response()->json($response);
    }
    
    
    public function checkvalidation(Request $request){
        
        $hotel_id = $request->hotel_id;
        $hotel_room_id = $request->hotel_room_id;
        $in_date = $request->in_date;
        $out_date = date('Y-m-d', strtotime('-1 day', strtotime($request->out_date)));

        $date_range = self::getDatesFromRange($in_date, $out_date);

        //$date_array
        $arr = array();
        $unavailable = 0;
        $unavailable_array = array();
        foreach ($date_range as $k => $date){
            $arr[$k] = Hotel::validateBooking($hotel_id,$hotel_room_id, $date);
            if($arr[$k] == null){
                $unavailable++;
                $unavailable_array[] = $date;
            }
        }
        
        //print_r($unavailable_array);die();
        
        $response = array(
            'status' => 'success',
            'unavailable_array' => $unavailable_array,
        );

        return response()->json($response);
    }


     /**
     * Generate an array of string dates between 2 dates
     *
     * @param string $start Start date
     * @param string $end End date
     * @param string $format Output format (Default: Y-m-d)
     *
     * @return array
     */
    
    function getDatesFromRange($start, $end, $format = 'Y-m-d') {
        $array = array();
        $interval = new DateInterval('P1D');

        $realEnd = new DateTime($end);
        $realEnd->add($interval);

        $period = new DatePeriod(new DateTime($start), $interval, $realEnd);

        foreach($period as $date) { 
            $array[] = $date->format($format); 
        }

        return $array;
    }
    
}
