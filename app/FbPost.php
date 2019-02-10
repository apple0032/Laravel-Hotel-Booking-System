<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class FbPost extends Model
{
    protected $table = 'fb_post';

    public function hotel()
    {
        return $this->belongsTo('App\User');
    }

}

/*

CREATE TABLE `fb_post` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `comment` text NOT NULL,
  `filename` varchar(255) NOT NULL,
  `has_like` int(11) NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


*/