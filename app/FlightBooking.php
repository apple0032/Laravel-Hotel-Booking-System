<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\FlightPassenger;
use App\FlightPayment;
use DB;

class FlightBooking extends Model
{
    protected $table = 'flight_booking';

    //Relationship
    public static function payment($related_flight_id)
    {
        return FlightPayment::where('related_flight_id', '=', $related_flight_id )->first();
    }

    public static function passenger($flight_booking_id)
    {
        return FlightPassenger::where('flight_booking_id', '=', $flight_booking_id )->get();
    }

    public static function flightSeat($no_of_rows = 10){

        for ($x = 1; $x <= $no_of_rows; $x++) {
            $arr[] = $x;
        }

        return $arr;
    }

    public static function flightSeatEachRow(){
        return array('A','B','C','D','E','F');
    }

    public static function flightSeatExist($code, $date, $time){

        $passenger = DB::table('flight_passenger')
            ->select('flight_passenger.*')
            ->leftJoin('flight_booking', 'flight_passenger.flight_booking_id', '=', 'flight_booking.id')
            ->where('flight_booking.flight_code', '=', $code)
            ->where('flight_booking.dep_date', '=', $date)
            ->where('flight_booking.flight_start', '=', $time)
            ->get();

        $booked_seat = array();
        foreach ($passenger as $pass){
            if($pass->seat != ''){
                $booked_seat[] = $pass->seat;
            }
        }

        return $booked_seat;
    }

    public static function flightSeatAvailableSelect($passenger){

        $c = 0;
        foreach ($passenger as $ppl){
            if($ppl['seat'] == null){
                $c ++;
            }
        }

        return $c;
    }

    public static function flightSelectedSeat($passenger){

        $selected_seat = array();
        foreach ($passenger as $ppl){
            if($ppl['seat'] != null){
                $selected_seat[] = $ppl['seat'];
            }
        }

        return $selected_seat;
    }
}

/*

CREATE TABLE `flight_booking` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `related_flight_id` varchar(255) NOT NULL,
  `country` varchar(255) NOT NULL,
  `country_code` varchar(255) NOT NULL,
  `dep_airport` varchar(255) NOT NULL,
  `arr_airport` varchar(255) NOT NULL,
  `dep_date` datetime NOT NULL,
  `airline_name` varchar(255) NOT NULL,
  `airline_code` varchar(255) NOT NULL,
  `flight_code` varchar(255) NOT NULL,
  `flight_start` varchar(255) NOT NULL,
  `flight_end` varchar(255) NOT NULL,
  `duration` varchar(255) NOT NULL,
  `plane` varchar(255) NOT NULL,
  `price` int(11) NOT NULL,
  `tax` int(11) NOT NULL,
  `class` varchar(255) NOT NULL,
  `is_single_way` int(11) NOT NULL,
  `updated_at` datetime NOT NULL,
  `created_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

ALTER TABLE `flight_booking`
  ADD PRIMARY KEY (`id`);

ALTER TABLE `flight_booking`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1;

//ALTER TABLE `flight_booking` ADD `seat` VARCHAR(255) NULL DEFAULT NULL AFTER `class`; //should be moved to passengers table

ALTER TABLE `flight_booking` ADD `arr_country` VARCHAR(255) NOT NULL AFTER `country_code`, ADD `arr_country_code` VARCHAR(255) NOT NULL AFTER `arr_country`;

*/

