@extends('layouts.app')
@section('content')
    <div class="page-wrapper">
        <div class="content">
            <div class="row">
                <div class="col-sm-4 col-3">
                    <h4 class="page-title">Schedule</h4>
                </div>
                <div class="col-sm-8 col-9 text-right m-b-20">
                    <a href="{{route('schedule.create')}}" class="btn btn btn-primary btn-rounded float-right"><i class="fa fa-plus"></i> Add Schedule</a>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <div class="table-responsive">
                        <table class="table table-border table-striped custom-table mb-0">
                            <thead>
                            <tr>
                                <th>Doctor Name</th>
                                <th>Department</th>
                                <th>Available Days</th>
                                <th>Available Time</th>
                                <th>Status</th>
                                @if(Auth::user()->getRoles->where('key',env('ADMIN'))->first() != null)
                                <th class="text-right">Action</th>
                                    @endif
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($schedule as $data)
                            <tr>
                                <td><img width="28" height="28" src="{{asset($data->getDoctor->image)}}" class="rounded-circle m-r-5" alt="">
                                    {{$data->getDoctor->name}}</td>
                                <td>{{$data->getDoctor->getDepartment->name}}</td>
                                <td>
                                @foreach($data->getDays as $day)
                                    {{$day->name}}
                                @endforeach
                                </td>
                                <td>{{$data->start_date}} - {{$data->end_date}}</td>
                                <td>
                                    @if($data->is_active === 1)
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
                                            <a class="dropdown-item" href="{{ route('schedule.edit', ['schedule' => $data->id]) }}"><i class="fa fa-pencil m-r-5"></i> Edit</a>
                                            <a type="button"  class="dropdown-item"   data-toggle="modal" data-target="#delete_schedule_{{$data->id}}" data-schedule-id="{{$data->id}}"><i class="fa fa-trash-o m-r-5"></i> Delete</a>
                                        </div>
                                    </div>
                                </td>
                                    @endif
                            </tr>
                            <div id="delete_schedule_{{$data->id}}" class="modal fade delete-modal" role="dialog">
                                <div class="modal-dialog modal-dialog-centered">
                                    <div class="modal-content">
                                        <div class="modal-body text-center">
                                            <img src="assets/img/sent.png" alt="" width="50" height="46">
                                            <h3>Are you sure want to delete this schedule?</h3>
                                            <div class="m-t-20">
                                                <a href="#" class="btn btn-white" data-dismiss="modal">Close</a>
                                                <button type="submit" onclick="DeleteAjaxCall('{{$data->id}}', '{{ route('schedule.destroy', ['schedule' => $data->id]) }}')" class="btn btn-danger">Delete</button>
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
