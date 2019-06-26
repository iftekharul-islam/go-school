@extends('layouts.student-app')

@section('title', 'Add New Book')

@section('content')
    <div class="breadcrumbs-area">
        <h3><a class="float-left" href="{{ url()->previous() }}"><h4 style="color: #fea801; font-size: 22px;">Back</h4>
            </a>&nbsp;&nbsp;Add New Book
        </h3>
        <ul style="margin-left: -100px !important;">
            <li>
                <a style="margin-left: -43px;" href="{{ url('/home') }}">Home</a>
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
            <form class="new-added-form justify-content-md-center" action="{{ route('library.books.store') }}" method="POST">
                {{ csrf_field() }}
                @include('library.books.form')
                <div class="col-12 form-group mt-5">
                    <button type="submit" class="btn-fill-lg btn-gradient-yellow btn-hover-bluedark">Save</button>
                </div>
            </form>
        </div>
    </div>
@endsection
