@extends('layouts.student-app')
@section('title', 'Issue Book')
@section('content')
    <div class="breadcrumbs-area">
        <h3>
            {{ __('text.issue_book') }}
        </h3>
        <ul>
            <li>
                <a href="{{ URL::previous() }}" style="color: #32998f!important;">
                    {{ __('text.Back') }} &nbsp;&nbsp;|</a>
                <a style="margin-left: 8px;" href="{{ url(\Illuminate\Support\Facades\Auth::user()->role.'/home') }}">&nbsp;&nbsp;{{ __('text.Home') }}</a>
            </li>
            <li>{{ __('text.issue_book') }}</li>
        </ul>
    </div>
    <div class="row">
        <div class="col-12 col-lg-8 col-xl-8 col-md-10">
            <div class="card height-auto false-height">
                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success">
                            {{ session('status') }}
                        </div>
                    @elseif (session('error-status'))
                        <div class="alert alert-danger">
                            {{ session('error-status') }}
                        </div>
                    @endif
                    @component('components.book-issue-form',['books'=>$books, 'classes' => $classes, 'class_number' => $class_number])
                    @endcomponent
                </div>
            </div>
        </div>
    </div>
@endsection
