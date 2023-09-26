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
        'studied_at'
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

    // その他のメソッドやリレーションは必要に応じて追加してください。
}
