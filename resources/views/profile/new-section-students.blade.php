@extends('layouts.student-app')

@section('title', 'Course Students')

@section('content')
    <div class="breadcrumbs-area">
        <h3>
            Section Students
        </h3>
        <ul>
            <li> <a href="javascript:history.back()" style="color: #32998f!important;">
                    Back &nbsp;&nbsp;|</a>
                <a style="margin-left: 8px;" href="{{ url('/home') }}">&nbsp;&nbsp;Home</a>
            </li>
            @if(isset($_GET['grade']) && $_GET['grade'] == 1)
                <li><a href="{{url('grades/all-exams-grade')}}">Grades</a></li>
            @else
                <li><a href="{{url('school/sections?course=1')}}">Section</a></li>
            @endif
            <li class="active">Students</li>
        </ul>
    </div>
    @if(count($students) > 0)
        <div class="card height-auto false-height">
            <div class="card-body">
                <div class="heading-layout1">
                    <div class="item-title">
{{--                        <h3>All Section Student</h3>--}}
                    </div>
                </div>
                <div class="table-responsive">
                    <table class="table display data-table text-nowrap">
                        <thead>
                        <tr>
                            <th>Sl.</th>
                            <th>Student Code</th>
                            <th>Student Name</th>
                            <th>Grade History</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach ($students as $student)
                            <tr>
                                <td>{{($loop->index+1)}}</td>
                                <td>{{$student->student_code}}</td>
                                <td><a class="text-teal" href="{{url('user/'.$student->student_code)}}">{{$student->name}}</a></td>
                                <td><a class="button button--text font-weight-bold" role="button" href="{{url('grades/'.$student->id)}}">View Grade History</a></td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    @endif
@endsection