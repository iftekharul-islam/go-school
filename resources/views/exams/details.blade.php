@extends('layouts.student-app')
@section('title', 'Exam Details')
@section('content')
    <div class="breadcrumbs-area">
        <h3>
            Exams Details
        </h3>
        <ul>
            <li> <a href="{{ URL::previous() }}" style="color: #32998f!important;">
                    Back &nbsp;&nbsp;|</a>
                <a style="margin-left: 8px;" href="{{ url(\Illuminate\Support\Facades\Auth::user()->role.'/home') }}">&nbsp;&nbsp;Home</a>
            </li>
            <li> <a style="margin-left: 8px;" href="{{ url('/exams/active') }}">All Active Exams</a></li>
            <li>Exams Details</li>
        </ul>
    </div>

    <div class="card false-height">
        <div class="card-body">
            <table class="table table-bordered table-striped">
                <thead>
                <tr>
                    <th>Class</th>
                    <th>Course Name</th>
                    <th>Course Type</th>
                    <th>Course Time</th>
                    <th>Course Teacher</th>
                </tr>
                </thead>
                <tbody>
                @foreach($courses as $course)
                    @if( $exam_id == $course->exam_id )
                        <tr>
                            <td>{{ $course->class->class_number }}</td>
                            <td>{{ $course->course_name }}</td>
                            <td>{{ $course->course_type }}</td>
                            <td>{{ $course->course_time }}</td>
                            <td>
                                @if ( isset($course->teacher['student_code']) )
                                    <a href="{{url('user/'.$course->teacher['student_code'])}}">{{ $course->teacher->name }}</a>
                                @else
                                    {{ $course->teacher->name }}
                                @endif
                            </td>
                        </tr>
                    @endif
                @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection
