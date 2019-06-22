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
use App\Cities;
use App\ApiInfo;

class TripController extends Controller
{

    public function __construct() {
        $this->middleware(['auth']);
    }

    public function TripIndex(){

        $user_id = Auth::user()->id;
        $join = User::select('created_at')->where('id','=',$user_id)->first()->toArray();
        $join = substr($join['created_at'], 0, 10);

        $trip = Trip::select('*')
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
            $trip[$k]['image'] = $this->getCountryImage($trip[$k]['booking']['country'],$tr['city']);
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


    public function getCountryImage($country,$city){

        $image = CountryImage::where('country','=',$country)->first();
        $image = $image['image'];

        if($image != null){
            return $image;
        } else {

            $city = Cities::where('name','=',$city)->first();

            if($city == null) {
                return $this->getCountryImageByGoogleAPI($country);
            } else {
                return $this->getCountryImageBySygicApi($city,$country);
            }
        }
    }

    public function getCountryImageBySygicApi($city,$country){

        $city = $city->country_id;

        $host = 'https://api.sygictravelapi.com/1.1/en/places/'.$city.'/media';
        $api_key = ApiInfo::SygicTravelApi();

        $ch = curl_init($host);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('x-api-key: '.$api_key));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);

        // execute api
        $response = curl_exec($ch);

        // close the connection, release resources used
        curl_close($ch);

        //return result
        $response = json_decode($response,true);

        if(isset($response['data']['media'][0]['url'])){
            $image = $response['data']['media'][0]['url'];

            $ig = new CountryImage();
            $ig->country = $country;
            $ig->image = $image;
            $ig->save();
        }

        return $image;
    }


    public function getCountryImageByGoogleAPI($country){

        $apiData = ApiInfo::GoogleSearchApiData();

        $data = array(
            'q'=> $country.' beautiful',
            'cx'=> $apiData['cx'],
            'key'=> $apiData['key'],
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

        $city = Cities::where('name','=',$trip_data->city)->first();

        return view('trip.info')
            ->with('flight',$flight)
            ->with('booking',$booking)
            ->with('trip_data',$trip_data)
            ->with('trip',$trip);
    }

}


/****************************************************************************
 *** TRIP MANAGEMENT SYSTEM RESOURCES, DATA SOURCES, DATA FLOW, LOGIC FLOW***
 ****************************************************************************
 
Trip advisor & Data sources - 
http://docs.sygictravelapi.com/1.1/#
 - x-api-key (Each request must contain an authorization header that identifies the requesting party)

https://www.inspirock.com/trip/6-days-in-tokyo-itinerary-in-june-7250aad4-2ccd-425e-b1e2-08b0fffe3934/overview
https://www.trip-jam.com/organizer/zh_TW/nl7hlZcx/1
 - The demo function/web application that hotelsdb trying to clone it.

https://fullcalendar.io/
 - javascript based widget to do drag&drop action on their trip.

https://admin.sygictraveldata.com/data-export/zf8979vspcvz61dya3pyxbvsduyjtnh4
- List of top cities CSV file that provided by sygictravel

1. First,import the cities CSV file into system database
2. In table 'airport', we have airport name, airport code, iso country, city name, coordinates etc..
3. We have enough information & support to call sygic API because the `city name` is linkage from both side(We can store city name in each trip)
4. Need to update/enhance flight system search UI to include city name on each of the trip
5. This API get all articles from country id
 * https://api.sygictravelapi.com/1.1/en/collections?parent_place_id=country:75
6. This API get all attractions from city
 * https://api.sygictravelapi.com/1.1/en/places/list?parents=city:2585&level=poi&limit=100
7. This API get details of each points/attractions including photo & desc
 * https://api.sygictravelapi.com/1.1/en/places/poi:19822
8. This API is a search API by inputting string
 * https://api.sygictravelapi.com/1.1/en/places/list?query=Senso-ji
9. This API search for media information by attraction id
 * https://api.sygictravelapi.com/1.1/en/places/poi:19822/media

*/