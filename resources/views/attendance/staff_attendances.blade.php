@extends('layouts.student-app')

@section('title', 'Staff Attendance Report')
@section('content')
    <div class="breadcrumbs-area">
        <h3>
            {{ __('text.attendance_report') }}
        </h3>
        <ul>
            <li> <a class="text-color mr-2" href="{{ URL::previous() }}">
                    {{ __('text.Back') }}</a>|
                <a class="text-color" href="{{ url(current_user()->role.'/home') }}">{{ __('text.Home') }}</a>
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
