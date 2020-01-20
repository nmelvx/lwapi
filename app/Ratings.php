<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Ratings extends Model
{

    protected $table = 'ratings';

    protected $fillable = ['lwID', 'userID', 'ratingUp', 'ratingDown'];
}
