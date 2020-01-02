@extends('layouts.student-app')

@section('title', 'Teacher Attendance')

@section('content')
    <div class="breadcrumbs-area">
        <h3>
            Adjust Attendance
        </h3>
        <ul>
            <li>
                <a href="{{ URL::previous() }}" style="color: #32998f!important;">Back &nbsp;|</a>
                <a style="margin-left: 8px;" href="{{ url(\Illuminate\Support\Facades\Auth::user()->role.'/home') }}">&nbsp;&nbsp;Home</a>
            </li>
            <li>Adjust Attendance</li>
        </ul>
    </div>

    <div class="card height-auto false-height">
        <div class="card-body">
            @if(count($attendances) > 0)
                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success">
                            {{ session('status') }}
                        </div>
                    @elseif(session('error-status'))
                        <div class="alert alert-danger">
                            {{ session('error-status') }}
                        </div>
                    @endif

                    @component('components.adjust-staff-attendance',['attendances'=>$attendances,'student_id'=>$staff_id])

                    @endcomponent
                </div>
            @else
                <div class="card-body text-center mt-5">
                    No Related Data Found.
                </div>
            @endif
        </div>
    </div>
@endsection
