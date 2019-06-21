<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use DB;

class Trip extends Model
{
    protected $table = 'trip';

    //Relationship
    public static function booing($related_flight_id)
    {
        return FlightBooking::where('related_flight_id', '=', $related_flight_id )->get();
    }

    public function City()
    {
        return $this->hasone('App\Cities');
    }

    public static function getTrip($book_id){
        $trip = Trip::where('booking_id','=',$book_id)->first();

        if($trip != null){
            return true;
        } else {
            return false;
        }
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

ALTER TABLE `trip` CHANGE `booking_id` `booking_id` INT(11) NULL DEFAULT NULL;

ALTER TABLE `trip` ADD `user_id` INT(11) NOT NULL AFTER `related_flight_id`;

 */

