<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\FlightPassenger;
use App\FlightPayment;
use App\FlightBooking;
use DB;

class Trip extends Model
{
    protected $table = 'trip';

    //Relationship
    public static function booing($related_flight_id)
    {
        return FlightBooking::where('related_flight_id', '=', $related_flight_id )->get();
    }

}

/*

CREATE TABLE `trip` (
  `id` int(11) NOT NULL,
  `booking_id` int(11) NOT NULL,
  `related_flight_id` varchar(255) NOT NULL,
  `updated_at` datetime NOT NULL,
  `created_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

ALTER TABLE `trip`
  ADD PRIMARY KEY (`id`);

ALTER TABLE `trip`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1;

 */

