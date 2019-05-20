@extends('layouts.student-app')
@section('title', 'All Examinations')
@section('content')
    <div class="breadcrumbs-area">
        <h3>Dashboard</h3>
        <ul>
            <li>
                <a href="{{ url('/home') }}">Home</a>
            </li>
            <li>All Examinations</li>
        </ul>
    </div>

    <div class="card height-auto">
        <div class="card-body">
            <div class="heading-layout1">
                <div class="item-title">
                    <h3>Add Exam</h3>
                </div>
            </div>
            @if (session('status'))
                <div class="alert alert-success">
                    {{ session('status') }}
                </div>
            @endif

            @component('components.exams-list',['exams'=>$exams])
            @endcomponent
        </div>
    </div>

{{--<div class="container-fluid">--}}
{{--    <div class="row">--}}
{{--        <div class="col-md-2" id="side-navbar">--}}
{{--            @include('layouts.leftside-menubar')--}}
{{--        </div>--}}
{{--        <div class="col-md-10" id="main-container">--}}
{{--            <div class="panel panel-default">--}}
{{--                <div class="page-panel-title">All Examinations</div>--}}

{{--                <div class="panel-body">--}}
{{--                    @if (session('status'))--}}
{{--                        <div class="alert alert-success">--}}
{{--                            {{ session('status') }}--}}
{{--                        </div>--}}
{{--                    @endif--}}

{{--                    @component('components.exams-list',['exams'=>$exams])--}}
{{--                    @endcomponent--}}
{{--                </div>--}}
{{--            </div>--}}
{{--        </div>--}}
{{--    </div>--}}
{{--</div>--}}
@endsection
