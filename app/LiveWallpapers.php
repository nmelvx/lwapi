<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class LiveWallpapers extends Model
{
    protected $fillable = [
        'typeID', 'categID', 'previewURL', 'resourcesURL', 'title', 'statusID', 'ratingUp', 'ratingDown'
    ];

    protected $table = 'live_wallpapers';
}
