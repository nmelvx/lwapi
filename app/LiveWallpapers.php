<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class LiveWallpapers extends Model
{
    protected $table = 'live_wallpapers';

    protected $fillable = [
        'typeID', 'categID', 'userID', 'previewURL', 'resourceURL', 'title', 'statusID', 'ratingUp', 'ratingDown'
    ];

    public function category() {
        return $this->hasOne(Categories::class, 'id', 'categID');
    }

    public function type() {
        return $this->hasOne(Types::class, 'id','typeID');
    }

    public function tags()
    {
        return $this->morphToMany(Tags::class, 'taggable')->withTimestamps();
    }


    public function scopeWithFilters($query, $filters)
    {

        return $query
            ->type($filters)
            ->category($filters)
            ->latest($filters)
            ->top($filters)
            ->order($filters);

    }

    public function scopeType($query, $filters)
    {
        if( isset($filters['typeID']) && is_numeric($filters['typeID']) )
        {
            $query = $query->where( 'typeID', $filters['typeID'] );
        }

        return $query;
    }

    public function scopeCategory($query, $filters)
    {
        if( isset($filters['categID']) && is_numeric($filters['categID']) )
        {
            $query = $query->where( 'categID', $filters['categID'] );
        }

        return $query;
    }

    public function scopeLatest($query, $filters)
    {
        if( isset($filters['latest']) && $filters['latest'] === true)
        {
            $query = $query->orderBy( 'updated_at', 'DESC' );
        }

        return $query;
    }

    public function scopeTop($query, $filters)
    {
        if( isset($filters['top']) && is_numeric($filters['top']) )
        {
            $query = $query->orderBy( 'ratingUp', 'DESC' );
        }

        return $query;
    }

    public function scopeOrder($query, $filters)
    {
        if( isset($filters['orderField']) )
        {
            $query = $query->orderBy( $filters['orderField'], isset($filters['orderType'])? $filters['orderType']:'ASC' );
        }

        return $query;
    }
}
