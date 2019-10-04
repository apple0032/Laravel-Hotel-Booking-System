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
use App\FlightBooking;
use App\FlightPayment;
use App\FlightPassenger;
use App\Trip;
use App\Airports;

class FlightController extends Controller
{
    const token = "r3jjBWdKXrMzqMkc";

    public function __construct() {
        $this->middleware(['auth'],['except' => ['searchcountry','searchairport','search','getairportlist']]);
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
        $trip = $request->trip;
        $city = $request->city;
      
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
            'city' => $city,
            'from' => $de_airport,
            'to' => $airport,
            'start' => $start,
            'end' => $end,
            'trip' => $trip,
        ]);
    }
    
    public function getSearchFlightPage()
    {
        sleep(1);

        $code = Input::get('code');
        $from = Input::get('from');
        $to = Input::get('to');
        $start = Input::get('start');
        $end = Input::get('end');
        $city = Input::get('city');
        $country = Input::get('country');
        //Call Flight scheduled Api to retrieve data from api source

        //Retrieve flight data from SygicTravelApi
        $departure = self::FlightData($from,$to,$start);
        $arrival = self::FlightData($to,$from,$end);

        //Temporarily hardcoded json string to enhance speed of development
        //$departure = '{"data":[{"type":"flight-offer","id":"1551613833282--1754331648","offerItems":[{"services":[{"segments":[{"flightSegment":{"departure":{"iataCode":"HKG","terminal":"1","at":"2019-06-04T00:50:00+08:00"},"arrival":{"iataCode":"HND","terminal":"I","at":"2019-06-04T05:55:00+09:00"},"carrierCode":"NH","number":"822","aircraft":{"code":"763"},"operating":{"carrierCode":"NQ","number":"822"},"duration":"0DT4H5M"},"pricingDetailPerAdult":{"travelClass":"ECONOMY","fareClass":"U","availability":9,"fareBasis":"URFJ0O"}}]}],"price":{"total":"5153","totalTaxes":"503"},"pricePerAdult":{"total":"5153","totalTaxes":"503"}}]},{"type":"flight-offer","id":"1551613833282-1943551295","offerItems":[{"services":[{"segments":[{"flightSegment":{"departure":{"iataCode":"HKG","terminal":"1","at":"2019-06-04T15:15:00+08:00"},"arrival":{"iataCode":"HND","terminal":"I","at":"2019-06-04T20:25:00+09:00"},"carrierCode":"CX","number":"6320","aircraft":{"code":"772"},"operating":{"carrierCode":"JL","number":"6320"},"duration":"0DT4H10M"},"pricingDetailPerAdult":{"travelClass":"ECONOMY","fareClass":"B","availability":4,"fareBasis":"BAAROWF8"}}]}],"price":{"total":"7211","totalTaxes":"361"},"pricePerAdult":{"total":"7211","totalTaxes":"361"}}]},{"type":"flight-offer","id":"1551613833282--3784642","offerItems":[{"services":[{"segments":[{"flightSegment":{"departure":{"iataCode":"HKG","terminal":"2","at":"2019-06-04T18:05:00+08:00"},"arrival":{"iataCode":"HND","terminal":"I","at":"2019-06-04T23:25:00+09:00"},"carrierCode":"UO","number":"622","aircraft":{"code":"321"},"operating":{"carrierCode":"UO","number":"622"},"duration":"0DT4H20M"},"pricingDetailPerAdult":{"travelClass":"ECONOMY","fareClass":"V","availability":4,"fareBasis":"VGDD"}}]}],"price":{"total":"1355","totalTaxes":"305"},"pricePerAdult":{"total":"1355","totalTaxes":"305"}}]},{"type":"flight-offer","id":"1551613833282-1816767499","offerItems":[{"services":[{"segments":[{"flightSegment":{"departure":{"iataCode":"HKG","terminal":"1","at":"2019-06-04T16:20:00+08:00"},"arrival":{"iataCode":"HND","terminal":"I","at":"2019-06-04T21:35:00+09:00"},"carrierCode":"JL","number":"7032","aircraft":{"code":"773"},"operating":{"carrierCode":"CX","number":"7032"},"duration":"0DT4H15M"},"pricingDetailPerAdult":{"travelClass":"ECONOMY","fareClass":"H","availability":4,"fareBasis":"HLN0OGED"}}]}],"price":{"total":"5034","totalTaxes":"504"},"pricePerAdult":{"total":"5034","totalTaxes":"504"}}]},{"type":"flight-offer","id":"1551613833282-1717183141","offerItems":[{"services":[{"segments":[{"flightSegment":{"departure":{"iataCode":"HKG","terminal":"2","at":"2019-06-04T23:40:00+08:00"},"arrival":{"iataCode":"HND","terminal":"I","at":"2019-06-05T04:55:00+09:00"},"carrierCode":"UO","number":"624","aircraft":{"code":"321"},"operating":{"carrierCode":"UO","number":"624"},"duration":"0DT4H15M"},"pricingDetailPerAdult":{"travelClass":"ECONOMY","fareClass":"V","availability":4,"fareBasis":"VGDD"}}]}],"price":{"total":"1355","totalTaxes":"305"},"pricePerAdult":{"total":"1355","totalTaxes":"305"}}]},{"type":"flight-offer","id":"1551613833282-1281890586","offerItems":[{"services":[{"segments":[{"flightSegment":{"departure":{"iataCode":"HKG","terminal":"1","at":"2019-06-04T15:15:00+08:00"},"arrival":{"iataCode":"HND","terminal":"I","at":"2019-06-04T20:25:00+09:00"},"carrierCode":"JL","number":"26","aircraft":{"code":"777"},"operating":{"carrierCode":"JL","number":"26"},"duration":"0DT4H10M"},"pricingDetailPerAdult":{"travelClass":"ECONOMY","fareClass":"H","availability":9,"fareBasis":"HLN0OGDD"}}]}],"price":{"total":"5034","totalTaxes":"504"},"pricePerAdult":{"total":"5034","totalTaxes":"504"}}]},{"type":"flight-offer","id":"1551613833282--1796577260","offerItems":[{"services":[{"segments":[{"flightSegment":{"departure":{"iataCode":"HKG","terminal":"1","at":"2019-06-04T16:20:00+08:00"},"arrival":{"iataCode":"HND","terminal":"I","at":"2019-06-04T21:35:00+09:00"},"carrierCode":"CX","number":"542","aircraft":{"code":"773"},"operating":{"carrierCode":"CX","number":"542"},"duration":"0DT4H15M"},"pricingDetailPerAdult":{"travelClass":"ECONOMY","fareClass":"B","availability":9,"fareBasis":"BAAROWF8"}}]}],"price":{"total":"7211","totalTaxes":"361"},"pricePerAdult":{"total":"7211","totalTaxes":"361"}}]},{"type":"flight-offer","id":"1551613833282-50440429","offerItems":[{"services":[{"segments":[{"flightSegment":{"departure":{"iataCode":"HKG","terminal":"1","at":"2019-06-04T14:45:00+08:00"},"arrival":{"iataCode":"HND","terminal":"I","at":"2019-06-04T20:00:00+09:00"},"carrierCode":"NH","number":"860","aircraft":{"code":"77W"},"operating":{"carrierCode":"NH","number":"860"},"duration":"0DT4H15M"},"pricingDetailPerAdult":{"travelClass":"ECONOMY","fareClass":"U","availability":9,"fareBasis":"URFJ0O"}}]}],"price":{"total":"5153","totalTaxes":"503"},"pricePerAdult":{"total":"5153","totalTaxes":"503"}}]},{"type":"flight-offer","id":"1551613833282--272181557","offerItems":[{"services":[{"segments":[{"flightSegment":{"departure":{"iataCode":"HKG","terminal":"1","at":"2019-06-04T08:45:00+08:00"},"arrival":{"iataCode":"HND","terminal":"I","at":"2019-06-04T13:55:00+09:00"},"carrierCode":"JL","number":"7030","aircraft":{"code":"77W"},"operating":{"carrierCode":"CX","number":"7030"},"duration":"0DT4H10M"},"pricingDetailPerAdult":{"travelClass":"ECONOMY","fareClass":"H","availability":4,"fareBasis":"HLN0OGED"}}]}],"price":{"total":"5284","totalTaxes":"504"},"pricePerAdult":{"total":"5284","totalTaxes":"504"}}]},{"type":"flight-offer","id":"1551613833282-1864871668","offerItems":[{"services":[{"segments":[{"flightSegment":{"departure":{"iataCode":"HKG","terminal":"1","at":"2019-06-04T23:45:00+08:00"},"arrival":{"iataCode":"HND","terminal":"I","at":"2019-06-05T05:10:00+09:00"},"carrierCode":"CX","number":"5396","aircraft":{"code":"321"},"operating":{"carrierCode":"KA","number":"5396"},"duration":"0DT4H25M"},"pricingDetailPerAdult":{"travelClass":"ECONOMY","fareClass":"B","availability":9,"fareBasis":"BAAROWF8"}}]}],"price":{"total":"7211","totalTaxes":"361"},"pricePerAdult":{"total":"7211","totalTaxes":"361"}}]},{"type":"flight-offer","id":"1551613833282--601975588","offerItems":[{"services":[{"segments":[{"flightSegment":{"departure":{"iataCode":"HKG","terminal":"1","at":"2019-06-04T08:45:00+08:00"},"arrival":{"iataCode":"HND","terminal":"I","at":"2019-06-04T13:55:00+09:00"},"carrierCode":"CX","number":"548","aircraft":{"code":"77W"},"operating":{"carrierCode":"CX","number":"548"},"duration":"0DT4H10M"},"pricingDetailPerAdult":{"travelClass":"ECONOMY","fareClass":"B","availability":9,"fareBasis":"BAAROWF8"}}]}],"price":{"total":"7211","totalTaxes":"361"},"pricePerAdult":{"total":"7211","totalTaxes":"361"}}]},{"type":"flight-offer","id":"1551613833282-1830949611","offerItems":[{"services":[{"segments":[{"flightSegment":{"departure":{"iataCode":"HKG","terminal":"1","at":"2019-06-04T23:45:00+08:00"},"arrival":{"iataCode":"HND","terminal":"I","at":"2019-06-05T05:10:00+09:00"},"carrierCode":"KA","number":"396","aircraft":{"code":"321"},"operating":{"carrierCode":"KA","number":"396"},"duration":"0DT4H25M"},"pricingDetailPerAdult":{"travelClass":"ECONOMY","fareClass":"B","availability":9,"fareBasis":"BAAQOWF8"}}]}],"price":{"total":"7211","totalTaxes":"361"},"pricePerAdult":{"total":"7211","totalTaxes":"361"}}]}],"dictionaries":{"carriers":{"JL":"JAPAN AIRLINES","NQ":"AIR JAPAN COMPANY LTD","CX":"CATHAY PACIFIC","KA":"CATHAY DRAGON","NH":"ALL NIPPON AIRWAYS","UO":"HONG KONG EXPRESS AIRWAYS"},"currencies":{"HKD":"HONGKONG DOLLAR"},"aircraft":{"321":"AIRBUS INDUSTRIE A321","772":"BOEING 777-200/200ER","773":"BOEING 777-300","763":"BOEING 767-300/300ER","777":"BOEING 777-200/300","77W":"BOEING 777-300ER"},"locations":{"HKG":{"subType":"AIRPORT","detailedName":"INTERNATIONAL"},"HND":{"subType":"AIRPORT","detailedName":"TOKYO INTL HANEDA"}}},"meta":{"links":{"self":"https://api.amadeus.com/v1/shopping/flight-offers?origin=HKG&destination=HND&departureDate=2019-06-04&adults=1&nonStop=true¤cy=HKD&max=50"},"currency":"HKD"}}';
        //$arrival = '{"data":[{"type":"flight-offer","id":"1551613900689--2121462007","offerItems":[{"services":[{"segments":[{"flightSegment":{"departure":{"iataCode":"HND","terminal":"I","at":"2019-06-28T06:35:00+09:00"},"arrival":{"iataCode":"HKG","terminal":"1","at":"2019-06-28T10:20:00+08:00"},"carrierCode":"KA","number":"397","aircraft":{"code":"321"},"operating":{"carrierCode":"KA","number":"397"},"duration":"0DT4H45M"},"pricingDetailPerAdult":{"travelClass":"ECONOMY","fareClass":"V","availability":9,"fareBasis":"VLASOJP8"}}]}],"price":{"total":"3512","totalTaxes":"472"},"pricePerAdult":{"total":"3512","totalTaxes":"472"}}]},{"type":"flight-offer","id":"1551613900689-1493784203","offerItems":[{"services":[{"segments":[{"flightSegment":{"departure":{"iataCode":"HND","terminal":"I","at":"2019-06-28T10:35:00+09:00"},"arrival":{"iataCode":"HKG","terminal":"1","at":"2019-06-28T14:20:00+08:00"},"carrierCode":"CX","number":"543","aircraft":{"code":"773"},"operating":{"carrierCode":"CX","number":"543"},"duration":"0DT4H45M"},"pricingDetailPerAdult":{"travelClass":"ECONOMY","fareClass":"V","availability":9,"fareBasis":"VLATOJP8"}}]}],"price":{"total":"4012","totalTaxes":"472"},"pricePerAdult":{"total":"4012","totalTaxes":"472"}}]},{"type":"flight-offer","id":"1551613900689--64505619","offerItems":[{"services":[{"segments":[{"flightSegment":{"departure":{"iataCode":"HND","terminal":"I","at":"2019-06-28T10:00:00+09:00"},"arrival":{"iataCode":"HKG","terminal":"1","at":"2019-06-28T13:45:00+08:00"},"carrierCode":"JL","number":"29","aircraft":{"code":"777"},"operating":{"carrierCode":"JL","number":"29"},"duration":"0DT4H45M"},"pricingDetailPerAdult":{"travelClass":"ECONOMY","fareClass":"Y","availability":9,"fareBasis":"YNX0OABA"}}]}],"price":{"total":"11742","totalTaxes":"572"},"pricePerAdult":{"total":"11742","totalTaxes":"572"}}]},{"type":"flight-offer","id":"1551613900689-92057181","offerItems":[{"services":[{"segments":[{"flightSegment":{"departure":{"iataCode":"HND","terminal":"I","at":"2019-06-28T10:35:00+09:00"},"arrival":{"iataCode":"HKG","terminal":"1","at":"2019-06-28T14:20:00+08:00"},"carrierCode":"JL","number":"7031","aircraft":{"code":"773"},"operating":{"carrierCode":"CX","number":"7031"},"duration":"0DT4H45M"},"pricingDetailPerAdult":{"travelClass":"ECONOMY","fareClass":"Y","availability":4,"fareBasis":"YNX0OABA"}}]}],"price":{"total":"11742","totalTaxes":"572"},"pricePerAdult":{"total":"11742","totalTaxes":"572"}}]},{"type":"flight-offer","id":"1551613900689--1198921234","offerItems":[{"services":[{"segments":[{"flightSegment":{"departure":{"iataCode":"HND","terminal":"I","at":"2019-06-28T00:55:00+09:00"},"arrival":{"iataCode":"HKG","terminal":"1","at":"2019-06-28T04:30:00+08:00"},"carrierCode":"NH","number":"821","aircraft":{"code":"763"},"operating":{"carrierCode":"NQ","number":"821"},"duration":"0DT4H35M"},"pricingDetailPerAdult":{"travelClass":"ECONOMY","fareClass":"Y","availability":9,"fareBasis":"Y2XOWA3"}}]}],"price":{"total":"12172","totalTaxes":"572"},"pricePerAdult":{"total":"12172","totalTaxes":"572"}}]},{"type":"flight-offer","id":"1551613900689-1393475059","offerItems":[{"services":[{"segments":[{"flightSegment":{"departure":{"iataCode":"HND","terminal":"I","at":"2019-06-28T06:35:00+09:00"},"arrival":{"iataCode":"HKG","terminal":"1","at":"2019-06-28T10:15:00+08:00"},"carrierCode":"UO","number":"625","aircraft":{"code":"321"},"operating":{"carrierCode":"UO","number":"625"},"duration":"0DT4H40M"},"pricingDetailPerAdult":{"travelClass":"ECONOMY","fareClass":"V","availability":4,"fareBasis":"VGDD"}}]}],"price":{"total":"1371","totalTaxes":"331"},"pricePerAdult":{"total":"1371","totalTaxes":"331"}}]},{"type":"flight-offer","id":"1551613900689--1399493487","offerItems":[{"services":[{"segments":[{"flightSegment":{"departure":{"iataCode":"HND","terminal":"I","at":"2019-06-28T10:00:00+09:00"},"arrival":{"iataCode":"HKG","terminal":"1","at":"2019-06-28T13:45:00+08:00"},"carrierCode":"CX","number":"6321","aircraft":{"code":"772"},"operating":{"carrierCode":"JL","number":"6321"},"duration":"0DT4H45M"},"pricingDetailPerAdult":{"travelClass":"ECONOMY","fareClass":"Y","availability":4,"fareBasis":"YOW9"}}]}],"price":{"total":"16032","totalTaxes":"472"},"pricePerAdult":{"total":"16032","totalTaxes":"472"}}]},{"type":"flight-offer","id":"1551613900689--1589144392","offerItems":[{"services":[{"segments":[{"flightSegment":{"departure":{"iataCode":"HND","terminal":"I","at":"2019-06-28T16:25:00+09:00"},"arrival":{"iataCode":"HKG","terminal":"1","at":"2019-06-28T20:00:00+08:00"},"carrierCode":"JL","number":"7039","aircraft":{"code":"77W"},"operating":{"carrierCode":"CX","number":"7039"},"duration":"0DT4H35M"},"pricingDetailPerAdult":{"travelClass":"ECONOMY","fareClass":"Y","availability":4,"fareBasis":"YNX0OABA"}}]}],"price":{"total":"11742","totalTaxes":"572"},"pricePerAdult":{"total":"11742","totalTaxes":"572"}}]},{"type":"flight-offer","id":"1551613900689--1039050126","offerItems":[{"services":[{"segments":[{"flightSegment":{"departure":{"iataCode":"HND","terminal":"I","at":"2019-06-28T06:35:00+09:00"},"arrival":{"iataCode":"HKG","terminal":"1","at":"2019-06-28T10:20:00+08:00"},"carrierCode":"CX","number":"5397","aircraft":{"code":"321"},"operating":{"carrierCode":"KA","number":"5397"},"duration":"0DT4H45M"},"pricingDetailPerAdult":{"travelClass":"ECONOMY","fareClass":"V","availability":9,"fareBasis":"VLASOJP8"}}]}],"price":{"total":"3512","totalTaxes":"472"},"pricePerAdult":{"total":"3512","totalTaxes":"472"}}]},{"type":"flight-offer","id":"1551613900689--2015190044","offerItems":[{"services":[{"segments":[{"flightSegment":{"departure":{"iataCode":"HND","terminal":"I","at":"2019-06-28T16:25:00+09:00"},"arrival":{"iataCode":"HKG","terminal":"1","at":"2019-06-28T20:00:00+08:00"},"carrierCode":"CX","number":"549","aircraft":{"code":"77W"},"operating":{"carrierCode":"CX","number":"549"},"duration":"0DT4H35M"},"pricingDetailPerAdult":{"travelClass":"ECONOMY","fareClass":"L","availability":9,"fareBasis":"LLATOJP8"}}]}],"price":{"total":"4502","totalTaxes":"472"},"pricePerAdult":{"total":"4502","totalTaxes":"472"}}]},{"type":"flight-offer","id":"1551613900689--1268860943","offerItems":[{"services":[{"segments":[{"flightSegment":{"departure":{"iataCode":"HND","terminal":"I","at":"2019-06-28T01:00:00+09:00"},"arrival":{"iataCode":"HKG","terminal":"1","at":"2019-06-28T04:40:00+08:00"},"carrierCode":"UO","number":"623","aircraft":{"code":"321"},"operating":{"carrierCode":"UO","number":"623"},"duration":"0DT4H40M"},"pricingDetailPerAdult":{"travelClass":"ECONOMY","fareClass":"V","availability":4,"fareBasis":"VGDD"}}]}],"price":{"total":"1371","totalTaxes":"331"},"pricePerAdult":{"total":"1371","totalTaxes":"331"}}]},{"type":"flight-offer","id":"1551613900689-1650337939","offerItems":[{"services":[{"segments":[{"flightSegment":{"departure":{"iataCode":"HND","terminal":"I","at":"2019-06-28T08:50:00+09:00"},"arrival":{"iataCode":"HKG","terminal":"1","at":"2019-06-28T12:25:00+08:00"},"carrierCode":"NH","number":"859","aircraft":{"code":"77W"},"operating":{"carrierCode":"NH","number":"859"},"duration":"0DT4H35M"},"pricingDetailPerAdult":{"travelClass":"ECONOMY","fareClass":"Y","availability":9,"fareBasis":"Y2XOWA3"}}]}],"price":{"total":"12522","totalTaxes":"572"},"pricePerAdult":{"total":"12522","totalTaxes":"572"}}]}],"dictionaries":{"carriers":{"JL":"JAPAN AIRLINES","NQ":"AIR JAPAN COMPANY LTD","CX":"CATHAY PACIFIC","KA":"CATHAY DRAGON","NH":"ALL NIPPON AIRWAYS","UO":"HONG KONG EXPRESS AIRWAYS"},"currencies":{"HKD":"HONGKONG DOLLAR"},"aircraft":{"321":"AIRBUS INDUSTRIE A321","772":"BOEING 777-200/200ER","773":"BOEING 777-300","763":"BOEING 767-300/300ER","777":"BOEING 777-200/300","77W":"BOEING 777-300ER"},"locations":{"HKG":{"subType":"AIRPORT","detailedName":"INTERNATIONAL"},"HND":{"subType":"AIRPORT","detailedName":"TOKYO INTL HANEDA"}}},"meta":{"links":{"self":"https://api.amadeus.com/v1/shopping/flight-offers?origin=HND&destination=HKG&departureDate=2019-06-28&adults=1&nonStop=true¤cy=HKD&max=50"},"currency":"HKD"}}';

        //Reformat & regroup json data retrieved from API source
        $departure = self::ReformingJsonData($departure);
        $arrival = self::ReformingJsonData($arrival);


        $airports = Airports::select('id','iata_code as code','name')
            ->where('municipality', '=', $city)
            ->where('type','=','large_airport')
            ->orderby('name')->get()->toArray();

        $departure_airport = Airports::select('id','iata_code','name')
            ->where('iata_code', '=', $to)->first();
        $departure_airport = $departure_airport->name;

        //print_r($arrival);die();
        $payment_method = PaymentMethod::where('id','!=','5')->get();
        $token = $this->EncryptToken();

        return view('flight.result')
            ->with('code', $code)
            ->with('from', $from)
            ->with('to', $to)
            ->with('start', $start)
            ->with('end',$end)
            ->with('city',$city)
            ->with('country',$country)
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
            $airport = self::AirportsCity($code);
        }
        //print_r($airport);die();
        return response()->json($airport);
    }


    protected function AirportsCity($code, $airport = null){

        $country = $code;
        $airports = FlightStats::AirportsData($country,$airport);

        $airport = array();
        $counter = 0;
        foreach ($airports as $k => $obj){
            if($obj['iata_code'] != null && $obj['municipality'] != '' && $obj['type'] == 'large_airport') {
                $airport[$counter]['id'] = $obj['id'];
                $airport[$counter]['code'] = $obj['iata_code'];
                $airport[$counter]['name'] = $obj['name'];
                $airport[$counter]['municipality'] = $obj['municipality'];
                $counter++;
            }
        }

        //print_r($airport);die();
        $city = array();
        foreach ($airport as $air){
            if(!in_array($air['municipality'],$city)){
                array_push($city,$air['municipality']);
            }
        }
        sort($city);

        return $city;
    }

    public function getairportlist(Request $request){

        $city = $request->city;
        $airports = Airports::select('id','iata_code','name')->where('municipality', '=', $city)->where('type','=','large_airport');
        $airports = $airports->orderby('name')->get()->toArray();

        return response()->json($airports);
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
            'currency' => 'HKD',
            'adults' => '1',
            'max' => '50'
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

//        echo '<pre>';
//        print_r($data['data']);
//        echo '</pre>';die();

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

        $flight_arr = array();
        foreach ($flight as $key => $row)
        {
            $flight_arr[$key] = $row['carrier'];
        }
        array_multisort($flight_arr, SORT_DESC, $flight);

//        echo '<pre>';
//        print_r($flight);
//        echo '</pre>';die();

        return $flight;
    }

    public function booking(Request $request)
    {

        sleep(2);   //delay process

        //Split encrypted code
        $encrypted_code = $request->encrypted_code;
        $encrypted_code = explode(",",$encrypted_code);

        $token = base64_decode($encrypted_code[0]);
        $en_total = base64_decode($encrypted_code[1]);
        $en_dep = base64_decode($encrypted_code[2]);
        $en_arr = base64_decode($encrypted_code[3]);

        //Basic Validation
        $const_token = self::token;
        if(
            $token != $const_token || $en_total != $request->form_basic_price ||
            $en_dep != $request->form_departure || $en_arr != $request->form_arrival
        ){
            return redirect()->route('pages.error');
        }

        //Validate data
        foreach ($request->people_name as $k => $name) {
            if($name == null || $request->people_passport[$k] == null) {
                return redirect()->route('pages.error');
            }
        }

        $related_flight_id = uniqid();

        //******** Create booking process ******** //

        if($request->form_departure != null) {
            $source_dep = json_decode($request->source_dep, true);
            $source_dep = $source_dep[$request->source_dep_num];

            try
            {
               $bk = new FlightBooking();
               $bk->user_id = Auth::user()->id;
               $bk->related_flight_id = $related_flight_id;
               $bk->country = 'Hong Kong';
               $bk->country_code = 'HK';
               $bk->city = $request->final_city;
               $bk->arr_country = $request->country_name;
               $bk->arr_country_code = $request->country_code;
               $bk->dep_airport = 'HKG';
               $bk->arr_airport = $source_dep['arrival_airport'];
               $bk->dep_date = $source_dep['departure_date'];
               $bk->airline_name = FlightStats::AirlinesData($source_dep['carrier']);
               $bk->airline_code = $source_dep['carrier'];
               $bk->flight_code = $source_dep['carrier'].$source_dep['number'];
               $bk->flight_start = $source_dep['departure_time'];
               $bk->flight_end = $source_dep['arrival_time'];
               $bk->duration = $source_dep['duration'];
               $bk->plane = $source_dep['aircraft'];
               $bk->price = $source_dep['price_basic'];
               $bk->tax = $source_dep['price_taxes'];
               $bk->class = $source_dep['class'];

               $request->form_arrival == '' ? $bk->is_single_way = '1' : $bk->is_single_way = '0';
                
                if(!$bk->save())
                 {
                 throw new Exception();
                 } else {
                    $dep_bk_id = $bk->id;
                }
            }
           catch(Exception $e)
            {
                return redirect()->route('pages.error');
            }
        }

        if($request->form_arrival != null) {
            $source_arr = json_decode($request->source_arr, true);
            $source_arr = $source_arr[$request->source_arr_num];
            
            try
            {
                $bk = new FlightBooking();
                $bk->user_id = Auth::user()->id;
                $bk->related_flight_id = $related_flight_id;
                $bk->country = $request->country_name;
                $bk->country_code = $request->country_code;
                $bk->city = $request->final_city;
                $bk->arr_country = 'Hong Kong';
                $bk->arr_country_code = 'HK';
                $bk->dep_airport = $source_arr['departure_airport'];
                $bk->arr_airport = $source_arr['arrival_airport'];
                $bk->dep_date = $source_arr['departure_date'];
                $bk->airline_name = FlightStats::AirlinesData($source_arr['carrier']);
                $bk->airline_code = $source_arr['carrier'];
                $bk->flight_code = $source_arr['carrier'].$source_arr['number'];
                $bk->flight_start = $source_arr['departure_time'];
                $bk->flight_end = $source_arr['arrival_time'];
                $bk->duration = $source_arr['duration'];
                $bk->plane = $source_arr['aircraft'];
                $bk->price = $source_arr['price_basic'];
                $bk->tax = $source_arr['price_taxes'];
                $bk->class = $source_arr['class'];

                $request->form_departure == '' ? $bk->is_single_way = '1' : $bk->is_single_way = '0';
                
                if(!$bk->save())
                 {
                 throw new Exception();
                 } else {
                    $arr_bk_id = $bk->id;
                }
            }
           catch(Exception $e)
            {
                return redirect()->route('pages.error');
            }
        }

        //******** Create payment after booking ******** //
        if($en_total != 0 && $en_total != null && is_numeric($en_total) ){
            
            /* Handle real payment process here (ref to BookingController::BookingPayment) */
            /* If payment status return true, process to store in local DB */
            
            try
            {
                $pay = new FlightPayment;
                $pay->flight_booking_id = $bk->id;
                $pay->related_flight_id = $related_flight_id;
                $pay->total_price = $en_total;
                $pay->payment_method = $request->payment_method;
                $pay->card_number = $request->card_number;
                $pay->expired_date = $request->expired_date;
                $pay->security_number = $request->security_number;
                $pay->is_single_way = $bk->is_single_way;
                $pay->status = 1;
                $pay->user_id = Auth::user()->id;
            
                if(!$pay->save()){
                    throw new Exception();
                }
            }
           catch(Exception $e)
            {
                return redirect()->route('pages.error');
            }            
            
        } else {
            return redirect()->route('pages.error');
        }


        //******** Create passenger data after payment ******** //

        $num_of_ppl = count($request->people_name);
        if($num_of_ppl > 0){
            try{

                if($request->form_departure != null) {
                    foreach ($request->dep_people as $k => $n) {
                        if($n == 1) {
                            $ppl = new FlightPassenger();
                            $ppl->related_flight_id = $related_flight_id;
                            $ppl->people_name = $request->people_name[$k];
                            $ppl->people_passport = $request->people_passport[$k];
                            $ppl->flight_booking_id = $dep_bk_id;
                            if (!$ppl->save()) {
                                throw new Exception();
                            }
                        }
                    }
                }

                if($request->form_arrival != null) {
                    foreach ($request->arr_people as $k => $n) {
                        if($n == 1) {
                            $ppl = new FlightPassenger();
                            $ppl->related_flight_id = $related_flight_id;
                            $ppl->people_name = $request->people_name[$k];
                            $ppl->people_passport = $request->people_passport[$k];
                            $ppl->flight_booking_id = $arr_bk_id;
                            if (!$ppl->save()) {
                                throw new Exception();
                            }
                        }
                    }
                }

            } catch(Exception $e)
            {
                return redirect()->route('pages.error');
            }
        } else {
            return redirect()->route('pages.error');
        }

        //Create trip record if trip params exist

        $trip = new Trip();
        if($request->trip != '') {
            $trip->booking_id = $request->trip;
        } else {
            $trip->booking_id = NULL;
        }
        $trip->user_id = Auth::user()->id;
        $trip->related_flight_id = $related_flight_id;
        $trip->city = $request->final_city;
        $trip->save();



        return redirect()->route('flight.summary');
    }

    protected function EncryptToken(){
        return base64_encode($this::token);
    }


    public function FlightSummary(){

        $user_id = Auth::user()->id;
        $id = Input::get('id', false);
        if($id == null){
            $booking = FlightBooking::where('user_id', '=', $user_id)->orderby('dep_date','DESC')->get();
        } else {
            $booking = FlightBooking::where('user_id', '=', $user_id)->where('related_flight_id','=',$id)->orderby('dep_date', 'DESC')->get();
        }
        $pay_method_list = \App\Helpers\AppHelper::instance()->ObjectToArrayMap(PaymentMethod::where('id','!=','5')->get(),'id','type');


        return view('flight.summary')
            ->with('booking',$booking)
            ->with('pay_method_list',$pay_method_list);

    }


    public function FlightSeat($id){

        $booking = FlightBooking::where('id', '=', $id)->first();
        $passenger = FlightPassenger::where('flight_booking_id','=',$booking->id)->get()->toArray();
        $selected_seat = FlightBooking::flightSelectedSeat($passenger);
        $num_of_select = FlightBooking::flightSeatAvailableSelect($passenger);

        //To correctly display airbus seat map
        $num_of_rows = FlightBooking::flightSeat();
        $seat_each_row = FlightBooking::flightSeatEachRow();
        $booked_seat = FlightBooking::flightSeatExist($booking->flight_code, $booking->dep_date, $booking->flight_start);

        return view('flight.seat')
            ->with('booking',$booking)
            ->with('passenger',$passenger)
            ->with('num_of_rows',$num_of_rows)
            ->with('seat_each_row', $seat_each_row)
            ->with('booked_seat',$booked_seat)
            ->with('num_of_select',$num_of_select)
            ->with('selected_seat', $selected_seat);
    }

    public function seat(Request $request)
    {
        //Store selected seat to flight_passenger table.
        $booking = FlightBooking::where('id', '=', $request->booking_id)->first();
        $passenger = FlightPassenger::where('flight_booking_id','=',$booking->id)->get()->toArray();

        //Find all no seat passenger
        foreach ($passenger as $pass){
            if($pass['seat'] == null){
                $store[] = $pass['id'];
            }
        }

        $select = explode(',',$request->re_select);

        foreach ($select as $k => $set){
            $pass = FlightPassenger::find($store[$k]);
            $pass->seat = $set;
            $pass->save();
        }

        Session::flash('success', '已成功預訂座位!');
        return redirect()->route('flight.seat',$booking->id);
    }


}
