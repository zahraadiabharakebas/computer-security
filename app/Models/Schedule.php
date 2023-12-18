<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\UUID;
use Illuminate\Support\Facades\Crypt;


class schedule extends Model
{
    use HasFactory,UUID;
    protected $encrypt = ['message'];
    public function setAttribute($key, $value)
    {
        if (in_array($key, $this->encrypt)) {
            $this->attributes[$key] = encrypt($value);
        } else {
            parent::setAttribute($key, $value);
        }
    }
    public function getAttribute($key)
    {
        if (in_array($key, $this->encrypt) && !empty($this->attributes[$key])) {
            return decrypt($this->attributes[$key]);
        }

        return parent::getAttribute($key);
    }
    public function getDoctor(){
        return $this->belongsTo(User::class,'doctor_id','id');
    }
    public function getDays(){
        return  $this->belongsToMany(Day::class,'schedule_days','schedule_id','day_id');
    }
}
