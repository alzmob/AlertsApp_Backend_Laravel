<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Support\Str;
use Spatie\MediaLibrary\Models\Media;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia\HasMedia;
use Spatie\MediaLibrary\HasMedia\HasMediaTrait;

class Alert extends Model implements HasMedia
{
    use HasMediaTrait;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id', 'city_id', 'title', 'slug', 'lat', 'long', 'published', 'broadcasted', 'total_view_count', 'short_description'
    ];

    /**
     * The accessors to append to the model's array form.
     *
     * @var array
     */
    protected $appends = ['thumb', 'shot_description', 'createdDifference', 'updatedDifference'];

    protected $dates = ['created_at', 'updated_at'];

    /**
     * Get the administrator flag for the user.
     *
     * @return bool
     */
    public function getThumbAttribute()
    {
        return $this->getFirstMediaUrl('videos', 'thumb') ? asset($this->getFirstMediaUrl('videos', 'thumb')) : config('app.placeholder') . '500';
    }

    public function getCreatedDifferenceAttribute()
    {
        return $this->created_at->diffForHumans();
    }

    public function getUpdatedDifferenceAttribute()
    {
        return $this->updated_at->diffForHumans();
    }

    public function getTitleAttribute($value)
    {
        return Str::limit($value, 48);
    }

    public function getShotDescriptionAttribute()
    {
        //OIH
        return;
        // return Str::limit($this->updates()->first()->description, 96);
    }

    // public function getCreatedAtAttribute($value)
    // {
    //     return Carbon::parse($value)->diffForHumans();
    // }

    // public function getUpdatedAtAttribute($value)
    // {
    //     return Carbon::parse($value)->diffForHumans();
    // }

    public function registerMediaCollections()
    {
        $this->addMediaCollection('videos');
    }
    /**
     * Register the conversions that should be performed.
     *
     * @return array
     */
    public function registerMediaConversions(Media $media = null)
    {
        $this->addMediaConversion('thumb')
            ->extractVideoFrameAtSecond(20)
            ->performOnCollections('videos');
    }


    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function city()
    {
        return $this->belongsTo(City::class);
    }


    public function updates()
    {
        return $this->hasMany(AlertUpdate::class);
    }

    public function comments()
    {
        return $this->hasMany(AlertComment::class);
    }

    public function likes()
    {
        return $this->hasMany(Like::class);
    }

    public function likesPrayer()
    {
        return $this->hasMany(Like::class)->where('type', 'prayer');
    }

    public function likesSad()
    {
        return $this->hasMany(Like::class)->where('type', 'sad');
    }

    public function likesLove()
    {
        return $this->hasMany(Like::class)->where('type', 'love');
    }

    public function likesSmile()
    {
        return $this->hasMany(Like::class)->where('type', 'smile');
    }
}
