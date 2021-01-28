@extends('layouts.student-app')

@section('title', 'Add New Book')

@section('content')
    <div class="breadcrumbs-area">
        <h3>
            <i class='fas fa-book'></i>
            {{ __('text.add_book') }}
        </h3>
        <ul>
            <li>
                <a href="{{ URL::previous() }}" style="color: #32998f!important;">
                    {{ __('text.Back') }} &nbsp;&nbsp;|</a>
                <a style="margin-left: 8px;" href="{{ url(\Illuminate\Support\Facades\Auth::user()->role.'/home') }}">&nbsp;&nbsp;{{ __('text.Home') }}</a>
            </li>
            <li>{{ __('text.add_book') }}</li>
        </ul>
    </div>

    <div class="card height-auto false-height">
        <div class="card-body">
            @if (session('status'))
                <div class="alert alert-success">
                    {{ session('status') }}
                </div>
            @elseif(session('error-status'))
                <div class="alert alert-success">
                    {{ session('error-status') }}
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
            <form class="new-added-form justify-content-md-center aesteric" action="{{ url(\Illuminate\Support\Facades\Auth::user()->role.'/book/store') }}" method="POST" enctype="multipart/form-data">
                {{ csrf_field() }}
                @include('library.books.form')
                <div class="col-12 form-group mt-5">
                    <button type="submit" class="button button--save float-right">{{ __('text.save') }}</button>
                </div>
            </form>
        </div>
    </div>
@endsection
