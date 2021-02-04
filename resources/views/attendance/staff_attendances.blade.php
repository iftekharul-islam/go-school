@extends('layouts.student-app')

@section('title', 'Staff Attendance Report')
@section('content')
    <div class="breadcrumbs-area">
        <h3>
            {{ __('text.attendance_report') }}
        </h3>
        <ul>
            <li><a href="{{ URL::previous() }}">
                    {{ __('text.Back') }} &nbsp;&nbsp;|</a>
                <a href="{{ url(current_user()->role.'/home') }}">&nbsp;&nbsp;{{ __('text.Home') }}</a>
            </li>
            <li>{{ __('text.attendance_report') }}</li>
        </ul>
    </div>
    @if(count($attendances) > 0)
        @include('layouts.student.attendances_table')
    @else
        <h4 class="text-center">{{ __('text.No Related Data Found') }}</h4>
    @endif
@endsection
