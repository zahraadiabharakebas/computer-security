<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\UUID;

class Prescription extends Model
{
    use HasFactory,UUID;
    public function getAppointment(){
        return $this->belongsTo(Appointment::class,'appointment_id','id');
    }
}
