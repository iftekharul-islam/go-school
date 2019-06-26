@extends('layouts.student-app')
@section('title', 'Exam Details')
@section('content')
    <div class="breadcrumbs-area">
        <h3><a href="javascript:history.back()" class="float-left"><h4 style="color: #fea801; font-size: 22px;">Back</h4></a>&nbsp;&nbsp;Exams Details</h3>
        <ul style="margin-left: -100px !important;">
            <li>
                <a style="margin-left: -43px;" href="{{ url('/home') }}">Home</a>
            </li>
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
                    @if($exam_id == $course->exam_id)
                        <tr>
                            <td>{{$course->class->class_number}}</td>
                            <td>{{$course->course_name}}</td>
                            <td>{{$course->course_type}}</td>
                            <td>{{$course->course_time}}</td>
                            <td>
                                <a href="{{url('user/'.$course->teacher->student_code)}}">{{$course->teacher->name}}</a>
                            </td>
                        </tr>
                    @endif
                @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection