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
                    <a style="margin-left: 8px;" href="{{ url(\Illuminate\Support\Facades\Auth::user()->role.'/home') }}">&nbsp;&nbsp;Home</a>
                </li>
                <li>Student Attendance</li>
            </ul>
        </div>
        <div class="card">
            <div class="card-body false-height">
                @if(count($attendances) > 0)
                    <div class="table-responsive">
                        <table class="table bs-table  table-bordered text-nowrap">
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
                            </tbody>
                        </table>
                    </div>
                    @include('layouts.student.attendances-table')
                @else
                    No Related Data Found.
                @endif
            </div>
        </div>
        <!-- Student Attendence Area End Here -->
{{--    </div>--}}
@endsection
