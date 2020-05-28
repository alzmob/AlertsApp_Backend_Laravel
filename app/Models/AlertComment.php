<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AlertComment extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id', 'alert_id', 'body'
    ];



    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function alert()
    {
        return $this->belongsTo(Alert::class);
    }

    protected $appends = ['createdDifference', 'updatedDifference'];
    public function getCreatedDifferenceAttribute()
    {
        return $this->created_at->diffForHumans();
    }

    public function getUpdatedDifferenceAttribute()
    {
        return $this->updated_at->diffForHumans();
    }
}
