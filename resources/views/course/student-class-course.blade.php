@extends('layouts.student-app')

@section('title', 'Course')

@section('content')

    <div class="dashboard-content-one">
        <!-- Breadcubs Area Start Here -->
        <div class="breadcrumbs-area">
            <h3>Dashboard</h3>
            <ul>
                <li>
                    <a href="{{ url('home') }}">Home</a>
                </li>
                <li>Subjects</li>
            </ul>
        </div>
        <!-- Breadcubs Area End Here -->
        <!-- All Subjects Area Start Here -->
        <div class="row">
            <div class="col-12-xxxl col-12">
                <div class="card height-auto false-height">
                    <div class="card-body">
                        <div class="heading-layout1">
{{--                            @if(Auth::user()->role != 'student')--}}
{{--                                <ol class="breadcrumb" style="margin-top: 3%;">--}}
{{--                                    <li>--}}
{{--                                        <a href="{{url('school/sections?course=1')}}" style="color:#3b80ef;">All Classes &amp; Sections</a>--}}
{{--                                    </li>--}}
{{--                                    &nbsp;&nbsp;--}}
{{--                                    <li class="active">Courses</li>--}}
{{--                                </ol>--}}
{{--                            @endif--}}
                            <div class="item-title">
                                <a class="float-left" href="{{ url()->previous() }}"><h4 style="color: #fea801; margin-left: 10px;">Back</h4></a>
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
    </div>

@endsection
