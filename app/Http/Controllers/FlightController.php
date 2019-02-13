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
         * 5. Call Scheduled Flight(s) Api , requested params should be: addid,addkey,'HKG',arrivalAirportCode,Y-M-D
         * 6. Get scheduled flight data in json format
         * 7. In json->scheduledFlights, we got all of the flight,plane_eq,time,terminal..etc
         * 8. We only need the price of flight code!
         * 
         * 
         */
   
        
        return view('flight.index');
    }
    
    public function search(Request $request)
    {

        $this->validate($request, array(
            'daterange' => 'required',
            'airport' => 'required',
            'code' => 'required'
        ));
        
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
        
//        print_r($code);
//        die();
        
        //Call scheduled Flights Api to retrieve data from api source
        

        return view('flight.result')
            ->with('code', $code)
            ->with('from', $from)
            ->with('to', $to)
            ->with('start', $start)
            ->with('end',$end);
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

            $country = $code;
            $appId = '';
            $appKey = '';

            $host = 'https://api.flightstats.com/flex/airports/rest/v1/json/countryCode/'.$country.'?appId='.$appId.'&appKey='.$appKey.'&extendedOptions=languageCode%3Azh';

            $ch = curl_init($host);
            curl_setopt($ch, CURLOPT_HTTPHEADER, array('Expect:') );
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
            curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);

            $response = curl_exec($ch);

            curl_close($ch);

            $arr = json_decode($response,true);

            $airport = array();
            foreach ($arr['airports'] as $k => $obj){
                if($obj['active'] == 'true'){
                    $airport[$k]['code'] = $obj['fs'];
                    $airport[$k]['name'] = $obj['name'];
                }
            }

        }

        return response()->json($airport);
    }
    
}
