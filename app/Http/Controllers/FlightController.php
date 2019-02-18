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
         * 7. In json->scheduledFlights, we got all of the flight,plane_eq,time,terminal..etc
         * 8. We only need the price of flight code!
         * 
         * 
         */
   
        
        return view('flight.index');
    }
    
    public function search(Request $request)
    {

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

        $start = explode('-',$start);
        $start_y = $start[0];
        $start_m = $start[1];
        $start_d = $start[2];

        $end = explode('-',$end);
        $end_y = $end[0];
        $end_m = $end[1];
        $end_d = $end[2];

        //print_r($end_d);die();

        //Call Flight scheduled Api to retrieve data from api source

        //$departure = self::SchedulesAPI($from, $to,$start_y,$start_m,$start_d)['scheduledFlights'];
        //$arrival = self::SchedulesAPI($to,$from,$end_y,$end_m,$end_d)['scheduledFlights'];
        $airports = self::Airports($code);

        //Temporarily hardcoded json string to enhance speed of development
        $departure = '[{"carrierFsCode":"CX","flightNumber":"566","departureAirportFsCode":"HKG","arrivalAirportFsCode":"KIX","stops":0,"departureTerminal":"1","arrivalTerminal":"1","departureTime":"2019-02-22T01:50:00.000","arrivalTime":"2019-02-22T06:20:00.000","flightEquipmentIataCode":"351","isCodeshare":false,"isWetlease":false,"serviceType":"J","serviceClasses":["R","J","Y"],"trafficRestrictions":[],"codeshares":[{"carrierFsCode":"JL","flightNumber":"7050","serviceType":"J","serviceClasses":["J","Y"],"trafficRestrictions":[],"referenceCode":2247189},{"carrierFsCode":"QR","flightNumber":"5838","serviceType":"J","serviceClasses":["R","J","Y"],"trafficRestrictions":["Y"],"referenceCode":3123132}],"referenceCode":"774-1218602--"},{"carrierFsCode":"JL","flightNumber":"7050","departureAirportFsCode":"HKG","arrivalAirportFsCode":"KIX","stops":0,"departureTerminal":"1","arrivalTerminal":"1","departureTime":"2019-02-22T01:50:00.000","arrivalTime":"2019-02-22T06:20:00.000","flightEquipmentIataCode":"351","isCodeshare":true,"isWetlease":false,"serviceType":"J","serviceClasses":["J","Y"],"trafficRestrictions":[],"operator":{"carrierFsCode":"CX","flightNumber":"566","serviceType":"J","serviceClasses":["R","J","Y"],"trafficRestrictions":[]},"codeshares":[],"referenceCode":"774-1218602--2247189"},{"carrierFsCode":"QR","flightNumber":"5838","departureAirportFsCode":"HKG","arrivalAirportFsCode":"KIX","stops":0,"departureTerminal":"1","arrivalTerminal":"1","departureTime":"2019-02-22T01:50:00.000","arrivalTime":"2019-02-22T06:20:00.000","flightEquipmentIataCode":"351","isCodeshare":true,"isWetlease":false,"serviceType":"J","serviceClasses":["R","J","Y"],"trafficRestrictions":["Y"],"operator":{"carrierFsCode":"CX","flightNumber":"566","serviceType":"J","serviceClasses":["R","J","Y"],"trafficRestrictions":[]},"codeshares":[],"referenceCode":"774-1218602--3123132"},{"carrierFsCode":"APJ","flightNumber":"64","departureAirportFsCode":"HKG","arrivalAirportFsCode":"KIX","stops":0,"departureTerminal":"1","arrivalTerminal":"2","departureTime":"2019-02-22T12:35:00.000","arrivalTime":"2019-02-22T17:00:00.000","flightEquipmentIataCode":"320","isCodeshare":false,"isWetlease":false,"serviceType":"J","serviceClasses":["Y"],"trafficRestrictions":[],"codeshares":[],"referenceCode":"774-2735089--"},{"carrierFsCode":"GK","flightNumber":"64","departureAirportFsCode":"HKG","arrivalAirportFsCode":"KIX","stops":0,"departureTerminal":"2","arrivalTerminal":"1","departureTime":"2019-02-22T20:10:00.000","arrivalTime":"2019-02-23T00:35:00.000","flightEquipmentIataCode":"320","isCodeshare":false,"isWetlease":false,"serviceType":"J","serviceClasses":["R","F","J","Y"],"trafficRestrictions":[],"codeshares":[],"referenceCode":"774-2056189--"},{"carrierFsCode":"UO","flightNumber":"686","departureAirportFsCode":"HKG","arrivalAirportFsCode":"KIX","stops":0,"departureTerminal":"2","arrivalTerminal":"1","departureTime":"2019-02-22T09:00:00.000","arrivalTime":"2019-02-22T13:30:00.000","flightEquipmentIataCode":"320","isCodeshare":false,"isWetlease":false,"serviceType":"J","serviceClasses":["Y"],"trafficRestrictions":[],"codeshares":[],"referenceCode":"774-3857919--"},{"carrierFsCode":"UO","flightNumber":"688","departureAirportFsCode":"HKG","arrivalAirportFsCode":"KIX","stops":0,"departureTerminal":"2","arrivalTerminal":"1","departureTime":"2019-02-22T14:55:00.000","arrivalTime":"2019-02-22T19:35:00.000","flightEquipmentIataCode":"320","isCodeshare":false,"isWetlease":false,"serviceType":"J","serviceClasses":["Y"],"trafficRestrictions":[],"codeshares":[],"referenceCode":"774-3857913--"},{"carrierFsCode":"HX","flightNumber":"618","departureAirportFsCode":"HKG","arrivalAirportFsCode":"KIX","stops":0,"departureTerminal":"1","arrivalTerminal":"1","departureTime":"2019-02-22T11:30:00.000","arrivalTime":"2019-02-22T15:50:00.000","flightEquipmentIataCode":"332","isCodeshare":false,"isWetlease":false,"serviceType":"J","serviceClasses":["R","J","Y"],"trafficRestrictions":[],"codeshares":[{"carrierFsCode":"FJ","flightNumber":"5394","serviceType":"J","serviceClasses":["R","J","Y"],"trafficRestrictions":[],"referenceCode":1951582},{"carrierFsCode":"EY","flightNumber":"4292","serviceType":"J","serviceClasses":["J","Y"],"trafficRestrictions":["G"],"referenceCode":10710820},{"carrierFsCode":"9W","flightNumber":"4846","serviceType":"J","serviceClasses":["F","J","Y"],"trafficRestrictions":["G"],"referenceCode":10710821}],"referenceCode":"774-2107999--"},{"carrierFsCode":"FJ","flightNumber":"5394","departureAirportFsCode":"HKG","arrivalAirportFsCode":"KIX","stops":0,"departureTerminal":"1","arrivalTerminal":"1","departureTime":"2019-02-22T11:30:00.000","arrivalTime":"2019-02-22T15:50:00.000","flightEquipmentIataCode":"332","isCodeshare":true,"isWetlease":false,"serviceType":"J","serviceClasses":["R","J","Y"],"trafficRestrictions":[],"operator":{"carrierFsCode":"HX","flightNumber":"618","serviceType":"J","serviceClasses":["R","J","Y"],"trafficRestrictions":[]},"codeshares":[],"referenceCode":"774-2107999--1951582"},{"carrierFsCode":"EY","flightNumber":"4292","departureAirportFsCode":"HKG","arrivalAirportFsCode":"KIX","stops":0,"departureTerminal":"1","arrivalTerminal":"1","departureTime":"2019-02-22T11:30:00.000","arrivalTime":"2019-02-22T15:50:00.000","flightEquipmentIataCode":"332","isCodeshare":true,"isWetlease":false,"serviceType":"J","serviceClasses":["J","Y"],"trafficRestrictions":["G"],"operator":{"carrierFsCode":"HX","flightNumber":"618","serviceType":"J","serviceClasses":["R","J","Y"],"trafficRestrictions":[]},"codeshares":[],"referenceCode":"774-2107999--10710820"},{"carrierFsCode":"9W","flightNumber":"4846","departureAirportFsCode":"HKG","arrivalAirportFsCode":"KIX","stops":0,"departureTerminal":"1","arrivalTerminal":"1","departureTime":"2019-02-22T11:30:00.000","arrivalTime":"2019-02-22T15:50:00.000","flightEquipmentIataCode":"332","isCodeshare":true,"isWetlease":false,"serviceType":"J","serviceClasses":["F","J","Y"],"trafficRestrictions":["G"],"operator":{"carrierFsCode":"HX","flightNumber":"618","serviceType":"J","serviceClasses":["R","J","Y"],"trafficRestrictions":[]},"codeshares":[],"referenceCode":"774-2107999--10710821"},{"carrierFsCode":"CX","flightNumber":"502","departureAirportFsCode":"HKG","arrivalAirportFsCode":"KIX","stops":0,"departureTerminal":"1","arrivalTerminal":"1","departureTime":"2019-02-22T16:35:00.000","arrivalTime":"2019-02-22T21:10:00.000","flightEquipmentIataCode":"773","isCodeshare":false,"isWetlease":false,"serviceType":"J","serviceClasses":["J","Y"],"trafficRestrictions":[],"codeshares":[{"carrierFsCode":"QR","flightNumber":"5808","serviceType":"J","serviceClasses":["R","J","Y"],"trafficRestrictions":["Y"],"referenceCode":3123168},{"carrierFsCode":"JL","flightNumber":"7056","serviceType":"J","serviceClasses":["J","Y"],"trafficRestrictions":[],"referenceCode":10710875}],"referenceCode":"774-1218545--"},{"carrierFsCode":"QR","flightNumber":"5808","departureAirportFsCode":"HKG","arrivalAirportFsCode":"KIX","stops":0,"departureTerminal":"1","arrivalTerminal":"1","departureTime":"2019-02-22T16:35:00.000","arrivalTime":"2019-02-22T21:10:00.000","flightEquipmentIataCode":"773","isCodeshare":true,"isWetlease":false,"serviceType":"J","serviceClasses":["R","J","Y"],"trafficRestrictions":["Y"],"operator":{"carrierFsCode":"CX","flightNumber":"502","serviceType":"J","serviceClasses":["J","Y"],"trafficRestrictions":[]},"codeshares":[],"referenceCode":"774-1218545--3123168"},{"carrierFsCode":"JL","flightNumber":"7056","departureAirportFsCode":"HKG","arrivalAirportFsCode":"KIX","stops":0,"departureTerminal":"1","arrivalTerminal":"1","departureTime":"2019-02-22T16:35:00.000","arrivalTime":"2019-02-22T21:10:00.000","flightEquipmentIataCode":"773","isCodeshare":true,"isWetlease":false,"serviceType":"J","serviceClasses":["J","Y"],"trafficRestrictions":[],"operator":{"carrierFsCode":"CX","flightNumber":"502","serviceType":"J","serviceClasses":["J","Y"],"trafficRestrictions":[]},"codeshares":[],"referenceCode":"774-1218545--10710875"},{"carrierFsCode":"HX","flightNumber":"636","departureAirportFsCode":"HKG","arrivalAirportFsCode":"KIX","stops":0,"departureTerminal":"1","arrivalTerminal":"1","departureTime":"2019-02-22T18:15:00.000","arrivalTime":"2019-02-22T22:50:00.000","flightEquipmentIataCode":"320","isCodeshare":false,"isWetlease":false,"serviceType":"J","serviceClasses":["R","Y"],"trafficRestrictions":[],"codeshares":[{"carrierFsCode":"9W","flightNumber":"4853","serviceType":"J","serviceClasses":["Y"],"trafficRestrictions":["G"],"referenceCode":213933},{"carrierFsCode":"FJ","flightNumber":"5404","serviceType":"J","serviceClasses":["R","Y"],"trafficRestrictions":[],"referenceCode":1951598},{"carrierFsCode":"EY","flightNumber":"4296","serviceType":"J","serviceClasses":["Y"],"trafficRestrictions":["G"],"referenceCode":10710896}],"referenceCode":"774-2108016--"},{"carrierFsCode":"9W","flightNumber":"4853","departureAirportFsCode":"HKG","arrivalAirportFsCode":"KIX","stops":0,"departureTerminal":"1","arrivalTerminal":"1","departureTime":"2019-02-22T18:15:00.000","arrivalTime":"2019-02-22T22:50:00.000","flightEquipmentIataCode":"320","isCodeshare":true,"isWetlease":false,"serviceType":"J","serviceClasses":["Y"],"trafficRestrictions":["G"],"operator":{"carrierFsCode":"HX","flightNumber":"636","serviceType":"J","serviceClasses":["R","Y"],"trafficRestrictions":[]},"codeshares":[],"referenceCode":"774-2108016--213933"},{"carrierFsCode":"FJ","flightNumber":"5404","departureAirportFsCode":"HKG","arrivalAirportFsCode":"KIX","stops":0,"departureTerminal":"1","arrivalTerminal":"1","departureTime":"2019-02-22T18:15:00.000","arrivalTime":"2019-02-22T22:50:00.000","flightEquipmentIataCode":"320","isCodeshare":true,"isWetlease":false,"serviceType":"J","serviceClasses":["R","Y"],"trafficRestrictions":[],"operator":{"carrierFsCode":"HX","flightNumber":"636","serviceType":"J","serviceClasses":["R","Y"],"trafficRestrictions":[]},"codeshares":[],"referenceCode":"774-2108016--1951598"},{"carrierFsCode":"EY","flightNumber":"4296","departureAirportFsCode":"HKG","arrivalAirportFsCode":"KIX","stops":0,"departureTerminal":"1","arrivalTerminal":"1","departureTime":"2019-02-22T18:15:00.000","arrivalTime":"2019-02-22T22:50:00.000","flightEquipmentIataCode":"320","isCodeshare":true,"isWetlease":false,"serviceType":"J","serviceClasses":["Y"],"trafficRestrictions":["G"],"operator":{"carrierFsCode":"HX","flightNumber":"636","serviceType":"J","serviceClasses":["R","Y"],"trafficRestrictions":[]},"codeshares":[],"referenceCode":"774-2108016--10710896"},{"carrierFsCode":"CX","flightNumber":"506","departureAirportFsCode":"HKG","arrivalAirportFsCode":"KIX","stops":0,"departureTerminal":"1","arrivalTerminal":"1","departureTime":"2019-02-22T10:30:00.000","arrivalTime":"2019-02-22T15:00:00.000","flightEquipmentIataCode":"333","isCodeshare":false,"isWetlease":false,"serviceType":"J","serviceClasses":["J","Y"],"trafficRestrictions":[],"codeshares":[{"carrierFsCode":"JL","flightNumber":"7052","serviceType":"J","serviceClasses":["J","Y"],"trafficRestrictions":[],"referenceCode":10710810}],"referenceCode":"774-1218662--"},{"carrierFsCode":"JL","flightNumber":"7052","departureAirportFsCode":"HKG","arrivalAirportFsCode":"KIX","stops":0,"departureTerminal":"1","arrivalTerminal":"1","departureTime":"2019-02-22T10:30:00.000","arrivalTime":"2019-02-22T15:00:00.000","flightEquipmentIataCode":"333","isCodeshare":true,"isWetlease":false,"serviceType":"J","serviceClasses":["J","Y"],"trafficRestrictions":[],"operator":{"carrierFsCode":"CX","flightNumber":"506","serviceType":"J","serviceClasses":["J","Y"],"trafficRestrictions":[]},"codeshares":[],"referenceCode":"774-1218662--10710810"},{"carrierFsCode":"CX","flightNumber":"594","departureAirportFsCode":"HKG","arrivalAirportFsCode":"KIX","stops":0,"departureTerminal":"1","arrivalTerminal":"1","departureTime":"2019-02-22T07:55:00.000","arrivalTime":"2019-02-22T12:30:00.000","flightEquipmentIataCode":"359","isCodeshare":false,"isWetlease":false,"serviceType":"J","serviceClasses":["R","J","Y"],"trafficRestrictions":[],"codeshares":[{"carrierFsCode":"JL","flightNumber":"7060","serviceType":"J","serviceClasses":["J","Y"],"trafficRestrictions":[],"referenceCode":2247064}],"referenceCode":"774-1218710--"},{"carrierFsCode":"JL","flightNumber":"7060","departureAirportFsCode":"HKG","arrivalAirportFsCode":"KIX","stops":0,"departureTerminal":"1","arrivalTerminal":"1","departureTime":"2019-02-22T07:55:00.000","arrivalTime":"2019-02-22T12:30:00.000","flightEquipmentIataCode":"359","isCodeshare":true,"isWetlease":false,"serviceType":"J","serviceClasses":["J","Y"],"trafficRestrictions":[],"operator":{"carrierFsCode":"CX","flightNumber":"594","serviceType":"J","serviceClasses":["R","J","Y"],"trafficRestrictions":[]},"codeshares":[],"referenceCode":"774-1218710--2247064"},{"carrierFsCode":"HX","flightNumber":"612","departureAirportFsCode":"HKG","arrivalAirportFsCode":"KIX","stops":0,"departureTerminal":"1","arrivalTerminal":"1","departureTime":"2019-02-22T09:30:00.000","arrivalTime":"2019-02-22T13:50:00.000","flightEquipmentIataCode":"320","isCodeshare":false,"isWetlease":false,"serviceType":"J","serviceClasses":["R","Y"],"trafficRestrictions":[],"codeshares":[{"carrierFsCode":"EY","flightNumber":"4290","serviceType":"J","serviceClasses":["Y"],"trafficRestrictions":["G"],"referenceCode":1854893}],"referenceCode":"774-2108035--"},{"carrierFsCode":"EY","flightNumber":"4290","departureAirportFsCode":"HKG","arrivalAirportFsCode":"KIX","stops":0,"departureTerminal":"1","arrivalTerminal":"1","departureTime":"2019-02-22T09:30:00.000","arrivalTime":"2019-02-22T13:50:00.000","flightEquipmentIataCode":"320","isCodeshare":true,"isWetlease":false,"serviceType":"J","serviceClasses":["Y"],"trafficRestrictions":["G"],"operator":{"carrierFsCode":"HX","flightNumber":"612","serviceType":"J","serviceClasses":["R","Y"],"trafficRestrictions":[]},"codeshares":[],"referenceCode":"774-2108035--1854893"},{"carrierFsCode":"UO","flightNumber":"898","departureAirportFsCode":"HKG","arrivalAirportFsCode":"KIX","stops":0,"departureTerminal":"2","arrivalTerminal":"1","departureTime":"2019-02-22T13:05:00.000","arrivalTime":"2019-02-22T17:45:00.000","flightEquipmentIataCode":"320","isCodeshare":false,"isWetlease":false,"serviceType":"J","serviceClasses":["Y"],"trafficRestrictions":[],"codeshares":[],"referenceCode":"774-3857910--"},{"carrierFsCode":"UO","flightNumber":"850","departureAirportFsCode":"HKG","arrivalAirportFsCode":"KIX","stops":0,"departureTerminal":"2","arrivalTerminal":"1","departureTime":"2019-02-22T14:00:00.000","arrivalTime":"2019-02-22T18:40:00.000","flightEquipmentIataCode":"320","isCodeshare":false,"isWetlease":false,"serviceType":"J","serviceClasses":["Y"],"trafficRestrictions":[],"codeshares":[],"referenceCode":"774-3857924--"},{"carrierFsCode":"UO","flightNumber":"860","departureAirportFsCode":"HKG","arrivalAirportFsCode":"KIX","stops":0,"departureTerminal":"2","arrivalTerminal":"1","departureTime":"2019-02-22T20:20:00.000","arrivalTime":"2019-02-23T01:00:00.000","flightEquipmentIataCode":"320","isCodeshare":false,"isWetlease":false,"serviceType":"J","serviceClasses":["Y"],"trafficRestrictions":[],"codeshares":[],"referenceCode":"774-3857917--"}]';
        $departure = json_decode($departure,true);
        $arrival = '[{"carrierFsCode":"GK","flightNumber":"61","departureAirportFsCode":"KIX","arrivalAirportFsCode":"HKG","stops":0,"departureTerminal":"1","arrivalTerminal":"2","departureTime":"2019-02-28T15:35:00.000","arrivalTime":"2019-02-28T19:10:00.000","flightEquipmentIataCode":"320","isCodeshare":false,"isWetlease":false,"serviceType":"J","serviceClasses":["R","F","J","Y"],"trafficRestrictions":[],"codeshares":[],"referenceCode":"774-2056218--"},{"carrierFsCode":"UO","flightNumber":"687","departureAirportFsCode":"KIX","arrivalAirportFsCode":"HKG","stops":0,"departureTerminal":"1","arrivalTerminal":"1","departureTime":"2019-02-28T14:20:00.000","arrivalTime":"2019-02-28T17:50:00.000","flightEquipmentIataCode":"320","isCodeshare":false,"isWetlease":false,"serviceType":"J","serviceClasses":["Y"],"trafficRestrictions":[],"codeshares":[],"referenceCode":"774-3858072--"},{"carrierFsCode":"UO","flightNumber":"689","departureAirportFsCode":"KIX","arrivalAirportFsCode":"HKG","stops":0,"departureTerminal":"1","arrivalTerminal":"1","departureTime":"2019-02-28T20:30:00.000","arrivalTime":"2019-02-28T23:55:00.000","flightEquipmentIataCode":"320","isCodeshare":false,"isWetlease":false,"serviceType":"J","serviceClasses":["Y"],"trafficRestrictions":[],"codeshares":[],"referenceCode":"774-3858061--"},{"carrierFsCode":"UO","flightNumber":"851","departureAirportFsCode":"KIX","arrivalAirportFsCode":"HKG","stops":0,"departureTerminal":"1","arrivalTerminal":"1","departureTime":"2019-02-28T16:05:00.000","arrivalTime":"2019-02-28T19:40:00.000","flightEquipmentIataCode":"320","isCodeshare":false,"isWetlease":false,"serviceType":"J","serviceClasses":["Y"],"trafficRestrictions":[],"codeshares":[],"referenceCode":"774-3858078--"},{"carrierFsCode":"UO","flightNumber":"899","departureAirportFsCode":"KIX","arrivalAirportFsCode":"HKG","stops":0,"departureTerminal":"1","arrivalTerminal":"1","departureTime":"2019-02-28T18:05:00.000","arrivalTime":"2019-02-28T21:40:00.000","flightEquipmentIataCode":"320","isCodeshare":false,"isWetlease":false,"serviceType":"J","serviceClasses":["Y"],"trafficRestrictions":[],"codeshares":[],"referenceCode":"774-3858067--"},{"carrierFsCode":"AI","flightNumber":"315","departureAirportFsCode":"KIX","arrivalAirportFsCode":"HKG","stops":0,"departureTerminal":"1","arrivalTerminal":"1","departureTime":"2019-02-28T13:25:00.000","arrivalTime":"2019-02-28T16:35:00.000","flightEquipmentIataCode":"788","isCodeshare":false,"isWetlease":false,"serviceType":"J","serviceClasses":["J","Y"],"trafficRestrictions":[],"codeshares":[],"referenceCode":"774-695392--"},{"carrierFsCode":"CX","flightNumber":"503","departureAirportFsCode":"KIX","arrivalAirportFsCode":"HKG","stops":0,"departureTerminal":"1","arrivalTerminal":"1","departureTime":"2019-02-28T10:00:00.000","arrivalTime":"2019-02-28T13:25:00.000","flightEquipmentIataCode":"773","isCodeshare":false,"isWetlease":false,"serviceType":"J","serviceClasses":["J","Y"],"trafficRestrictions":[],"codeshares":[{"carrierFsCode":"QR","flightNumber":"5806","serviceType":"J","serviceClasses":["R","J","Y"],"trafficRestrictions":["Y"],"referenceCode":3127558},{"carrierFsCode":"JL","flightNumber":"7053","serviceType":"J","serviceClasses":["J","Y"],"trafficRestrictions":[],"referenceCode":10867317}],"referenceCode":"774-1275372--"},{"carrierFsCode":"QR","flightNumber":"5806","departureAirportFsCode":"KIX","arrivalAirportFsCode":"HKG","stops":0,"departureTerminal":"1","arrivalTerminal":"1","departureTime":"2019-02-28T10:00:00.000","arrivalTime":"2019-02-28T13:25:00.000","flightEquipmentIataCode":"773","isCodeshare":true,"isWetlease":false,"serviceType":"J","serviceClasses":["R","J","Y"],"trafficRestrictions":["Y"],"operator":{"carrierFsCode":"CX","flightNumber":"503","serviceType":"J","serviceClasses":["J","Y"],"trafficRestrictions":[]},"codeshares":[],"referenceCode":"774-1275372--3127558"},{"carrierFsCode":"JL","flightNumber":"7053","departureAirportFsCode":"KIX","arrivalAirportFsCode":"HKG","stops":0,"departureTerminal":"1","arrivalTerminal":"1","departureTime":"2019-02-28T10:00:00.000","arrivalTime":"2019-02-28T13:25:00.000","flightEquipmentIataCode":"773","isCodeshare":true,"isWetlease":false,"serviceType":"J","serviceClasses":["J","Y"],"trafficRestrictions":[],"operator":{"carrierFsCode":"CX","flightNumber":"503","serviceType":"J","serviceClasses":["J","Y"],"trafficRestrictions":[]},"codeshares":[],"referenceCode":"774-1275372--10867317"},{"carrierFsCode":"UO","flightNumber":"863","departureAirportFsCode":"KIX","arrivalAirportFsCode":"HKG","stops":0,"departureTerminal":"1","arrivalTerminal":"1","departureTime":"2019-02-28T18:35:00.000","arrivalTime":"2019-02-28T22:10:00.000","flightEquipmentIataCode":"320","isCodeshare":false,"isWetlease":false,"serviceType":"J","serviceClasses":["Y"],"trafficRestrictions":[],"codeshares":[],"referenceCode":"774-3858054--"},{"carrierFsCode":"NH","flightNumber":"873","departureAirportFsCode":"KIX","arrivalAirportFsCode":"HKG","stops":0,"departureTerminal":"1","arrivalTerminal":"1","departureTime":"2019-02-28T10:20:00.000","arrivalTime":"2019-02-28T13:50:00.000","flightEquipmentIataCode":"737","isCodeshare":false,"isWetlease":false,"serviceType":"J","serviceClasses":["F","J","Y"],"trafficRestrictions":[],"codeshares":[{"carrierFsCode":"9W","flightNumber":"4151","serviceType":"J","serviceClasses":["F","J","Y"],"trafficRestrictions":["G"],"referenceCode":145815},{"carrierFsCode":"NZ","flightNumber":"4149","serviceType":"J","serviceClasses":["J","Y"],"trafficRestrictions":["Q"],"referenceCode":2884254},{"carrierFsCode":"SA","flightNumber":"7137","serviceType":"J","serviceClasses":["J","Y"],"trafficRestrictions":["G"],"referenceCode":3200910}],"referenceCode":"774-2812603--"},{"carrierFsCode":"9W","flightNumber":"4151","departureAirportFsCode":"KIX","arrivalAirportFsCode":"HKG","stops":0,"departureTerminal":"1","arrivalTerminal":"1","departureTime":"2019-02-28T10:20:00.000","arrivalTime":"2019-02-28T13:50:00.000","flightEquipmentIataCode":"737","isCodeshare":true,"isWetlease":false,"serviceType":"J","serviceClasses":["F","J","Y"],"trafficRestrictions":["G"],"operator":{"carrierFsCode":"NH","flightNumber":"873","serviceType":"J","serviceClasses":["F","J","Y"],"trafficRestrictions":[]},"codeshares":[],"referenceCode":"774-2812603--145815"},{"carrierFsCode":"NZ","flightNumber":"4149","departureAirportFsCode":"KIX","arrivalAirportFsCode":"HKG","stops":0,"departureTerminal":"1","arrivalTerminal":"1","departureTime":"2019-02-28T10:20:00.000","arrivalTime":"2019-02-28T13:50:00.000","flightEquipmentIataCode":"737","isCodeshare":true,"isWetlease":false,"serviceType":"J","serviceClasses":["J","Y"],"trafficRestrictions":["Q"],"operator":{"carrierFsCode":"NH","flightNumber":"873","serviceType":"J","serviceClasses":["F","J","Y"],"trafficRestrictions":[]},"codeshares":[],"referenceCode":"774-2812603--2884254"},{"carrierFsCode":"SA","flightNumber":"7137","departureAirportFsCode":"KIX","arrivalAirportFsCode":"HKG","stops":0,"departureTerminal":"1","arrivalTerminal":"1","departureTime":"2019-02-28T10:20:00.000","arrivalTime":"2019-02-28T13:50:00.000","flightEquipmentIataCode":"737","isCodeshare":true,"isWetlease":false,"serviceType":"J","serviceClasses":["J","Y"],"trafficRestrictions":["G"],"operator":{"carrierFsCode":"NH","flightNumber":"873","serviceType":"J","serviceClasses":["F","J","Y"],"trafficRestrictions":[]},"codeshares":[],"referenceCode":"774-2812603--3200910"},{"carrierFsCode":"APJ","flightNumber":"67","departureAirportFsCode":"KIX","arrivalAirportFsCode":"HKG","stops":0,"departureTerminal":"2","arrivalTerminal":"1","departureTime":"2019-02-28T21:10:00.000","arrivalTime":"2019-03-01T00:40:00.000","flightEquipmentIataCode":"320","isCodeshare":false,"isWetlease":false,"serviceType":"J","serviceClasses":["Y"],"trafficRestrictions":[],"codeshares":[],"referenceCode":"774-2735116--"},{"carrierFsCode":"HX","flightNumber":"619","departureAirportFsCode":"KIX","arrivalAirportFsCode":"HKG","stops":0,"departureTerminal":"1","arrivalTerminal":"1","departureTime":"2019-02-28T16:50:00.000","arrivalTime":"2019-02-28T20:15:00.000","flightEquipmentIataCode":"332","isCodeshare":false,"isWetlease":false,"serviceType":"J","serviceClasses":["R","J","Y"],"trafficRestrictions":[],"codeshares":[{"carrierFsCode":"9W","flightNumber":"4851","serviceType":"J","serviceClasses":["F","J","Y"],"trafficRestrictions":["G"],"referenceCode":145797},{"carrierFsCode":"EY","flightNumber":"4293","serviceType":"J","serviceClasses":["J","Y"],"trafficRestrictions":["G"],"referenceCode":1856739},{"carrierFsCode":"FJ","flightNumber":"5395","serviceType":"J","serviceClasses":["R","J","Y"],"trafficRestrictions":[],"referenceCode":1951907},{"carrierFsCode":"TK","flightNumber":"9219","serviceType":"J","serviceClasses":["J","Y"],"trafficRestrictions":[],"referenceCode":3461607}],"referenceCode":"774-2109121--"},{"carrierFsCode":"9W","flightNumber":"4851","departureAirportFsCode":"KIX","arrivalAirportFsCode":"HKG","stops":0,"departureTerminal":"1","arrivalTerminal":"1","departureTime":"2019-02-28T16:50:00.000","arrivalTime":"2019-02-28T20:15:00.000","flightEquipmentIataCode":"332","isCodeshare":true,"isWetlease":false,"serviceType":"J","serviceClasses":["F","J","Y"],"trafficRestrictions":["G"],"operator":{"carrierFsCode":"HX","flightNumber":"619","serviceType":"J","serviceClasses":["R","J","Y"],"trafficRestrictions":[]},"codeshares":[],"referenceCode":"774-2109121--145797"},{"carrierFsCode":"EY","flightNumber":"4293","departureAirportFsCode":"KIX","arrivalAirportFsCode":"HKG","stops":0,"departureTerminal":"1","arrivalTerminal":"1","departureTime":"2019-02-28T16:50:00.000","arrivalTime":"2019-02-28T20:15:00.000","flightEquipmentIataCode":"332","isCodeshare":true,"isWetlease":false,"serviceType":"J","serviceClasses":["J","Y"],"trafficRestrictions":["G"],"operator":{"carrierFsCode":"HX","flightNumber":"619","serviceType":"J","serviceClasses":["R","J","Y"],"trafficRestrictions":[]},"codeshares":[],"referenceCode":"774-2109121--1856739"},{"carrierFsCode":"FJ","flightNumber":"5395","departureAirportFsCode":"KIX","arrivalAirportFsCode":"HKG","stops":0,"departureTerminal":"1","arrivalTerminal":"1","departureTime":"2019-02-28T16:50:00.000","arrivalTime":"2019-02-28T20:15:00.000","flightEquipmentIataCode":"332","isCodeshare":true,"isWetlease":false,"serviceType":"J","serviceClasses":["R","J","Y"],"trafficRestrictions":[],"operator":{"carrierFsCode":"HX","flightNumber":"619","serviceType":"J","serviceClasses":["R","J","Y"],"trafficRestrictions":[]},"codeshares":[],"referenceCode":"774-2109121--1951907"},{"carrierFsCode":"TK","flightNumber":"9219","departureAirportFsCode":"KIX","arrivalAirportFsCode":"HKG","stops":0,"departureTerminal":"1","arrivalTerminal":"1","departureTime":"2019-02-28T16:50:00.000","arrivalTime":"2019-02-28T20:15:00.000","flightEquipmentIataCode":"332","isCodeshare":true,"isWetlease":false,"serviceType":"J","serviceClasses":["J","Y"],"trafficRestrictions":[],"operator":{"carrierFsCode":"HX","flightNumber":"619","serviceType":"J","serviceClasses":["R","J","Y"],"trafficRestrictions":[]},"codeshares":[],"referenceCode":"774-2109121--3461607"},{"carrierFsCode":"APJ","flightNumber":"63","departureAirportFsCode":"KIX","arrivalAirportFsCode":"HKG","stops":0,"departureTerminal":"2","arrivalTerminal":"1","departureTime":"2019-02-28T08:20:00.000","arrivalTime":"2019-02-28T11:50:00.000","flightEquipmentIataCode":"320","isCodeshare":false,"isWetlease":false,"serviceType":"J","serviceClasses":["Y"],"trafficRestrictions":[],"codeshares":[],"referenceCode":"774-2735115--"},{"carrierFsCode":"HX","flightNumber":"603","departureAirportFsCode":"KIX","arrivalAirportFsCode":"HKG","stops":0,"departureTerminal":"1","arrivalTerminal":"1","departureTime":"2019-02-28T06:30:00.000","arrivalTime":"2019-02-28T10:05:00.000","flightEquipmentIataCode":"320","isCodeshare":false,"isWetlease":false,"serviceType":"J","serviceClasses":["R","J","Y"],"trafficRestrictions":[],"codeshares":[{"carrierFsCode":"9W","flightNumber":"4848","serviceType":"J","serviceClasses":["F","J","Y"],"trafficRestrictions":["G"],"referenceCode":145811},{"carrierFsCode":"FJ","flightNumber":"5393","serviceType":"J","serviceClasses":["R","J","Y"],"trafficRestrictions":[],"referenceCode":1951887},{"carrierFsCode":"EY","flightNumber":"4289","serviceType":"J","serviceClasses":["Y"],"trafficRestrictions":["G"],"referenceCode":10867247}],"referenceCode":"774-2109109--"},{"carrierFsCode":"9W","flightNumber":"4848","departureAirportFsCode":"KIX","arrivalAirportFsCode":"HKG","stops":0,"departureTerminal":"1","arrivalTerminal":"1","departureTime":"2019-02-28T06:30:00.000","arrivalTime":"2019-02-28T10:05:00.000","flightEquipmentIataCode":"320","isCodeshare":true,"isWetlease":false,"serviceType":"J","serviceClasses":["F","J","Y"],"trafficRestrictions":["G"],"operator":{"carrierFsCode":"HX","flightNumber":"603","serviceType":"J","serviceClasses":["R","J","Y"],"trafficRestrictions":[]},"codeshares":[],"referenceCode":"774-2109109--145811"},{"carrierFsCode":"FJ","flightNumber":"5393","departureAirportFsCode":"KIX","arrivalAirportFsCode":"HKG","stops":0,"departureTerminal":"1","arrivalTerminal":"1","departureTime":"2019-02-28T06:30:00.000","arrivalTime":"2019-02-28T10:05:00.000","flightEquipmentIataCode":"320","isCodeshare":true,"isWetlease":false,"serviceType":"J","serviceClasses":["R","J","Y"],"trafficRestrictions":[],"operator":{"carrierFsCode":"HX","flightNumber":"603","serviceType":"J","serviceClasses":["R","J","Y"],"trafficRestrictions":[]},"codeshares":[],"referenceCode":"774-2109109--1951887"},{"carrierFsCode":"EY","flightNumber":"4289","departureAirportFsCode":"KIX","arrivalAirportFsCode":"HKG","stops":0,"departureTerminal":"1","arrivalTerminal":"1","departureTime":"2019-02-28T06:30:00.000","arrivalTime":"2019-02-28T10:05:00.000","flightEquipmentIataCode":"320","isCodeshare":true,"isWetlease":false,"serviceType":"J","serviceClasses":["Y"],"trafficRestrictions":["G"],"operator":{"carrierFsCode":"HX","flightNumber":"603","serviceType":"J","serviceClasses":["R","J","Y"],"trafficRestrictions":[]},"codeshares":[],"referenceCode":"774-2109109--10867247"},{"carrierFsCode":"CX","flightNumber":"599","departureAirportFsCode":"KIX","arrivalAirportFsCode":"HKG","stops":0,"departureTerminal":"1","arrivalTerminal":"1","departureTime":"2019-02-28T13:55:00.000","arrivalTime":"2019-02-28T17:35:00.000","flightEquipmentIataCode":"333","isCodeshare":false,"isWetlease":false,"serviceType":"J","serviceClasses":["J","Y"],"trafficRestrictions":[],"codeshares":[{"carrierFsCode":"JL","flightNumber":"7027","serviceType":"J","serviceClasses":["J","Y"],"trafficRestrictions":[],"referenceCode":10867331}],"referenceCode":"774-1275368--"},{"carrierFsCode":"JL","flightNumber":"7027","departureAirportFsCode":"KIX","arrivalAirportFsCode":"HKG","stops":0,"departureTerminal":"1","arrivalTerminal":"1","departureTime":"2019-02-28T13:55:00.000","arrivalTime":"2019-02-28T17:35:00.000","flightEquipmentIataCode":"333","isCodeshare":true,"isWetlease":false,"serviceType":"J","serviceClasses":["J","Y"],"trafficRestrictions":[],"operator":{"carrierFsCode":"CX","flightNumber":"599","serviceType":"J","serviceClasses":["J","Y"],"trafficRestrictions":[]},"codeshares":[],"referenceCode":"774-1275368--10867331"},{"carrierFsCode":"JL","flightNumber":"7059","departureAirportFsCode":"KIX","arrivalAirportFsCode":"HKG","stops":0,"departureTerminal":"1","arrivalTerminal":"1","departureTime":"2019-02-28T17:55:00.000","arrivalTime":"2019-02-28T21:35:00.000","flightEquipmentIataCode":"333","isCodeshare":true,"isWetlease":false,"serviceType":"J","serviceClasses":["J","Y"],"trafficRestrictions":[],"operator":{"carrierFsCode":"CX","flightNumber":"507","serviceType":"J","serviceClasses":["J","Y"],"trafficRestrictions":[]},"codeshares":[],"referenceCode":"774-1275534--10867381"},{"carrierFsCode":"CX","flightNumber":"595","departureAirportFsCode":"KIX","arrivalAirportFsCode":"HKG","stops":0,"departureTerminal":"1","arrivalTerminal":"1","departureTime":"2019-02-28T18:10:00.000","arrivalTime":"2019-02-28T21:55:00.000","flightEquipmentIataCode":"333","isCodeshare":false,"isWetlease":false,"serviceType":"J","serviceClasses":["J","Y"],"trafficRestrictions":[],"codeshares":[{"carrierFsCode":"QR","flightNumber":"5803","serviceType":"J","serviceClasses":["R","J","Y"],"trafficRestrictions":["Y"],"referenceCode":3127653},{"carrierFsCode":"JL","flightNumber":"7067","serviceType":"J","serviceClasses":["J","Y"],"trafficRestrictions":[],"referenceCode":10867395}],"referenceCode":"774-1275477--"},{"carrierFsCode":"QR","flightNumber":"5803","departureAirportFsCode":"KIX","arrivalAirportFsCode":"HKG","stops":0,"departureTerminal":"1","arrivalTerminal":"1","departureTime":"2019-02-28T18:10:00.000","arrivalTime":"2019-02-28T21:55:00.000","flightEquipmentIataCode":"333","isCodeshare":true,"isWetlease":false,"serviceType":"J","serviceClasses":["R","J","Y"],"trafficRestrictions":["Y"],"operator":{"carrierFsCode":"CX","flightNumber":"595","serviceType":"J","serviceClasses":["J","Y"],"trafficRestrictions":[]},"codeshares":[],"referenceCode":"774-1275477--3127653"},{"carrierFsCode":"JL","flightNumber":"7067","departureAirportFsCode":"KIX","arrivalAirportFsCode":"HKG","stops":0,"departureTerminal":"1","arrivalTerminal":"1","departureTime":"2019-02-28T18:10:00.000","arrivalTime":"2019-02-28T21:55:00.000","flightEquipmentIataCode":"333","isCodeshare":true,"isWetlease":false,"serviceType":"J","serviceClasses":["J","Y"],"trafficRestrictions":[],"operator":{"carrierFsCode":"CX","flightNumber":"595","serviceType":"J","serviceClasses":["J","Y"],"trafficRestrictions":[]},"codeshares":[],"referenceCode":"774-1275477--10867395"},{"carrierFsCode":"CX","flightNumber":"561","departureAirportFsCode":"KIX","arrivalAirportFsCode":"HKG","stops":0,"departureTerminal":"1","arrivalTerminal":"1","departureTime":"2019-02-28T19:10:00.000","arrivalTime":"2019-02-28T22:40:00.000","flightEquipmentIataCode":"333","isCodeshare":false,"isWetlease":false,"serviceType":"J","serviceClasses":["J","Y"],"trafficRestrictions":[],"codeshares":[{"carrierFsCode":"QR","flightNumber":"5835","serviceType":"J","serviceClasses":["R","J","Y"],"trafficRestrictions":["Y"],"referenceCode":3127704},{"carrierFsCode":"JL","flightNumber":"7029","serviceType":"J","serviceClasses":["J","Y"],"trafficRestrictions":[],"referenceCode":10867431}],"referenceCode":"774-1275397--"},{"carrierFsCode":"QR","flightNumber":"5835","departureAirportFsCode":"KIX","arrivalAirportFsCode":"HKG","stops":0,"departureTerminal":"1","arrivalTerminal":"1","departureTime":"2019-02-28T19:10:00.000","arrivalTime":"2019-02-28T22:40:00.000","flightEquipmentIataCode":"333","isCodeshare":true,"isWetlease":false,"serviceType":"J","serviceClasses":["R","J","Y"],"trafficRestrictions":["Y"],"operator":{"carrierFsCode":"CX","flightNumber":"561","serviceType":"J","serviceClasses":["J","Y"],"trafficRestrictions":[]},"codeshares":[],"referenceCode":"774-1275397--3127704"},{"carrierFsCode":"JL","flightNumber":"7029","departureAirportFsCode":"KIX","arrivalAirportFsCode":"HKG","stops":0,"departureTerminal":"1","arrivalTerminal":"1","departureTime":"2019-02-28T19:10:00.000","arrivalTime":"2019-02-28T22:40:00.000","flightEquipmentIataCode":"333","isCodeshare":true,"isWetlease":false,"serviceType":"J","serviceClasses":["J","Y"],"trafficRestrictions":[],"operator":{"carrierFsCode":"CX","flightNumber":"561","serviceType":"J","serviceClasses":["J","Y"],"trafficRestrictions":[]},"codeshares":[],"referenceCode":"774-1275397--10867431"},{"carrierFsCode":"CX","flightNumber":"507","departureAirportFsCode":"KIX","arrivalAirportFsCode":"HKG","stops":0,"departureTerminal":"1","arrivalTerminal":"1","departureTime":"2019-02-28T17:55:00.000","arrivalTime":"2019-02-28T21:35:00.000","flightEquipmentIataCode":"333","isCodeshare":false,"isWetlease":false,"serviceType":"J","serviceClasses":["J","Y"],"trafficRestrictions":[],"codeshares":[{"carrierFsCode":"QR","flightNumber":"5839","serviceType":"J","serviceClasses":["R","J","Y"],"trafficRestrictions":["Y"],"referenceCode":3127584},{"carrierFsCode":"JL","flightNumber":"7059","serviceType":"J","serviceClasses":["J","Y"],"trafficRestrictions":[],"referenceCode":10867381}],"referenceCode":"774-1275534--"},{"carrierFsCode":"QR","flightNumber":"5839","departureAirportFsCode":"KIX","arrivalAirportFsCode":"HKG","stops":0,"departureTerminal":"1","arrivalTerminal":"1","departureTime":"2019-02-28T17:55:00.000","arrivalTime":"2019-02-28T21:35:00.000","flightEquipmentIataCode":"333","isCodeshare":true,"isWetlease":false,"serviceType":"J","serviceClasses":["R","J","Y"],"trafficRestrictions":["Y"],"operator":{"carrierFsCode":"CX","flightNumber":"507","serviceType":"J","serviceClasses":["J","Y"],"trafficRestrictions":[]},"codeshares":[],"referenceCode":"774-1275534--3127584"},{"carrierFsCode":"EY","flightNumber":"4297","departureAirportFsCode":"KIX","arrivalAirportFsCode":"HKG","stops":0,"departureTerminal":"1","arrivalTerminal":"1","departureTime":"2019-02-28T23:50:00.000","arrivalTime":"2019-03-01T03:20:00.000","flightEquipmentIataCode":"320","isCodeshare":true,"isWetlease":false,"serviceType":"J","serviceClasses":["Y"],"trafficRestrictions":["G"],"operator":{"carrierFsCode":"HX","flightNumber":"637","serviceType":"J","serviceClasses":["R","Y"],"trafficRestrictions":[]},"codeshares":[],"referenceCode":"774-2109136--10867437"},{"carrierFsCode":"HX","flightNumber":"637","departureAirportFsCode":"KIX","arrivalAirportFsCode":"HKG","stops":0,"departureTerminal":"1","arrivalTerminal":"1","departureTime":"2019-02-28T23:50:00.000","arrivalTime":"2019-03-01T03:20:00.000","flightEquipmentIataCode":"320","isCodeshare":false,"isWetlease":false,"serviceType":"J","serviceClasses":["R","Y"],"trafficRestrictions":[],"codeshares":[{"carrierFsCode":"9W","flightNumber":"4854","serviceType":"J","serviceClasses":["Y"],"trafficRestrictions":["G"],"referenceCode":145822},{"carrierFsCode":"FJ","flightNumber":"5405","serviceType":"J","serviceClasses":["R","Y"],"trafficRestrictions":[],"referenceCode":1951921},{"carrierFsCode":"EY","flightNumber":"4297","serviceType":"J","serviceClasses":["Y"],"trafficRestrictions":["G"],"referenceCode":10867437}],"referenceCode":"774-2109136--"},{"carrierFsCode":"9W","flightNumber":"4854","departureAirportFsCode":"KIX","arrivalAirportFsCode":"HKG","stops":0,"departureTerminal":"1","arrivalTerminal":"1","departureTime":"2019-02-28T23:50:00.000","arrivalTime":"2019-03-01T03:20:00.000","flightEquipmentIataCode":"320","isCodeshare":true,"isWetlease":false,"serviceType":"J","serviceClasses":["Y"],"trafficRestrictions":["G"],"operator":{"carrierFsCode":"HX","flightNumber":"637","serviceType":"J","serviceClasses":["R","Y"],"trafficRestrictions":[]},"codeshares":[],"referenceCode":"774-2109136--145822"},{"carrierFsCode":"FJ","flightNumber":"5405","departureAirportFsCode":"KIX","arrivalAirportFsCode":"HKG","stops":0,"departureTerminal":"1","arrivalTerminal":"1","departureTime":"2019-02-28T23:50:00.000","arrivalTime":"2019-03-01T03:20:00.000","flightEquipmentIataCode":"320","isCodeshare":true,"isWetlease":false,"serviceType":"J","serviceClasses":["R","Y"],"trafficRestrictions":[],"operator":{"carrierFsCode":"HX","flightNumber":"637","serviceType":"J","serviceClasses":["R","Y"],"trafficRestrictions":[]},"codeshares":[],"referenceCode":"774-2109136--1951921"},{"carrierFsCode":"CX","flightNumber":"597","departureAirportFsCode":"KIX","arrivalAirportFsCode":"HKG","stops":0,"departureTerminal":"1","arrivalTerminal":"1","departureTime":"2019-02-28T09:25:00.000","arrivalTime":"2019-02-28T12:50:00.000","flightEquipmentIataCode":"359","isCodeshare":false,"isWetlease":false,"serviceType":"J","serviceClasses":["R","J","Y"],"trafficRestrictions":[],"codeshares":[{"carrierFsCode":"JL","flightNumber":"7051","serviceType":"J","serviceClasses":["J","Y"],"trafficRestrictions":[],"referenceCode":2252758},{"carrierFsCode":"QR","flightNumber":"5851","serviceType":"J","serviceClasses":["R","J","Y"],"trafficRestrictions":["Y"],"referenceCode":3127612}],"referenceCode":"774-1275437--"},{"carrierFsCode":"JL","flightNumber":"7051","departureAirportFsCode":"KIX","arrivalAirportFsCode":"HKG","stops":0,"departureTerminal":"1","arrivalTerminal":"1","departureTime":"2019-02-28T09:25:00.000","arrivalTime":"2019-02-28T12:50:00.000","flightEquipmentIataCode":"359","isCodeshare":true,"isWetlease":false,"serviceType":"J","serviceClasses":["J","Y"],"trafficRestrictions":[],"operator":{"carrierFsCode":"CX","flightNumber":"597","serviceType":"J","serviceClasses":["R","J","Y"],"trafficRestrictions":[]},"codeshares":[],"referenceCode":"774-1275437--2252758"},{"carrierFsCode":"QR","flightNumber":"5851","departureAirportFsCode":"KIX","arrivalAirportFsCode":"HKG","stops":0,"departureTerminal":"1","arrivalTerminal":"1","departureTime":"2019-02-28T09:25:00.000","arrivalTime":"2019-02-28T12:50:00.000","flightEquipmentIataCode":"359","isCodeshare":true,"isWetlease":false,"serviceType":"J","serviceClasses":["R","J","Y"],"trafficRestrictions":["Y"],"operator":{"carrierFsCode":"CX","flightNumber":"597","serviceType":"J","serviceClasses":["R","J","Y"],"trafficRestrictions":[]},"codeshares":[],"referenceCode":"774-1275437--3127612"}]';
        $arrival = json_decode($arrival,true);

        //print_r($arrival);die();

        return view('flight.result')
            ->with('code', $code)
            ->with('from', $from)
            ->with('to', $to)
            ->with('start', $start)
            ->with('end',$end)
            ->with('departure',$departure)
            ->with('arrival',$arrival)
            ->with('airports',$airports);
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


    protected function Airports($code){

        $country = $code;

//        $api_data = FlightStats::ApiData();
//        $appId = $api_data['appId'];
//        $appKey = $api_data['appKey'];
//
//        $host = 'https://api.flightstats.com/flex/airports/rest/v1/json/countryCode/'.$country.'?appId='.$appId.'&appKey='.$appKey.'&extendedOptions=languageCode%3Azh';
//
//        $ch = curl_init($host);
//        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Expect:') );
//        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
//        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
//        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
//
//        $response = curl_exec($ch);
//
//        curl_close($ch);
//
//        $arr = json_decode($response,true);
//
//        $airport = array();
//        foreach ($arr['airports'] as $k => $obj){
//            if($obj['active'] == 'true'){
//                $airport[$k]['code'] = $obj['fs'];
//                $airport[$k]['name'] = $obj['name'];
//            }
//        }

        $airports = FlightStats::AirportsData($country,null);

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



}
