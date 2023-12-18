<div class="sidebar" id="sidebar">
    <div class="sidebar-inner slimscroll">
        <div id="sidebar-menu" class="sidebar-menu">
            <ul>
                <li class="menu-title">Main</li>
                @if(Auth::user()->getRoles->where('key',env('ADMIN'))->first() != null)
                <li>
                    <a href="{{route('home')}}"><i class="fa fa-dashboard"></i> <span>Dashboard</span></a>
                </li>
                @endif

                <li>
                    <a href="{{route('doctor.index')}}"><i class="fa fa-user-md"></i> <span>Doctors</span></a>
                </li>

                <li>
                    <a href="{{route('patient.index')}}"><i class="fa fa-wheelchair"></i> <span>Patients</span></a>
                </li>
                <li>
                    <a href="{{route('appointment.index')}}"><i class="fa fa-calendar"></i> <span>Appointments</span></a>
                </li>

                <li>
                    <a href="{{route('schedule.index')}}"><i class="fa fa-calendar-check-o"></i> <span>Doctor Schedule</span></a>
                </li>
                <li>
                    <a href="{{route('department.index')}}"><i class="fa fa-hospital-o"></i> <span>Departments</span></a>
                </li>
                    </ul>
                </li>
            </ul>
        </div>
    </div>
</div>
