@extends('layouts.app')
@section('content')
    <div class="page-wrapper">
        <div class="content">
            <div class="row">
                <div class="col-sm-5 col-5">
                    <h4 class="page-title">Patients</h4>
                </div>
                @if(Auth::user()->getRoles->where('key',env('ADMIN'))->first() != null)
                <div class="col-sm-7 col-7 text-right m-b-30">
                    <a href="{{route('patient.create')}}" class="btn btn-primary btn-rounded"><i class="fa fa-plus"></i> Add Patient</a>
                </div>
                    @endif
            </div>
            <div class="row">
                <div class="col-md-12">
                    <div class="table-responsive">

                        <table id="table" class="table table-striped custom-table mb-0 datatable">
                            <thead>
                            <tr>
                                <th>#</th>
                                <th> Name</th>
                                <th> Email</th>
                                <th>Telephone</th>
                                <th> Address</th>
                                <th> Gender</th>
                                <th>Status</th>
                                <th class="text-right">Action</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($patients as $index => $data)
                                <tr id='row{{$data->id}}'>
                                    <td>{{ $index + 1}}</td>
                                    <td>{{$data->name}}</td>
                                    <td>{{$data->email}}</td>
                                    <td>{{$data->telephone}}</td>
                                    <td>{{$data->address}}</td>
                                    <td>{{$data->gender}}</td>
                                    <td>
                                        @if($data->status == 1)
                                            <span class="custom-badge status-green">
                                                Active
                                            </span>
                                        @else
                                            <span class="custom-badge status-red">
                                                Inactive
                                            </span>
                                        @endif
                                    </td>
                                    @if(Auth::user()->getRoles->where('key',env('ADMIN'))->first() != null)
                                    <td class="text-right">
                                        <div class="dropdown dropdown-action">
                                            <a href="#" class="action-icon dropdown-toggle" data-toggle="dropdown" aria-expanded="false"><i class="fa fa-ellipsis-v"></i></a>
                                            <div class="dropdown-menu dropdown-menu-right">
                                                <a class="dropdown-item" href="{{ route('patient.edit', ['patient' => $data->id]) }}"><i class="fa fa-pencil m-r-5"></i> Edit</a>
                                                <a type="button"  class="dropdown-item"   data-toggle="modal" data-target="#delete_patient_{{$data->id}}" data-department-id="{{$data->id}}"><i class="fa fa-trash-o m-r-5"></i> Delete</a>
                                            </div>
                                        </div>
                                    </td>
                                    @endif
                                    @if(Auth::user()->getRoles->where('key',env('PATIENT'))->first() != null)
                                        <td class="text-right">
                                            <div class="dropdown dropdown-action">
                                                <a href="#" class="action-icon dropdown-toggle" data-toggle="dropdown" aria-expanded="false"><i class="fa fa-ellipsis-v"></i></a>
                                                <div class="dropdown-menu dropdown-menu-right">
                                                    <a class="dropdown-item" href="{{ route('patient.edit', ['patient' => $data->id]) }}"><i class="fa fa-pencil m-r-5"></i> Edit</a>
                                                </div>
                                            </div>
                                        </td>
                                    @endif
                                </tr>
                                <div id="delete_patient_{{$data->id}}" class="modal fade delete-modal" role="dialog">
                                    <div class="modal-dialog modal-dialog-centered">
                                        <div class="modal-content">
                                            <div class="modal-body text-center">
                                                <img src="assets/img/sent.png" alt="" width="50" height="46">
                                                <h3>Are you sure want to delete this Department?</h3>
                                                <div class="m-t-20">
                                                    <a href="#" class="btn btn-white" data-dismiss="modal">Close</a>
                                                    <button type="submit" onclick="DeleteAjaxCall('{{$data->id}}', '{{ route('patient.destroy', ['patient' => $data->id]) }}')" class="btn btn-danger">Delete</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
