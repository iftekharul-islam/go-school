@extends('layouts.student-app')

@section('title', 'Manage Schools')

@section('content')
    <div class="breadcrumbs-area">
        <h3>Dashboard</h3>
        <ul>
            <li>
                <a href="{{ url('/home') }}">Home</a>
            </li>
            <li>Manage Academy</li>
        </ul>
    </div>


    <div class="card height-auto false-height">
        <div class="card-body">
            <div class="heading-layout1 mb-5">
                <div class="item-title">
                    <h3>School Information</h3>
                </div>
            </div>

            {{--            <div class="col-12-xxxl col-lg-12">--}}
            <div class="row">
                <!-- Summery Area Start Here -->
                <div class="col-lg-3">
                    <div class="dashboard-summery-one">
                        <div class="row">
                            <div class="col-6">
                                <div class="item-icon bg-light-magenta">
                                    <i class="fas fa-user text-magenta"></i>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="item-content">
                                    <div class="item-title">Total Student</div>
                                    <div class="item-number"><span class="counter"
                                                                   data-num="{{ $total_students }}">{{ $total_students }}</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3">
                    <div class="dashboard-summery-one">
                        <div class="row">
                            <div class="col-6">
                                <div class="item-icon bg-light-blue">
                                    <i class="flaticon-calendar text-blue"></i>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="item-content">
                                    <div class="item-title">Total Classes</div>
                                    <div class="item-number"><span class="counter"
                                                                   data-num="{{ $total_classes }}">{{ $total_classes }}</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3">
                    <div class="dashboard-summery-one">
                        <div class="row">
                            <div class="col-6">
                                <div class="item-icon bg-light-yellow">
                                    <i class="fas fa-user text-orange"></i>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="item-content">
                                    <div class="item-title">Total Teacher</div>
                                    <div class="item-number"><span class="counter"
                                                                   data-num="{{ $total_teacher }}">{{ $total_teacher }}</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3">
                    <div class="dashboard-summery-one">
                        <div class="row">
                            <div class="col-6">
                                <div class="item-icon bg-light-yellow">
                                    <i class="flaticon-calendar text-orange"></i>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="item-content">
                                    <div class="item-title">Total Departments</div>
                                    <div class="item-number"><span class="counter"
                                                                   data-num="{{count($school->departments)}}">{{count($school->departments)}}</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card text-center" style="width: 100%">
                    <div class="card-header">
                        School Details
                    </div>
                    <div class="card-body">
                        <table class="table text-wrap">
                            <thead>
                            <tr>
                                <th>Name</th>
                                <th>Code</th>
                                <th>Theme</th>
                                <th>Established</th>
                                <th>Add Admin</th>
                                <th>View Admins</th>
                                <th></th>
                            </tr>
                            </thead>
                            <tbody>
                            <tr>
                            @if(\Auth::user()->role == 'master' || \Auth::user()->school_id == $school->id)
                                <tr>
                                    @if(\Auth::user()->role == 'master')
                                        <td>
                                            {{$school->name}}
                                        </td>
                                        <td>
                                            {{$school->code}}
                                        </td>
                                        <td>
                                            {{$school->theme}}
                                        </td>
                                        <td>
                                            {{$school->established}}
                                        </td>
                                    @endif
                                    @if(\Auth::user()->role == 'master')
                                        <td>
                                            <a class="btn btn-danger btn-lg" role="button"
                                               href="{{url('register/admin/'.$school->id.'/'.$school->code)}}">
                                                <small>+ Create Admin</small>
                                            </a>
                                        </td>
                                        <td>
                                            <a class="btn btn-success btn-lg" role="button"
                                               href="{{url('school/admin-list/'.$school->id)}}">
                                                <small>View Admins</small>
                                            </a>
                                        </td>
                                    @endif
                                </tr>
                                @endif
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>


{{--                <div class="table-responsive">--}}
{{--                    <h3 style="text-align: center">School Details</h3>--}}
{{--                    <table class="table display data-table text-wrap">--}}
{{--                        <thead>--}}
{{--                        <tr>--}}
{{--                            <th>Name</th>--}}
{{--                            <th>Code</th>--}}
{{--                            <th>About</th>--}}
{{--                            <th>Action</th>--}}
{{--                            <th></th>--}}
{{--                        </tr>--}}
{{--                        </thead>--}}
{{--                        <tbody>--}}
{{--                        <tr>--}}
{{--                        @if(\Auth::user()->role == 'master' || \Auth::user()->school_id == $school->id)--}}
{{--                            <tr>--}}
{{--                                @if(\Auth::user()->role == 'master')--}}
{{--                                    <td>--}}
{{--                                        {{$school->name}}--}}
{{--                                    </td>--}}
{{--                                    <td>--}}
{{--                                        {{$school->code}}--}}
{{--                                    </td>--}}
{{--                                    <td>--}}
{{--                                        {{$school->about}}--}}
{{--                                    </td>--}}
{{--                                @endif--}}
{{--                                @if(\Auth::user()->role == 'master')--}}
{{--                                    <td>--}}
{{--                                        <a class="btn btn-danger btn-lg" role="button"--}}
{{--                                           href="{{url('register/admin/'.$school->id.'/'.$school->code)}}">--}}
{{--                                            <small>+ Create Admin</small>--}}
{{--                                        </a>--}}
{{--                                    </td>--}}
{{--                                    <td>--}}
{{--                                        <a class="btn btn-success btn-lg" role="button"--}}
{{--                                           href="{{url('school/admin-list/'.$school->id)}}">--}}
{{--                                            <small>View Admins</small>--}}
{{--                                        </a>--}}
{{--                                    </td>--}}
{{--                                @endif--}}
{{--                            </tr>--}}
{{--                            @endif--}}
{{--                            </tr>--}}
{{--                        </tbody>--}}
{{--                    </table>--}}
{{--                </div>--}}
            </div>
        </div>
    </div>


    {{--    <div class="card height-auto false-height">--}}
    {{--        <div class="card-body">--}}
    {{--            <div class="heading-layout1">--}}
    {{--                <div class="item-title">--}}
    {{--                    <a class="float-left" href="{{ url()->previous() }}"><h4 style="color: #fea801; margin-left: 10px;">Back</h4></a>--}}
    {{--                    <h3>Manage Departments, Classes, Sections, Student Promotion, Courses</h3>--}}
    {{--                </div>--}}
    {{--            </div>--}}
    {{--            <div class="">--}}
    {{--                <div class="table-responsive">--}}
    {{--                    <div class="table">--}}
    {{--                        <tr>--}}
    {{--                            @if(\Auth::user()->role == 'master')--}}
    {{--                                --}}{{--                        <th>#</th>--}}
    {{--                                <th>Name</th>--}}
    {{--                                <th>Code</th>--}}
    {{--                                <th>About</th>--}}
    {{--                            @endif--}}
    {{--                        </tr>--}}
    {{--                        @if(\Auth::user()->role == 'master' || \Auth::user()->school_id == $school->id)--}}
    {{--                            <tr>--}}
    {{--                                @if(\Auth::user()->role == 'master')--}}
    {{--                                    <td>--}}
    {{--                                        {{$school->name}}--}}
    {{--                                    </td>--}}
    {{--                                    <td>--}}
    {{--                                        {{$school->code}}--}}
    {{--                                    </td>--}}
    {{--                                    <td>--}}
    {{--                                        {{$school->about}}--}}
    {{--                                    </td>--}}
    {{--                                @endif--}}
    {{--                                @if(\Auth::user()->role == 'master')--}}
    {{--                                    <td>--}}
    {{--                                        <a class="btn btn-danger btn-lg" role="button"--}}
    {{--                                           href="{{url('register/admin/'.$school->id.'/'.$school->code)}}">--}}
    {{--                                            <small>+ Create Admin</small>--}}
    {{--                                        </a>--}}
    {{--                                    </td>--}}
    {{--                                    <td>--}}
    {{--                                        <a class="btn btn-success btn-lg" role="button"--}}
    {{--                                           href="{{url('school/admin-list/'.$school->id)}}">--}}
    {{--                                            <small>View Admins</small>--}}
    {{--                                        </a>--}}
    {{--                                    </td>--}}
    {{--                            </tr>--}}
    {{--                        @endif--}}
    {{--                    </div>--}}
    {{--                </div>--}}
    {{--            </div>--}}
    {{--        </div>--}}
    {{--    </div>--}}
@endsection