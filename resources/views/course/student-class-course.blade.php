@extends('layouts.student-app')

@section('title', 'Course')

@section('content')

    {{--    <div class="dashboard-content-one">--}}
    <!-- Breadcubs Area Start Here -->
    <div class="breadcrumbs-area">
        <h3>
            </a>Student Courses
        </h3>
        <ul>
            <li> <a href="javascript:history.back()" style="color: #32998f!important;">
                    Back &nbsp;&nbsp;|</a>
                <a style="margin-left: 8px;" href="{{ url(\Illuminate\Support\Facades\Auth::user()->role.'/home') }}">&nbsp;&nbsp;Home</a>
            </li>
            <li>Student Courses</li>
        </ul>
    </div>
    <!-- Breadcubs Area End Here -->
    <!-- All Subjects Area Start Here -->
    <div class="row">
        <div class="col-12-xxxl col-12">
            <div class="card height-auto false-height">
                <div class="card-body">
                    <div class="heading-layout1">
                        <div class="item-title">
                            <h3>My Courses</h3>
                            @if(count($courses) > 0)
                                @foreach ($courses as $course)
                                    <div class="page-panel-title" style="text-align: center"><b>Section</b> -   {{$course->section->section_number}} &nbsp;<b>Class</b> -  {{$course->section->class->class_number}}</div>
                                    @break($loop->first)
                                @endforeach
                            @endif
                        </div>
                    </div>
                    <div class="table-responsive">
                        @if(count($courses) > 0)
                            <div>
                                @if (session('status'))
                                    <div class="alert alert-success">
                                        {{ session('status') }}
                                    </div>
                                @endif
                                @component('components.student-course-table',['courses'=>$courses, 'exams'=>$exams, 'student'=>(Auth::user()->role == 'student')?true:false])
                                @endcomponent
                            </div>
                        @else
                            <div class="panel-body">
                                No Related Data Found.
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- All Subjects Area End Here -->
    {{--    </div>--}}

@endsection
