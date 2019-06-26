@extends('layouts.student-app')
@section('title', 'All Issued Book')
@section('content')
<div class="container-fluid">
    <div class="breadcrumbs-area">
        <h3><a class="float-left" href="{{ url()->previous() }}"><h4 style="color: #fea801; font-size: 22px;">Back</h4>
            </a>&nbsp;&nbsp;Issued Books
        </h3>
        <ul style="margin-left: -100px !important;">
            <li>
                <a style="margin-left: -43px;" href="{{ url('/home') }}">Home</a>
            </li>
            <li>Issued Books</li>
        </ul>
    </div>
    <div class="card height-auto false-height">
        <div class="card-body">
{{--            <div class="heading-layout1">--}}
{{--                <div class="item-title">--}}
{{--                    <a class="float-left" href="{{ url()->previous() }}"><h4 style="color: #fea801; margin-left: 8px;">Back</h4></a>--}}
{{--                    <h3>All Issued Books</h3>--}}
{{--                </div>--}}
{{--            </div>--}}
{{--            <form class="mg-b-20">--}}
{{--                <div class="row gutters-8">--}}
{{--                    <div class="col-3-xxxl col-xl-3 col-lg-3 col-12 form-group">--}}
{{--                        <input type="text" placeholder="Search by ID ..." class="form-control">--}}
{{--                    </div>--}}
{{--                    <div class="col-4-xxxl col-xl-4 col-lg-3 col-12 form-group">--}}
{{--                        <input type="text" placeholder="Search by Name ..." class="form-control">--}}
{{--                    </div>--}}
{{--                    <div class="col-4-xxxl col-xl-3 col-lg-3 col-12 form-group">--}}
{{--                        <input type="text" placeholder="Search by Phone ..." class="form-control">--}}
{{--                    </div>--}}
{{--                    <div class="col-1-xxxl col-xl-2 col-lg-3 col-12 form-group">--}}
{{--                        <button type="submit" class="fw-btn-fill btn-gradient-yellow">SEARCH</button>--}}
{{--                    </div>--}}
{{--                </div>--}}
{{--            </form>--}}
            @if (session('status'))
                <div class="alert alert-success">
                    {{ session('status') }}
                </div>
            @endif

            @component('components.issued-books-list',['books'=>$issued_books])
            @endcomponent
        </div>
    </div>
</div>
@endsection
