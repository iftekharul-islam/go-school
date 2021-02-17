@extends('layouts.student-app')

@section('title', 'Add Event')

@section('content')

    <div class="breadcrumbs-area">
        <h3>
            <i class="fa fa-bullhorn"></i>
            {{ __('text.Events') }}
            <a class="btn btn-lg btn-info float-right font-bold" href="{{ route('inactive.events') }}">Inactive Events</a>
        </h3>
        <ul>
            <li> <a href="{{ URL::previous() }}">
                    {{ __('text.Back') }} |</a>
                <a href="{{ url(current_user()->role.'/home') }}">{{ __('text.Home') }}</a>
            </li>
            <li>{{ __('text.Events') }}</li>
        </ul>
    </div>
    @if (session('status'))
        <div class="alert alert-success">
            {{ session('status') }}
        </div>
    @endif
    <div class="card height-auto false-height">
        <div class="card-body">
            <a href="{{ route('create.event') }}" class="button button--save mr-2">{{ __('text.create_event') }}</a>
            @component('components.uploaded_event_list',['files'=>$files,'upload_type'=>'event'])
            @endcomponent
        </div>
    </div>
@endsection
