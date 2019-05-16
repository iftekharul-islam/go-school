@extends('layouts.student-app')
@section('title', 'Issue Book')
@section('content')
    <div class="breadcrumbs-area">
        <h3>Dashboard</h3>
        <ul>
            <li>
                <a href="{{ url('/home') }}">Home</a>
            </li>
            <li>Issue books</li>
        </ul>
    </div>
    <div class="card height-auto">
        <div class="card-body">
            <div class="heading-layout1">
                <div class="item-title">
                    <h3>Issue book</h3>
                </div>
            </div>
            @if (session('status'))
                <div class="alert alert-success">
                    {{ session('status') }}
                </div>
            @endif
            @component('components.book-issue-form',['books'=>$books])
            @endcomponent
        </div>
{{--    <div class="row">--}}
{{--        <div class="col-md-8" id="main-container">--}}
{{--            <div class="panel panel-default">--}}
{{--                <div class="page-panel-title">Issue books</div>--}}

{{--                <div class="panel-body">--}}
{{--                    @if (session('status'))--}}
{{--                        <div class="alert alert-success">--}}
{{--                            {{ session('status') }}--}}
{{--                        </div>--}}
{{--                    @endif--}}

{{--                    @component('components.book-issue-form',['books'=>$books])--}}
{{--                    @endcomponent--}}
{{--                </div>--}}
{{--            </div>--}}
{{--        </div>--}}
{{--    </div>--}}
</div>
@endsection
