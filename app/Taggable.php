<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Taggable extends Model
{
    protected $table = 'taggables';

    public function taggable()
    {
        return $this->morphTo();
    }
}
