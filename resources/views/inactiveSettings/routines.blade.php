@extends('layouts.student-app')

@section('title', 'All Inactive Routines')

@section('content')
    <div class="breadcrumbs-area">
        <h3>
            <i class="fa fa-calendar"></i>
            {{ __('text.inactive_routine') }}
        </h3>
        <ul>
            <li> <a class="text-color mr-2" href="{{ URL::previous() }}">
                    {{ __('text.Back') }}</a>|
                <a class="text-color" href="{{ url(current_user()->role.'/home') }}">{{ __('text.Home') }}</a>
            </li>
            <li>{{ __('text.inactive_routine') }}</li>
        </ul>
    </div>
    <div class="card height-auto false-height">
        <div class="card-body">
            @if (session('status'))
                <div class="alert alert-success">
                    {{ session('status') }}
                </div>
            @endif
            @component('components.uploaded-files-list',['files'=>$files,'parent'=>($section_id !== 0)?'section':'','upload_type'=>'routine'])
            @endcomponent
        </div>
    </div>
@endsection
