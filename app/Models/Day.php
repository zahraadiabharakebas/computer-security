<?php

namespace App\Models;

use App\Traits\UUID;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Day extends Model
{
    use HasFactory,UUID;
    public function getSchedules(){
        return  $this->belongsToMany(Schedule::class,'schedule_days','day_id','schedule_id');
    }
}
