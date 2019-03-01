<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\User;
use Mail;
use Session;
use Purifier;
use Image;
use Auth;
use Redirect;
use App\FlightStats;
use App\PaymentMethod;
use Illuminate\Support\Facades\Input;
use DateTime;
use DatePeriod;
use DateInterval;
use DB;

class FlightController extends Controller
{
    const token = "r3jjBWdKXrMzqMkc";

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
         * Git category [UI][FIX][DOC][TEST][NEW][ENHANCE][REWRITE][MOVE]
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

        //$departure = self::FlightData($from,$to,$start);
        //$arrival = self::FlightData($to,$from,$end);
        $airports = self::Airports($code);
        $departure_airport = self::Airports($code, $to);
        $departure_airport = $departure_airport[0]['name'];

        //Temporarily hardcoded json string to enhance speed of development
        $departure = '{"data":[{"type":"flight-offer","id":"1551069674880--995430862","offerItems":[{"services":[{"segments":[{"flightSegment":{"departure":{"iataCode":"HKG","at":"2019-02-27T20:20:00+08:00"},"arrival":{"iataCode":"PVG","terminal":"1","at":"2019-02-27T22:45:00+08:00"},"carrierCode":"HX","number":"1506","aircraft":{"code":"321"},"operating":{"carrierCode":"MU","number":"1506"},"duration":"0DT2H25M"},"pricingDetailPerAdult":{"travelClass":"ECONOMY","fareClass":"L","availability":4,"fareBasis":"LSOHC3"}}]}],"price":{"total":"2401","totalTaxes":"361"},"pricePerAdult":{"total":"2401","totalTaxes":"361"}}]},{"type":"flight-offer","id":"1551069674880-2122897082","offerItems":[{"services":[{"segments":[{"flightSegment":{"departure":{"iataCode":"HKG","terminal":"1","at":"2019-02-27T13:40:00+08:00"},"arrival":{"iataCode":"PVG","terminal":"1","at":"2019-02-27T16:15:00+08:00"},"carrierCode":"FM","number":"702","aircraft":{"code":"321"},"operating":{"carrierCode":"MU","number":"702"},"duration":"0DT2H35M"},"pricingDetailPerAdult":{"travelClass":"ECONOMY","fareClass":"R","availability":9,"fareBasis":"RSRWHK"}}]}],"price":{"total":"1570","totalTaxes":"310"},"pricePerAdult":{"total":"1570","totalTaxes":"310"}}]},{"type":"flight-offer","id":"1551069674880-412232301","offerItems":[{"services":[{"segments":[{"flightSegment":{"departure":{"iataCode":"HKG","terminal":"1","at":"2019-02-27T14:25:00+08:00"},"arrival":{"iataCode":"SHA","terminal":"1","at":"2019-02-27T16:50:00+08:00"},"carrierCode":"MU","number":"8985","aircraft":{"code":"333"},"operating":{"carrierCode":"HX","number":"8985"},"duration":"0DT2H25M"},"pricingDetailPerAdult":{"travelClass":"ECONOMY","fareClass":"R","availability":9,"fareBasis":"RHXWHK"}}]}],"price":{"total":"1810","totalTaxes":"310"},"pricePerAdult":{"total":"1810","totalTaxes":"310"}}]},{"type":"flight-offer","id":"1551069674880-662211441","offerItems":[{"services":[{"segments":[{"flightSegment":{"departure":{"iataCode":"HKG","terminal":"1","at":"2019-02-27T21:00:00+08:00"},"arrival":{"iataCode":"PVG","terminal":"2","at":"2019-02-27T23:35:00+08:00"},"carrierCode":"MU","number":"8983","aircraft":{"code":"359"},"operating":{"carrierCode":"HX","number":"8983"},"duration":"0DT2H35M"},"pricingDetailPerAdult":{"travelClass":"ECONOMY","fareClass":"R","availability":9,"fareBasis":"RHXWHK"}}]}],"price":{"total":"1810","totalTaxes":"310"},"pricePerAdult":{"total":"1810","totalTaxes":"310"}}]},{"type":"flight-offer","id":"1551069674880--1871145343","offerItems":[{"services":[{"segments":[{"flightSegment":{"departure":{"iataCode":"HKG","at":"2019-02-27T12:30:00+08:00"},"arrival":{"iataCode":"PVG","terminal":"1","at":"2019-02-27T14:50:00+08:00"},"carrierCode":"HX","number":"1502","aircraft":{"code":"773"},"operating":{"carrierCode":"MU","number":"1502"},"duration":"0DT2H20M"},"pricingDetailPerAdult":{"travelClass":"ECONOMY","fareClass":"N","availability":9,"fareBasis":"NSOHC3"}}]}],"price":{"total":"1881","totalTaxes":"361"},"pricePerAdult":{"total":"1881","totalTaxes":"361"}}]},{"type":"flight-offer","id":"1551069674880-1679713324","offerItems":[{"services":[{"segments":[{"flightSegment":{"departure":{"iataCode":"HKG","terminal":"1","at":"2019-02-27T09:00:00+08:00"},"arrival":{"iataCode":"PVG","terminal":"2","at":"2019-02-27T11:35:00+08:00"},"carrierCode":"HX","number":"236","aircraft":{"code":"332"},"operating":{"carrierCode":"HX","number":"236"},"duration":"0DT2H35M"},"pricingDetailPerAdult":{"travelClass":"ECONOMY","fareClass":"S","availability":9,"fareBasis":"SOWHK11W"}}]}],"price":{"total":"1631","totalTaxes":"361"},"pricePerAdult":{"total":"1631","totalTaxes":"361"}}]},{"type":"flight-offer","id":"1551069674880-1618662427","offerItems":[{"services":[{"segments":[{"flightSegment":{"departure":{"iataCode":"HKG","terminal":"1","at":"2019-02-27T07:40:00+08:00"},"arrival":{"iataCode":"PVG","terminal":"1","at":"2019-02-27T09:50:00+08:00"},"carrierCode":"FM","number":"726","aircraft":{"code":"321"},"operating":{"carrierCode":"MU","number":"726"},"duration":"0DT2H10M"},"pricingDetailPerAdult":{"travelClass":"ECONOMY","fareClass":"R","availability":9,"fareBasis":"RSRWHK"}}]}],"price":{"total":"1570","totalTaxes":"310"},"pricePerAdult":{"total":"1570","totalTaxes":"310"}}]},{"type":"flight-offer","id":"1551069674880--2113698679","offerItems":[{"services":[{"segments":[{"flightSegment":{"departure":{"iataCode":"HKG","terminal":"1","at":"2019-02-27T18:40:00+08:00"},"arrival":{"iataCode":"PVG","terminal":"2","at":"2019-02-27T21:20:00+08:00"},"carrierCode":"FM","number":"8232","aircraft":{"code":"333"},"operating":{"carrierCode":"HX","number":"8232"},"duration":"0DT2H40M"},"pricingDetailPerAdult":{"travelClass":"ECONOMY","fareClass":"R","availability":9,"fareBasis":"RSRWHK"}}]}],"price":{"total":"1570","totalTaxes":"310"},"pricePerAdult":{"total":"1570","totalTaxes":"310"}}]},{"type":"flight-offer","id":"1551069674880--1567869063","offerItems":[{"services":[{"segments":[{"flightSegment":{"departure":{"iataCode":"HKG","terminal":"1","at":"2019-02-27T15:55:00+08:00"},"arrival":{"iataCode":"PVG","terminal":"1","at":"2019-02-27T18:50:00+08:00"},"carrierCode":"FM","number":"504","aircraft":{"code":"321"},"operating":{"carrierCode":"MU","number":"504"},"duration":"0DT2H55M"},"pricingDetailPerAdult":{"travelClass":"ECONOMY","fareClass":"R","availability":9,"fareBasis":"RSRWHK"}}]}],"price":{"total":"1570","totalTaxes":"310"},"pricePerAdult":{"total":"1570","totalTaxes":"310"}}]},{"type":"flight-offer","id":"1551069674880--1921946908","offerItems":[{"services":[{"segments":[{"flightSegment":{"departure":{"iataCode":"HKG","terminal":"1","at":"2019-02-27T20:20:00+08:00"},"arrival":{"iataCode":"PVG","terminal":"1","at":"2019-02-27T22:45:00+08:00"},"carrierCode":"MU","number":"506","aircraft":{"code":"773"},"operating":{"carrierCode":"MU","number":"506"},"duration":"0DT2H25M"},"pricingDetailPerAdult":{"travelClass":"ECONOMY","fareClass":"K","availability":4,"fareBasis":"KSRWHK"}}]}],"price":{"total":"2110","totalTaxes":"310"},"pricePerAdult":{"total":"2110","totalTaxes":"310"}}]},{"type":"flight-offer","id":"1551069674880-640318200","offerItems":[{"services":[{"segments":[{"flightSegment":{"departure":{"iataCode":"HKG","terminal":"1","at":"2019-02-27T13:00:00+08:00"},"arrival":{"iataCode":"PVG","terminal":"2","at":"2019-02-27T15:40:00+08:00"},"carrierCode":"MU","number":"8989","aircraft":{"code":"359"},"operating":{"carrierCode":"HX","number":"8989"},"duration":"0DT2H40M"},"pricingDetailPerAdult":{"travelClass":"ECONOMY","fareClass":"R","availability":9,"fareBasis":"RHXWHK"}}]}],"price":{"total":"1810","totalTaxes":"310"},"pricePerAdult":{"total":"1810","totalTaxes":"310"}}]},{"type":"flight-offer","id":"1551069674880-1437647202","offerItems":[{"services":[{"segments":[{"flightSegment":{"departure":{"iataCode":"HKG","terminal":"1","at":"2019-02-27T21:15:00+08:00"},"arrival":{"iataCode":"PVG","terminal":"2","at":"2019-02-27T23:45:00+08:00"},"carrierCode":"KA","number":"870","aircraft":{"code":"320"},"operating":{"carrierCode":"KA","number":"870"},"duration":"0DT2H30M"},"pricingDetailPerAdult":{"travelClass":"ECONOMY","fareClass":"Y","availability":9,"fareBasis":"YOW2"}}]}],"price":{"total":"2991","totalTaxes":"361"},"pricePerAdult":{"total":"2991","totalTaxes":"361"}}]},{"type":"flight-offer","id":"1551069674880-433688806","offerItems":[{"services":[{"segments":[{"flightSegment":{"departure":{"iataCode":"HKG","terminal":"1","at":"2019-02-27T21:00:00+08:00"},"arrival":{"iataCode":"PVG","terminal":"2","at":"2019-02-27T23:35:00+08:00"},"carrierCode":"HX","number":"234","aircraft":{"code":"359"},"operating":{"carrierCode":"HX","number":"234"},"duration":"0DT2H35M"},"pricingDetailPerAdult":{"travelClass":"ECONOMY","fareClass":"S","availability":9,"fareBasis":"SOWHK11W"}}]}],"price":{"total":"1631","totalTaxes":"361"},"pricePerAdult":{"total":"1631","totalTaxes":"361"}}]},{"type":"flight-offer","id":"1551069674880--677940546","offerItems":[{"services":[{"segments":[{"flightSegment":{"departure":{"iataCode":"HKG","terminal":"1","at":"2019-02-27T17:30:00+08:00"},"arrival":{"iataCode":"PVG","terminal":"2","at":"2019-02-27T20:00:00+08:00"},"carrierCode":"KA","number":"5364","aircraft":{"code":"333"},"operating":{"carrierCode":"CX","number":"5364"},"duration":"0DT2H30M"},"pricingDetailPerAdult":{"travelClass":"ECONOMY","fareClass":"Y","availability":9,"fareBasis":"YOW2"}}]}],"price":{"total":"2991","totalTaxes":"361"},"pricePerAdult":{"total":"2991","totalTaxes":"361"}}]},{"type":"flight-offer","id":"1551069674880-1082757961","offerItems":[{"services":[{"segments":[{"flightSegment":{"departure":{"iataCode":"HKG","terminal":"1","at":"2019-02-27T11:55:00+08:00"},"arrival":{"iataCode":"SHA","terminal":"1","at":"2019-02-27T14:25:00+08:00"},"carrierCode":"MU","number":"722","aircraft":{"code":"333"},"operating":{"carrierCode":"MU","number":"722"},"duration":"0DT2H30M"},"pricingDetailPerAdult":{"travelClass":"ECONOMY","fareClass":"R","availability":9,"fareBasis":"RSRWHK"}}]}],"price":{"total":"1570","totalTaxes":"310"},"pricePerAdult":{"total":"1570","totalTaxes":"310"}}]},{"type":"flight-offer","id":"1551069674880--448887335","offerItems":[{"services":[{"segments":[{"flightSegment":{"departure":{"iataCode":"HKG","terminal":"1","at":"2019-02-27T15:55:00+08:00"},"arrival":{"iataCode":"PVG","terminal":"1","at":"2019-02-27T18:50:00+08:00"},"carrierCode":"MU","number":"504","aircraft":{"code":"321"},"operating":{"carrierCode":"MU","number":"504"},"duration":"0DT2H55M"},"pricingDetailPerAdult":{"travelClass":"ECONOMY","fareClass":"R","availability":9,"fareBasis":"RSRWHK"}}]}],"price":{"total":"1570","totalTaxes":"310"},"pricePerAdult":{"total":"1570","totalTaxes":"310"}}]},{"type":"flight-offer","id":"1551069674880-1797383823","offerItems":[{"services":[{"segments":[{"flightSegment":{"departure":{"iataCode":"HKG","terminal":"1","at":"2019-02-27T09:35:00+08:00"},"arrival":{"iataCode":"PVG","terminal":"1","at":"2019-02-27T12:00:00+08:00"},"carrierCode":"MU","number":"724","aircraft":{"code":"321"},"operating":{"carrierCode":"MU","number":"724"},"duration":"0DT2H25M"},"pricingDetailPerAdult":{"travelClass":"ECONOMY","fareClass":"R","availability":9,"fareBasis":"RSRWHK"}}]}],"price":{"total":"1570","totalTaxes":"310"},"pricePerAdult":{"total":"1570","totalTaxes":"310"}}]},{"type":"flight-offer","id":"1551069674880-606827341","offerItems":[{"services":[{"segments":[{"flightSegment":{"departure":{"iataCode":"HKG","terminal":"1","at":"2019-02-27T12:55:00+08:00"},"arrival":{"iataCode":"SHA","terminal":"1","at":"2019-02-27T15:40:00+08:00"},"carrierCode":"FM","number":"8258","aircraft":{"code":"333"},"operating":{"carrierCode":"HX","number":"8258"},"duration":"0DT2H45M"},"pricingDetailPerAdult":{"travelClass":"ECONOMY","fareClass":"R","availability":9,"fareBasis":"RSRWHK"}}]}],"price":{"total":"1570","totalTaxes":"310"},"pricePerAdult":{"total":"1570","totalTaxes":"310"}}]},{"type":"flight-offer","id":"1551069674880--1653394649","offerItems":[{"services":[{"segments":[{"flightSegment":{"departure":{"iataCode":"HKG","at":"2019-02-27T15:55:00+08:00"},"arrival":{"iataCode":"PVG","terminal":"1","at":"2019-02-27T18:50:00+08:00"},"carrierCode":"HX","number":"1504","aircraft":{"code":"320"},"operating":{"carrierCode":"MU","number":"1504"},"duration":"0DT2H55M"},"pricingDetailPerAdult":{"travelClass":"ECONOMY","fareClass":"N","availability":9,"fareBasis":"NSOHC3"}}]}],"price":{"total":"1881","totalTaxes":"361"},"pricePerAdult":{"total":"1881","totalTaxes":"361"}}]},{"type":"flight-offer","id":"1551069674880-183769248","offerItems":[{"services":[{"segments":[{"flightSegment":{"departure":{"iataCode":"HKG","terminal":"1","at":"2019-02-27T14:25:00+08:00"},"arrival":{"iataCode":"SHA","terminal":"1","at":"2019-02-27T16:50:00+08:00"},"carrierCode":"HX","number":"238","aircraft":{"code":"333"},"operating":{"carrierCode":"HX","number":"238"},"duration":"0DT2H25M"},"pricingDetailPerAdult":{"travelClass":"ECONOMY","fareClass":"S","availability":9,"fareBasis":"SOWHK11W"}}]}],"price":{"total":"1631","totalTaxes":"361"},"pricePerAdult":{"total":"1631","totalTaxes":"361"}}]},{"type":"flight-offer","id":"1551069674880-1943581501","offerItems":[{"services":[{"segments":[{"flightSegment":{"departure":{"iataCode":"HKG","terminal":"1","at":"2019-02-27T18:40:00+08:00"},"arrival":{"iataCode":"PVG","terminal":"2","at":"2019-02-27T21:20:00+08:00"},"carrierCode":"HX","number":"232","aircraft":{"code":"333"},"operating":{"carrierCode":"HX","number":"232"},"duration":"0DT2H40M"},"pricingDetailPerAdult":{"travelClass":"ECONOMY","fareClass":"S","availability":9,"fareBasis":"SOWHK11W"}}]}],"price":{"total":"1631","totalTaxes":"361"},"pricePerAdult":{"total":"1631","totalTaxes":"361"}}]},{"type":"flight-offer","id":"1551069674880-1435997269","offerItems":[{"services":[{"segments":[{"flightSegment":{"departure":{"iataCode":"HKG","terminal":"1","at":"2019-02-27T13:00:00+08:00"},"arrival":{"iataCode":"PVG","terminal":"2","at":"2019-02-27T15:30:00+08:00"},"carrierCode":"KA","number":"874","aircraft":{"code":"333"},"operating":{"carrierCode":"KA","number":"874"},"duration":"0DT2H30M"},"pricingDetailPerAdult":{"travelClass":"ECONOMY","fareClass":"Y","availability":9,"fareBasis":"YOW2"}}]}],"price":{"total":"2991","totalTaxes":"361"},"pricePerAdult":{"total":"2991","totalTaxes":"361"}}]},{"type":"flight-offer","id":"1551069674880-1289918401","offerItems":[{"services":[{"segments":[{"flightSegment":{"departure":{"iataCode":"HKG","terminal":"1","at":"2019-02-27T17:40:00+08:00"},"arrival":{"iataCode":"PVG","terminal":"1","at":"2019-02-27T20:20:00+08:00"},"carrierCode":"FM","number":"510","aircraft":{"code":"321"},"operating":{"carrierCode":"MU","number":"510"},"duration":"0DT2H40M"},"pricingDetailPerAdult":{"travelClass":"ECONOMY","fareClass":"Y","availability":9,"fareBasis":"YFFWHK"}}]}],"price":{"total":"2940","totalTaxes":"310"},"pricePerAdult":{"total":"2940","totalTaxes":"310"}}]},{"type":"flight-offer","id":"1551069674880-1907431602","offerItems":[{"services":[{"segments":[{"flightSegment":{"departure":{"iataCode":"HKG","terminal":"1","at":"2019-02-27T09:00:00+08:00"},"arrival":{"iataCode":"PVG","terminal":"2","at":"2019-02-27T11:35:00+08:00"},"carrierCode":"MU","number":"8979","aircraft":{"code":"332"},"operating":{"carrierCode":"HX","number":"8979"},"duration":"0DT2H35M"},"pricingDetailPerAdult":{"travelClass":"ECONOMY","fareClass":"R","availability":9,"fareBasis":"RHXWHK"}}]}],"price":{"total":"1810","totalTaxes":"310"},"pricePerAdult":{"total":"1810","totalTaxes":"310"}}]},{"type":"flight-offer","id":"1551069674880-671375922","offerItems":[{"services":[{"segments":[{"flightSegment":{"departure":{"iataCode":"HKG","terminal":"1","at":"2019-02-27T21:00:00+08:00"},"arrival":{"iataCode":"PVG","terminal":"2","at":"2019-02-27T23:35:00+08:00"},"carrierCode":"FM","number":"8234","aircraft":{"code":"359"},"operating":{"carrierCode":"HX","number":"8234"},"duration":"0DT2H35M"},"pricingDetailPerAdult":{"travelClass":"ECONOMY","fareClass":"R","availability":9,"fareBasis":"RSRWHK"}}]}],"price":{"total":"1570","totalTaxes":"310"},"pricePerAdult":{"total":"1570","totalTaxes":"310"}}]},{"type":"flight-offer","id":"1551069674880--36223767","offerItems":[{"services":[{"segments":[{"flightSegment":{"departure":{"iataCode":"HKG","terminal":"1","at":"2019-02-27T11:55:00+08:00"},"arrival":{"iataCode":"SHA","terminal":"1","at":"2019-02-27T14:25:00+08:00"},"carrierCode":"FM","number":"722","aircraft":{"code":"333"},"operating":{"carrierCode":"MU","number":"722"},"duration":"0DT2H30M"},"pricingDetailPerAdult":{"travelClass":"ECONOMY","fareClass":"R","availability":9,"fareBasis":"RSRWHK"}}]}],"price":{"total":"1570","totalTaxes":"310"},"pricePerAdult":{"total":"1570","totalTaxes":"310"}}]},{"type":"flight-offer","id":"1551069674880-592876509","offerItems":[{"services":[{"segments":[{"flightSegment":{"departure":{"iataCode":"HKG","at":"2019-02-27T09:35:00+08:00"},"arrival":{"iataCode":"PVG","terminal":"1","at":"2019-02-27T12:00:00+08:00"},"carrierCode":"HX","number":"1724","aircraft":{"code":"320"},"operating":{"carrierCode":"MU","number":"1724"},"duration":"0DT2H25M"},"pricingDetailPerAdult":{"travelClass":"ECONOMY","fareClass":"N","availability":9,"fareBasis":"NSOHC3"}}]}],"price":{"total":"1881","totalTaxes":"361"},"pricePerAdult":{"total":"1881","totalTaxes":"361"}}]},{"type":"flight-offer","id":"1551069674880--666638029","offerItems":[{"services":[{"segments":[{"flightSegment":{"departure":{"iataCode":"HKG","terminal":"1","at":"2019-02-27T12:30:00+08:00"},"arrival":{"iataCode":"PVG","terminal":"1","at":"2019-02-27T14:50:00+08:00"},"carrierCode":"MU","number":"502","aircraft":{"code":"773"},"operating":{"carrierCode":"MU","number":"502"},"duration":"0DT2H20M"},"pricingDetailPerAdult":{"travelClass":"ECONOMY","fareClass":"R","availability":9,"fareBasis":"RSRWHK"}}]}],"price":{"total":"1570","totalTaxes":"310"},"pricePerAdult":{"total":"1570","totalTaxes":"310"}}]},{"type":"flight-offer","id":"1551069674880--2122863160","offerItems":[{"services":[{"segments":[{"flightSegment":{"departure":{"iataCode":"HKG","terminal":"1","at":"2019-02-27T18:40:00+08:00"},"arrival":{"iataCode":"PVG","terminal":"2","at":"2019-02-27T21:20:00+08:00"},"carrierCode":"MU","number":"8981","aircraft":{"code":"333"},"operating":{"carrierCode":"HX","number":"8981"},"duration":"0DT2H40M"},"pricingDetailPerAdult":{"travelClass":"ECONOMY","fareClass":"R","availability":9,"fareBasis":"RHXWHK"}}]}],"price":{"total":"1810","totalTaxes":"310"},"pricePerAdult":{"total":"1810","totalTaxes":"310"}}]},{"type":"flight-offer","id":"1551069674880--1785619757","offerItems":[{"services":[{"segments":[{"flightSegment":{"departure":{"iataCode":"HKG","terminal":"1","at":"2019-02-27T12:30:00+08:00"},"arrival":{"iataCode":"PVG","terminal":"1","at":"2019-02-27T14:50:00+08:00"},"carrierCode":"FM","number":"502","aircraft":{"code":"773"},"operating":{"carrierCode":"MU","number":"502"},"duration":"0DT2H20M"},"pricingDetailPerAdult":{"travelClass":"ECONOMY","fareClass":"R","availability":9,"fareBasis":"RSRWHK"}}]}],"price":{"total":"1570","totalTaxes":"310"},"pricePerAdult":{"total":"1570","totalTaxes":"310"}}]},{"type":"flight-offer","id":"1551069674880-251362420","offerItems":[{"services":[{"segments":[{"flightSegment":{"departure":{"iataCode":"HKG","terminal":"1","at":"2019-02-27T15:25:00+08:00"},"arrival":{"iataCode":"PVG","terminal":"1","at":"2019-02-27T18:05:00+08:00"},"carrierCode":"MU","number":"508","aircraft":{"code":"321"},"operating":{"carrierCode":"MU","number":"508"},"duration":"0DT2H40M"},"pricingDetailPerAdult":{"travelClass":"ECONOMY","fareClass":"R","availability":9,"fareBasis":"RSRWHK"}}]}],"price":{"total":"1570","totalTaxes":"310"},"pricePerAdult":{"total":"1570","totalTaxes":"310"}}]},{"type":"flight-offer","id":"1551069674880-1917400440","offerItems":[{"services":[{"segments":[{"flightSegment":{"departure":{"iataCode":"HKG","terminal":"1","at":"2019-02-27T09:00:00+08:00"},"arrival":{"iataCode":"PVG","terminal":"2","at":"2019-02-27T11:35:00+08:00"},"carrierCode":"FM","number":"8236","aircraft":{"code":"332"},"operating":{"carrierCode":"HX","number":"8236"},"duration":"0DT2H35M"},"pricingDetailPerAdult":{"travelClass":"ECONOMY","fareClass":"R","availability":9,"fareBasis":"RSRWHK"}}]}],"price":{"total":"1570","totalTaxes":"310"},"pricePerAdult":{"total":"1570","totalTaxes":"310"}}]},{"type":"flight-offer","id":"1551069674880-1533136841","offerItems":[{"services":[{"segments":[{"flightSegment":{"departure":{"iataCode":"HKG","at":"2019-02-27T07:40:00+08:00"},"arrival":{"iataCode":"PVG","terminal":"1","at":"2019-02-27T09:50:00+08:00"},"carrierCode":"HX","number":"1726","aircraft":{"code":"320"},"operating":{"carrierCode":"MU","number":"1726"},"duration":"0DT2H10M"},"pricingDetailPerAdult":{"travelClass":"ECONOMY","fareClass":"N","availability":9,"fareBasis":"NSOHC3"}}]}],"price":{"total":"1881","totalTaxes":"361"},"pricePerAdult":{"total":"1881","totalTaxes":"361"}}]},{"type":"flight-offer","id":"1551069674880-595815818","offerItems":[{"services":[{"segments":[{"flightSegment":{"departure":{"iataCode":"HKG","terminal":"1","at":"2019-02-27T12:55:00+08:00"},"arrival":{"iataCode":"SHA","terminal":"1","at":"2019-02-27T15:40:00+08:00"},"carrierCode":"MU","number":"8987","aircraft":{"code":"333"},"operating":{"carrierCode":"HX","number":"8987"},"duration":"0DT2H45M"},"pricingDetailPerAdult":{"travelClass":"ECONOMY","fareClass":"R","availability":9,"fareBasis":"RHXWHK"}}]}],"price":{"total":"1810","totalTaxes":"310"},"pricePerAdult":{"total":"1810","totalTaxes":"310"}}]},{"type":"flight-offer","id":"1551069674880--121749353","offerItems":[{"services":[{"segments":[{"flightSegment":{"departure":{"iataCode":"HKG","at":"2019-02-27T11:55:00+08:00"},"arrival":{"iataCode":"SHA","terminal":"1","at":"2019-02-27T14:25:00+08:00"},"carrierCode":"HX","number":"1722","aircraft":{"code":"333"},"operating":{"carrierCode":"MU","number":"1722"},"duration":"0DT2H30M"},"pricingDetailPerAdult":{"travelClass":"ECONOMY","fareClass":"N","availability":9,"fareBasis":"NSOHC3"}}]}],"price":{"total":"1881","totalTaxes":"361"},"pricePerAdult":{"total":"1881","totalTaxes":"361"}}]},{"type":"flight-offer","id":"1551069674880--953144894","offerItems":[{"services":[{"segments":[{"flightSegment":{"departure":{"iataCode":"HKG","at":"2019-02-27T15:25:00+08:00"},"arrival":{"iataCode":"PVG","terminal":"1","at":"2019-02-27T18:05:00+08:00"},"carrierCode":"HX","number":"1508","aircraft":{"code":"320"},"operating":{"carrierCode":"MU","number":"1508"},"duration":"0DT2H40M"},"pricingDetailPerAdult":{"travelClass":"ECONOMY","fareClass":"N","availability":9,"fareBasis":"NSOHC3"}}]}],"price":{"total":"1881","totalTaxes":"361"},"pricePerAdult":{"total":"1881","totalTaxes":"361"}}]},{"type":"flight-offer","id":"1551069674880--201838413","offerItems":[{"services":[{"segments":[{"flightSegment":{"departure":{"iataCode":"HKG","terminal":"1","at":"2019-02-27T10:00:00+08:00"},"arrival":{"iataCode":"SHA","terminal":"1","at":"2019-02-27T12:20:00+08:00"},"carrierCode":"CX","number":"5858","aircraft":{"code":"333"},"operating":{"carrierCode":"KA","number":"5858"},"duration":"0DT2H20M"},"pricingDetailPerAdult":{"travelClass":"ECONOMY","fareClass":"Y","availability":9,"fareBasis":"YOW2"}}]}],"price":{"total":"2991","totalTaxes":"361"},"pricePerAdult":{"total":"2991","totalTaxes":"361"}}]},{"type":"flight-offer","id":"1551069674880-1124088478","offerItems":[{"services":[{"segments":[{"flightSegment":{"departure":{"iataCode":"HKG","terminal":"1","at":"2019-02-27T10:00:00+08:00"},"arrival":{"iataCode":"SHA","terminal":"1","at":"2019-02-27T12:20:00+08:00"},"carrierCode":"KA","number":"858","aircraft":{"code":"333"},"operating":{"carrierCode":"KA","number":"858"},"duration":"0DT2H20M"},"pricingDetailPerAdult":{"travelClass":"ECONOMY","fareClass":"Y","availability":9,"fareBasis":"YOW2"}}]}],"price":{"total":"2991","totalTaxes":"361"},"pricePerAdult":{"total":"2991","totalTaxes":"361"}}]},{"type":"flight-offer","id":"1551069674880-678402095","offerItems":[{"services":[{"segments":[{"flightSegment":{"departure":{"iataCode":"HKG","terminal":"1","at":"2019-02-27T09:35:00+08:00"},"arrival":{"iataCode":"PVG","terminal":"1","at":"2019-02-27T12:00:00+08:00"},"carrierCode":"FM","number":"724","aircraft":{"code":"321"},"operating":{"carrierCode":"MU","number":"724"},"duration":"0DT2H25M"},"pricingDetailPerAdult":{"travelClass":"ECONOMY","fareClass":"R","availability":9,"fareBasis":"RSRWHK"}}]}],"price":{"total":"1570","totalTaxes":"310"},"pricePerAdult":{"total":"1570","totalTaxes":"310"}}]},{"type":"flight-offer","id":"1551069674880-2037371496","offerItems":[{"services":[{"segments":[{"flightSegment":{"departure":{"iataCode":"HKG","at":"2019-02-27T13:40:00+08:00"},"arrival":{"iataCode":"PVG","terminal":"1","at":"2019-02-27T16:15:00+08:00"},"carrierCode":"HX","number":"1702","aircraft":{"code":"320"},"operating":{"carrierCode":"MU","number":"1702"},"duration":"0DT2H35M"},"pricingDetailPerAdult":{"travelClass":"ECONOMY","fareClass":"N","availability":9,"fareBasis":"NSOHC3"}}]}],"price":{"total":"1881","totalTaxes":"361"},"pricePerAdult":{"total":"1881","totalTaxes":"361"}}]},{"type":"flight-offer","id":"1551069674880-369140225","offerItems":[{"services":[{"segments":[{"flightSegment":{"departure":{"iataCode":"HKG","terminal":"1","at":"2019-02-27T12:55:00+08:00"},"arrival":{"iataCode":"SHA","terminal":"1","at":"2019-02-27T15:40:00+08:00"},"carrierCode":"HX","number":"258","aircraft":{"code":"333"},"operating":{"carrierCode":"HX","number":"258"},"duration":"0DT2H45M"},"pricingDetailPerAdult":{"travelClass":"ECONOMY","fareClass":"S","availability":9,"fareBasis":"SOWHK11W"}}]}],"price":{"total":"1631","totalTaxes":"361"},"pricePerAdult":{"total":"1631","totalTaxes":"361"}}]},{"type":"flight-offer","id":"1551069674880--1886067167","offerItems":[{"services":[{"segments":[{"flightSegment":{"departure":{"iataCode":"HKG","terminal":"1","at":"2019-02-27T17:40:00+08:00"},"arrival":{"iataCode":"PVG","terminal":"1","at":"2019-02-27T20:20:00+08:00"},"carrierCode":"MU","number":"510","aircraft":{"code":"321"},"operating":{"carrierCode":"MU","number":"510"},"duration":"0DT2H40M"},"pricingDetailPerAdult":{"travelClass":"ECONOMY","fareClass":"Y","availability":9,"fareBasis":"YFFWHK"}}]}],"price":{"total":"2940","totalTaxes":"310"},"pricePerAdult":{"total":"2940","totalTaxes":"310"}}]},{"type":"flight-offer","id":"1551069674880--1053088486","offerItems":[{"services":[{"segments":[{"flightSegment":{"departure":{"iataCode":"HKG","terminal":"1","at":"2019-02-27T13:40:00+08:00"},"arrival":{"iataCode":"PVG","terminal":"1","at":"2019-02-27T16:15:00+08:00"},"carrierCode":"MU","number":"702","aircraft":{"code":"321"},"operating":{"carrierCode":"MU","number":"702"},"duration":"0DT2H35M"},"pricingDetailPerAdult":{"travelClass":"ECONOMY","fareClass":"R","availability":9,"fareBasis":"RSRWHK"}}]}],"price":{"total":"1570","totalTaxes":"310"},"pricePerAdult":{"total":"1570","totalTaxes":"310"}}]},{"type":"flight-offer","id":"1551069674880--867619308","offerItems":[{"services":[{"segments":[{"flightSegment":{"departure":{"iataCode":"HKG","terminal":"1","at":"2019-02-27T15:25:00+08:00"},"arrival":{"iataCode":"PVG","terminal":"1","at":"2019-02-27T18:05:00+08:00"},"carrierCode":"FM","number":"508","aircraft":{"code":"321"},"operating":{"carrierCode":"MU","number":"508"},"duration":"0DT2H40M"},"pricingDetailPerAdult":{"travelClass":"ECONOMY","fareClass":"R","availability":9,"fareBasis":"RSRWHK"}}]}],"price":{"total":"1570","totalTaxes":"310"},"pricePerAdult":{"total":"1570","totalTaxes":"310"}}]},{"type":"flight-offer","id":"1551069674880-412599922","offerItems":[{"services":[{"segments":[{"flightSegment":{"departure":{"iataCode":"HKG","terminal":"1","at":"2019-02-27T13:00:00+08:00"},"arrival":{"iataCode":"PVG","terminal":"2","at":"2019-02-27T15:40:00+08:00"},"carrierCode":"HX","number":"246","aircraft":{"code":"359"},"operating":{"carrierCode":"HX","number":"246"},"duration":"0DT2H40M"},"pricingDetailPerAdult":{"travelClass":"ECONOMY","fareClass":"S","availability":9,"fareBasis":"SOWHK11W"}}]}],"price":{"total":"1631","totalTaxes":"361"},"pricePerAdult":{"total":"1631","totalTaxes":"361"}}]},{"type":"flight-offer","id":"1551069674880-1254038660","offerItems":[{"services":[{"segments":[{"flightSegment":{"departure":{"iataCode":"HKG","terminal":"1","at":"2019-02-27T20:20:00+08:00"},"arrival":{"iataCode":"PVG","terminal":"1","at":"2019-02-27T22:45:00+08:00"},"carrierCode":"FM","number":"506","aircraft":{"code":"773"},"operating":{"carrierCode":"MU","number":"506"},"duration":"0DT2H25M"},"pricingDetailPerAdult":{"travelClass":"ECONOMY","fareClass":"K","availability":4,"fareBasis":"KSRWHK"}}]}],"price":{"total":"2110","totalTaxes":"310"},"pricePerAdult":{"total":"2110","totalTaxes":"310"}}]},{"type":"flight-offer","id":"1551069674880--2035665974","offerItems":[{"services":[{"segments":[{"flightSegment":{"departure":{"iataCode":"HKG","terminal":"1","at":"2019-02-27T22:30:00+08:00"},"arrival":{"iataCode":"PVG","terminal":"2","at":"2019-02-28T00:55:00+08:00"},"carrierCode":"HO","number":"1306","aircraft":{"code":"321"},"operating":{"carrierCode":"HO","number":"1306"},"duration":"0DT2H25M"},"pricingDetailPerAdult":{"travelClass":"ECONOMY","fareClass":"T","availability":9,"fareBasis":"TOWA"}}]}],"price":{"total":"1010","totalTaxes":"260"},"pricePerAdult":{"total":"1010","totalTaxes":"260"}}]},{"type":"flight-offer","id":"1551069674880-421456364","offerItems":[{"services":[{"segments":[{"flightSegment":{"departure":{"iataCode":"HKG","terminal":"1","at":"2019-02-27T14:25:00+08:00"},"arrival":{"iataCode":"SHA","terminal":"1","at":"2019-02-27T16:50:00+08:00"},"carrierCode":"FM","number":"8238","aircraft":{"code":"333"},"operating":{"carrierCode":"HX","number":"8238"},"duration":"0DT2H25M"},"pricingDetailPerAdult":{"travelClass":"ECONOMY","fareClass":"R","availability":9,"fareBasis":"RSRWHK"}}]}],"price":{"total":"1570","totalTaxes":"310"},"pricePerAdult":{"total":"1570","totalTaxes":"310"}}]},{"type":"flight-offer","id":"1551069674880-650287038","offerItems":[{"services":[{"segments":[{"flightSegment":{"departure":{"iataCode":"HKG","terminal":"1","at":"2019-02-27T13:00:00+08:00"},"arrival":{"iataCode":"PVG","terminal":"2","at":"2019-02-27T15:40:00+08:00"},"carrierCode":"FM","number":"8246","aircraft":{"code":"359"},"operating":{"carrierCode":"HX","number":"8246"},"duration":"0DT2H40M"},"pricingDetailPerAdult":{"travelClass":"ECONOMY","fareClass":"R","availability":9,"fareBasis":"RSRWHK"}}]}],"price":{"total":"1570","totalTaxes":"310"},"pricePerAdult":{"total":"1570","totalTaxes":"310"}}]},{"type":"flight-offer","id":"1551069674880--1557323141","offerItems":[{"services":[{"segments":[{"flightSegment":{"departure":{"iataCode":"HKG","terminal":"1","at":"2019-02-27T07:40:00+08:00"},"arrival":{"iataCode":"PVG","terminal":"1","at":"2019-02-27T09:50:00+08:00"},"carrierCode":"MU","number":"726","aircraft":{"code":"321"},"operating":{"carrierCode":"MU","number":"726"},"duration":"0DT2H10M"},"pricingDetailPerAdult":{"travelClass":"ECONOMY","fareClass":"R","availability":9,"fareBasis":"RSRWHK"}}]}],"price":{"total":"1570","totalTaxes":"310"},"pricePerAdult":{"total":"1570","totalTaxes":"310"}}]}],"dictionaries":{"carriers":{"HX":"HONG KONG AIRLINES","CX":"CATHAY PACIFIC","KA":"CATHAY DRAGON","FM":"SHANGHAI AIRLINES","HO":"JUNEYAO AIRLINES","MU":"CHINA EASTERN AIRLINES"},"currencies":{"HKD":"HONGKONG DOLLAR"},"aircraft":{"320":"AIRBUS INDUSTRIE A320-100/200","321":"AIRBUS INDUSTRIE A321","332":"AIRBUS INDUSTRIE A330-200","333":"AIRBUS INDUSTRIE A330-300","773":"BOEING 777-300","359":"AIRBUS INDUSTRIE A350-900"},"locations":{"PVG":{"subType":"AIRPORT","detailedName":"PUDONG INTL"},"HKG":{"subType":"AIRPORT","detailedName":"INTERNATIONAL"},"SHA":{"subType":"AIRPORT","detailedName":"HONGQIAO INTL"}}},"meta":{"links":{"self":"https://api.amadeus.com/v1/shopping/flight-offers?origin=HKG&destination=SHA&departureDate=2019-02-27&adults=1&nonStop=true¤cy=HKD"},"currency":"HKD","defaults":{"adults":1}}}';
        $arrival = '{"data":[{"type":"flight-offer","id":"1551069721093-1187196873","offerItems":[{"services":[{"segments":[{"flightSegment":{"departure":{"iataCode":"PVG","terminal":"2","at":"2019-03-06T12:45:00+08:00"},"arrival":{"iataCode":"HKG","terminal":"1","at":"2019-03-06T15:45:00+08:00"},"carrierCode":"FM","number":"8237","aircraft":{"code":"333"},"operating":{"carrierCode":"HX","number":"8237"},"duration":"0DT3H0M"},"pricingDetailPerAdult":{"travelClass":"ECONOMY","fareClass":"R","availability":9,"fareBasis":"RSRWCH"}}]}],"price":{"total":"1645","totalTaxes":"165"},"pricePerAdult":{"total":"1645","totalTaxes":"165"}}]},{"type":"flight-offer","id":"1551069721093-1025253952","offerItems":[{"services":[{"segments":[{"flightSegment":{"departure":{"iataCode":"SHA","terminal":"1","at":"2019-03-06T18:10:00+08:00"},"arrival":{"iataCode":"HKG","terminal":"1","at":"2019-03-06T20:55:00+08:00"},"carrierCode":"MU","number":"8986","aircraft":{"code":"333"},"operating":{"carrierCode":"HX","number":"8986"},"duration":"0DT2H45M"},"pricingDetailPerAdult":{"travelClass":"ECONOMY","fareClass":"R","availability":9,"fareBasis":"RHXWCH"}}]}],"price":{"total":"1645","totalTaxes":"165"},"pricePerAdult":{"total":"1645","totalTaxes":"165"}}]},{"type":"flight-offer","id":"1551069721093-1876006245","offerItems":[{"services":[{"segments":[{"flightSegment":{"departure":{"iataCode":"PVG","terminal":"2","at":"2019-03-06T07:25:00+08:00"},"arrival":{"iataCode":"HKG","terminal":"1","at":"2019-03-06T10:40:00+08:00"},"carrierCode":"HX","number":"231","aircraft":{"code":"359"},"operating":{"carrierCode":"HX","number":"231"},"duration":"0DT3H15M"},"pricingDetailPerAdult":{"travelClass":"ECONOMY","fareClass":"S","availability":9,"fareBasis":"SOWCN11W"}}]}],"price":{"total":"1320","totalTaxes":"200"},"pricePerAdult":{"total":"1320","totalTaxes":"200"}}]},{"type":"flight-offer","id":"1551069721093--2113023185","offerItems":[{"services":[{"segments":[{"flightSegment":{"departure":{"iataCode":"PVG","terminal":"2","at":"2019-03-06T07:25:00+08:00"},"arrival":{"iataCode":"HKG","terminal":"1","at":"2019-03-06T10:40:00+08:00"},"carrierCode":"MU","number":"8982","aircraft":{"code":"359"},"operating":{"carrierCode":"HX","number":"8982"},"duration":"0DT3H15M"},"pricingDetailPerAdult":{"travelClass":"ECONOMY","fareClass":"R","availability":9,"fareBasis":"RHXWCH"}}]}],"price":{"total":"1645","totalTaxes":"165"},"pricePerAdult":{"total":"1645","totalTaxes":"165"}}]},{"type":"flight-offer","id":"1551069721093-606204937","offerItems":[{"services":[{"segments":[{"flightSegment":{"departure":{"iataCode":"PVG","terminal":"1","at":"2019-03-06T18:30:00+08:00"},"arrival":{"iataCode":"HKG","terminal":"1","at":"2019-03-06T21:30:00+08:00"},"carrierCode":"FM","number":"723","aircraft":{"code":"321"},"operating":{"carrierCode":"MU","number":"723"},"duration":"0DT3H0M"},"pricingDetailPerAdult":{"travelClass":"ECONOMY","fareClass":"T","availability":9,"fareBasis":"TPRWCH"}}]}],"price":{"total":"985","totalTaxes":"165"},"pricePerAdult":{"total":"985","totalTaxes":"165"}}]},{"type":"flight-offer","id":"1551069721093-1842122126","offerItems":[{"services":[{"segments":[{"flightSegment":{"departure":{"iataCode":"PVG","terminal":"1","at":"2019-03-06T11:05:00+08:00"},"arrival":{"iataCode":"HKG","terminal":"1","at":"2019-03-06T14:25:00+08:00"},"carrierCode":"MU","number":"507","aircraft":{"code":"320"},"operating":{"carrierCode":"MU","number":"507"},"duration":"0DT3H20M"},"pricingDetailPerAdult":{"travelClass":"ECONOMY","fareClass":"T","availability":9,"fareBasis":"TPRWCH"}}]}],"price":{"total":"985","totalTaxes":"165"},"pricePerAdult":{"total":"985","totalTaxes":"165"}}]},{"type":"flight-offer","id":"1551069721093--1087056588","offerItems":[{"services":[{"segments":[{"flightSegment":{"departure":{"iataCode":"SHA","terminal":"1","at":"2019-03-06T13:35:00+08:00"},"arrival":{"iataCode":"HKG","terminal":"1","at":"2019-03-06T16:15:00+08:00"},"carrierCode":"CX","number":"5813","aircraft":{"code":"333"},"operating":{"carrierCode":"KA","number":"5813"},"duration":"0DT2H40M"},"pricingDetailPerAdult":{"travelClass":"ECONOMY","fareClass":"S","availability":9,"fareBasis":"SLATOXB8"}}]}],"price":{"total":"1927","totalTaxes":"227"},"pricePerAdult":{"total":"1927","totalTaxes":"227"}}]},{"type":"flight-offer","id":"1551069721093--47025613","offerItems":[{"services":[{"segments":[{"flightSegment":{"departure":{"iataCode":"PVG","terminal":"1","at":"2019-03-06T21:20:00+08:00"},"arrival":{"iataCode":"HKG","terminal":"1","at":"2019-03-07T00:05:00+08:00"},"carrierCode":"FM","number":"725","aircraft":{"code":"321"},"operating":{"carrierCode":"MU","number":"725"},"duration":"0DT2H45M"},"pricingDetailPerAdult":{"travelClass":"ECONOMY","fareClass":"T","availability":8,"fareBasis":"TPRWCH"}}]}],"price":{"total":"985","totalTaxes":"165"},"pricePerAdult":{"total":"985","totalTaxes":"165"}}]},{"type":"flight-offer","id":"1551069721093--1401148492","offerItems":[{"services":[{"segments":[{"flightSegment":{"departure":{"iataCode":"PVG","terminal":"2","at":"2019-03-06T16:50:00+08:00"},"arrival":{"iataCode":"HKG","terminal":"1","at":"2019-03-06T19:50:00+08:00"},"carrierCode":"FM","number":"8241","aircraft":{"code":"333"},"operating":{"carrierCode":"HX","number":"8241"},"duration":"0DT3H0M"},"pricingDetailPerAdult":{"travelClass":"ECONOMY","fareClass":"R","availability":9,"fareBasis":"RSRWCH"}}]}],"price":{"total":"1645","totalTaxes":"165"},"pricePerAdult":{"total":"1645","totalTaxes":"165"}}]},{"type":"flight-offer","id":"1551069721093--84038387","offerItems":[{"services":[{"segments":[{"flightSegment":{"departure":{"iataCode":"PVG","terminal":"2","at":"2019-03-06T09:10:00+08:00"},"arrival":{"iataCode":"HKG","terminal":"1","at":"2019-03-06T11:55:00+08:00"},"carrierCode":"FM","number":"8235","aircraft":{"code":"332"},"operating":{"carrierCode":"HX","number":"8235"},"duration":"0DT2H45M"},"pricingDetailPerAdult":{"travelClass":"ECONOMY","fareClass":"R","availability":9,"fareBasis":"RSRWCH"}}]}],"price":{"total":"1645","totalTaxes":"165"},"pricePerAdult":{"total":"1645","totalTaxes":"165"}}]},{"type":"flight-offer","id":"1551069721093--607209539","offerItems":[{"services":[{"segments":[{"flightSegment":{"departure":{"iataCode":"PVG","terminal":"1","at":"2019-03-06T16:15:00+08:00"},"arrival":{"iataCode":"HKG","terminal":"1","at":"2019-03-06T19:20:00+08:00"},"carrierCode":"FM","number":"505","aircraft":{"code":"332"},"operating":{"carrierCode":"MU","number":"505"},"duration":"0DT3H5M"},"pricingDetailPerAdult":{"travelClass":"ECONOMY","fareClass":"T","availability":9,"fareBasis":"TPRWCH"}}]}],"price":{"total":"985","totalTaxes":"165"},"pricePerAdult":{"total":"985","totalTaxes":"165"}}]},{"type":"flight-offer","id":"1551069721093-872517561","offerItems":[{"services":[{"segments":[{"flightSegment":{"departure":{"iataCode":"SHA","terminal":"1","at":"2019-03-06T16:55:00+08:00"},"arrival":{"iataCode":"HKG","terminal":"1","at":"2019-03-06T20:00:00+08:00"},"carrierCode":"HX","number":"259","aircraft":{"code":"333"},"operating":{"carrierCode":"HX","number":"259"},"duration":"0DT3H5M"},"pricingDetailPerAdult":{"travelClass":"ECONOMY","fareClass":"S","availability":9,"fareBasis":"SOWCN11W"}}]}],"price":{"total":"1320","totalTaxes":"200"},"pricePerAdult":{"total":"1320","totalTaxes":"200"}}]},{"type":"flight-offer","id":"1551069721093-238870303","offerItems":[{"services":[{"segments":[{"flightSegment":{"departure":{"iataCode":"SHA","terminal":"1","at":"2019-03-06T13:35:00+08:00"},"arrival":{"iataCode":"HKG","terminal":"1","at":"2019-03-06T16:15:00+08:00"},"carrierCode":"KA","number":"813","aircraft":{"code":"333"},"operating":{"carrierCode":"KA","number":"813"},"duration":"0DT2H40M"},"pricingDetailPerAdult":{"travelClass":"ECONOMY","fareClass":"S","availability":9,"fareBasis":"SLATOXB8"}}]}],"price":{"total":"1927","totalTaxes":"227"},"pricePerAdult":{"total":"1927","totalTaxes":"227"}}]},{"type":"flight-offer","id":"1551069721093-1176548803","offerItems":[{"services":[{"segments":[{"flightSegment":{"departure":{"iataCode":"SHA","terminal":"1","at":"2019-03-06T16:55:00+08:00"},"arrival":{"iataCode":"HKG","terminal":"1","at":"2019-03-06T20:00:00+08:00"},"carrierCode":"MU","number":"8988","aircraft":{"code":"333"},"operating":{"carrierCode":"HX","number":"8988"},"duration":"0DT3H5M"},"pricingDetailPerAdult":{"travelClass":"ECONOMY","fareClass":"R","availability":9,"fareBasis":"RHXWCH"}}]}],"price":{"total":"1645","totalTaxes":"165"},"pricePerAdult":{"total":"1645","totalTaxes":"165"}}]},{"type":"flight-offer","id":"1551069721093-719435250","offerItems":[{"services":[{"segments":[{"flightSegment":{"departure":{"iataCode":"SHA","terminal":"1","at":"2019-03-06T18:10:00+08:00"},"arrival":{"iataCode":"HKG","terminal":"1","at":"2019-03-06T20:55:00+08:00"},"carrierCode":"HX","number":"239","aircraft":{"code":"333"},"operating":{"carrierCode":"HX","number":"239"},"duration":"0DT2H45M"},"pricingDetailPerAdult":{"travelClass":"ECONOMY","fareClass":"S","availability":9,"fareBasis":"SOWCN11W"}}]}],"price":{"total":"1320","totalTaxes":"200"},"pricePerAdult":{"total":"1320","totalTaxes":"200"}}]},{"type":"flight-offer","id":"1551069721093--1084982394","offerItems":[{"services":[{"segments":[{"flightSegment":{"departure":{"iataCode":"SHA","terminal":"1","at":"2019-03-06T16:55:00+08:00"},"arrival":{"iataCode":"HKG","terminal":"1","at":"2019-03-06T20:00:00+08:00"},"carrierCode":"FM","number":"8259","aircraft":{"code":"333"},"operating":{"carrierCode":"HX","number":"8259"},"duration":"0DT3H5M"},"pricingDetailPerAdult":{"travelClass":"ECONOMY","fareClass":"R","availability":9,"fareBasis":"RSRWCH"}}]}],"price":{"total":"1645","totalTaxes":"165"},"pricePerAdult":{"total":"1645","totalTaxes":"165"}}]},{"type":"flight-offer","id":"1551069721093--2115627444","offerItems":[{"services":[{"segments":[{"flightSegment":{"departure":{"iataCode":"PVG","terminal":"2","at":"2019-03-06T09:10:00+08:00"},"arrival":{"iataCode":"HKG","terminal":"1","at":"2019-03-06T11:55:00+08:00"},"carrierCode":"MU","number":"8984","aircraft":{"code":"332"},"operating":{"carrierCode":"HX","number":"8984"},"duration":"0DT2H45M"},"pricingDetailPerAdult":{"travelClass":"ECONOMY","fareClass":"R","availability":9,"fareBasis":"RHXWCH"}}]}],"price":{"total":"1645","totalTaxes":"165"},"pricePerAdult":{"total":"1645","totalTaxes":"165"}}]},{"type":"flight-offer","id":"1551069721093-1895938032","offerItems":[{"services":[{"segments":[{"flightSegment":{"departure":{"iataCode":"PVG","terminal":"1","at":"2019-03-06T13:10:00+08:00"},"arrival":{"iataCode":"HKG","terminal":"1","at":"2019-03-06T16:20:00+08:00"},"carrierCode":"MU","number":"509","aircraft":{"code":"321"},"operating":{"carrierCode":"MU","number":"509"},"duration":"0DT3H10M"},"pricingDetailPerAdult":{"travelClass":"ECONOMY","fareClass":"T","availability":9,"fareBasis":"TPRWCH"}}]}],"price":{"total":"985","totalTaxes":"165"},"pricePerAdult":{"total":"985","totalTaxes":"165"}}]},{"type":"flight-offer","id":"1551069721093-173493399","offerItems":[{"services":[{"segments":[{"flightSegment":{"departure":{"iataCode":"PVG","terminal":"1","at":"2019-03-06T21:20:00+08:00"},"arrival":{"iataCode":"HKG","at":"2019-03-07T00:05:00+08:00"},"carrierCode":"HX","number":"1725","aircraft":{"code":"320"},"operating":{"carrierCode":"MU","number":"1725"},"duration":"0DT2H45M"},"pricingDetailPerAdult":{"travelClass":"ECONOMY","fareClass":"N","availability":9,"fareBasis":"NSOCH3"}}]}],"price":{"total":"1680","totalTaxes":"200"},"pricePerAdult":{"total":"1680","totalTaxes":"200"}}]},{"type":"flight-offer","id":"1551069721093-1071956115","offerItems":[{"services":[{"segments":[{"flightSegment":{"departure":{"iataCode":"PVG","terminal":"1","at":"2019-03-06T21:20:00+08:00"},"arrival":{"iataCode":"HKG","terminal":"1","at":"2019-03-07T00:05:00+08:00"},"carrierCode":"MU","number":"725","aircraft":{"code":"321"},"operating":{"carrierCode":"MU","number":"725"},"duration":"0DT2H45M"},"pricingDetailPerAdult":{"travelClass":"ECONOMY","fareClass":"T","availability":8,"fareBasis":"TPRWCH"}}]}],"price":{"total":"985","totalTaxes":"165"},"pricePerAdult":{"total":"985","totalTaxes":"165"}}]},{"type":"flight-offer","id":"1551069721093-1908953940","offerItems":[{"services":[{"segments":[{"flightSegment":{"departure":{"iataCode":"PVG","terminal":"1","at":"2019-03-06T13:10:00+08:00"},"arrival":{"iataCode":"HKG","at":"2019-03-06T16:20:00+08:00"},"carrierCode":"HX","number":"1509","aircraft":{"code":"320"},"operating":{"carrierCode":"MU","number":"1509"},"duration":"0DT3H10M"},"pricingDetailPerAdult":{"travelClass":"ECONOMY","fareClass":"N","availability":9,"fareBasis":"NSOCH3"}}]}],"price":{"total":"1680","totalTaxes":"200"},"pricePerAdult":{"total":"1680","totalTaxes":"200"}}]},{"type":"flight-offer","id":"1551069721093-1738202573","offerItems":[{"services":[{"segments":[{"flightSegment":{"departure":{"iataCode":"PVG","terminal":"1","at":"2019-03-06T18:30:00+08:00"},"arrival":{"iataCode":"HKG","at":"2019-03-06T21:30:00+08:00"},"carrierCode":"HX","number":"1723","aircraft":{"code":"320"},"operating":{"carrierCode":"MU","number":"1723"},"duration":"0DT3H0M"},"pricingDetailPerAdult":{"travelClass":"ECONOMY","fareClass":"N","availability":9,"fareBasis":"NSOCH3"}}]}],"price":{"total":"1680","totalTaxes":"200"},"pricePerAdult":{"total":"1680","totalTaxes":"200"}}]},{"type":"flight-offer","id":"1551069721093-511772189","offerItems":[{"services":[{"segments":[{"flightSegment":{"departure":{"iataCode":"PVG","terminal":"1","at":"2019-03-06T16:15:00+08:00"},"arrival":{"iataCode":"HKG","terminal":"1","at":"2019-03-06T19:20:00+08:00"},"carrierCode":"MU","number":"505","aircraft":{"code":"332"},"operating":{"carrierCode":"MU","number":"505"},"duration":"0DT3H5M"},"pricingDetailPerAdult":{"travelClass":"ECONOMY","fareClass":"T","availability":9,"fareBasis":"TPRWCH"}}]}],"price":{"total":"985","totalTaxes":"165"},"pricePerAdult":{"total":"985","totalTaxes":"165"}}]},{"type":"flight-offer","id":"1551069721093--1150270468","offerItems":[{"services":[{"segments":[{"flightSegment":{"departure":{"iataCode":"PVG","terminal":"2","at":"2019-03-06T12:45:00+08:00"},"arrival":{"iataCode":"HKG","terminal":"1","at":"2019-03-06T15:45:00+08:00"},"carrierCode":"HX","number":"237","aircraft":{"code":"333"},"operating":{"carrierCode":"HX","number":"237"},"duration":"0DT3H0M"},"pricingDetailPerAdult":{"travelClass":"ECONOMY","fareClass":"S","availability":9,"fareBasis":"SOWCN11W"}}]}],"price":{"total":"1320","totalTaxes":"200"},"pricePerAdult":{"total":"1320","totalTaxes":"200"}}]},{"type":"flight-offer","id":"1551069721093--844570930","offerItems":[{"services":[{"segments":[{"flightSegment":{"departure":{"iataCode":"PVG","terminal":"2","at":"2019-03-06T12:45:00+08:00"},"arrival":{"iataCode":"HKG","terminal":"1","at":"2019-03-06T15:45:00+08:00"},"carrierCode":"MU","number":"8980","aircraft":{"code":"333"},"operating":{"carrierCode":"HX","number":"8980"},"duration":"0DT3H0M"},"pricingDetailPerAdult":{"travelClass":"ECONOMY","fareClass":"R","availability":9,"fareBasis":"RHXWCH"}}]}],"price":{"total":"1645","totalTaxes":"165"},"pricePerAdult":{"total":"1645","totalTaxes":"165"}}]},{"type":"flight-offer","id":"1551069721093-862259538","offerItems":[{"services":[{"segments":[{"flightSegment":{"departure":{"iataCode":"PVG","terminal":"2","at":"2019-03-06T16:50:00+08:00"},"arrival":{"iataCode":"HKG","terminal":"1","at":"2019-03-06T19:50:00+08:00"},"carrierCode":"MU","number":"8991","aircraft":{"code":"333"},"operating":{"carrierCode":"HX","number":"8991"},"duration":"0DT3H0M"},"pricingDetailPerAdult":{"travelClass":"ECONOMY","fareClass":"R","availability":9,"fareBasis":"RHXWCH"}}]}],"price":{"total":"1645","totalTaxes":"165"},"pricePerAdult":{"total":"1645","totalTaxes":"165"}}]},{"type":"flight-offer","id":"1551069721093-972562967","offerItems":[{"services":[{"segments":[{"flightSegment":{"departure":{"iataCode":"PVG","terminal":"1","at":"2019-03-06T12:00:00+08:00"},"arrival":{"iataCode":"HKG","at":"2019-03-06T14:55:00+08:00"},"carrierCode":"HX","number":"1503","aircraft":{"code":"320"},"operating":{"carrierCode":"MU","number":"1503"},"duration":"0DT2H55M"},"pricingDetailPerAdult":{"travelClass":"ECONOMY","fareClass":"N","availability":9,"fareBasis":"NSOCH3"}}]}],"price":{"total":"1680","totalTaxes":"200"},"pricePerAdult":{"total":"1680","totalTaxes":"200"}}]},{"type":"flight-offer","id":"1551069721093-1435511942","offerItems":[{"services":[{"segments":[{"flightSegment":{"departure":{"iataCode":"SHA","terminal":"1","at":"2019-03-06T08:05:00+08:00"},"arrival":{"iataCode":"HKG","at":"2019-03-06T10:50:00+08:00"},"carrierCode":"HX","number":"1721","aircraft":{"code":"333"},"operating":{"carrierCode":"MU","number":"1721"},"duration":"0DT2H45M"},"pricingDetailPerAdult":{"travelClass":"ECONOMY","fareClass":"N","availability":9,"fareBasis":"NSOCH3"}}]}],"price":{"total":"1680","totalTaxes":"200"},"pricePerAdult":{"total":"1680","totalTaxes":"200"}}]},{"type":"flight-offer","id":"1551069721093-524788097","offerItems":[{"services":[{"segments":[{"flightSegment":{"departure":{"iataCode":"PVG","terminal":"1","at":"2019-03-06T16:15:00+08:00"},"arrival":{"iataCode":"HKG","at":"2019-03-06T19:20:00+08:00"},"carrierCode":"HX","number":"1505","aircraft":{"code":"321"},"operating":{"carrierCode":"MU","number":"1505"},"duration":"0DT3H5M"},"pricingDetailPerAdult":{"travelClass":"ECONOMY","fareClass":"N","availability":9,"fareBasis":"NSOCH3"}}]}],"price":{"total":"1680","totalTaxes":"200"},"pricePerAdult":{"total":"1680","totalTaxes":"200"}}]},{"type":"flight-offer","id":"1551069721093--1535830790","offerItems":[{"services":[{"segments":[{"flightSegment":{"departure":{"iataCode":"SHA","terminal":"1","at":"2019-03-06T15:00:00+08:00"},"arrival":{"iataCode":"HKG","terminal":"1","at":"2019-03-06T17:50:00+08:00"},"carrierCode":"MU","number":"9845","aircraft":{"code":"738"},"operating":{"carrierCode":"FM","number":"9845"},"duration":"0DT2H50M"},"pricingDetailPerAdult":{"travelClass":"ECONOMY","fareClass":"V","availability":8,"fareBasis":"VPRWCH"}}]}],"price":{"total":"1335","totalTaxes":"165"},"pricePerAdult":{"total":"1335","totalTaxes":"165"}}]},{"type":"flight-offer","id":"1551069721093-723140398","offerItems":[{"services":[{"segments":[{"flightSegment":{"departure":{"iataCode":"PVG","terminal":"1","at":"2019-03-06T11:05:00+08:00"},"arrival":{"iataCode":"HKG","terminal":"1","at":"2019-03-06T14:25:00+08:00"},"carrierCode":"FM","number":"507","aircraft":{"code":"320"},"operating":{"carrierCode":"MU","number":"507"},"duration":"0DT3H20M"},"pricingDetailPerAdult":{"travelClass":"ECONOMY","fareClass":"T","availability":9,"fareBasis":"TPRWCH"}}]}],"price":{"total":"985","totalTaxes":"165"},"pricePerAdult":{"total":"985","totalTaxes":"165"}}]},{"type":"flight-offer","id":"1551069721093-1725186665","offerItems":[{"services":[{"segments":[{"flightSegment":{"departure":{"iataCode":"PVG","terminal":"1","at":"2019-03-06T18:30:00+08:00"},"arrival":{"iataCode":"HKG","terminal":"1","at":"2019-03-06T21:30:00+08:00"},"carrierCode":"MU","number":"723","aircraft":{"code":"321"},"operating":{"carrierCode":"MU","number":"723"},"duration":"0DT3H0M"},"pricingDetailPerAdult":{"travelClass":"ECONOMY","fareClass":"T","availability":9,"fareBasis":"TPRWCH"}}]}],"price":{"total":"985","totalTaxes":"165"},"pricePerAdult":{"total":"985","totalTaxes":"165"}}]},{"type":"flight-offer","id":"1551069721093--303288609","offerItems":[{"services":[{"segments":[{"flightSegment":{"departure":{"iataCode":"PVG","terminal":"1","at":"2019-03-06T09:35:00+08:00"},"arrival":{"iataCode":"HKG","terminal":"1","at":"2019-03-06T12:40:00+08:00"},"carrierCode":"MU","number":"701","aircraft":{"code":"773"},"operating":{"carrierCode":"MU","number":"701"},"duration":"0DT3H5M"},"pricingDetailPerAdult":{"travelClass":"ECONOMY","fareClass":"T","availability":9,"fareBasis":"TPRWCH"}}]}],"price":{"total":"985","totalTaxes":"165"},"pricePerAdult":{"total":"985","totalTaxes":"165"}}]},{"type":"flight-offer","id":"1551069721093-120042465","offerItems":[{"services":[{"segments":[{"flightSegment":{"departure":{"iataCode":"SHA","terminal":"1","at":"2019-03-06T15:00:00+08:00"},"arrival":{"iataCode":"HKG","terminal":"1","at":"2019-03-06T17:50:00+08:00"},"carrierCode":"FM","number":"845","aircraft":{"code":"738"},"operating":{"carrierCode":"FM","number":"845"},"duration":"0DT2H50M"},"pricingDetailPerAdult":{"travelClass":"ECONOMY","fareClass":"V","availability":6,"fareBasis":"VPRWCH"}}]}],"price":{"total":"1335","totalTaxes":"165"},"pricePerAdult":{"total":"1335","totalTaxes":"165"}}]},{"type":"flight-offer","id":"1551069721093--801367333","offerItems":[{"services":[{"segments":[{"flightSegment":{"departure":{"iataCode":"PVG","terminal":"2","at":"2019-03-06T18:30:00+08:00"},"arrival":{"iataCode":"HKG","terminal":"1","at":"2019-03-06T21:25:00+08:00"},"carrierCode":"HO","number":"1305","aircraft":{"code":"321"},"operating":{"carrierCode":"HO","number":"1305"},"duration":"0DT2H55M"},"pricingDetailPerAdult":{"travelClass":"ECONOMY","fareClass":"G","availability":9,"fareBasis":"GOWA"}}]}],"price":{"total":"640","totalTaxes":"170"},"pricePerAdult":{"total":"640","totalTaxes":"170"}}]},{"type":"flight-offer","id":"1551069721093-776956304","offerItems":[{"services":[{"segments":[{"flightSegment":{"departure":{"iataCode":"PVG","terminal":"1","at":"2019-03-06T13:10:00+08:00"},"arrival":{"iataCode":"HKG","terminal":"1","at":"2019-03-06T16:20:00+08:00"},"carrierCode":"FM","number":"509","aircraft":{"code":"321"},"operating":{"carrierCode":"MU","number":"509"},"duration":"0DT3H10M"},"pricingDetailPerAdult":{"travelClass":"ECONOMY","fareClass":"T","availability":9,"fareBasis":"TPRWCH"}}]}],"price":{"total":"985","totalTaxes":"165"},"pricePerAdult":{"total":"985","totalTaxes":"165"}}]},{"type":"flight-offer","id":"1551069721093-556351463","offerItems":[{"services":[{"segments":[{"flightSegment":{"departure":{"iataCode":"PVG","terminal":"2","at":"2019-03-06T16:50:00+08:00"},"arrival":{"iataCode":"HKG","terminal":"1","at":"2019-03-06T19:50:00+08:00"},"carrierCode":"HX","number":"241","aircraft":{"code":"333"},"operating":{"carrierCode":"HX","number":"241"},"duration":"0DT3H0M"},"pricingDetailPerAdult":{"travelClass":"ECONOMY","fareClass":"S","availability":9,"fareBasis":"SOWCN11W"}}]}],"price":{"total":"1320","totalTaxes":"200"},"pricePerAdult":{"total":"1320","totalTaxes":"200"}}]},{"type":"flight-offer","id":"1551069721093--1047556263","offerItems":[{"services":[{"segments":[{"flightSegment":{"departure":{"iataCode":"PVG","terminal":"1","at":"2019-03-06T08:35:00+08:00"},"arrival":{"iataCode":"HKG","at":"2019-03-06T11:30:00+08:00"},"carrierCode":"HX","number":"1501","aircraft":{"code":"321"},"operating":{"carrierCode":"MU","number":"1501"},"duration":"0DT2H55M"},"pricingDetailPerAdult":{"travelClass":"ECONOMY","fareClass":"N","availability":9,"fareBasis":"NSOCH3"}}]}],"price":{"total":"1680","totalTaxes":"200"},"pricePerAdult":{"total":"1680","totalTaxes":"200"}}]},{"type":"flight-offer","id":"1551069721093--1238064705","offerItems":[{"services":[{"segments":[{"flightSegment":{"departure":{"iataCode":"SHA","terminal":"1","at":"2019-03-06T18:10:00+08:00"},"arrival":{"iataCode":"HKG","terminal":"1","at":"2019-03-06T20:55:00+08:00"},"carrierCode":"FM","number":"8239","aircraft":{"code":"333"},"operating":{"carrierCode":"HX","number":"8239"},"duration":"0DT2H45M"},"pricingDetailPerAdult":{"travelClass":"ECONOMY","fareClass":"R","availability":9,"fareBasis":"RSRWCH"}}]}],"price":{"total":"1645","totalTaxes":"165"},"pricePerAdult":{"total":"1645","totalTaxes":"165"}}]},{"type":"flight-offer","id":"1551069721093--290272701","offerItems":[{"services":[{"segments":[{"flightSegment":{"departure":{"iataCode":"PVG","terminal":"1","at":"2019-03-06T09:35:00+08:00"},"arrival":{"iataCode":"HKG","at":"2019-03-06T12:40:00+08:00"},"carrierCode":"HX","number":"1701","aircraft":{"code":"773"},"operating":{"carrierCode":"MU","number":"1701"},"duration":"0DT3H5M"},"pricingDetailPerAdult":{"travelClass":"ECONOMY","fareClass":"N","availability":9,"fareBasis":"NSOCH3"}}]}],"price":{"total":"1680","totalTaxes":"200"},"pricePerAdult":{"total":"1680","totalTaxes":"200"}}]},{"type":"flight-offer","id":"1551069721093--601529467","offerItems":[{"services":[{"segments":[{"flightSegment":{"departure":{"iataCode":"SHA","terminal":"1","at":"2019-03-06T15:00:00+08:00"},"arrival":{"iataCode":"HKG","at":"2019-03-06T17:50:00+08:00"},"carrierCode":"HX","number":"1845","aircraft":{"code":"333"},"operating":{"carrierCode":"FM","number":"1845"},"duration":"0DT2H50M"},"pricingDetailPerAdult":{"travelClass":"ECONOMY","fareClass":"N","availability":9,"fareBasis":"NSOCH3"}}]}],"price":{"total":"1680","totalTaxes":"200"},"pricePerAdult":{"total":"1680","totalTaxes":"200"}}]},{"type":"flight-offer","id":"1551069721093--81493710","offerItems":[{"services":[{"segments":[{"flightSegment":{"departure":{"iataCode":"PVG","terminal":"2","at":"2019-03-06T07:25:00+08:00"},"arrival":{"iataCode":"HKG","terminal":"1","at":"2019-03-06T10:40:00+08:00"},"carrierCode":"FM","number":"8231","aircraft":{"code":"359"},"operating":{"carrierCode":"HX","number":"8231"},"duration":"0DT3H15M"},"pricingDetailPerAdult":{"travelClass":"ECONOMY","fareClass":"R","availability":9,"fareBasis":"RSRWCH"}}]}],"price":{"total":"1645","totalTaxes":"165"},"pricePerAdult":{"total":"1645","totalTaxes":"165"}}]},{"type":"flight-offer","id":"1551069721093-2115413397","offerItems":[{"services":[{"segments":[{"flightSegment":{"departure":{"iataCode":"PVG","terminal":"1","at":"2019-03-06T08:35:00+08:00"},"arrival":{"iataCode":"HKG","terminal":"1","at":"2019-03-06T11:30:00+08:00"},"carrierCode":"FM","number":"501","aircraft":{"code":"321"},"operating":{"carrierCode":"MU","number":"501"},"duration":"0DT2H55M"},"pricingDetailPerAdult":{"travelClass":"ECONOMY","fareClass":"T","availability":9,"fareBasis":"TPRWCH"}}]}],"price":{"total":"985","totalTaxes":"165"},"pricePerAdult":{"total":"985","totalTaxes":"165"}}]},{"type":"flight-offer","id":"1551069721093-1873461568","offerItems":[{"services":[{"segments":[{"flightSegment":{"departure":{"iataCode":"PVG","terminal":"2","at":"2019-03-06T09:10:00+08:00"},"arrival":{"iataCode":"HKG","terminal":"1","at":"2019-03-06T11:55:00+08:00"},"carrierCode":"HX","number":"235","aircraft":{"code":"332"},"operating":{"carrierCode":"HX","number":"235"},"duration":"0DT2H45M"},"pricingDetailPerAdult":{"travelClass":"ECONOMY","fareClass":"S","availability":9,"fareBasis":"SOWCN11W"}}]}],"price":{"total":"1320","totalTaxes":"200"},"pricePerAdult":{"total":"1320","totalTaxes":"200"}}]},{"type":"flight-offer","id":"1551069721093-959547059","offerItems":[{"services":[{"segments":[{"flightSegment":{"departure":{"iataCode":"PVG","terminal":"1","at":"2019-03-06T12:00:00+08:00"},"arrival":{"iataCode":"HKG","terminal":"1","at":"2019-03-06T14:55:00+08:00"},"carrierCode":"MU","number":"503","aircraft":{"code":"321"},"operating":{"carrierCode":"MU","number":"503"},"duration":"0DT2H55M"},"pricingDetailPerAdult":{"travelClass":"ECONOMY","fareClass":"T","availability":9,"fareBasis":"TPRWCH"}}]}],"price":{"total":"985","totalTaxes":"165"},"pricePerAdult":{"total":"985","totalTaxes":"165"}}]},{"type":"flight-offer","id":"1551069721093--577351998","offerItems":[{"services":[{"segments":[{"flightSegment":{"departure":{"iataCode":"SHA","terminal":"1","at":"2019-03-06T08:05:00+08:00"},"arrival":{"iataCode":"HKG","terminal":"1","at":"2019-03-06T10:50:00+08:00"},"carrierCode":"FM","number":"721","aircraft":{"code":"333"},"operating":{"carrierCode":"MU","number":"721"},"duration":"0DT2H45M"},"pricingDetailPerAdult":{"travelClass":"ECONOMY","fareClass":"V","availability":9,"fareBasis":"VPRWCH"}}]}],"price":{"total":"1335","totalTaxes":"165"},"pricePerAdult":{"total":"1335","totalTaxes":"165"}}]},{"type":"flight-offer","id":"1551069721093-541629730","offerItems":[{"services":[{"segments":[{"flightSegment":{"departure":{"iataCode":"SHA","terminal":"1","at":"2019-03-06T08:05:00+08:00"},"arrival":{"iataCode":"HKG","terminal":"1","at":"2019-03-06T10:50:00+08:00"},"carrierCode":"MU","number":"721","aircraft":{"code":"333"},"operating":{"carrierCode":"MU","number":"721"},"duration":"0DT2H45M"},"pricingDetailPerAdult":{"travelClass":"ECONOMY","fareClass":"V","availability":9,"fareBasis":"VPRWCH"}}]}],"price":{"total":"1335","totalTaxes":"165"},"pricePerAdult":{"total":"1335","totalTaxes":"165"}}]},{"type":"flight-offer","id":"1551069721093--1060572171","offerItems":[{"services":[{"segments":[{"flightSegment":{"departure":{"iataCode":"PVG","terminal":"1","at":"2019-03-06T08:35:00+08:00"},"arrival":{"iataCode":"HKG","terminal":"1","at":"2019-03-06T11:30:00+08:00"},"carrierCode":"MU","number":"501","aircraft":{"code":"321"},"operating":{"carrierCode":"MU","number":"501"},"duration":"0DT2H55M"},"pricingDetailPerAdult":{"travelClass":"ECONOMY","fareClass":"T","availability":9,"fareBasis":"TPRWCH"}}]}],"price":{"total":"985","totalTaxes":"165"},"pricePerAdult":{"total":"985","totalTaxes":"165"}}]},{"type":"flight-offer","id":"1551069721093--1422270337","offerItems":[{"services":[{"segments":[{"flightSegment":{"departure":{"iataCode":"PVG","terminal":"1","at":"2019-03-06T09:35:00+08:00"},"arrival":{"iataCode":"HKG","terminal":"1","at":"2019-03-06T12:40:00+08:00"},"carrierCode":"FM","number":"701","aircraft":{"code":"773"},"operating":{"carrierCode":"MU","number":"701"},"duration":"0DT3H5M"},"pricingDetailPerAdult":{"travelClass":"ECONOMY","fareClass":"T","availability":9,"fareBasis":"TPRWCH"}}]}],"price":{"total":"985","totalTaxes":"165"},"pricePerAdult":{"total":"985","totalTaxes":"165"}}]},{"type":"flight-offer","id":"1551069721093--159434669","offerItems":[{"services":[{"segments":[{"flightSegment":{"departure":{"iataCode":"PVG","terminal":"1","at":"2019-03-06T12:00:00+08:00"},"arrival":{"iataCode":"HKG","terminal":"1","at":"2019-03-06T14:55:00+08:00"},"carrierCode":"FM","number":"503","aircraft":{"code":"321"},"operating":{"carrierCode":"MU","number":"503"},"duration":"0DT2H55M"},"pricingDetailPerAdult":{"travelClass":"ECONOMY","fareClass":"T","availability":9,"fareBasis":"TPRWCH"}}]}],"price":{"total":"985","totalTaxes":"165"},"pricePerAdult":{"total":"985","totalTaxes":"165"}}]}],"dictionaries":{"carriers":{"HX":"HONG KONG AIRLINES","CX":"CATHAY PACIFIC","KA":"CATHAY DRAGON","FM":"SHANGHAI AIRLINES","HO":"JUNEYAO AIRLINES","MU":"CHINA EASTERN AIRLINES"},"currencies":{"HKD":"HONGKONG DOLLAR"},"aircraft":{"320":"AIRBUS INDUSTRIE A320-100/200","321":"AIRBUS INDUSTRIE A321","332":"AIRBUS INDUSTRIE A330-200","333":"AIRBUS INDUSTRIE A330-300","773":"BOEING 777-300","359":"AIRBUS INDUSTRIE A350-900","738":"BOEING 737-800"},"locations":{"PVG":{"subType":"AIRPORT","detailedName":"PUDONG INTL"},"HKG":{"subType":"AIRPORT","detailedName":"INTERNATIONAL"},"SHA":{"subType":"AIRPORT","detailedName":"HONGQIAO INTL"}}},"meta":{"links":{"self":"https://api.amadeus.com/v1/shopping/flight-offers?origin=SHA&destination=HKG&departureDate=2019-03-06&adults=1&nonStop=true¤cy=HKD"},"currency":"HKD","defaults":{"adults":1}}}';
        $departure = self::ReformingJsonData($departure);
        $arrival = self::ReformingJsonData($arrival);

        //print_r($arrival);die();
        $payment_method = PaymentMethod::where('id','!=','5')->get();
        $token = $this->EncryptToken();

        return view('flight.result')
            ->with('code', $code)
            ->with('from', $from)
            ->with('to', $to)
            ->with('start', $start)
            ->with('end',$end)
            ->with('departure',$departure)
            ->with('arrival',$arrival)
            ->with('airports',$airports)
            ->with('departure_airport',$departure_airport)
            ->with('payment_method', $payment_method)
            ->with('token', $token);
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
            $flight[$k]['departure_terminal'] = isset($segments['flightSegment']['departure']['terminal']) ? $segments['flightSegment']['departure']['terminal'] : null;
            $flight[$k]['departure_timezone'] = substr($segments['flightSegment']['departure']['at'],-6);
            $flight[$k]['departure_date'] = substr($segments['flightSegment']['departure']['at'], 0, 10);
            $flight[$k]['departure_time'] = str_replace($flight[$k]['departure_timezone'],"",substr(str_replace($flight[$k]['departure_date']," ",$segments['flightSegment']['departure']['at']),2));


            $flight[$k]['arrival_airport'] = $segments['flightSegment']['arrival']['iataCode'];
            $flight[$k]['arrival_terminal'] = isset($segments['flightSegment']['arrival']['terminal']) ? $segments['flightSegment']['arrival']['terminal'] : null;
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

    public function booking(Request $request)
    {

        sleep(4);

        $encrypted_code = $request->encrypted_code;
        $encrypted_code = explode(",",$encrypted_code);

        $token = base64_decode($encrypted_code[0]);
        $en_total = base64_decode($encrypted_code[1]);
        $en_dep = base64_decode($encrypted_code[2]);
        $en_arr = base64_decode($encrypted_code[3]);

        print_r($en_total);
        die('book process');
        
    }

    protected function EncryptToken(){
        return base64_encode($this::token);
    }

}
