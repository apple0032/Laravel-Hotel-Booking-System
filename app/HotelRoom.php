<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class HotelRoom extends Model
{

    protected $table = 'hotel_room';

    public function hotel()
    {
    	return $this->belongsTo('App\Hotel');
    }

    public function Type()
    {
        return $this->hasOne('App\RoomType','id');
    }
    
    public function facility()
    {
        return $this->hasOne('App\HotelRoomFacility');
    }

}
