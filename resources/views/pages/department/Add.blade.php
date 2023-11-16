@extends('layouts.app')
@section('content')
    <div class="page-wrapper">
        @if(!(isset($data)))
        <div class="content">
            <div class="row">
                <div class="col-lg-8 offset-lg-2">
                    <h4 class="page-title">Add Department</h4>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-8 offset-lg-2">
                    <form method="POST" action="{{ route('department.store') }}">
                        @csrf
                        <div class="form-group">
                            <label>Department Name</label>
                            <input class="form-control" name="department_name" type="text" value="{{old('department_name')}}" required>
                        </div>
                        <div class="form-group">
                            <label>Description</label>
                            <textarea cols="30" rows="4" class="form-control" name="department_description" required>{{old('department_description')}}</textarea>
                        </div>
                        <div class="form-group">
                            <label class="display-block">Department Status</label>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="status" id="product_active" value="active" required>
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
                        </div>
                        <div class="m-t-20 text-center">
                            <button class="btn btn-primary submit-btn" type="submit">Save Department</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        @else
        <div class="content">
                <div class="row">
                    <div class="col-lg-8 offset-lg-2">
                        <h4 class="page-title">Edit Department</h4>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-8 offset-lg-2">
                        <form method="POST" action="{{ route('department.update', ['department' => $data]) }}" enctype="multipart/form-data">
                            @csrf
                            @method('PUT')
                            <div class="form-group">
                                <label>Department Name</label>
                                <input class="form-control" name="department_name" type="text" value="{{$data->name}}" required>
                            </div>
                            <div class="form-group">
                                <label>Description</label>
                                <textarea cols="30" rows="4" class="form-control" name="department_description" required>{{$data->description}}</textarea>
                            </div>
                            <div class="form-group">
                                <label class="display-block">Department Status</label>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="status" id="product_active" value="active" {{ $data->status === 1 ? 'checked' : '' }}>
                                    <label class="form-check-label" for="product_active">
                                        Active
                                    </label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="status" id="product_inactive" value="inactive" {{ $data->status === 0 ? 'checked' : '' }}>
                                    <label class="form-check-label" for="product_inactive">
                                        Inactive
                                    </label>
                                </div>
                            </div>
                            <div class="m-t-20 text-center">
                                <button class="btn btn-primary submit-btn" type="submit">Save Department</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        @endif

    </div>
@endsection
