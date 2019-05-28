@extends('layouts.student-app')

@section('title', 'Attendance')
@section('content')
    <div class="dashboard-content-one">
        <!-- Breadcubs Area Start Here -->
        <div class="breadcrumbs-area">
            <h3>Student Attendence</h3>
            <ul>
                <li>
                    <a href="{{ url('home') }}">Home</a>
                </li>
                <li>Attendence</li>
            </ul>
        </div>
        <!-- Breadcubs Area End Here -->
        <div class="row">
            <!-- Student Attendence Area Start Here -->
            <div class="col-12" style="min-height: 700px;">
                <div class="card">
                    <div class="card-body">
                        <div class="heading-layout1">
                            <div class="item-title">
                                <h3>Attendance Sheet Of This Term</h3>
                            </div>
                            <div class="dropdown">
                                <a class="dropdown-toggle" href="#" role="button"
                                   data-toggle="dropdown" aria-expanded="false">...</a>

                                <div class="dropdown-menu dropdown-menu-right">
                                    <a class="dropdown-item" href="#"><i class="fas fa-times text-orange-red"></i>Close</a>
                                    <a class="dropdown-item" href="#"><i class="fas fa-cogs text-dark-pastel-green"></i>Edit</a>
                                    <a class="dropdown-item" href="#"><i class="fas fa-redo-alt text-orange-peel"></i>Refresh</a>
                                </div>
                            </div>
                        </div>
                        @if(count($attendances) > 0)
                            <div class="table-responsive">
                                <table class="table bs-table table-striped table-bordered text-nowrap">
                                    <thead>
                                    <tr>
{{--                                        <th class="text-left">Students</th>--}}
                                        <th>Status</th>
                                        <th>Date</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach ($attendances as $attendance)
                                        @if($attendance->present == 1)
                                            <tr class="success">
                                                <td>Present</td>
                                                <td>{{$attendance->created_at->format('M d Y h:i:sa')}}</td>
                                            </tr>
                                        @elseif($attendance->present == 2)
                                            <tr class="warning">
                                                <td>Escaped</td>
                                                <td>{{$attendance->created_at->format('M d Y h:i:sa')}}</td>
                                            </tr>
                                        @else
                                            <tr class="danger">
                                                <td>Absent</td>
                                                <td>{{$attendance->created_at->format('M d Y h:i:sa')}}</td>
                                            </tr>
                                        @endif
                                    @endforeach
                                    </tbody>
                                </table>
                            </div>
                            @include('layouts.student.attendances-table')
                        @else
                            No Related Data Found.
                        @endif
                    </div>
                </div>
            </div>
        </div>
        <!-- Student Attendence Area End Here -->
    </div>
@endsection
