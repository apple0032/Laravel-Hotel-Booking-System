<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class FbImage extends Model
{
    protected $table = 'fb_image';

    public function hotel()
    {
        return $this->belongsTo('App\User');
    }

}

/*

CREATE TABLE `fb_image` (
`id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `filename` varchar(255) NOT NULL,
  `resized_name` varchar(255) NOT NULL,
  `original_name` varchar(255) NOT NULL,
  `extension` varchar(255) DEFAULT 'jpg',
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

*/