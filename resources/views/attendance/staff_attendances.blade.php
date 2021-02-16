@extends('layouts.student-app')

@section('title', 'Staff Attendance Report')
@section('content')
    <div class="breadcrumbs-area">
        <h3>
            {{ __('text.attendance_report') }}
        </h3>
        <ul>
            <li><a href="{{ URL::previous() }}" class="mr-2">
                    {{ __('text.Back') }}|</a>
                <a href="{{ url(current_user()->role.'/home') }}">&nbsp;&nbsp;{{ __('text.Home') }}</a>
            </li>
            <li>{{ __('text.attendance_report') }}</li>
        </ul>
    </div>
    @if(count($attendances) > 0)
        @include('layouts.student.attendances_table')
    @else
        <div class="card mb-3">
            <div class="card-body">
                <h4 class="text-center">{{ __('text.No_related_data_notification') }}</h4>
            </div>
        </div>
    @endif
@endsection
