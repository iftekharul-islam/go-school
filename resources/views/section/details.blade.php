@extends('layouts.student-app')

@section('title', 'Section Details')

@section('content')
    <div class="breadcrumbs-area">
        <h3>
            {{ __('text.section_details') }}
        </h3>
        <ul>
            <li>
                <a href="{{ URL::previous() }}" style="color: #32998f!important;">
                    {{ __('text.Back') }} &nbsp;&nbsp;|</a>
                <a style="margin-left: 8px;" href="{{ url(\Illuminate\Support\Facades\Auth::user()->role.'/home') }}">&nbsp;&nbsp;{{ __('text.Home') }}</a>
            </li>
            @if(isset($_GET['grade']) && $_GET['grade'] == 1)
                <li><a href="{{url('grades/all-exams-grade')}}">{{ __('text.Grades') }}</a></li>
            @else
                <li><a href="{{url('school/sections?course=1')}}">{{ __('text.Section') }}</a></li>
            @endif
            <li class="active">{{ __('text.section_details') }}</li>
        </ul>
    </div>

    @if(count($courses)>0)
        <div class="card">
            <div class="card-body section-details">
                <div class="heading-layout1">
                    <div class="item-title">
                        <div class="row">
                            <div class="col-12">
                                <h3><i class="fas fa-book-open mr-2"></i>Courses</h3>
                            </div>
                        </div>
                        @if(count($courses) > 0)
                            @foreach ($courses as $course)
                                <div class="page-panel-title"><b>Section</b> -   {{$course->section->section_number}} &nbsp;<b>Class</b> -  {{$course->section->class->class_number}}</div>
                                @break($loop->first)
                            @endforeach
                        @endif
                    </div>
                    <div class="table table-responsive mt-4">
                        <table class="table table-bordered display text-nowrap">
                            <thead>
                            <tr>
                                <th>SL.</th>
                                <th>Course Name</th>
                                <th>Room Number</th>
                                <th>Class Time</th>
                                <th>Class Teacher</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($courses as $key=>$course)
                                <tr>
                                    <td>
                                        {{ $key+1 }}
                                    </td>
                                    <td>{{ $course->course_name }}</td>
                                    <td>{{ $course->section['room_number'] }}</td>
                                    <td>{{ $course->course_time }}</td>
                                    <td><a class="text-teal" href="{{ route('user.show', $course->teacher['student_code'])}}">{{$course->teacher['name']}}</a></td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    @endif

    @if(count($students) > 0)
        <div class="card height-auto false-height mt-4">
            <div class="card-body">
                @if(count($students) > 0)
                    <div class="heading-layout1">
                        <div class="item-title">
                            <h3><i class="fas fa-users mr-2"></i>Students</h3>
                        </div>
                    </div>
                    <div class="table-responsive">
                        <table class="table table-bordered table-data-div display text-nowrap">
                            <thead>
                            <tr>
                                <th>SL.</th>
                                <th>Student Code</th>
                                <th>Student Name</th>
                                <th>Email</th>
                                <th>Grade History</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach ($students as $student)
                                <tr>
                                    <td>{{($loop->index+1)}}</td>
                                    <td>{{$student['student_code']}}</td>
                                    <td><a class="text-teal" href="{{ route('user.show', $student['student_code']) }}">{{$student['name']}}</a></td>
                                    <td>{{ $student->email }}</td>
                                    <td><a class="btn-link text-teal" role="button" href="{{ route('student.grades', $student->id) }}">View Grade History</a></td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                @endif
            </div>
        </div>
    @endif
    <div class="card mt-4">
        <div class="card-body">
            <div id="main-container">
                <div class="panel panel-default">
                    <div class="panel-body">
                        @if (session('status'))
                            <div class="alert alert-success">
                                {{ session('status') }}
                            </div>
                        @endif
                        @component('components.file-uploader',['upload_type'=>'routine', 'section_id' => $section_id])
                        @endcomponent
                        @component('components.uploaded-files-list',['files'=>$files,'parent'=>($section_id !== 0)?'section':'','upload_type'=>'routine'])
                        @endcomponent
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
