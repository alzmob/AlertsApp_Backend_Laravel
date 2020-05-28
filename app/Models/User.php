<?php

namespace App\Models;

use Spatie\MediaLibrary\Models\Media;
use Spatie\Permission\Traits\HasRoles;
use Tymon\JWTAuth\Contracts\JWTSubject;
use Illuminate\Notifications\Notifiable;
use Spatie\MediaLibrary\HasMedia\HasMedia;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Spatie\MediaLibrary\HasMedia\HasMediaTrait;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable implements HasMedia, JWTSubject
{
    use HasRoles, HasMediaTrait, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'first_name', 'last_name', 'email', 'phone_number', 'password', 'status', 'profile_picture','fcm_token'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
     * The accessors to append to the model's array form.
     *
     * @var array
     */
    protected $appends = ['avatar', 'createdDifference', 'updatedDifference'];

    /**
     * Get the administrator flag for the user.
     *
     * @return bool
     */
    public function getAvatarAttribute()
    {
        return $this->getFirstMediaUrl('avatar', 'thumb') ? asset($this->getFirstMediaUrl('avatar', 'thumb')) : config('app.placeholder') . '130';
    }

    public function registerMediaCollections()
    {
        $this
            ->addMediaCollection('avatar')
            ->singleFile()
            ->registerMediaConversions(function (Media $media) {
                $this
                    ->addMediaConversion('thumb')
                    ->width(160)
                    ->height(160);
            });
    }

    // Rest omitted for brevity

    /**
     * Get the identifier that will be stored in the subject claim of the JWT.
     *
     * @return mixed
     */
    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    /**
     * Return a key value array, containing any custom claims to be added to the JWT.
     *
     * @return array
     */
    public function getJWTCustomClaims()
    {
        return [];
    }

    public function alerts()
    {
        return $this->hasMany(Alert::class);
    }

    public function likes()
    {
        return $this->hasMany(Like::class);
    }

    public function getCreatedDifferenceAttribute()
    {
        return $this->created_at->diffForHumans();
    }

    public function getUpdatedDifferenceAttribute()
    {
        return $this->updated_at->diffForHumans();
    }
}
