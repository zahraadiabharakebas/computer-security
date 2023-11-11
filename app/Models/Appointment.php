<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\UUID;

class Appointment extends Model
{
    use HasFactory,UUID;

    public function getPrescription(){
        return $this->hasOne(Prescription::class);
    }

    public function getDoctor(){
        return $this->belongsTo(User::class,'doctor_id','id');
    }
    public function getPatient(){
        return $this->belongsTo(User::class,'patient_id','id');
    }
}
