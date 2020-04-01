@extends('layouts.student-app')

@section('title', 'Notices')

@section('content')
    <div class="breadcrumbs-area">
        <h3>
            <i class="fas fa-exclamation-circle"></i>
            {{ __('text.Notices') }}
            <a class="btn btn-lg btn-info float-right font-bold" href="{{ route('inactive.notices')}}">Inactive Notices</a>
        </h3>
        <ul>
            <li>
                <a href="{{ URL::previous() }}" style="color: #32998f!important;">
                    {{ __('text.Back') }} &nbsp;&nbsp;|</a>
                <a style="margin-left: 8px;" href="{{ url(\Illuminate\Support\Facades\Auth::user()->role.'/home') }}">&nbsp;&nbsp;{{ __('text.Home') }}</a>
            </li>
            <li>{{ __('text.Notices') }}</li>
        </ul>
    </div>
     @if (session('status'))
        <div class="alert alert-success">
            {{ session('status') }}
        </div>
    @endif
    <div class="card height-auto false-height">
        <div class="card-body">
            <a href="{{ route('create.notice') }}" class="button button--save mr-2">Create Notice</a>
            @component('components.uploaded-notices-list',['files'=>$files,'upload_type'=>'notice'])@endcomponent
        </div>
    </div>
@endsection
