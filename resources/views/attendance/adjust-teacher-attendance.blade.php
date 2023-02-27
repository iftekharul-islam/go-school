@extends('layouts.student-app')

@section('title', 'Teacher Attendance')

@section('content')
    <div class="breadcrumbs-area">
        <h3>
            {{ __('text.Adjust Attendance') }}
        </h3>
        <ul>
            <li> <a class="text-color mr-2" href="{{ URL::previous() }}">
                    {{ __('text.Back') }}</a>|
                <a class="text-color" href="{{ url(current_user()->role.'/home') }}">{{ __('text.Home') }}</a>
            </li>
            <li>{{ __('text.Adjust Attendance') }}</li>
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

                    @component('components.adjust-teacher-attendance',['attendances'=>$attendances,'student_id'=>$stuff_id])

                    @endcomponent
                </div>
            @else
                {{ __('text.No_related_data_notification') }}
            @endif
        </div>
    </div>
@endsection
