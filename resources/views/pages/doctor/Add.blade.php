@extends('layouts.app')
@section('content')
    <div class="page-wrapper">
        @if(!(isset($data)))
        <div class="content">
            <div class="row">
                <div class="col-lg-8 offset-lg-2">
                    <h4 class="page-title">Add Doctor</h4>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-8 offset-lg-2">
                    <form method="POST" action="{{ route('doctor.store') }}" enctype="multipart/form-data">
                        @csrf
                        <div class="row">
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label>First Name <span class="text-danger">*</span></label>
                                    <input class="form-control" type="text" name="name" value="{{old('name')}}" required>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label>Email <span class="text-danger">*</span></label>
                                    <input class="form-control" type="email" name="email" value="{{old('email')}}" required>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label>Password <span class="text-danger">*</span></label>
                                    <input class="form-control" type="password" name="password" value="{{old('password')}}" required>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label>Confirm Password <span class="text-danger">*</span></label>
                                    <input class="form-control" type="password" name="rpassword" value="{{old('rpassword')}}" required>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label>Date of Birth</label>
                                    <div class="cal-icon">
                                        <input type="text" class="form-control datetimepicker" name="date_of_birth" value="{{old('date_of_birth')}}">
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group gender-select">
                                    <label class="gen-label">Gender: <span class="text-danger">*</span></label>
                                    <div class="form-check-inline">
                                        <label class="form-check-label">
                                            <input type="radio" name="gender" class="form-check-input" value="male">Male
                                        </label>
                                    </div>
                                    <div class="form-check-inline">
                                        <label class="form-check-label">
                                            <input type="radio" name="gender" class="form-check-input" value="female">Female
                                        </label>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-12">
                                <div class="row">
                                    <div class="col-sm-12">
                                        <div class="form-group">
                                            <label>Address</label>
                                            <input type="text" class="form-control" value="{{old('address')}}" name="address">
                                        </div>
                                    </div>
                            </div>
                            </div>
                            <div class="col-sm-12">
                                <div class="row">
                                    <div class="col-sm-12">
                                        <div class="form-group">
                                            <label>Department</label>
                                            {!! Form::select('department', $departments,null, ['class' => 'select2 form-control', 'placeholder'=>'Select a department','required'=>'true']) !!}
                                        </div>
                                    </div>
                                </div>

                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label>Phone <span class="text-danger">*</span></label>
                                    <input class="form-control" type="text" name="telephone" value="{{old('telephone')}}">
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label>Image <span class="text-danger">*</span></label>
                                    <div class="profile-upload">
                                        <div class="upload-img">
                                            <div class="image-area">
                                                <img data-enlargable id="logoPreview" class="img" width="200px">
                                            </div>
                                        </div>
                                        <div class="upload-input">
                                            <input type="file" name="image" class="form-control" onchange="previewFile(this, 'logoPreview')">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-6">
                            <div class="form-group">
                                <label class="display-block">Status <span class="text-danger">*</span></label>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="status" id="doctor_active" value="active">
                                    <label class="form-check-label" for="doctor_active">
                                        Active
                                    </label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="status" id="doctor_inactive" value="inactive">
                                    <label class="form-check-label" for="doctor_inactive">
                                        Inactive
                                    </label>
                                </div>
                            </div>
                            </div>
                            <div class="col-sm-6">
                            <div class="m-t-20 text-center">
                                <button class="btn btn-primary submit-btn" type="submit">Create Doctor</button>
                            </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        @else
        <div class="content">
                <div class="row">
                    <div class="col-lg-8 offset-lg-2">
                        <h4 class="page-title">Add Doctor</h4>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-8 offset-lg-2">
                        <form method="POST" action="{{ route('doctor.update', ['doctor' => $data]) }}" enctype="multipart/form-data">
                            @csrf
                            @method('PUT')
                            <div class="row">
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label>First Name <span class="text-danger">*</span></label>
                                        <input class="form-control" type="text" name="name" value="{{$data->name}}" required>
                                        @error('name')
                                        <div class="error-msg">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label>Email <span class="text-danger">*</span></label>
                                        <input class="form-control" type="email" name="email" value="{{$data->email}}" required>
                                        @error('email')
                                        <div class="error-msg">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label>Password <span class="text-danger">*</span></label>
                                        <input class="form-control" type="password" name="password" value="{{old('password')}}">
                                        @error('password')
                                        <div class="error-msg">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label>Confirm Password <span class="text-danger">*</span></label>
                                        <input class="form-control" type="password" name="rpassword" value="{{old('rpassword')}}">
                                        @error('rpassword')
                                        <div class="error-msg">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label>Date of Birth</label>
                                        @php
                                        $date = \DateTime::createFromFormat('Y-m-d', $data->date_birth)->format('d/m/Y');
                                        @endphp
                                        <div class="cal-icon">
                                            <input type="text" class="form-control datetimepicker" name="date_of_birth" value="{{$date}}">
                                            @error('date_of_birth')
                                            <div class="error-msg">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group gender-select">
                                        <label class="gen-label">Gender: <span class="text-danger">*</span></label>
                                        <div class="form-check-inline">
                                            <label class="form-check-label">
                                                <input type="radio" name="gender" class="form-check-input" value="male" {{ $data->gender === 'male' ? 'checked' : '' }}>Male
                                                @error('gender')
                                                <div class="error-msg">{{ $message }}</div>
                                                @enderror
                                            </label>
                                        </div>
                                        <div class="form-check-inline">
                                            <label class="form-check-label">
                                                <input type="radio" name="gender" class="form-check-input" value="female" {{ $data->gender === 'female' ? 'checked' : '' }}>Female
                                                @error('gender')
                                                <div class="error-msg">{{ $message }}</div>
                                                @enderror
                                            </label>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-12">
                                    <div class="row">
                                        <div class="col-sm-12">
                                            <div class="form-group">
                                                <label>Address</label>
                                                <input type="text" class="form-control" value="{{$data->address}}" name="address">
                                                @error('address')
                                                <div class="error-msg">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-12">
                                    <div class="row">
                                        <div class="col-sm-12">
                                            <div class="form-group">
                                                <label>Department</label>
                                                {!! Form::select('department', $departments,$data->department_id, ['class' => 'select2 form-control', 'placeholder'=>'Select a department','required'=>'true']) !!}
                                                @error('department')
                                                <div class="error-msg">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>

                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label>Phone <span class="text-danger">*</span></label>
                                        <input class="form-control" type="text" name="telephone" value="{{$data->telephone}}">
                                        @error('telephone')
                                        <div class="error-msg">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label>Image <span class="text-danger">*</span></label>
                                        <div class="profile-upload">
                                            <div class="upload-img">
                                                <div class="image-area">
                                                    <img data-enlargable id="logoPreview" src="{{asset($data->image)}}" class="img" width="200px">
                                                </div>
                                            </div>
                                            <div class="upload-input">
                                                <input type="file" name="image" class="form-control" onchange="previewFile(this, 'logoPreview')">
                                                @error('image')
                                                <div class="error-msg">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label class="display-block">Status <span class="text-danger">*</span></label>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" name="status" id="doctor_active" value="active" {{ $data->is_active === 1 ? 'checked' : '' }}>
                                            <label class="form-check-label" for="doctor_active">
                                                Active
                                            </label>
                                        </div>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" name="status" id="doctor_inactive" value="inactive" {{ $data->is_active === 0 ? 'checked' : '' }}>
                                            <label class="form-check-label" for="doctor_inactive">
                                                Inactive
                                            </label>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="m-t-20 text-center">
                                        <button class="btn btn-primary submit-btn" type="submit">Create Doctor</button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
       @endif
    </div>
@endsection
