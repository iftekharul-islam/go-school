@extends('layouts.student-app')
@section('title','Dashboard')
@section('content')
    <div class="dashboard-content-one">
        <div class="breadcrumbs-area">
            <h3>
                All Students Under My Classes
            </h3>
            <ul>
                <li>
                    <a href="{{ URL::previous() }}" style="color: #32998f!important;">Back &nbsp;|</a>
                    <a style="margin-left: 8px;" href="{{ url(\Illuminate\Support\Facades\Auth::user()->role.'/home') }}">&nbsp;&nbsp;Home</a>
                </li>
                <li>My Students</li>
            </ul>
        </div>
        <div class="row">
            <div class="col-lg-12">
                <div class="card dashboard-card-eleven">
                    <div class="card-body">
                        <div class="table-box-wrap">
                            <div class="table-responsive student-table-box">
                                <table class="table data-table-paginate table-bordered display text-wrap" id="myStudent">
                                    <thead>
                                    <tr>
                                        <th>Name</th>
                                        <th>Version</th>
                                        <th>Course Name</th>
                                        <th>Section</th>
                                        <th>Class</th>
                                        <th>Phone</th>
                                        <th>Attendance</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($courses_student as $course)
                                        @if($course['section']['users'] !== null)
                                            @foreach($course['section']['users'] as $user)
                                                <tr>
                                                    <td> <a class="text-teal" href="{{url('user/'.$user->student_code)}}">{{$user->name}}</a></td>
                                                    <td>{{ ucfirst($user['school']['medium']) }}</td>
                                                    <td>{{ $course['course_name'] }}</td>
                                                    <td>{{ ucfirst($user['section']['section_number']) }} </td>
                                                    <td>{{ ucfirst($user['section']['class']['class_number']) }} </td>
                                                    <td>{{ ucfirst($user['phone_number']) }}</td>
                                                    <td><b><a class="btn-link text-teal" role="button" href="{{url('teacher/attendances/0/'.$user->id.'/0')}}">View</a></b></td>
                                                </tr>
                                            @endforeach
                                        @endif
                                    @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
