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

    public function __construct()
    {
        $this->middleware(['auth.admin']);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function user(Request $request)
    {

        $name = $request->input('name');

        if ($name != '') {
            $users = User::where('role', '=', 'user')->Where('name', 'like', '%' . $name . '%')->orderBy('id', 'asc')->paginate(10);
        } else {
            $users = User::where('role', '=', 'user')->orderBy('id', 'asc')->paginate(10);
        }

        if ($users->count() == 0) {
            return redirect('admin');
        }

        //print_r($users);die();
        //die('This is laravel admin.');


        return view('admin.user')
            ->with('users', $users)
            ->with('name', $name);
    }


    public function hotel(Request $request)
    {

        $id = $request->input('id');
        $name = $request->input('name');

        if ($name != '') {
            if (!is_numeric($name)) {
                $name = str_replace("|", " ", $name);
                $hotels = Hotel::where('soft_delete', '=', 0)->Where('name', 'like', '%' . $name . '%')->orderBy('id', 'asc')->paginate(10);
            } else {
                $hotels = Hotel::where('soft_delete', '=', 0)->Where('id','=',$name)->orderBy('id', 'asc')->paginate(10);
            }
        } else {
            $hotels = Hotel::where('soft_delete', '=', 0)->orderBy('id', 'asc')->paginate(10);
        }

        $book_date = date("Y-m-d") . ' 00:00:00'; //current day

        foreach ($hotels as $k => $hotel) {
            $book_percent[$k] = Hotel::CheckBookingStatus($hotel->id, $book_date);
        }

        if ($hotels->count() == 0) {
            $book_percent = null;
        }

        return view('admin.hotel')->with('hotels', $hotels)->with('book_percent', $book_percent)->with('name', $name);
    }


    public function create()
    {

        $categories = Category::all();
        $tags = Tag::all();
        $stars = Hotel::hotelstar();

        //Hotel Facility

        $facility_table = new HotelFacility;
        $hotel_facility_list = $facility_table->getTableColumns();

        $hotel_facility_label = array();
        foreach ($hotel_facility_list as $facilities) {
            $facilities = str_replace("_", " ", $facilities);
            $hotel_facility_label[] = ucwords($facilities);
        }

        $hotel = new Hotel();
        $temp_fontawesome = $hotel->getFontAwesome();

        return view('admin.create')
            ->withCategories($categories)
            ->withTags($tags)
            ->withStars($stars)
            ->with('hotel_facility_list', $hotel_facility_list)
            ->with('hotel_facility_label', $hotel_facility_label)
            ->with('temp_fontawesome', $temp_fontawesome);
    }


    public function store(Request $request)
    {
        // validate the data
        $this->validate($request, array(
            'title' => 'required|max:50',
            'star' => 'required|integer',
            'phone' => 'required|integer',
            'category_id' => 'required|integer',
            'body' => 'required',

        ));

        $facility_table = new HotelFacility;
        $hotel_facility_list = $facility_table->getTableColumns();

        foreach ($hotel_facility_list as $hotel_facility) {
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
        $post->phone = $request->phone;
        $post->star = $request->star;
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
        if ($post->save()) {
            if ($request->tags != null) {
                foreach ($request->tags as $save_tag) {
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
        foreach ($hotel_facility_list as $sv_hotel_fac) {
            $facility->$sv_hotel_fac = $request->$sv_hotel_fac;
        }
        $facility->save();


        Session::flash('success', 'The new hotel was successfully created!');

        return redirect()->route('admin.hotel',['name' => $post->id]);
    }


    public function edit($id)
    {

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
        foreach ($tags as $tag) {
            $tag_array[] = $tag->id;
        }
        $hotel_tags_array = array();
        foreach ($hotel_tags as $hotel_tag) {
            $hotel_tags_array[] = $hotel_tag['tag_id'];
        }

        $hotel_notags = array();
        $hotel_untags = array_diff($tag_array, $hotel_tags_array);
        foreach ($hotel_untags as $hotel_untag) {
            $hotel_notags[] = $hotel_untag;
        }


        //Hotel Facility
        $hotel_facility_selected = HotelFacility::where('hotel_id', '=', $id)->first();


        $facility_table = new HotelFacility;
        $hotel_facility_list = $facility_table->getTableColumns();

        $hotel_facility_label = array();
        foreach ($hotel_facility_list as $facilities) {
            $facilities = str_replace("_", " ", $facilities);
            $hotel_facility_label[] = ucwords($facilities);
        }

        $temp_fontawesome = $hotel->getFontAwesome();


        //Hotel Image
        $hotel_image = HotelImage::where('hotel_id', '=', $id)->get()->toArray();


        // return the view and pass in the var we previously created
        return view('admin.edit')
            ->withHotel($hotel)
            ->withCategories($cats)
            ->with('stars', $stars)
            ->withTags($tags)
            ->with('hotel_tags', $hotel_tags)
            ->with('hotel_notags', $hotel_notags)
            ->with('hotel_facility_list', $hotel_facility_list)
            ->with('hotel_facility_label', $hotel_facility_label)
            ->with('hotel_facility_selected', $hotel_facility_selected)
            ->with('temp_fontawesome', $temp_fontawesome)
            ->with('hotel_image', $hotel_image);
    }


    public function update(Request $request, $id)
    {
        // Validate the data
        $hotel = Hotel::find($id);

        $this->validate($request, array(
            'name' => 'required|max:50',
            'star' => 'required|integer',
            'phone' => 'required|integer',
            'category_id' => 'required|integer',
            'body' => 'required',
        ));

        $facility_table = new HotelFacility;
        $hotel_facility_list = $facility_table->getTableColumns();

        foreach ($hotel_facility_list as $hotel_facility) {
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
        $post->phone = $request->phone;
        $post->star = $request->star;
        $post->coordi_x = $request->coordi_x;
        $post->coordi_y = $request->coordi_y;
        $post->handling_price = $request->handling_price;

        if ($request->featured_img) {
            $old_file = 'images/upload/' . $post->image;
            if (file_exists($old_file)) {
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
        if ($post->save()) {
            if ($request->tags != null) {

                //Remove all tag from existed table
                $hotel_tags = PostTag::where('hotel_id', '=', $post->id)->get();
                foreach ($hotel_tags as $hotel_tag) {
                    $hotel_tag->delete();
                }

                //Create new record when updated
                foreach ($request->tags as $save_tag) {
                    $tags = new PostTag;
                    $tags->hotel_id = $post->id;
                    $tags->tag_id = $save_tag;
                    $tags->save();
                }
            }
        }


        //Update Hotel Facilities in loop
        $fac = HotelFacility::where('hotel_id', '=', $post->id)->first();
        foreach ($hotel_facility_list as $sv_hotel_fac) {
            $fac->$sv_hotel_fac = $request->$sv_hotel_fac;
        }
        $fac->save();

        Session::flash('success', 'The hotel was successfully updated!');

        return redirect()->route('hotel.edit', $post->id);
    }

    public function destroy($id)
    {
        $post = hotel::find($id);

        $post->delete();

        Session::flash('success', 'The hotel was successfully deleted.');
        return redirect()->route('admin.hotel');
    }

    public function delete($id)
    {
        $hotel = Hotel::find($id);

        $hotel->soft_delete = 1;
        $hotel->save();

        Session::flash('success', 'The hotel was successfully deleted.');
        return redirect()->route('admin.hotel');
    }


    public function room($id)
    {

        $hotel = Hotel::find($id);
        $types = RoomType::all();

        $type_list = \App\Helpers\AppHelper::instance()->ObjectToArrayMap($types, 'id', 'type');

        $facility_table = new HotelRoomFacility;
        $room_facility_list = $facility_table->getTableColumns();

        $temp_fontawesome = $facility_table->getFontAwesome();

        $room_facility_label = array();
        foreach ($room_facility_list as $facilities) {
            $facilities = str_replace("_", " ", $facilities);
            $room_facility_label[] = ucwords($facilities);
        }

//        print_r($room_facility_list);
//        die();


        return view('admin.room')
            ->withHotel($hotel)
            ->with('type_list', $type_list)
            ->with('room_facility_list', $room_facility_list)
            ->with('temp_fontawesome', $temp_fontawesome)
            ->with('room_facility_label', $room_facility_label);
    }


    public function roomcreate($id)
    {

        $hotel = Hotel::find($id);
        $types = RoomType::all();
        $type_list = \App\Helpers\AppHelper::instance()->ObjectToArrayMap($types, 'id', 'type');

        //print_r($types[0]['id']);die();
        $type_lefts = array();
        $counter = 0;
        foreach ($types as $key => $type) {
            $exist_room = HotelRoom::where('room_type_id', '=', $type['id'])->where('hotel_id', '=', $hotel->id)->get();
            if (!count($exist_room)) {
                $type_lefts[$counter]['id'] = $type['id'];
                $type_lefts[$counter]['type'] = $type['type'];
                $counter++;
            }
        }

        $facility_table = new HotelRoomFacility;
        $room_facility_list = $facility_table->getTableColumns();

        $room_facility_label = array();
        foreach ($room_facility_list as $facilities) {
            $facilities = str_replace("_", " ", $facilities);
            $room_facility_label[] = ucwords($facilities);
        }

        $temp_fontawesome = $facility_table->getFontAwesome();

        return view('admin.roomcreate')
            ->withHotel($hotel)
            ->with('type_list', $type_list)
            ->with('types', $types)
            ->with('type_lefts', $type_lefts)
            ->with('room_facility_list', $room_facility_list)
            ->with('room_facility_label', $room_facility_label)
            ->with('temp_fontawesome', $temp_fontawesome);
    }


    public function roomstore(Request $request, $id)
    {
        // validate the data
        $this->validate($request, array(
            'room_type_id' => 'required',
            'ppl_limit' => 'required|integer',
            'price' => 'required|integer',
            'qty' => 'required|integer',
            'availability' => 'required'
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
        foreach ($room_facility_list as $sv_room_fac) {
            $facility->$sv_room_fac = $request->$sv_room_fac;
        }
        $facility->save();

        Session::flash('success', 'The room was successfully created!');

        return redirect()->route('hotel.room', $id);
    }


    public function roomedit($id, $roomid)
    {
        $room = HotelRoom::find($roomid);
        $hotel = Hotel::find($id);
        $types = RoomType::all();
        $type_list = \App\Helpers\AppHelper::instance()->ObjectToArrayMap($types, 'id', 'type');

        //print_r($room->facility);die();

        $type_lefts = array();
        $counter = 0;
        foreach ($types as $key => $type) {
            $exist_room = HotelRoom::where('room_type_id', '=', $type['id'])->where('hotel_id', '=', $hotel->id)->get();
            if (!count($exist_room)) {
                $type_lefts[$counter]['id'] = $type['id'];
                $type_lefts[$counter]['type'] = $type['type'];
                $counter++;
            }
        }

        $room_facility_selected = HotelRoomFacility::where('hotel_room_id', '=', $roomid)->first();

        $facility_table = new HotelRoomFacility;
        $room_facility_list = $facility_table->getTableColumns();

        $room_facility_label = array();
        foreach ($room_facility_list as $facilities) {
            $facilities = str_replace("_", " ", $facilities);
            $room_facility_label[] = ucwords($facilities);
        }

        $temp_fontawesome = $facility_table->getFontAwesome();

        //print_r($room_facility_label);die();


        return view('admin.roomedit')
            ->withHotel($hotel)
            ->with('type_list', $type_list)
            ->with('types', $types)
            ->with('type_lefts', $type_lefts)
            ->withRoom($room)
            ->with('room_facility_list', $room_facility_list)
            ->with('room_facility_selected', $room_facility_selected)
            ->with('room_facility_label', $room_facility_label)
            ->with('temp_fontawesome', $temp_fontawesome);
    }


    public function roomupdate(Request $request, $id, $roomid)
    {

        // validate the data
        $this->validate($request, array(
            'room_type_id' => 'required',
            'ppl_limit' => 'required|integer',
            'price' => 'required|integer',
            'qty' => 'required|integer',
            'availability' => 'required'
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
        foreach ($room_facility_list as $sv_room_fac) {
            $fac->$sv_room_fac = $request->$sv_room_fac;
        }
        $fac->save();


        return redirect()->route('hotel.roomedit', ['id' => $id, 'roomid' => $roomid]);
    }


    public function roomdelete($id, $roomid)
    {

        $room = HotelRoom::find($roomid);
        $room->delete();

        Session::flash('success', 'The room was successfully deleted.');
        return redirect()->route('hotel.room', $id);
    }


}
