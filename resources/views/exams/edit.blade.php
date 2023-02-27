@extends('layouts.student-app')
@section('title', 'Add Examination')
@section('content')
    <div class="breadcrumbs-area">
        <h3>
            {{ __('text.edit') }}
        </h3>
        <ul>
            <li> <a class="text-color mr-2" href="{{ URL::previous() }}">
                    {{ __('text.Back') }}</a>|
                <a class="text-color" href="{{ url(current_user()->role.'/home') }}">{{ __('text.Home') }}</a>
            </li>
            <li>{{ __('text.edit') }}</li>
        </ul>
    </div>
    <div class="card height-auto">
        <div class="card-body">
            @if (session('status'))
                <div class="alert alert-success">
                    {{ session('status') }}
                </div>
            @endif

            @component('components.edit-exam-form',['classes'=>$classes,'assigned_classes'=>$already_assigned_classes, 'exam' => $exam])
            @endcomponent
        </div>
    </div>
@endsection
