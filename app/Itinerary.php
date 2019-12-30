<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use DB;

class Itinerary extends Model
{
    protected $table = 'itinerary';

    public function Trip()
    {
        return $this->belongsTo('App\Trip');
    }
    
}

