@extends('layouts.student-app')

@section('title', 'Attendance')

@section('content')

    <div class="breadcrumbs-area">
        <h3><a href="javascript:history.back()" class="float-left"><h4 style="color: #fea801; font-size: 22px;">Back</h4></a>&nbsp;&nbsp;Student Attendance
        </h3>
        <ul style="margin-left: -100px !important;">
            <li>
                <a style="margin-left: -43px;" href="{{ url('/home') }}">Home</a>
            </li>
            <li>Student Attendance</li>
        </ul>
    </div>

    <div class="card height-auto false-height">
        <div class="card-body">
            <div class="heading-layout1">
                <div class="item-title">
                </div>
            </div>
            @if(count($students) > 0)
                @foreach ($students as $student)
                    <div class="card-header-title mt-5 ml-2">
                        <b>Section</b> - {{ $student->section->section_number}} <b>Class</b> - {{$student->section->class->class_number}}
                        <span class="pull-right">Current Date Time: &nbsp;{{ Carbon\Carbon::now()->format('h:i A d/m/Y')}}</span>
                    </div>
                    @break($loop->first)
                @endforeach
                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success">
                            {{ session('status') }}
                        </div>
                    @endif

                    @include('layouts.teacher.attendance-form')
                </div>
            @else
                <div class="panel-body">
                    No Related Data Found.
                </div>
            @endif
        </div>
    </div>
@endsection
