@extends('layouts.app')
@section('content')
    <div class="page-wrapper">
        @if(!(isset($data)))
            <div class="content">
                <div class="row">
                    <div class="col-lg-8 offset-lg-2">
                        <h4 class="page-title">Add Schedule</h4>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-8 offset-lg-2">
                        <form method="POST" action="{{ route('schedule.store') }}">
                            @csrf
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Doctor Name</label>
                                        {!! Form::select('doctor', $doctors,null, ['class' => 'select2 form-control', 'placeholder'=>'Select a doctor','required'=>'true']) !!}
                                        @error('doctor')
                                        <div class="error-msg">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Available Days</label>
                                        {!! Form::select('day', $days, null, [
                                            'class' => 'select2 form-control',
                                            'placeholder' => 'Select a day',
                                            'required' => 'true',
                                        ]) !!}
                                        @error('day')
                                        <div class="error-msg">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Start Time</label>
                                        <div class="time-icon">
                                            <input type="text" name="start_time" class="form-control" id="datetimepicker3" value="{{old('start_time')}}">
                                        </div>
                                        @error('start_time')
                                        <div class="error-msg">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>End Time</label>
                                        <div class="time-icon">
                                            <input type="text"  name="end_time" class="form-control" id="datetimepicker4" value="{{old('end_time')}}">
                                        </div>
                                        @error('end_time')
                                        <div class="error-msg">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label>Message</label>
                                <textarea cols="30" rows="4" name='message' class="form-control">{{old('message')}}</textarea>
                                @error('message')
                                <div class="error-msg">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label class="display-block">Schedule Status</label>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="status" id="product_active" value="active" checked>
                                    <label class="form-check-label" for="product_active">
                                        Active
                                    </label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="status" id="product_inactive" value="inactive">
                                    <label class="form-check-label" for="product_inactive">
                                        Inactive
                                    </label>
                                </div>
                                @error('status')
                                <div class="error-msg">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="m-t-20 text-center">
                                <button class="btn btn-primary submit-btn">Create Schedule</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        @else
            <div class="content">
                <div class="row">
                    <div class="col-lg-8 offset-lg-2">
                        <h4 class="page-title">Edit Schedule</h4>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-8 offset-lg-2">
                        <form method="POST" action="{{ route('schedule.update', ['schedule' => $data]) }}" enctype="multipart/form-data">
                            @csrf
                            @method('PUT')
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Doctor Name</label>
                                        {!! Form::select('doctor', $doctors,$data->doctor_id, ['class' => 'select2 form-control', 'placeholder'=>'Select a doctor','required'=>'true']) !!}
                                        @error('doctor')
                                        <div class="error-msg">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Available Days</label>
                                        {!! Form::select('day', $days, $data->getDays->pluck('id')->toArray(), [
                                            'class' => 'select2 form-control',
                                            'placeholder' => 'Select a day',
                                            'required' => 'true',
                                        ]) !!}
                                        @error('day')
                                        <div class="error-msg">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Start Time</label>
                                        <div class="time-icon">
                                            <input type="text" name="start_time" class="form-control" id="datetimepicker3" value="{{$data->start_date}}">
                                        </div>
                                        @error('start_time')
                                        <div class="error-msg">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>End Time</label>
                                        <div class="time-icon">
                                            <input type="text"  name="end_time" class="form-control" id="datetimepicker4" value="{{$data->end_date}}">
                                        </div>
                                        @error('end_time')
                                        <div class="error-msg">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label>Message</label>
                                <textarea cols="30" rows="4" name='message' class="form-control">{{$data->message}}</textarea>
                                @error('message')
                                <div class="error-msg">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label class="display-block">Schedule Status</label>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="status" id="product_active" value="active" {{ $data->is_active === 1 ? 'checked' : '' }}>
                                    <label class="form-check-label" for="product_active">
                                        Active
                                    </label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="status" id="product_inactive" value="inactive" {{ $data->is_active === 0 ? 'checked' : '' }}>
                                    <label class="form-check-label" for="product_inactive">
                                        Inactive
                                    </label>
                                </div>
                                @error('status')
                                <div class="error-msg">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="m-t-20 text-center">
                                <button class="btn btn-primary submit-btn">Create Schedule</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        @endif

    </div>
@endsection
