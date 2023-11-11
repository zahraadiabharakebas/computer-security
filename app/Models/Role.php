<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\UUID;

class Role extends Model
{
    use HasFactory,UUID;
    public function getUsers(){
        return  $this->belongsToMany(User::class,'user_roles','role_id','user_id');
    }
}
