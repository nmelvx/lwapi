<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Tags extends Model
{
    protected $table = 'tags';

    protected $fillable = ['tag'];

    public function lw()
    {
        return $this->morphedByMany(LiveWallpapers::class, 'taggable')->withTimestamps();
    }
}
