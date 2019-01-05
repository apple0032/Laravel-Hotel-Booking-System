<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\HotelComment;
use App\HotelRoom;
use App\Booking;
use DB;

class Hotel extends Model
{
    protected $table = 'hotel';

    //Relationship
    public function category()
    {
    	return $this->belongsTo('App\Category');
    }

    public function posttag()
    {
        return $this->hasmany('App\PostTag');
    }

    public function room()
    {
        return $this->hasmany('App\HotelRoom');
    }

    public function facility()
    {
        return $this->hasone('App\HotelFacility');
    }

    public function booking()
    {
        return $this->hasmany('App\Booking');
    }

    public function allimage()
    {
        return $this->hasmany('App\HotelImage');
    }

    public function comment()
    {
        return $this->hasmany('App\HotelComment');
    }

    public static function rate($id){

        $rate = DB::table("hotel_comment")
            ->where('hotel_id', '=',$id)
            ->average('star');

        return $rate;
    }
    
    public static function hotelstar(){
        
        $stars = array(
            '0' => '0',
            '1' => '1',
            '2' => '2',
            '3' => '3',
            '4' => '4',
            '5' => '5'
        );
                
        return $stars;
    }

    public static function getFontAwesome() {
        
        //Return fontawesome i element class ORDERBY the fields in hotel_facility table.
        //Add new field may lead to an error because of not setting this element.
        
        $temp_fontawesome = array(
            "fa-ban",
            "fa-concierge-bell",
            "fa-wifi",
            "fa-utensils",
            "fa-tshirt",
            "fa-car",
            "fa-warehouse",
            "fa-cocktail",
            "fa-dumbbell",
            "fa-swimmer",
        );

        return $temp_fontawesome;
    }
    
    
    public static function CheckBookingStatus($hotel_id,$book_date){
        
        $num_room = DB::table("hotel_room")
        ->where('hotel_id', '=',$hotel_id)
        ->sum('qty');

        //Number of today booking
        $booking = Booking::where('hotel_id','=',$hotel_id)
                ->where('in_date','<=',$book_date)
                ->where('out_date','>',$book_date)
                ->get();

        if($num_room != 0){
            //Count the percentage of today booking
            $book_percent = intval((($booking->count())/$num_room)*100);
        } else {
            $book_percent = 0;
        }
        
        return $book_percent;
    }
    
    public static function validateBooking($hotel_id, $hotel_room_id, $book_date){
        
        $num_room = DB::table("hotel_room")
        ->where('id','=',$hotel_room_id)
        ->where('hotel_id', '=',$hotel_id)
        ->sum('qty');

        //Number of today booking
        $booking = Booking::where('hotel_id','=',$hotel_id)
                ->where('in_date','<=',$book_date)
                ->where('out_date','>',$book_date)
                ->get();
        
        if(($booking->count() + 1 ) > $num_room){
            $available_book = false;
        } else {
            $available_book = true;
        }
        
        return $available_book;
    }
    

}
