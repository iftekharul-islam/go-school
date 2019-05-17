@extends('layouts.student-app')

@section('title', 'Attendance')

@section('content')
    <div class="breadcrumbs-area">
        <h3>Dashboard</h3>
        <ul>
            <li>
                <a href="{{ url('/home') }}">Home</a>
            </li>
            @if(Auth::user()->role != 'student')
                    <li><a href="{{url('school/sections?att=1')}}">Classes &amp; Sections</a></li>
                    <li><a href="{{url()->previous()}}">List of Students</a></li>
                    <li class="active">View Attendance</li>
            @endif
        </ul>
    </div>

    <div class="card height-auto false-height">
        <div class="card-body">
            <div class="heading-layout1">
                <div class="item-title">
                    <h3>Adjust Attendance</h3>
                </div>
            </div>
            @if(count($attendances) > 0)
                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success">
                            {{ session('status') }}
                        </div>
                    @endif

                    @component('components.adjust-attendance',['attendances'=>$attendances,'student_id'=>$student_id])

                    @endcomponent
                </div>
            @else
                No Related Data Found.
            @endif
        </div>
    </div>
@endsection
