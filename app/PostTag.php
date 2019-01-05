<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PostTag extends Model
{
    protected $table = 'post_tag';

    public function tag()
    {
        return $this->hasone('App\Tag');
    }

}
