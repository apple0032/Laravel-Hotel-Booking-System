<?php

namespace App;
use App\Airlines;
use App\Airports;

class FlightStats
{
    public static function ApiData()
    {
        /* UPDATE 2019-02-21 */
        /*
         * API source updated : https://developers.amadeus.com/my-account
         *
         */

        //Api data provided from flightstats.com
        //The api key auth data will hide in git server

        $data['appId'] = '/* HIDDEN */';
        $data['appKey'] = '/* HIDDEN */';

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
