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
        //$this->middleware(['auth']);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if(self::CheckPermission() == false){ return redirect('auth/login');};

        $id = $request->input('id');
        $name = $request->input('name');
        
        if($name != ''){
            $name = str_replace("|"," ",$name);
            $hotels = Hotel::where('soft_delete','=',0)->Where('name', 'like', '%' . $name . '%')->orderBy('id', 'asc')->paginate(10);
        } else {
            $hotels = Hotel::where('soft_delete','=',0)->orderBy('id', 'asc')->paginate(10);
        }

        if($hotels->count() == 0){
            return redirect('hotel');
        }
        
        $book_date = date("Y-m-d").' 00:00:00'; //current day
        //$book_date = date('Y-m-d',strtotime('+1 day'));
        //$book_date = '2018-12-28 00:00:00';
        //print_r($book_date);die();
        
        foreach($hotels as $k => $hotel){
            $book_percent[$k] = Hotel::CheckBookingStatus($hotel->id, $book_date);
        }

        //print_r($book_percent);die();
        
        //$available_book = Hotel::validateBooking('40','22', $book_date);
        //print_r($available_book);die();
        
        //check booking validation
        // step 1 
            //find number of room of a hotel
        // step 2
            //find booking where hotel_id match and date = today, count rows
        // step 3
            //If countrows+1 > hotelroom -> block/no show room
                //else -> allow
        

        return view('hotel.index')->with('hotels',$hotels)->with('book_percent',$book_percent)->with('name',$name);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if(self::CheckPermission() == false){ return redirect('auth/login');};

        $categories = Category::all();
        $tags = Tag::all();
        $stars = Hotel::hotelstar();

        //Hotel Facility

        $facility_table = new HotelFacility;
        $hotel_facility_list = $facility_table->getTableColumns();

        $hotel_facility_label = array();
        foreach ($hotel_facility_list as $facilities){
            $facilities = str_replace("_"," ",$facilities);
            $hotel_facility_label[] = ucwords($facilities);
        }

        $hotel = new Hotel();
        $temp_fontawesome = $hotel->getFontAwesome();
        
        return view('hotel.create')
            ->withCategories($categories)
            ->withTags($tags)
            ->withStars($stars)
            ->with('hotel_facility_list',$hotel_facility_list)
            ->with('hotel_facility_label',$hotel_facility_label)
            ->with('temp_fontawesome',$temp_fontawesome);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // validate the data
        $this->validate($request, array(
                'title'         => 'required|max:50',
                'star'          => 'required|integer',
                'phone'         => 'required|integer',
                'category_id'   => 'required|integer',
                'body'          => 'required',

            ));

        $facility_table = new HotelFacility;
        $hotel_facility_list = $facility_table->getTableColumns();

        foreach($hotel_facility_list as $hotel_facility){
            $this->validate($request, array(
                $hotel_facility => 'required',
            ));
        }

        // store in the database
        $post = new Hotel;

        $post->name = $request->title;
        $post->category_id = $request->category_id;
        //$post->body = Purifier::clean($request->body);
        $post->body = $request->body;
        $post->phone =  $request->phone;
        $post->star =  $request->star;
        $post->coordi_x = $request->coordi_x;
        $post->coordi_y = $request->coordi_y;
        $post->new = 1;
        $post->handling_price = $request->handling_price;

        if ($request->hasFile('featured_img')) {
          $image = $request->file('featured_img');
          $filename = time() . '.' . $image->getClientOriginalExtension();
          $location = public_path('images/upload/' . $filename);
          Image::make($image)->resize(750, 500)->save($location);

          $post->image = $filename;
        }

        $post->save();

        //$post->tags()->sync($request->tags, false);
        if($post->save()){
            if($request->tags != null){
                foreach($request->tags as $save_tag){
                    $tags = new PostTag;
                    $tags->hotel_id = $post->id;
                    $tags->tag_id = $save_tag;
                    $tags->save();
                }
            }
        }


        //Create Hotel Facilities in loop

        $facility = new HotelFacility();
        $facility->hotel_id = $post->id;
        foreach ($hotel_facility_list as $sv_hotel_fac){
            $facility->$sv_hotel_fac = $request->$sv_hotel_fac;
        }
        $facility->save();



        Session::flash('success', 'The new hotel was successfully created!');

        return redirect()->route('hotel.index', $post->id);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
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

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        if(self::CheckPermission() == false){ return redirect('auth/login');};

        // find the post in the database and save as a var
        $hotel = Hotel::find($id);
        $categories = Category::all();
        $cats = array();
        foreach ($categories as $category) {
            $cats[$category->id] = $category->name;
        }
        
        $tags = Tag::all();
        $stars = Hotel::hotelstar();
        $hotel_tags = PostTag::where('hotel_id', '=', $id)->orderBy('id', 'asc')->get()->toArray();
        
        $tag_array = array();
        foreach($tags as $tag){
            $tag_array[] = $tag->id;
        }
        $hotel_tags_array = array();
        foreach($hotel_tags as $hotel_tag){
            $hotel_tags_array[] = $hotel_tag['tag_id'];
        }
        
        $hotel_notags = array();
        $hotel_untags = array_diff($tag_array,$hotel_tags_array);
        foreach($hotel_untags as $hotel_untag){
            $hotel_notags[] = $hotel_untag;
        }


        //Hotel Facility
        $hotel_facility_selected = HotelFacility::where('hotel_id', '=', $id)->first();


        $facility_table = new HotelFacility;
        $hotel_facility_list = $facility_table->getTableColumns();
        
        $hotel_facility_label = array();
        foreach ($hotel_facility_list as $facilities){
            $facilities = str_replace("_"," ",$facilities);
            $hotel_facility_label[] = ucwords($facilities);
        }
        
        $temp_fontawesome = $hotel->getFontAwesome();


        //Hotel Image
        $hotel_image = HotelImage::where('hotel_id', '=', $id)->get()->toArray();


        // return the view and pass in the var we previously created
        return view('hotel.edit')
                ->withHotel($hotel)
                ->withCategories($cats)
                ->with('stars',$stars)
                ->withTags($tags)
                ->with('hotel_tags',$hotel_tags)
                ->with('hotel_notags',$hotel_notags)
                ->with('hotel_facility_list',$hotel_facility_list)
                ->with('hotel_facility_label',$hotel_facility_label)
                ->with('hotel_facility_selected',$hotel_facility_selected)
                ->with('temp_fontawesome',$temp_fontawesome)
                ->with('hotel_image',$hotel_image)
            ;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        // Validate the data
        $hotel = Hotel::find($id);

        $this->validate($request, array(
                'name'         => 'required|max:50',
                'star'          => 'required|integer',
                'phone'         => 'required|integer',
                'category_id'   => 'required|integer',
                'body'          => 'required',
            ));
        
        $facility_table = new HotelFacility;
        $hotel_facility_list = $facility_table->getTableColumns();

        foreach($hotel_facility_list as $hotel_facility){
            $this->validate($request, array(
                $hotel_facility => 'required',
            ));
        }
        

         // store in the database
        $post = Hotel::find($id);

        $post->name = $request->name;
        $post->category_id = $request->category_id;
        //$post->body = Purifier::clean($request->body);
        $post->body = $request->body;
        $post->phone =  $request->phone;
        $post->star =  $request->star;
        $post->coordi_x = $request->coordi_x;
        $post->coordi_y = $request->coordi_y;
        $post->handling_price = $request->handling_price;

        if ($request->featured_img) {
          $old_file = 'images/upload/'.$post->image;
          if(file_exists($old_file)) {
              unlink($old_file);
          }

          $image = $request->file('featured_img');
          $filename = time() . '.' . $image->getClientOriginalExtension();
          $location = public_path('images/upload/' . $filename);
          Image::make($image)->resize(750, 500)->save($location);

          $post->image = $filename;
        }

        $post->touch();
        $post->save();

        //$post->tags()->sync($request->tags, false);
        if($post->save()){
            if($request->tags != null){
                
                //Remove all tag from existed table
                $hotel_tags = PostTag::where('hotel_id', '=', $post->id)->get();
                foreach ($hotel_tags as $hotel_tag){
                    $hotel_tag->delete();
                }
                
                //Create new record when updated
                foreach($request->tags as $save_tag){
                    $tags = new PostTag;
                    $tags->hotel_id = $post->id;
                    $tags->tag_id = $save_tag;
                    $tags->save();
                }
            }
        }
        
        
        //Update Hotel Facilities in loop
        $fac = HotelFacility::where('hotel_id', '=', $post->id)->first();
        foreach ($hotel_facility_list as $sv_hotel_fac){
            $fac->$sv_hotel_fac = $request->$sv_hotel_fac;
        }
        $fac->save();

        Session::flash('success', 'The hotel was successfully updated!');

        return redirect()->route('hotel.edit', $post->id);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $post = hotel::find($id);

        $post->delete();

        Session::flash('success', 'The hotel was successfully deleted.');
        return redirect()->route('hotel.index');
    }
    
    public function delete($id)
    {
        $hotel = Hotel::find($id);

        $hotel->soft_delete = 1;
        $hotel->save();

        Session::flash('success', 'The hotel was successfully deleted.');
        return redirect()->route('hotel.index');
    }



    public function room($id)
    {
        if(self::CheckPermission() == false){ return redirect('auth/login');};

        $hotel = Hotel::find($id);
        $types = RoomType::all();
          
        $type_list = \App\Helpers\AppHelper::instance()->ObjectToArrayMap($types,'id','type');

        $facility_table = new HotelRoomFacility;
        $room_facility_list = $facility_table->getTableColumns();

        $temp_fontawesome = $facility_table->getFontAwesome();

        $room_facility_label = array();
        foreach ($room_facility_list as $facilities){
            $facilities = str_replace("_"," ",$facilities);
            $room_facility_label[] = ucwords($facilities);
        }

//        print_r($room_facility_list);
//        die();


        return view('hotel.room')
            ->withHotel($hotel)
            ->with('type_list',$type_list)
            ->with('room_facility_list',$room_facility_list)
            ->with('temp_fontawesome',$temp_fontawesome)
            ->with('room_facility_label',$room_facility_label);
    }

    
    public function roomcreate($id)
    {
        if(self::CheckPermission() == false){ return redirect('auth/login');};

        $hotel = Hotel::find($id);
        $types = RoomType::all();
        $type_list = \App\Helpers\AppHelper::instance()->ObjectToArrayMap($types,'id','type');
        
        //print_r($types[0]['id']);die();
        $type_lefts = array(); 
        $counter = 0;
        foreach($types as $key => $type){
            $exist_room = HotelRoom::where('room_type_id','=',$type['id'])->where('hotel_id','=',$hotel->id)->get();
            if(!count($exist_room)){
                $type_lefts[$counter]['id'] = $type['id'];
                $type_lefts[$counter]['type'] = $type['type'];
                $counter++;
            }
        }
        
        $facility_table = new HotelRoomFacility;
        $room_facility_list = $facility_table->getTableColumns();

        $room_facility_label = array();
        foreach ($room_facility_list as $facilities){
            $facilities = str_replace("_"," ",$facilities);
            $room_facility_label[] = ucwords($facilities);
        }

        $temp_fontawesome = $facility_table->getFontAwesome();
        
        return view('hotel.roomcreate')
                ->withHotel($hotel)
                ->with('type_list',$type_list)
                ->with('types',$types)
                ->with('type_lefts',$type_lefts)
                ->with('room_facility_list', $room_facility_list)
                ->with('room_facility_label',$room_facility_label)
                ->with('temp_fontawesome', $temp_fontawesome);
    }

    
    
    public function roomstore(Request $request,$id)
    {
        // validate the data
        $this->validate($request, array(
                'room_type_id'         => 'required',
                'ppl_limit'          => 'required|integer',
                'price'         => 'required|integer',
                'qty'   => 'required|integer',
                'availability'          => 'required'
            ));
        
        $room = new HotelRoom();
        $room->hotel_id = $id;
        $room->room_type_id = $request->room_type_id;
        $room->ppl_limit = $request->ppl_limit;
        $room->price = $request->price;
        $room->qty = $request->qty;
        $room->availability = $request->availability;
        $room->promo = $request->promo;
        $room->save();
        
        $facility_table = new HotelRoomFacility;
        $room_facility_list = $facility_table->getTableColumns();
        
        $facility = new HotelRoomFacility();
        $facility->hotel_room_id = $room->id;
        foreach ($room_facility_list as $sv_room_fac){
            $facility->$sv_room_fac = $request->$sv_room_fac;
        }
        $facility->save();
      
        Session::flash('success', 'The room was successfully created!');

        return redirect()->route('hotel.room',$id);
    }

    
    public function roomedit($id,$roomid)
    {
        if(self::CheckPermission() == false){ return redirect('auth/login');};

        $room = HotelRoom::find($roomid);
        $hotel = Hotel::find($id);
        $types = RoomType::all();
        $type_list = \App\Helpers\AppHelper::instance()->ObjectToArrayMap($types,'id','type');
        
        //print_r($room->facility);die();
        
        $type_lefts = array(); 
        $counter = 0;
        foreach($types as $key => $type){
            $exist_room = HotelRoom::where('room_type_id','=',$type['id'])->where('hotel_id','=',$hotel->id)->get();
            if(!count($exist_room)){
                $type_lefts[$counter]['id'] = $type['id'];
                $type_lefts[$counter]['type'] = $type['type'];
                $counter++;
            }
        }
        
        $room_facility_selected = HotelRoomFacility::where('hotel_room_id', '=', $roomid)->first();
        
        $facility_table = new HotelRoomFacility;
        $room_facility_list = $facility_table->getTableColumns();

        $room_facility_label = array();
        foreach ($room_facility_list as $facilities){
            $facilities = str_replace("_"," ",$facilities);
            $room_facility_label[] = ucwords($facilities);
        }

        $temp_fontawesome = $facility_table->getFontAwesome();

        //print_r($room_facility_label);die();
        
        
        return view('hotel.roomedit')
                ->withHotel($hotel)
                ->with('type_list',$type_list)
                ->with('types',$types)
                ->with('type_lefts',$type_lefts)
                ->withRoom($room)
                ->with('room_facility_list',$room_facility_list)
                ->with('room_facility_selected',$room_facility_selected)
                ->with('room_facility_label',$room_facility_label)
                ->with('temp_fontawesome',$temp_fontawesome);
    }
    
    
    public function roomupdate(Request $request, $id, $roomid)
    {
        
        // validate the data
        $this->validate($request, array(
                'room_type_id'         => 'required',
                'ppl_limit'          => 'required|integer',
                'price'         => 'required|integer',
                'qty'   => 'required|integer',
                'availability'          => 'required'
            ));
        
        
        $room = HotelRoom::find($roomid);
        $room->room_type_id = $request->room_type_id;
        $room->ppl_limit = $request->ppl_limit;
        $room->price = $request->price;
        $room->qty = $request->qty;
        $room->availability = $request->availability;
        $room->promo = $request->promo;
        $room->save();
        

        //Update Romm Facilities in loop        
        $facility_table = new HotelRoomFacility;
        $room_facility_list = $facility_table->getTableColumns();
        
        $fac = HotelRoomFacility::where('hotel_room_id', '=', $roomid)->first();
        foreach ($room_facility_list as $sv_room_fac){
            $fac->$sv_room_fac = $request->$sv_room_fac;
        }
        $fac->save();
        
        
        return redirect()->route('hotel.roomedit',['id'=> $id,'roomid' => $roomid]);
    }

    public function roomdelete($id,$roomid)
    {

        $room = HotelRoom::find($roomid);
        $room->delete();

        Session::flash('success', 'The room was successfully deleted.');
        return redirect()->route('hotel.room',$id);
    }


    public function allhotels()
    {
        $data = self::HotelGrid();

        $hotels = Hotel::select('*');
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
            ->with('search_small', $search_small);
    }


    public function HotelGrid(){
        $data = app('App\Http\Controllers\PagesController')->HotelGrid();

        return $data;
    }
    
    
    public function book($id,$roomid)
    {
        //$id = hotel's id;
        if(!Auth::check()){
            Session::flash('success', 'Please login!');
            return redirect('auth/login');
        }
        
        $hotel = Hotel::where('id','=',$id)->first();
        $room = HotelRoom::where('id','=',$roomid)->where('hotel_id','=',$id)->first();

        if($room == null){
            return redirect('/');
        }

        $room_type_list = \App\Helpers\AppHelper::instance()->ObjectToArrayMap(RoomType::all(),'id','type');
        $payment_method = PaymentMethod::all();

        $today = date('Y-m-d');

        $user_id = Auth::user()->id;
        $user = User::where('id','=',$user_id)->first();

        return view('hotel.book')
            ->with('room',$room)
            ->with('room_type_list', $room_type_list)
            ->with('hotel',$hotel)
            ->with('today', $today)
            ->with('user',$user)
            ->with('payment_method', $payment_method);
    }


    public function booking(Request $request,$id,$roomid)
    {

        //$post->name = $request->title;
        $this->validate($request, array(
            'name'         => 'required',
        ));

        sleep(5);

        $booking = new Booking;
        $booking->user_id = Auth::user()->id;
        $booking->hotel_id = $id;
        $booking->hotel_room_id = $roomid;
        $booking->people = count($request->name);
        $booking->in_date = $request->in_date;
        $booking->out_date = $request->out_date;
        $booking->book_date = date('Y-m-d H:i:s');
        $booking->total_price = $request->total_price;
        $booking->payment_method_id = $request->payment_method;
        $booking->approved = 1;
        $booking->status = 1;
        $booking->save();

        if($booking->save()){

            $payment = new BookingPayment();
            $payment->booking_id = $booking->id;
            $payment->user_id = $booking->user_id;
            $payment->single_price = $request->single_price;
            $payment->handling_price = $request->handling_price;
            $payment->total_price = $booking->total_price;
            $payment->payment_method_id = $request->payment_method;
            $payment->card_number = $request->card_number;
            $payment->expired_date = $request->expired_date;
            $payment->security_number = $request->security_number;
            if($request->payment_method == 5) {
                $payment->status = 0;
            } else {
                $payment->status = 1;
            }
            $payment->save();

            if($payment->save()){

                for ($x = 0; $x < count($request->name); $x++) {
                    $guest = new BookingGuest();
                    $guest->booking_id = $booking->id;
                    $guest->name = $request->name[$x];
                    $guest->phone = $request->phone[$x];

                    $c = $x + 1;
                    if($request['gender'.$c][0] != null){
                        $gender = $request['gender'.$c][0];
                    } else {
                        $gender = '';
                    }

                    $guest->gender = $gender;
                    $guest->email = $request->email[$x];
                    $guest->save();
                }

                return redirect('booklist');
            }
        }


        Session::flash('success', 'Sucess booking!');

        //return redirect()->route('hotel.index', $post->id);
    }

    public function booklist()
    {

        if(!Auth::check()){
            return redirect('auth/login');
        } else {
            $user_id = Auth::user()->id;
        };

        $booking = Booking::where('user_id', '=', $user_id)->orderby('in_date','DESC')->get();
        $room_type_list = \App\Helpers\AppHelper::instance()->ObjectToArrayMap(RoomType::all(),'id','type');
        $pay_method_list = \App\Helpers\AppHelper::instance()->ObjectToArrayMap(PaymentMethod::all(),'id','type');

        $room_type = null;
        $pay_method = null;

        if($booking != null) {
            foreach ($booking as $k => $bk) {
                $room[$k] = HotelRoom::where('id', '=', $bk->hotel_room_id)->get()->toarray();
                $room_type[$k] = $room_type_list[$room[$k][0]['room_type_id']];
                $pay_method[$k] = $pay_method_list[$bk->payment['payment_method_id']];
            }
        }

        //print_r($pay_method);die();

        return view('pages.booklist')
            ->with('room_type',$room_type)
            ->with('room_type_list', $room_type_list)
            ->with('pay_method', $pay_method)
            ->with('booking', $booking);
    }

    public function Payment()
    {

        if(!Auth::check()){
            return redirect('auth/login');
        } else {
            $user_id = Auth::user()->id;
        };

        $booking = Booking::where('user_id', '=', $user_id)->orderby('in_date','DESC')->get();
        $room_type_list = \App\Helpers\AppHelper::instance()->ObjectToArrayMap(RoomType::all(),'id','type');
        $pay_method_list = \App\Helpers\AppHelper::instance()->ObjectToArrayMap(PaymentMethod::all(),'id','type');

        $room_type = null;
        $pay_method = null;

        if($booking != null) {
            foreach ($booking as $k => $bk) {
                $room[$k] = HotelRoom::where('id', '=', $bk->hotel_room_id)->get()->toarray();
                $room_type[$k] = $room_type_list[$room[$k][0]['room_type_id']];
                $pay_method[$k] = $pay_method_list[$bk->payment['payment_method_id']];
            }
        }

        //print_r($pay_method);die();

        return view('pages.payment')
            ->with('room_type',$room_type)
            ->with('room_type_list', $room_type_list)
            ->with('pay_method', $pay_method)
            ->with('booking', $booking);
    }
    
    public function Comment(Request $request,$id)
    {
        
        $this->validate($request, [
            'comment' => 'required',
            'rating' => 'required',
        ]);

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


        return view('pages.account')->with('user',$user);
    }
    
    
    

    public function CheckPermission(){

        if(Auth::check()){
            if(Auth::user()->role != 'superadmin'){
                return false;
            }
        } else {
            return false;
        }

        return true;
    }


}
