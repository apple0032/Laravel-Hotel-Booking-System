<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class HotelImage extends Model
{
    protected $table = 'hotel_image';

    public function hotel()
    {
        return $this->belongsTo('App\Hotel');
    }

}
