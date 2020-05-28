<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AlertUpdate extends Model
{

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'alert_id', 'description'
    ];


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
