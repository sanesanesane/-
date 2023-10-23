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
    
    public function members()
{
    return $this->hasMany(GroupMember::class);
}

public function edit(Group $group)
{
    $this->authorize('update', $group);
    
}
public function users()
{
    return $this->belongsToMany(User::class, 'group_members')->withPivot('role');
}


}

