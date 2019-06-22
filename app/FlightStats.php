<?php

namespace App;
use App\Airlines;
use App\Airports;
use App\ApiInfo;

class FlightStats
{
    public static function ApiData()
    {
        /* UPDATE 2019-02-21 */
        /*
         * API source updated : https://developers.amadeus.com/my-account
         *
         */

        //Amadeus API auth structure
        $client_id = (ApiInfo::ApiData())['client_id'];
        $client_secret = (ApiInfo::ApiData())['client_secret'];

        $data['client_id'] = $client_id;
        $data['client_secret'] = $client_secret;

        return $data;
    }

    public static function AirlinesData($fs){
        $airline = Airlines::Where('fs', '=', $fs)->where('active','=','1')->first();
        return $airline->name;
    }

    public static function AirportsData($country,$iata){

        $airports = Airports::select('*');

        if($country != null) {
            $airports = $airports->where('iso_country', '=', $country);
        }

        if($iata != null) {
            $airports = $airports->where('iata_code', '=', $iata);
        }

        $airports = $airports->orderby('name')->get();

        return $airports;
    }
}
