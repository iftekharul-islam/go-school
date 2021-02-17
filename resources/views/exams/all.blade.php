@extends('layouts.student-app')
@section('title', 'All Examinations')
@section('content')
    <div class="breadcrumbs-area">
        <h3>
            <i class="fas fa-file-alt"></i>
            {{ __('text.manage_exam') }}
        </h3>
        <ul>
            <li> <a class="text-color mr-2" href="{{ URL::previous() }}">
                    {{ __('text.Back') }}</a>|
                <a class="text-color" href="{{ url(current_user()->role.'/home') }}">{{ __('text.Home') }}</a>
            </li>
            <li>{{ __('text.manage_exam') }}</li>
        </ul>
    </div>

    <div class="card height-auto">
        <div class="card-body">
            @if (session('status'))
                <div class="alert alert-success">
                    {{ session('status') }}
                </div>
            @endif

            @component('components.exams-list',['exams'=>$exams])
            @endcomponent
        </div>
    </div>
@endsection
