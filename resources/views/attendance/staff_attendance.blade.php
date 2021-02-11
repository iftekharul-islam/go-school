@extends('layouts.student-app')

@section('title', 'Staffs Attendance')

@section('content')
    <div class="breadcrumbs-area">
        <h3>
            {{ __('text.Staff Attendance') }}
        </h3>
        <ul>
            <li>
                <a href="{{ URL::previous() }}" class="mr-2">{{ __('text.Back') }}|</a>
                <a href="{{ route(current_user()->role . '.home') }}">{{ __('text.Home') }}</a>
            </li>
            <li>{{ __('text.Staff Attendance') }}</li>
        </ul>
    </div>
    @if (session('status'))
        <div class="alert alert-success">
            {{ session('status') }}
        </div>
    @endif
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="card height-auto">
        <div class="card-body">
            @if(count($staffs) > 0)
                <div class="heading-layout1">
                    <div class="item-title">
                        <b>{{ __('text.Date') }}</b> - {{ Carbon\Carbon::now()->format('d/m/Y')}}
                    </div>
                </div>
                @include('layouts.teacher.teacher-attendance-form')
            @else
                <div class="card mt-5 false-height">
                    <div class="card-body">
                        <div class="card-body-body mt-5 text-center">
                            {{ __('text.No_related_data_notification') }}
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </div>
@endsection
