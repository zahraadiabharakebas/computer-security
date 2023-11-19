<?php

namespace App\Http\Controllers;

use App\Models\Department;
use App\Models\Role;
use App\Models\Doctor;
use App\Models\Schedule;
use App\Models\ScheduleDay;
use App\Models\User;
use App\Models\Day;

use Illuminate\Http\Request;

class ScheduleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $schedule = Schedule::all();
        return view('pages.schedule.List')->with('schedule',$schedule);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $doctor =  Role::where('key', env('doctor'))->first();
        $doctorId = $doctor->id ;
        $doctors = User::whereHas('getRoles', function ($query) use ($doctorId) {
            $query->where('role_id', $doctorId);
        })->pluck('name','id');
        $days = Day::pluck('name','id');
        return view('pages.schedule.Add')
            ->with('doctors',$doctors)
            ->with('days',$days);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {

        $request->validate([

            'start_time' => 'required',
            'end_time' => 'required',
            'status' =>'required',
            'day'=>'required',
            'message'=>'required',
            'doctor'=>'required',
        ]);

        $schedule = new Schedule();
        $schedule->start_date = $request->start_time;
        $schedule->end_date = $request->end_time;
        $schedule->message = $request->message;
        $schedule->is_active = $request->status == 'active'? 1 : 0 ;
        $schedule->doctor_id = $request->doctor;

        $schedule->save();

        $scheduleDay = new ScheduleDay();
        $scheduleDay->schedule_id =$schedule->id;
        $scheduleDay->day_id = $request->day;
        $scheduleDay->save();
        return redirect()->route('schedule.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $doctor =  Role::where('key', env('doctor'))->first();
        $doctorId = $doctor->id ;
        $doctors = User::whereHas('getRoles', function ($query) use ($doctorId) {
            $query->where('role_id', $doctorId);
        })->pluck('name','id');
        $days = Day::pluck('name','id');
        $data = Schedule::find($id);
        return view('pages.schedule.Add')
            ->with('doctors',$doctors)
            ->with('data',$data)
            ->with('days',$days);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([

            'start_time' => 'required',
            'end_time' => 'required',
            'status' =>'required',
            'day'=>'required',
            'message'=>'required',
            'doctor'=>'required',
        ]);

        $schedule = Schedule::find($id);
        $schedule->start_date = $request->start_time;
        $schedule->end_date = $request->end_time;
        $schedule->message = $request->message;
        $schedule->is_active = $request->status == 'active'? 1 : 0 ;
        $schedule->doctor_id = $request->doctor;

        $schedule->save();

        $scheduleDay = new ScheduleDay();
        $scheduleDay->schedule_id =$schedule->id;
        $scheduleDay->day_id = $request->day;
        $scheduleDay->save();
        return redirect()->route('schedule.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $schedule = Schedule::find($id);
        $scheduleDate = ScheduleDay::where('schedule_id',$id);
        if (!$schedule) {
            return response()->json([
                'code' => 404,
                'msg' => 'Schedule not found.'
            ]);
        }
        $scheduleDate->delete();
        $schedule->delete();
        $code = 200;
        $msg = 'The selected doctor has been successfully deleted!';
        return response()->json([
            'code' => $code,
            'msg'=>$msg
        ]);
    }
}
