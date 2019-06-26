@extends('layouts.student-app')

@section('title', 'Attendance')

@section('content')
    <div class="breadcrumbs-area">
        <h3><a href="javascript:history.back()" class="float-left"><h4 style="color: #fea801; font-size: 22px;">Back</h4></a>&nbsp;&nbsp;Adjust Attendance
        </h3>
        <ul style="margin-left: -100px !important;">
            <li>
                <a style="margin-left: -43px;" href="{{ url('/home') }}">Home</a>
            </li>
            <li>Adjust Attendance</li>
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
