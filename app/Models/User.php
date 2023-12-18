<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use App\Traits\UUID;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Crypt;
class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable,UUID;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'username',
        'name',
        'email',
        'password',
        'address',
        'gender',
        'telephone'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */

    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    public function getRoles(){
        return  $this->belongsToMany(Role::class,'user_roles','user_id','role_id');
    }
    public function hasRole($role)
    {
        if ($this->getRoles()->where('key', $role)->first()) {
            return true;
        }
        return false;
    }

    public function getDoctorAppointments(){
        return $this->hasMany(Appointment::class);
    }

    public function getPatientAppointments(){
        return $this->hasMany(Appointment::class);
    }
    public function getDepartment(){
        return $this->belongsTo(Department::class,'department_id','id');
    }
    public function getSchedule(){
        return $this->hasOne(Schedule::class);
    }

}
