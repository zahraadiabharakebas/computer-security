@extends('layouts.app')
@section('content')
    <div class="page-wrapper">
        <div class="content">
            <div class="row">
                <div class="col-sm-5 col-5">
                    <h4 class="page-title">Departments</h4>
                </div>
                @if(Auth::user()->getRoles->where('key',env('ADMIN'))->first() != null)
                <div class="col-sm-7 col-7 text-right m-b-30">
                    <a href="{{route('department.create')}}" class="btn btn-primary btn-rounded"><i class="fa fa-plus"></i> Add Department</a>
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
                                <th>Department Name</th>
                                <th>Description with escaped</th>
                                <th>Description with unescaped</th>
                                <th>Status</th>
                                @if(Auth::user()->getRoles->where('key',env('ADMIN'))->first() != null)
                                <th class="text-right">Action</th>
                                    @endif
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($departments as $index => $data)
                                <tr id='row{{$data->id}}'>
                                    <td>{{ $index + 1}}</td>
                                    <td>{{$data->name}}</td>
                                    <td>{{$data->description}}</td>
                                    <td>{!! $data->description !!}</td>
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
                                                <a class="dropdown-item" href="{{ route('department.edit', ['department' => $data->id]) }}"><i class="fa fa-pencil m-r-5"></i> Edit</a>
                                                <a type="button"  class="dropdown-item"   data-toggle="modal" data-target="#delete_department_{{$data->id}}" data-department-id="{{$data->id}}"><i class="fa fa-trash-o m-r-5"></i> Delete</a>
                                            </div>
                                        </div>
                                    </td>
                                    @endif
                                </tr>
                                <div id="delete_department_{{$data->id}}" class="modal fade delete-modal" role="dialog">
                                    <div class="modal-dialog modal-dialog-centered">
                                        <div class="modal-content">
                                            <div class="modal-body text-center">
                                                <img src="assets/img/sent.png" alt="" width="50" height="46">
                                                <h3>Are you sure want to delete this Department?</h3>
                                                <div class="m-t-20">
                                                    <a href="#" class="btn btn-white" data-dismiss="modal">Close</a>
                                                    <button type="submit" onclick="DeleteAjaxCall('{{$data->id}}', '{{ route('department.destroy', ['department' => $data->id]) }}')" class="btn btn-danger">Delete</button>
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
