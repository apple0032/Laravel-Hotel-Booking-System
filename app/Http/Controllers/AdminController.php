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
    public function user(Request $request)
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
        

        return view('admin.user')
            ->with('users',$users)
            ->with('name',$name);
    }
    
    
    public function hotel(Request $request)
    {

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
        
        foreach($hotels as $k => $hotel){
            $book_percent[$k] = Hotel::CheckBookingStatus($hotel->id, $book_date);
        }

        return view('admin.hotel')->with('hotels',$hotels)->with('book_percent',$book_percent)->with('name',$name);
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
        foreach ($hotel_facility_list as $facilities){
            $facilities = str_replace("_"," ",$facilities);
            $hotel_facility_label[] = ucwords($facilities);
        }

        $hotel = new Hotel();
        $temp_fontawesome = $hotel->getFontAwesome();
        
        return view('admin.create')
            ->withCategories($categories)
            ->withTags($tags)
            ->withStars($stars)
            ->with('hotel_facility_list',$hotel_facility_list)
            ->with('hotel_facility_label',$hotel_facility_label)
            ->with('temp_fontawesome',$temp_fontawesome);
    }
    
    
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

        return redirect()->route('admin.hotel');
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
        return view('admin.edit')
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

        return redirect()->route('admin.hotel', $post->id);
    }


}
