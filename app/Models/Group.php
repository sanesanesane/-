<?php

namespace App\Models;

use App\Models\Group;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;



class Group extends Model
{
    use HasFactory;
    use SoftDeletes;
    protected $fillable = ['name', 'description', 'user_id'];
    //変数可


    public function members()
    {
        return $this->belongsToMany(User::class, 'group_members')->withPivot('role');
    }
    //userとリレーション。group_membersを中間テーブルにしroleカラムを取得。

    public function groupMembers()
    {
        return $this->hasMany(GroupMember::class);
    }
    //group_membersと一対多のリレーション



    public function activities()
    {
        return $this->belongsToMany(Activity::class, 'group_activities');
    }
    //メンバーのActivityを取得する。多数対多数のリレーション
    
    public function users()
    {
        return $this->belongsToMany(User::class, 'group_members')->withPivot('role');
    }
    


}
