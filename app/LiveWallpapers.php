<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class LiveWallpapers extends Model
{
    protected $table = 'live_wallpapers';

    protected $fillable = [
        'typeID', 'categID', 'userID', 'previewURL', 'resourceURL', 'title', 'statusID', 'ratingUp', 'ratingDown'
    ];

}
