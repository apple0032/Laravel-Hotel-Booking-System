<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use DB;

class CountryImage extends Model
{
    protected $table = 'country_image';


}

/*

CREATE TABLE `country_image` (
  `id` int(11) NOT NULL,
  `country` varchar(255) NOT NULL,
  `image` varchar(255) NOT NULL,
  `updated_at` datetime NOT NULL,
  `created_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

ALTER TABLE `country_image`
  ADD PRIMARY KEY (`id`);

ALTER TABLE `country_image`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1;


 */

