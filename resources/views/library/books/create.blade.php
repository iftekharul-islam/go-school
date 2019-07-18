@extends('layouts.student-app')

@section('title', 'Add New Book')

@section('content')
    <div class="breadcrumbs-area">
        <h3>
            Add New Book
        </h3>
        <ul>
            <li> <a href="javascript:history.back()" style="color: #32998f!important;">
                    Back &nbsp;&nbsp;|</a>
                <a style="margin-left: 8px;" href="{{ url(\Illuminate\Support\Facades\Auth::user()->role.'/home') }}">&nbsp;&nbsp;Home</a>
            </li>
            <li>Add New Book</li>
        </ul>
    </div>

    <div class="card height-auto false-height">
        <div class="card-body">
            @if (session('status'))
                <div class="alert alert-success">
                    {{ session('status') }}
                </div>
            @endif
            <div class="heading-layout1">
                <div class="item-title">
{{--                    <a class="float-left" href="{{ url()->previous() }}"><h4 style="color: #fea801; margin-left: 8px;">Back</h4></a>--}}
{{--                    <h3>Add New Book</h3>--}}
                </div>
            </div>
            <form class="new-added-form justify-content-md-center" action="{{ url(\Illuminate\Support\Facades\Auth::user()->role.'/book/store') }}" method="POST">
                {{ csrf_field() }}
                @include('library.books.form')
                <div class="col-12 form-group mt-5">
                    <button type="submit" class="button button--save float-left"><b>Save</b></button>
                </div>
            </form>
        </div>
    </div>
@endsection
