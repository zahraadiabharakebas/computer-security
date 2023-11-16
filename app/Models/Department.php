<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\UUID;

class Department extends Model
{
    use HasFactory,UUID;

    public function getDoctors(){
        return $this->hasMany(User::class);
    }
}
