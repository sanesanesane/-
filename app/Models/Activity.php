<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Activity extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id',
        'category_id',
        'start_time',
        'end_time',
        'description',
        'studied_at',
        'reflect',
        
    ];

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = ['studied_at', 'start_time', 'end_time'];

    /**
     * Get the user that owns the activity.
     */
    public function user()
    {
        return $this->belongsTo('App\Models\User');
    }

    /**
     * Get the category associated with the activity.
     */
    public function category()
    {
        return $this->belongsTo('App\Models\Category');
    }

public function groups()
{
    return $this->belongsToMany(Group::class, 'group_activities');
}
/**
 * 勉強時間の期間を分で取得するアクセサ。
 *
 * @return int
 */
public function getDurationAttribute() 
{
    if ($this->start_time && $this->end_time) {
        return $this->end_time->diffInMinutes($this->start_time);
    }

    return 0;
}




}
