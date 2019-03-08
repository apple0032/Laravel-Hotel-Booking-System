<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\FlightPassenger;
use App\FlightPayment;

class FlightBooking extends Model
{
    protected $table = 'flight_booking';

    //Relationship
    public static function payment($related_flight_id)
    {
        return FlightPayment::where('related_flight_id', '=', $related_flight_id )->first();
    }

    public static function passenger($related_flight_id)
    {
        return FlightPassenger::where('related_flight_id', '=', $related_flight_id )->get();
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

ALTER TABLE `flight_booking` ADD `seat` VARCHAR(255) NULL DEFAULT NULL AFTER `class`;
 */

