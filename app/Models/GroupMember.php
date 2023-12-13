<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GroupMember extends Model

{
    protected $table = 'group_members';
    //テーブルを使用
    protected $fillable = ['user_id', 'group_id', 'role'];
    //変数可能
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function group()
    {
        return $this->belongsTo(Group::class);
    }
}
