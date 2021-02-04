@extends('layouts.student-app')

@section('title', 'Course')

@section('content')
    <div class="breadcrumbs-area">
        <h3>{{ __('text.student_course') }}</h3>
        <ul>
            <li> <a href="{{ URL::previous() }}">
                    {{ __('text.Back') }} &nbsp;&nbsp;|</a>
                <a href="{{ url(current_user()->role.'/home') }}">&nbsp;&nbsp;{{ __('text.Home') }}</a>
            </li>
            <li>{{ __('text.student_course') }}</li>
        </ul>
    </div>

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
                                @component('components.student_course_table',['courses'=>$courses, 'exams'=>$exams, 'student'=>(Auth::user()->role == 'student')?true:false])
                                @endcomponent
                            </div>
                        @else
                            <div class="card mt-5 false-height">
                                <div class="card-body">
                                    <div class="card-body-body mt-5 text-center">
                                        {{ __('text.No_related_data_notification') }}
                                    </div>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
