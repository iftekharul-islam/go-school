@extends('layouts.student-app')

@section('title', 'Attendance')

@section('content')

    <div class="breadcrumbs-area">
        <h3>Dashboard</h3>
        <ul>
            <li>
                <a href="{{ url('/home') }}">Home</a>
            </li>
            <li>Attendance</li>
            <li><a href="{{url('school/sections?att=1')}}">All Classes &amp; Sections</a></li>
            <li class="active">Attendance</li>
        </ul>
    </div>

    <div class="card height-auto false-height">
        <div class="card-body">
            <div class="heading-layout1">
                <div class="item-title">
                    <a class="float-left" href="{{ url()->previous() }}"><h4 style="color: #fea801; margin-left: 10px;">Back</h4></a>
                    <h3>Take Attendance</h3>
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
