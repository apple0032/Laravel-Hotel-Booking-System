<?php

namespace App\Http\Controllers;

use App\Booking;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\User;
use Mail;
use Session;
use Purifier;
use Auth;
use Redirect;
use DB;
use App\FlightBooking;
use App\FlightPassenger;
use App\FlightPayment;
use App\Trip;
use App\CountryImage;

class TripController extends Controller
{

    public function __construct() {
        $this->middleware(['auth']);
    }

    public function TripIndex(){

        $user_id = Auth::user()->id;
        $join = User::select('created_at')->where('id','=',$user_id)->first()->toArray();
        $join = substr($join['created_at'], 0, 10);

        $trip = Trip::select('id','booking_id','related_flight_id','user_id')
            ->where('user_id','=',$user_id)
            ->orderby('id','desc')
            ->get()
            ->toArray();

        foreach ($trip as $k => $tr){
            $trip_book =
                FlightBooking::select('country','country_code','arr_country','arr_country_code','dep_date')
                    ->where('related_flight_id','=',$tr['related_flight_id'])
                    ->get()
                    ->toArray();

            $trip[$k]['booking'] = $this->getFlightBookingTripInfo($trip_book);
            $trip[$k]['image'] = $this->getCountryImage($trip[$k]['booking']['country']);
            $trip[$k]['order'] = $k + 1;
        }

        //echo '<pre>';print_r($trip);echo '</pre>';die();

        return view('trip.index')->with('trip',$trip)->with('join',$join);
    }


    public function getFlightBookingTripInfo($booking){

        if(count($booking) == 1){
            $booking = $booking[0];

            $bk = array();
            if($booking['country_code'] == 'HK'){
                $bk['country'] = $booking['arr_country'];
                $bk['country_code'] = $booking['arr_country_code'];
            } else {
                $bk['country'] = $booking['country'];
                $bk['country_code'] = $booking['country_code'];
            }

            $bk['dep_date'] = substr($booking['dep_date'], 0, 10);
        } else {
            $bk = array();
            if($booking[0]['country_code'] == 'HK'){
                $bk['country'] = $booking[0]['arr_country'];
                $bk['country_code'] = $booking[0]['arr_country_code'];
            } else {
                $bk['country'] = $booking[0]['country'];
                $bk['country_code'] = $booking[0]['country_code'];
            }

            if($booking[1]['dep_date'] > $booking[0]['dep_date']){
                $bk['dep_date'] = substr($booking[0]['dep_date'], 0, 10) .' -> '. substr($booking[1]['dep_date'], 0, 10);
            } else {
                $bk['dep_date'] = substr($booking[1]['dep_date'], 0, 10) .' -> '. substr($booking[0]['dep_date'], 0, 10);
            }
        }

        return $bk;
    }


    public function getCountryImage($country){

        $image = CountryImage::where('country','=',$country)->first();
        $image = $image['image'];

        if($image != null){
            return $image;
        } else {
            return $this->getCountryImageByGoogleAPI($country);
        }
    }


    public function getCountryImageByGoogleAPI($country){
        $data = array(
            'q'=> $country.' beautiful',
            'cx'=>'/* hidden */',
            'key'=>'/* hidden */',
            'searchType'=>'image'
        );

        $search_url = http_build_query($data);

        $host = 'https://www.googleapis.com/customsearch/v1?'.$search_url;

        $ch = curl_init($host);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Expect:') );
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);

        $response = curl_exec($ch);
        curl_close($ch);
        $arr = json_decode($response,true);

        $image = $arr['items'][0]['link'];

        $ig = new CountryImage();
        $ig->country = $country;
        $ig->image = $image;
        $ig->save();

        return $image;
    }

    public function getTripDetails($trip){

        $trip_data = Trip::where('id','=',$trip)->first();
        if($trip_data == null){
            return redirect()->route('pages.error');
        }

        $flight = DB::table('flight_booking')
            ->select('flight_booking.*','flight_payment.*','flight_passenger.*')
            ->leftJoin('flight_payment', 'flight_payment.related_flight_id', '=', 'flight_booking.related_flight_id')
            ->leftJoin('flight_passenger', 'flight_passenger.related_flight_id', '=', 'flight_booking.related_flight_id')
            ->where('flight_booking.related_flight_id', '=', $trip_data->related_flight_id)
            ->groupby('flight_passenger.people_name')
            ->distinct()
            ->get();

        if($trip_data->booking_id != null){
            $booking = DB::table('booking')
                ->select('booking.*','booking_payment.*','booking_guest.*','hotel.name','hotel.star','hotel.image','hotel.default_image')
                ->leftJoin('booking_payment', 'booking_payment.booking_id', '=', 'booking.id')
                ->leftJoin('booking_guest', 'booking_guest.booking_id', '=', 'booking.id')
                ->leftJoin('hotel', 'hotel.id', '=', 'booking.hotel_id')
                ->where('booking.id', '=', $trip_data->booking_id)
                ->first();
        } else {
            $booking = null;
        }

        //echo '<pre>';print_r($booking);echo '</pre>';die();

        return view('trip.info')
            ->with('flight',$flight)
            ->with('booking',$booking)
            ->with('trip_data',$trip_data)
            ->with('trip',$trip);
    }

}
