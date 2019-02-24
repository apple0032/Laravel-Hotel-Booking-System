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
use App\FlightStats;
use Illuminate\Support\Facades\Input;
use DateTime;
use DatePeriod;
use DateInterval;
use DB;

class FlightController extends Controller
{
    
    public function FlightIndex(){
        
        /*
         * The actual operation of Aviation industry - 
         * 
         * N kinds of Country * N kinds of City * N kinds of Airports * N kinds of Airlines * N kinds of Flights * N kinds of Price * N kinds of Price Source
         * 
         * Country code : https://countrycode.org/
         * Coutrty search api : https://restcountries.eu/#api-endpoints-language
         * 
         * Flight search process (draft at 2019-02-11)
         * 1. User typing keywords on searchbar will trigger ajax call -> country code search api   //done
         * 2. User click to select right country , get country code (HK,US,GB)  //done
         * 3. Popup a input text, call search-airport by country code API to list out all airport from selected country   //done
         * 4. Also get from_date & to_date from user input  //done
         * 5. Call Scheduled Flight(s) Api , requested params should be: addid,addkey,'HKG',arrivalAirportCode,Y-M-D    //done
         * 6. Get scheduled flight data in json format  //done
         * 7. In json->scheduledFlights, we got all of the flight,plane_eq,time,terminal..etc   //done
         * 8. We only need the price of flight code!    //done
         *
         * 9. Web form to display , calculate and store the booking flight data to local db
         * 10. Integration between hotel & flight
         *
         * 
         */
   
        
        return view('flight.index');
    }
    
    public function search(Request $request)
    {
        if(!Auth::check()){
            return redirect('auth/login');
        }

        $required_fields = array('countrycode','airport','daterange');
        $missing_fields = array();
        foreach ($required_fields as $field){
            if($request->$field == null){
                $missing_fields[] = $field;
            }
        }
        
        if($missing_fields != null){
            $missing= '';
            foreach($missing_fields as $k => $miss){
                if($k >0){
                    $missing = $missing.' , '.$miss;
                } else {
                    $missing = $miss;
                }
            }
            $error_msg = '搜索航班必須輸入以下資料: '.$missing;
            Session::flash('danger', $error_msg);
            return Redirect::route('pages.error');
        }

        $country = $request->country;
        $code = $request->countrycode;
        $de_airport = $request->departure_airport;
        $airport = $request->airport;
        $daterange = $request->daterange;
      
//        print_r($code);
//        die();
        
        if($daterange != '') {
            $range = explode("-", $daterange);
            $start = trim($range[0]) . '-' . trim($range[1]) . '-' . trim($range[2]);
            $end = trim($range[3]) . '-' . trim($range[4]) . '-' . trim($range[5]);
        }
        
        return redirect()->route('flight.result', [
            'country' => $country,
            'code' => $code,
            'from' => $de_airport,
            'to' => $airport,
            'start' => $start,
            'end' => $end
        ]);
    }
    
    public function getSearchFlightPage()
    {

        $code = Input::get('code');
        $from = Input::get('from');
        $to = Input::get('to');
        $start = Input::get('start');
        $end = Input::get('end');

        //Call Flight scheduled Api to retrieve data from api source

        $departure = self::FlightData($from,$to,$start);
        $arrival = self::FlightData($to,$from,$end);
        $airports = self::Airports($code);
        $departure_airport = self::Airports($code, $to);
        $departure_airport = $departure_airport[0]['name'];

        //Temporarily hardcoded json string to enhance speed of development

        $departure = self::ReformingJsonData($departure);
        $arrival = self::ReformingJsonData($arrival);

        //print_r($arrival);die();

        return view('flight.result')
            ->with('code', $code)
            ->with('from', $from)
            ->with('to', $to)
            ->with('start', $start)
            ->with('end',$end)
            ->with('departure',$departure)
            ->with('arrival',$arrival)
            ->with('airports',$airports)
            ->with('departure_airport',$departure_airport);
    }
    
    public function searchcountry(Request $request){

        $name = $request->name;

        if($name == ''){
            $country = null;
            $status = 'error';
        } else {
            
            $host = 'https://restcountries.eu/rest/v2/name/'.$name;

            $ch = curl_init($host);
            curl_setopt($ch, CURLOPT_HTTPHEADER, array('Expect:') );
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
            curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);

            $response = curl_exec($ch);
            curl_close($ch);

            $arr = json_decode($response);
            
            $country = $arr;
            
            $status = 'success';
            
            if (array_key_exists('status', $country)) {
                $status = 'error';
            } else {
                $status = 'success';
            }
        }

        $response = array(
            'status' => $status,
            'country' => $country,
        );

        return response()->json($response);
    }


    public function searchairport(Request $request){
        
        //https://openflights.org/data.html

        $code = $request->code;

        if($code == ''){
            $airport = null;
        } else {
            $airport = self::Airports($code);
        }

        return response()->json($airport);
    }


    protected function Airports($code, $airport = null){

        $country = $code;
        $airports = FlightStats::AirportsData($country,$airport);

        $airport = array();
        foreach ($airports as $k => $obj){
            $airport[$k]['code'] = $obj['iata_code'];
            $airport[$k]['name'] = $obj['name'];
        }

        return $airport;
    }


    protected function SchedulesAPI($departure, $arrival, $year, $month, $day){

        $api_data = FlightStats::ApiData();
        $appId = $api_data['appId'];
        $appKey = $api_data['appKey'];

        $host = 'https://api.flightstats.com/flex/schedules/rest/v1/json/from/'.$departure.'/to/'.$arrival.'/departing/'.$year.'/'.$month.'/'.$day.'/?appId='.$appId.'&appKey='.$appKey.'&extendedOptions=languageCode%3Azh';

        $ch = curl_init($host);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Expect:') );
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);

        $response = curl_exec($ch);

        curl_close($ch);

        $arr = json_decode($response,true);

        return $arr;
    }



    protected function FlightData($from,$to,$date){

        $access_token = self::GetAmadeusAccessToken();
        $flightData = self::GetFlightOffers($access_token,$from,$to,$date);

        return $flightData;
        //return json_decode($flightData,true);
    }


    protected function GetAmadeusAccessToken(){

        $host = 'https://api.amadeus.com/v1/security/oauth2/token';
        $api_data = FlightStats::ApiData();

        $post = array(
            'grant_type' => 'client_credentials',
            'client_id' => $api_data['client_id'],
            'client_secret' => $api_data['client_secret']
        );

        $ch = curl_init($host);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/x-www-form-urlencoded'));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($post)); //formdata with post method
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);

        // execute api
        $response = curl_exec($ch);

        // close the connection, release resources used
        curl_close($ch);

        //return result
        $response = json_decode($response,true);
        $access_token = $response['access_token'];

        return $access_token;
    }


    protected function GetFlightOffers($access_token,$from,$to,$date){

        $post = array(
            'origin' => $from,
            'destination' => $to,
            'departureDate' => $date,
            'nonStop' => 'true',    //Direct route to airport
            'currency' => 'HKD'
        );

        $host = 'https://api.amadeus.com/v1/shopping/flight-offers?'.http_build_query($post);

        $ch = curl_init($host);
        $headers = 'Authorization: Bearer '.$access_token;

        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            $headers
        ));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);

        $response = curl_exec($ch);

        curl_close($ch);

        return $response;
    }


    protected function ReformingJsonData($json){

        $data = json_decode($json, true);

        $flight = array();

        if(isset($data['errors'])){
            return $flight;
        }

        if(isset($data['dictionaries'])){
            $aircraft = $data['dictionaries']['aircraft'];
        } else {
            $aircraft = null;
        }

        foreach ($data['data'] as $k => $d){

            $segments = $d['offerItems'][0]['services'][0]['segments'][0];

            $flight[$k]['departure_airport'] = $segments['flightSegment']['departure']['iataCode'];
            $flight[$k]['departure_terminal'] = $segments['flightSegment']['departure']['terminal'];
            $flight[$k]['departure_timezone'] = substr($segments['flightSegment']['departure']['at'],-6);
            $flight[$k]['departure_date'] = substr($segments['flightSegment']['departure']['at'], 0, 10);
            $flight[$k]['departure_time'] = str_replace($flight[$k]['departure_timezone'],"",substr(str_replace($flight[$k]['departure_date']," ",$segments['flightSegment']['departure']['at']),2));


            $flight[$k]['arrival_airport'] = $segments['flightSegment']['arrival']['iataCode'];
            $flight[$k]['arrival_terminal'] = $segments['flightSegment']['arrival']['terminal'];
            $flight[$k]['arrival_timezone'] = substr($segments['flightSegment']['arrival']['at'],-6);
            $flight[$k]['arrival_date'] = substr($segments['flightSegment']['arrival']['at'], 0, 10);
            $flight[$k]['arrival_time'] = str_replace($flight[$k]['arrival_timezone'],"",substr(str_replace($flight[$k]['arrival_date']," ",$segments['flightSegment']['arrival']['at']),2));

            $flight[$k]['duration'] =  substr($segments['flightSegment']['duration'], 3);
            $flight[$k]['class'] = $segments['pricingDetailPerAdult']['travelClass'];

            $flight[$k]['carrier'] = $segments['flightSegment']['carrierCode'];
            $flight[$k]['number'] = $segments['flightSegment']['number'];
            $flight[$k]['aircraft'] = $segments['flightSegment']['aircraft']['code'];

            $flight[$k]['price_basic'] = $d['offerItems'][0]['price']['total'];
            $flight[$k]['price_taxes'] = $d['offerItems'][0]['price']['totalTaxes'];

            $flight[$k]['aircraft_gp'] = $aircraft;
        }

        //print_r($flight);die();

        return $flight;
    }


}
