@extends('layouts.student-app')
@section('title', 'All Issued Book')
@section('content')
    <div class="container-fluid">
        <div class="breadcrumbs-area">
            <h3>
                {{ __('text.issued_books') }}
            </h3>
            <ul>
                <li>
                    <a href="{{ URL::previous() }}">
                        {{ __('text.Back') }} &nbsp;&nbsp;|</a>
                    <a href="{{ url(current_user()->role.'/home') }}">&nbsp;&nbsp;{{ __('text.Home') }}</a>
                </li>
                <li>{{ __('text.issued_books') }}</li>
            </ul>
        </div>
        <div class="card height-auto false-height">
            <div class="card-body">
                @if (session('status'))
                    <div class="alert alert-success">
                        {{ session('status') }}
                    </div>
                @endif

                @component('components.issued_books_list',['books'=>$issued_books])
                @endcomponent
            </div>
        </div>
    </div>
@endsection
