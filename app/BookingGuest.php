<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class BookingGuest extends Model
{
    protected $table = 'booking_guest';

    public function booking()
    {
        return $this->hasone('App\Booking');
    }


}
