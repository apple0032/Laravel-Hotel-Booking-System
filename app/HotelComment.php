<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class HotelComment extends Model
{
    protected $table = 'hotel_comment';
        
    public function hotel()
    {
    	return $this->belongsTo('App\Hotel');
    }
    
}
