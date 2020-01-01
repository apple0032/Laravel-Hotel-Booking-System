<?php

namespace App\Http\Controllers;

use App\Booking;
use App\Airports;
use App\TripAdviser;
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
use App\Country;
use App\ApiInfo;
use App\Itinerary;

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
        
        //print_r($trip_data->itinerary);die();
        //echo '<pre>';print_r($booking);echo '</pre>';die();

        $city = Cities::where('name','=',$trip_data->city)->first();

        $bk = self::getHotelBookingFromNodeAPI($trip_data->user_id);
        //$bk = null;
        //echo '<pre>';print_r($bk);echo '</pre>';die();

        return view('trip.info')
            ->with('flight',$flight)
            ->with('booking',$booking)
            ->with('trip_data',$trip_data)
            ->with('trip',$trip)
            ->with('bk',$bk);
    }

    public function getHotelBookingFromNodeAPI($userid){
        $host = request()->getHost();
        $host = 'http://'.$host.':8080/hotel/booking/'.$userid;
        $api_key = ApiInfo::NodeAPI();
        $headers[] = 'api_key: '.$api_key;
        //print_r($host);die();

        $ch = curl_init($host);
        curl_setopt($ch, CURLOPT_HTTPHEADER,$headers);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);

        $response = curl_exec($ch);
        curl_close($ch);
        $arr = json_decode($response,true);

        $bk = array();

        if($arr != null) {
            foreach ($arr['booking'] as $k => $booking) {
                $bk[$k]['id'] = $booking['id'];
                $bk[$k]['hotel'] = $booking['hotel']['name'];
                $bk[$k]['in_date'] = $rest = substr($booking['in_date'], 0, 10);
                $bk[$k]['out_date'] = $rest = substr($booking['out_date'], 0, 10);
            }
        }

        return $bk;
    }

        public function matchbooking(Request $request){
        
        $host = request()->getHost();
        $host = 'http://'.$host.':8080/hotel/trip_match/'.$request->id.'/'.$request->booking;
        $api_key = ApiInfo::NodeAPI();
        $headers[] = 'api_key: '.$api_key;

        $ch = curl_init($host);
        curl_setopt($ch, CURLOPT_HTTPHEADER,$headers);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "PUT");

        $response = curl_exec($ch);
        curl_close($ch);
        $arr = json_decode($response,true);
            
        $response = array(
            'status' => 'success',
        );

        return response()->json($response);
    }

    public function getTripAdviser($city){

        $city_name = $city;
        $city = Cities::where('name','=',$city)->first();
        if($city == null){
            return redirect()->route('pages.error');
        }

        $airports = Airports::select('*')->where('municipality', '=', $city_name)->first();
        $country_code = $airports->iso_country;

        $country = TripAdviser::searchCountryByCode($country_code);
        $country = $country['name'];

        $data = TripAdviser::getTripCollections($city);
        $data = TripAdviser::getPlaceIdFromCollectionsData($data);
        $data = TripAdviser::getPlacesDetailsByMultiIds($data);
        $data = $data['data']['places'];

        //echo '<pre>';print_r($data);echo '</pre>';die();

        return view('trip.adviser')
            ->with('data',$data)
            ->with('city',$city)
            ->with('country',$country)
            ->with('country_code',$country_code);
    }

    public function generateItinerary(Request $request){
        //AJAX to generate itinerary

        $user_id = Auth::user()->id;
        $city = $request->city;
        $start = substr($request->date, 0, 10);
        $end = substr($request->date, -10);
        $starttime = $request->starttime;
        $endtime = $request->endtime;

        //print_r($city);print_r($start);print_r($end);print_r($starttime);print_r($endtime);die();
        $priority = $request->priority;
        foreach ($priority as $k => $p){
            $priority[$k] = intval(substr($priority[$k], 0, -1));
        }

        $priority = json_encode($priority);
        $priority = str_replace("outdoor","going_out",$priority);

        $point = $request->point;
        $hottest = $request->hottest;
        $has_accom = $request->has_accom;

        //Generate all itineraries by NodeJSAPI
        $itinerary = $this->getItineraryFromNodeAPI($city,$start,$end,$starttime,$endtime,$priority,$point,$hottest,$has_accom);

        //Get all pois from the itinerary
        $itinerary_json = json_decode($itinerary,true);
        $pois = json_encode($itinerary_json['itinerary_pois']);
        $trip_days = json_encode($itinerary_json['trip_days']);

        //Get the all pois string
        $poi_string = $this->getPOIStringFromNodeAPI($pois);
        $poi_string = json_decode($poi_string,true);

        //Get all details from details API where the Sygic API only accept max 64 of pois
        foreach ($poi_string['places_list'] as $poi){
            $poi_arr[] = json_decode($this->getPOIDetailsFromNodeAPI($poi),true);
        }

        $poi_data = array();
        foreach($poi_arr as $p){
            foreach ($p['details'] as $pinfo) {
                array_push($poi_data, $pinfo);
            }
        }

        $poi_details = array();
        foreach ($poi_data as $a){
            $poi_details[$a['id']] = $a;
        }
        
        $stay_obj = array();
        for ($x = 0; $x < $trip_days; $x++) {
            $stay_obj[$x]['start'] = 1;
            $stay_obj[$x]['end'] = 1;
        }
        $stay_obj = '{"roomflag" : '.json_encode($stay_obj).'}';

        $new = new Itinerary();
        $new->user_id = $user_id;
        $new->itinerary_obj = $itinerary;
        $new->pois = json_encode($poi_details,true);
        $new->stay_obj = $stay_obj;
        $new->save();


        $response = array(
            'status' => "success",
            'id' => $new->id
        );

        return response()->json($response);
    }

    public function ItineraryIndex($id){

        //$plan = Itinerary::where('id', '=', 1)->get()->first();
        //echo '<pre>'; print_r($plan->itinerary_obj); echo '</pre>'; die();

        $user_id = Auth::user()->id;
        //$path = 'http://'.request()->getHttpHost().'/hotelsdb/storage/itinerary2.json';
        //$itinerary = json_decode(file_get_contents($path), true);
        //echo'<pre>'; print_r($itinerary); echo '</pre>';die();

        $api_key = ApiInfo::GoogleMapApiData();
        $itinerary = Itinerary::where('id', '=', $id)->get()->first();
        $poi_details = json_decode($itinerary['pois'],true);
        $stay = json_decode($itinerary['stay_obj'],true);
        $itinerary = json_decode($itinerary['itinerary_obj'],true);

        $related_flight_id = null;
        if($itinerary['related_flight_id'] != 'null') {
            $related_flight_id = $itinerary['related_flight_id'];
        }
        $city = $itinerary['city'];

        $edit_itinerary = array();
        $itinerary_timeflag = array();
        $have_hotel = false;
        $hotel_details = null;
        foreach($itinerary['schedule'] as $k => $iti){
            foreach ($iti as $k2 => $poi_gp){
                if($have_hotel == false){
                    if($poi_gp[1]['type'] == "hotel"){
                        $have_hotel = true;
                        $hotel_details = $poi_gp[1];
                    }
                }
                array_push($itinerary_timeflag, $poi_gp[0]);
                $poi_arr = array();
                foreach ($poi_gp as $k3 => $poi){
                    if(isset($poi['poi_id']) && $poi['poi_id'] != 'hotel'){
                        $poise['poi'] = $poi['poi_id'];
                        $poise['time'] = $poi['schedule_time'];
                        $poise['duration'] = $poi['duration'];
                        $poise['location'] = $poi_details[$poise['poi']]['name'];
                        $poise['thumbnail'] = $poi_details[$poise['poi']]['thumbnail_url'];
                        array_push($poi_arr,$poise);
                    }
                    $edit_itinerary[$k] = $poi_arr;
                }
            }
        }

        return view('trip.itinerary')
            ->with('id',$id)
            ->with('itinerary',$itinerary)
            ->with('related_flight_id',$related_flight_id)
            ->with('poi_data',$poi_details)
            ->with('edit_itinerary', $edit_itinerary)
            ->with('itinerary_timeflag', $itinerary_timeflag)
            ->with('stay',$stay)
            ->with('hotel_details', $hotel_details)
            ->with('city',$city)
            ->with('api_key',$api_key);
    }

    public function getItineraryFromNodeAPI($city,$start,$end,$starttime,$endtime,$priority,$point,$hottest,$has_accom){
        $host = request()->getHost();
        $host = 'http://'.$host.':8080/trip';
        $api_key = ApiInfo::NodeAPI();

        $post = [
            'city' => $city,
            'limit' => '500',
            'priority' => $priority,
            'trip_start' => $start,
            'trip_end' => $end,
            'start_time' => $starttime,
            'dayend_time' => $endtime
        ];

        if($hottest == 1){
            $post['hottest'] = 1;
        }
        if($has_accom == 1){
            $post['start_point'] = $point;
            $post['end_point'] = $point;
            $post['start_location'] = 'hotel';
            $post['end_location'] = 'hotel';
        }

        $ch = curl_init($host);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/x-www-form-urlencoded','api_key: '.$api_key));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
        curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($post));

        $response = curl_exec($ch);
        curl_close($ch);
        //$result = json_decode($response,true);

        return $response;
    }

    public function getPOIStringFromNodeAPI($pois){
        $host = request()->getHost();
        $host = 'http://'.$host.':8080/pois';
        $api_key = ApiInfo::NodeAPI();

        $post = [
            'pois' => $pois
        ];

        $ch = curl_init($host);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/x-www-form-urlencoded','api_key: '.$api_key));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
        curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($post));

        $response = curl_exec($ch);
        curl_close($ch);
        //$result = json_decode($response,true);

        return $response;
    }

    public function getPOIDetailsFromNodeAPI($pois){
        $host = request()->getHost();
        $host = 'http://'.$host.':8080/pois-info';
        $api_key = ApiInfo::NodeAPI();

        $post = [
            'pois' => $pois
        ];

        $ch = curl_init($host);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/x-www-form-urlencoded','api_key: '.$api_key));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
        curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($post));

        $response = curl_exec($ch);
        curl_close($ch);
        //$result = json_decode($response,true);

        return $response;
    }

    public function PlanIndex(){

        $categories = array(
            "shopping" => "fa-shopping-cart",
            "eating" => "fa-utensils",
            "relaxing" => "fa-couch",
            "sightseeing" => "fa-torii-gate",
            "playing" => "fa-football-ball",
            "outdoor" => "fa-hiking",
            "discovering" => "fa-binoculars"
        );

        $api_key = ApiInfo::GoogleMapJsApiData();
        
        return view('trip.plan')->with('categories',$categories)->with('api_key',$api_key);
    }

    public function searchCity(Request $request){

        if($request->type == "match") {
            $cities = Cities::where('name', 'like', '%' . $request->name . '%')->get()->toArray();
        } else {
            $cities = Cities::where('name', '=', $request->name)->get()->toArray();
        }

        //$city = array('osaka', 'tokyo');
        //print_r($city);die();

        $response = array(
            'status' => "success",
            'city' => $cities
        );

        return response()->json($response);
    }


    public function searchPlaces(Request $request){

        $keyword = str_replace(" ","%7C",$request->keyword);

        $api_key = ApiInfo::GoogleMapApiData();
        $url='https://maps.googleapis.com/maps/api/place/textsearch/json?query='.$keyword.'&language=en&key='.$api_key;
        $response=file_get_contents($url);
        $response = json_decode($response,true);

        //print_r($response['results']);die();
        $result = array();
        foreach ($response['results'] as $k => $place){
            if($k < 10) {
                $result[$k]['name'] = $place['name'];
                $result[$k]['location'] = $place['geometry']['location'];
            }
        }

        //print_r($result);die();

        $response = array(
            'status' => "success",
            'result' => $result
        );

        return response()->json($response);
    }

    public function updateItinerary(Request $request){
        //print_r($request->id);
        //print_r($request->day);
        //print_r($request->obj);

        $obj = json_encode($request->obj);
        $obj = '{"pois": ' . $obj . '}';

        $itinerary = Itinerary::where('id', '=', $request->id)->get()->first();
        $poi_details = json_decode($itinerary['itinerary_obj'],true);
        $poi_info = json_decode($itinerary['pois'],true);

        $day = array_keys( $poi_details['schedule'][$request->day] )[0];

        $host = request()->getHost();
        $host = 'http://'.$host.':8080/trip-update';
        $api_key = ApiInfo::NodeAPI();

        $post = [
            'pois' => $obj,
            'date' => $day,
            'start_time' => $request->start_time,
            'end_time' => $request->end_time,
            'hotel' => $request->hotel_details
        ];

        $ch = curl_init($host);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/x-www-form-urlencoded','api_key: '.$api_key));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
        curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($post));

        $response = curl_exec($ch);
        curl_close($ch);
        $result = json_decode($response,true);

        $update_json = json_encode($result['schedule'][0][$day],JSON_UNESCAPED_SLASHES);
        //$update_json = '[{"type":"poi","poi_id":"poi:20610","location":"Takashimaya","coordinate":"35.0030805,135.7683288","duration":3600,"rating":0.029983700945047,"schedule_time":"1/6/2020, 10:00:00","perex":"Shopaholics - beware! This major Kyoto department store is the right place for you.","thumbnail_url":"https://media-cdn.sygictraveldata.com/media/poi:20610"},{"type":"transport","duration":2606,"distance":26333},{"type":"poi","poi_id":"poi:20515","location":"Chion-in temple","coordinate":"35.0055008,135.7833427","duration":3600,"rating":0.18299526981186,"schedule_time":"1/6/2020, 11:31:00","perex":"Chion-in in Higashiyama-ku, Kyoto, Japan is the headquarters of the J\u014ddo-sh\u016b founded by H\u014dnen, who proclaimed that sentient beings are\u2026","thumbnail_url":"https://media-cdn.sygictraveldata.com/media/poi:20515"},{"type":"transport","duration":748,"distance":6993},{"type":"poi","poi_id":"poi:20606","location":"Pontoch\u014d","coordinate":"35.0042456,135.7712125","duration":5400,"rating":0.58326359302772,"schedule_time":"1/6/2020, 13:13:00","perex":"Ponto-ch\u014d is a Hanamachi district, which literally translates as \"flower town.\" This name is a Japanese way of saying that there are geisha\u2026","thumbnail_url":"https://media-cdn.sygictraveldata.com/media/poi:20606"}]';

        $new = array();
        $new[$day] = json_decode($update_json,true);

        $poi_details['schedule'][$request->day] = $new;
        $new_json = json_encode($poi_details,JSON_UNESCAPED_SLASHES);

        //print_r($new_json);die();
        $itinerary->itinerary_obj = $new_json;
        
        foreach($result['details'] as $poi_id => $de){
            if(!isset($poi_info[$poi_id])){
                $poi_info[$poi_id] = $de;
            }
        }
        $itinerary->pois = json_encode($poi_info,true);
        
        $itinerary->save();

        $response = array(
            'status' => "success",
            'result' => $itinerary
        );

        return response()->json($response);
    }


    public function ItineraryAll($user_id){

        $itineraries = Itinerary::where('user_id', '=', $user_id)->get()->toArray();
        $city = array();
        foreach($itineraries as $k =>$itinerary){
            $json = json_decode($itinerary['itinerary_obj'],true);
            $city[$k]['city'] = $json['city_name'];
            $flag = Airports::where('municipality', '=', $city[$k]['city'])->get()->first();
            if($flag != null) {
                $city[$k]['flag'] = $flag->iso_country;
            } else {
                $cities = Cities::where('name', '=', $city[$k]['city'])->get()->first();
                $country = Country::where('country_id', '=', $cities->country_id)->get()->first();

                if($country != null) {
                    $result = self::getCountryCodeByAPI($country->name);
                    $result = json_decode($result,true);
                    $city[$k]['flag'] = $result[0]['alpha2Code'];
                } else {
                    $city[$k]['flag'] = null;
                }
            }

            $city[$k]['start'] = $json['trip_start'];
            $city[$k]['end'] = $json['trip_end'];
            $city[$k]['total'] = $json['trip_days'];
        }

        //print_r($city);die();
        //print_r($itinerary);die();

        return view('trip.itinerary_index')
            ->with('city',$city)
            ->with('itineraries',$itineraries);
    }

    public function getCountryCodeByAPI($name){
        $url = 'https://restcountries.eu/rest/v2/name/'.$name;
        $result = file_get_contents($url, false);

        return $result;
    }

    public function ItineraryDelete($id){
        $itinerary = Itinerary::where('id', '=', $id)->get()->first();
        $itinerary->delete();
        return redirect()->back();
    }

    public function ItineraryCopy($id){
        $itinerary = Itinerary::where('id', '=', $id)->get()->first();

        $new = new Itinerary();
        $new->user_id = $itinerary->user_id;
        $new->itinerary_obj = $itinerary->itinerary_obj;
        $new->pois = $itinerary->pois;
        $new->save();

        return redirect()->back();
    }
    
    public function searchAttractions(Request $request){
        
        $host = request()->getHost();
        $host = 'http://'.$host.':8080/trip/search';
        $api_key = ApiInfo::NodeAPI();

        $post = [
            'keyword' => $request->keyword,
            'city' => $request->city
        ];

        $ch = curl_init($host);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/x-www-form-urlencoded','api_key: '.$api_key));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
        curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($post));

        $response = curl_exec($ch);
        curl_close($ch);
        $result = json_decode($response,true);
        
        return $result['places'];
    }

    public function updateRoomView(Request $request){
        //print_r($request->id);die();

        $itinerary = Itinerary::where('id', '=', $request->id)->get()->first();
        $stay_obj = json_decode($itinerary->stay_obj,true);
        $obj = $stay_obj['roomflag'][$request->day];
        $obj['start'] = intval($request->start);
        $obj['end'] = intval($request->end);

        $stay_obj['roomflag'][$request->day] = $obj;
        $update_obj = json_encode($stay_obj);

        $itinerary->stay_obj = $update_obj;
        $itinerary->save();

        return;
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

1. First,import the cities CSV file into system database //DONE
2. In table 'airport', we have airport name, airport code, iso country, city name, coordinates etc..  //DONE
3. We have enough information & support to call sygic API because the `city name` is linkage from both side(We can store city name in each trip) //DONE
4. Need to update/enhance flight system search UI to include city name on each of the trip //DONE


5. This API get all articles from country id (These API return place_ids array like : poi:19886)
 * https://api.sygictravelapi.com/1.1/en/collections?parent_place_id=country:75
 * https://api.sygictravelapi.com/1.1/en/collections?parent_place_id=city:2585
    - What to See in Tokyo
    - Popular Parks in Tokyo
    - Best Restaurants in Tokyo

6. This API get all attractions from city
 * https://api.sygictravelapi.com/1.1/en/places/list?parents=city:2585&level=poi&limit=100


7. This API get details of each points/attractions including photo & desc
 * https://api.sygictravelapi.com/1.1/en/places/poi:19822
 * https://api.sygictravelapi.com/1.1/en/places?ids=poi:19822%7Cpoi:19967 //get all ids


8. This API is a search API by inputting string
 * https://api.sygictravelapi.com/1.1/en/places/list?query=Senso-ji


9. This API search for media information by attraction id
 * https://api.sygictravelapi.com/1.1/en/places/poi:19822/media



*/