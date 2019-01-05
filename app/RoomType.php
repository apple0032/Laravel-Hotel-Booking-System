<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class RoomType extends Model
{

    protected $table = 'room_type';

    public function hotelroom()
    {
    	return $this->belongsToMany('App\HotelRoom');
    }
}
