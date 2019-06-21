<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use DB;

class Cities extends Model
{
    protected $table = 'cities';

    public function Trip()
    {
        return $this->belongsTo('App\Trip');
    }


}
