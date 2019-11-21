@extends('layouts.student-app')

@section('title', 'Attendance')

@section('content')
    <div class="breadcrumbs-area">
        <h3>
            Student Attendance
        </h3>
        <ul>
            <li> <a href="javascript:history.back()" style="color: #32998f!important;">
                    Back &nbsp;&nbsp;|</a>
                <a style="margin-left: 8px;" href="{{ url(\Illuminate\Support\Facades\Auth::user()->role.'/home') }}">&nbsp;&nbsp;Home</a>
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
                        <b>Section</b> - {{ $student->section->section_number}}&nbsp;&nbsp; <b>Class</b> - {{$student->section->class->class_number}} &nbsp;&nbsp;<b>Date</b> - {{ Carbon\Carbon::now()->format('d/m/Y')}}
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
                <div class="card mt-5 false-height">
                    <div class="card-body">
                        <div class="card-body-body mt-5 text-center">
                            No Related Data Found.
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </div>
@endsection
