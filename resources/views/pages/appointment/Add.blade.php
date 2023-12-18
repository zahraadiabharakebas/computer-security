@extends('layouts.app')
@section('content')
    <div class="page-wrapper">
        @if(!(isset($data)))
            <div class="content">
                <div class="row">
                    <div class="col-lg-8 offset-lg-2">
                        <h4 class="page-title">Add Appointment</h4>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-8 offset-lg-2">
                        <form>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label>Patient Name</label>
                                        <select class="select" name="patient">
                                            <option value="">Select</option>
                                            @foreach($patients as $patient)
                                                <option value="{{ $patient->id }}">{{ $patient->name }}</option>
                                            @endforeach
                                        </select>

                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Department</label>
                                        <select class="select" name="department" id="departmentSelect">
                                            <option value="">Select</option>
                                            @foreach($departments as $department)
                                                <option value="{{ $department->id }}">{{ $department->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>

                                <div class="col-md-6" id="doctorsContainer">
                                    <div class="form-group">
                                        <label>Doctor</label>
{{--                                        <select class="select">--}}
{{--                                            <option>Select</option>--}}
{{--                                            <option>Cristina Groves</option>--}}
{{--                                            <option>Marie Wells</option>--}}
{{--                                            <option>Henry Daniels</option>--}}
{{--                                        </select>--}}
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Date</label>
                                        <div class="cal-icon">
                                            <input type="text" class="form-control datetimepicker">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Time</label>
                                        <div class="time-icon">
                                            <input type="text" class="form-control" id="datetimepicker3">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Patient Email</label>
                                        <input class="form-control" type="email">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Patient Phone Number</label>
                                        <input class="form-control" type="text">
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label>Message</label>
                                <textarea cols="30" rows="4" class="form-control"></textarea>
                            </div>
                            <div class="form-group">
                                <label class="display-block">Appointment Status</label>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="status" id="product_active" value="option1" checked>
                                    <label class="form-check-label" for="product_active">
                                        Active
                                    </label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="status" id="product_inactive" value="option2">
                                    <label class="form-check-label" for="product_inactive">
                                        Inactive
                                    </label>
                                </div>
                            </div>
                            <div class="m-t-20 text-center">
                                <button class="btn btn-primary submit-btn">Create Appointment</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        @else
            <div class="content">
                <div class="row">
                    <div class="col-lg-8 offset-lg-2">
                        <h4 class="page-title">Add Appointment</h4>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-8 offset-lg-2">
                        <form method="POST" action="{{ route('schedule.update', ['schedule' => $data]) }}" enctype="multipart/form-data">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Appointment ID</label>
                                        <input class="form-control" type="text" value="APT-0001" readonly="">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Patient Name</label>
                                        <select class="select">
                                            <option>Select</option>
                                            <option>Jennifer Robinson</option>
                                            <option>Terry Baker</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Department</label>
                                        <select class="select">
                                            <option>Select</option>
                                            <option>Dentists</option>
                                            <option>Neurology</option>
                                            <option>Opthalmology</option>
                                            <option>Orthopedics</option>
                                            <option>Cancer Department</option>
                                            <option>ENT Department</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Doctor</label>
                                        <select class="select">
                                            <option>Select</option>
                                            <option>Cristina Groves</option>
                                            <option>Marie Wells</option>
                                            <option>Henry Daniels</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Date</label>
                                        <div class="cal-icon">
                                            <input type="text" class="form-control datetimepicker">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Time</label>
                                        <div class="time-icon">
                                            <input type="text" class="form-control" id="datetimepicker3">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Patient Email</label>
                                        <input class="form-control" type="email">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Patient Phone Number</label>
                                        <input class="form-control" type="text">
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label>Message</label>
                                <textarea cols="30" rows="4" class="form-control"></textarea>
                            </div>
                            <div class="form-group">
                                <label class="display-block">Appointment Status</label>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="status" id="product_active" value="option1" checked>
                                    <label class="form-check-label" for="product_active">
                                        Active
                                    </label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="status" id="product_inactive" value="option2">
                                    <label class="form-check-label" for="product_inactive">
                                        Inactive
                                    </label>
                                </div>
                            </div>
                            <div class="m-t-20 text-center">
                                <button class="btn btn-primary submit-btn">Create Appointment</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        @endif

    </div>
@endsection
@section('customjs')
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <script>
        $(document).ready(function() {
            $('#departmentSelect').on('change', function() {
                var departmentId = $(this).val();
               alert(departmentId)
                $.ajax({
                    url: '/get-doctors/' + departmentId,
                    type: 'GET',
                    success: function(data) {
                        // Display doctors in the specified container
                        displayDoctors(data);
                    },
                    error: function(error) {
                        console.log(error);
                    }
                });
            });
            function displayDoctors(doctors) {
                var doctorsContainer = $('#doctorsContainer');
                doctorsContainer.empty(); // Clear previous content

                if (doctors.length > 0) {
                    // Iterate over the doctors and append them to the container
                    doctors.forEach(function(doctor) {
                        doctorsContainer.append('<p>' + doctor.name + '</p>');
                    });
                } else {
                    doctorsContainer.append('<p>No doctors found for the selected department</p>');
                }
            }
        });
    </script>
@endsection
