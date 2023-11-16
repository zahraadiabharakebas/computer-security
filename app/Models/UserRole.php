<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\UUID;

class UserRole extends Model
{
    use HasFactory,UUID;
    public function role()
    {
        return $this->belongsTo(Role::class, 'role_id');
    }


}
