@extends('layouts.app')
@section('content')

<div class="page-wrapper">
    <div class="content">
        <div class="row">
            <div class="col-sm-4 col-3">
                <h4 class="page-title">Doctors</h4>
            </div>
            @if(Auth::user()->getRoles->where('key',env('ADMIN'))->first() != null)
            <div class="col-sm-8 col-9 text-right m-b-20">
                <a href="{{route('doctor.create')}}" class="btn btn-primary btn-rounded float-right"><i class="fa fa-plus"></i> Add Doctor</a>
            </div>
                @endif
        </div>
        @if($errors->any())
            <div class="alert alert-danger">
                    @foreach($errors->all() as $error)
                        {{ $error }}
                    @endforeach
            </div>
        @endif
        <div class="row doctor-grid doctor-container">
        @foreach($doctors as $data)
            <div class="col-md-4 col-sm-4  col-lg-3 doctor-card" id='row{{$data->id}}'>
                <div class="profile-widget">
                    <div class="doctor-img">
                        <a class="avatar" href=""><img alt="{{$data->name}} image" style="" src="{{asset($data->image)}}"></a>
                    </div>
                    @if(Auth::user()->getRoles->where('key',env('ADMIN'))->first() != null)
                    <div class="dropdown profile-action">
                        <a href="#" class="action-icon dropdown-toggle" data-toggle="dropdown" aria-expanded="false"><i class="fa fa-ellipsis-v"></i></a>
                        <div class="dropdown-menu dropdown-menu-right">
                            <a class="dropdown-item" href="{{ route('doctor.edit', ['doctor' => $data->id]) }}"><i class="fa fa-pencil m-r-5"></i> Edit</a>
                            <a type="button"  class="dropdown-item"   data-toggle="modal" data-target="#delete_doctor_{{$data->id}}" data-doctor-id="{{$data->id}}"><i class="fa fa-trash-o m-r-5"></i> Delete</a>
                        </div>
                    </div>
                    @endif
                    @if(Auth::user()->getRoles->where('key',env('DOCTOR'))->first() != null)
                        <div class="dropdown profile-action">
                            <a href="#" class="action-icon dropdown-toggle" data-toggle="dropdown" aria-expanded="false"><i class="fa fa-ellipsis-v"></i></a>
                            <div class="dropdown-menu dropdown-menu-right">
                                <a class="dropdown-item" href="{{ route('doctor.edit', ['doctor' => $data->id]) }}"><i class="fa fa-pencil m-r-5"></i> Edit</a>
                            </div>
                        </div>
                    @endif
                    <h4 class="doctor-name text-ellipsis"><a href="">{{$data->name}}</a></h4>
                    <div class="doc-prof">{{$data->getDepartment->name}}</div>
                    <div class="user-country">
                        <i class="fa fa-map-marker"></i> {{$data->address}}
                    </div>
                </div>
            </div>
                <div id="delete_doctor_{{$data->id}}" class="modal fade delete-modal" role="dialog">
                    <div class="modal-dialog modal-dialog-centered">
                        <div class="modal-content">
                            <div class="modal-body text-center">
                                <img src="assets/img/sent.png" alt="" width="50" height="46">
                                <h3>Are you sure want to delete this Doctor?</h3>
                                <div class="m-t-20">
                                    <a href="#" class="btn btn-white" data-dismiss="modal">Close</a>
                                    <button type="submit" onclick="DeleteAjaxCall('{{$data->id}}', '{{ route('doctor.destroy', ['doctor' => $data->id]) }}')" class="btn btn-danger">Delete</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</div>
@endsection
@section('customjs')
    <script>
        setTimeout(function() {
            document.getElementById('errorAlert').style.display = 'none';
        }, 1000);
    </script>

@endsection
