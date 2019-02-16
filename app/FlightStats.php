<?php

namespace App;

class FlightStats
{
    public static function ApiData()
    {
        //Api data provided from flightstats.com
        //The api key auth data will hide in git server

        $data['appId'] = '/* HIDDEN */';
        $data['appKey'] = '/* HIDDEN */';

    	return $data;
    }

}
