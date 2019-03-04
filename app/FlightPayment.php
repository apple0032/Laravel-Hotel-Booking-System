<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class FlightPayment extends Model
{
    protected $table = 'flight_payment';

}

/*

CREATE TABLE `flight_payment` (
  `id` int(11) NOT NULL,
  `flight_booking_id` int(11) NOT NULL,
  `related_flight_id` varchar(255) NOT NULL,
  `total_price` int(11) NOT NULL,
  `payment_method` int(11) NOT NULL,
  `card_number` int(11) NOT NULL,
  `expired_date` varchar(255) NOT NULL,
  `security_number` int(11) NOT NULL,
  `is_single_way` int(11) NOT NULL,
  `status` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `updated_at` datetime NOT NULL,
  `created_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

ALTER TABLE `flight_payment`
  ADD PRIMARY KEY (`id`);

ALTER TABLE `flight_payment`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1;

 */

