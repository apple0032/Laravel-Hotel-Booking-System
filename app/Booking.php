<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Booking extends Model
{
    protected $table = 'booking';
        
    public function hotel()
    {
    	return $this->belongsTo('App\Hotel');
    }

    public function paymentMethod()
    {
        return $this->hasone('App\PaymentMethod');
    }

    public function payment()
    {
        return $this->hasone('App\BookingPayment');
    }

    public function guest()
    {
        return $this->hasmany('App\BookingGuest');
    }

}
