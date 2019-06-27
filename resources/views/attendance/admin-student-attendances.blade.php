@extends('layouts.student-app')

@section('title', 'Attendance')
@section('content')
{{--    <div class="dashboard-content-one">--}}
        <!-- Breadcubs Area Start Here -->
        <div class="breadcrumbs-area">
            <h3>
                </a>Student Attendance
            </h3>
            <ul>
                <li> <a href="javascript:history.back()" style="color: #32998f!important;">
                        Back &nbsp;&nbsp;|</a>
                    <a style="margin-left: 8px;" href="{{ url('/home') }}">&nbsp;&nbsp;Home</a>
                </li>
                <li>Student Attendance</li>
            </ul>
        </div>
        <!-- Breadcubs Area End Here -->
        <div class="row">
            <!-- Student Attendence Area Start Here -->
            <div class="col-12" style="min-height: 700px;">
                <div class="card">
                    <div class="card-body">
                        @if(count($attendances) > 0)
                            <div class="table-responsive">
                                <table class="table bs-table table-striped table-bordered text-nowrap">
                                    <thead>
                                    <tr>
{{--                                        <th class="text-left">Students</th>--}}
                                        <th>Total Class</th>
                                        <th>Total Present</th>
                                        <th>Total Absent</th>
                                        <th>Total Escaped</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <tr>
                                        <td>{{ $total }}</td>
                                        <td>{{ $present }}</td>
                                        <td>{{ $absent }}</td>
                                        <td>{{ $escaped }}</td>
                                    </tr>
{{--                                    @foreach ($attendances as $attendance)--}}
{{--                                        @if($attendance->present == 1)--}}
{{--                                            <tr class="success">--}}
{{--                                                <td>Present</td>--}}
{{--                                                <td>{{$attendance->created_at->format('M d Y h:i:sa')}}</td>--}}
{{--                                            </tr>--}}
{{--                                        @elseif($attendance->present == 2)--}}
{{--                                            <tr class="warning">--}}
{{--                                                <td>Escaped</td>--}}
{{--                                                <td>{{$attendance->created_at->format('M d Y h:i:sa')}}</td>--}}
{{--                                            </tr>--}}
{{--                                        @else--}}
{{--                                            <tr class="danger">--}}
{{--                                                <td>Absent</td>--}}
{{--                                                <td>{{$attendance->created_at->format('M d Y h:i:sa')}}</td>--}}
{{--                                            </tr>--}}
{{--                                        @endif--}}
{{--                                    @endforeach--}}
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
{{--    </div>--}}
@endsection
