@extends('layouts.student-app')

@section('title', 'Attendance')
@section('content')
{{--    <div class="dashboard-content-one">--}}
        <!-- Breadcubs Area Start Here -->
        <div class="breadcrumbs-area">
            <h3>
                </a>Student Attendance
            </h3>
            <ul>
                <li>
                    <a href="{{ URL::previous() }}" style="color: #32998f!important;">Back &nbsp;|</a>
                    <a style="margin-left: 8px;" href="{{ url(\Illuminate\Support\Facades\Auth::user()->role.'/home') }}">&nbsp;&nbsp;Home</a>
                </li>
                <li>Student Attendance</li>
            </ul>
        </div>
        @if(count($attendances) > 0)
            <div class="card height-auto mb-5">
                <div class="card-body">
                    @foreach($attendances as $att)
                        <div class="row">
                            <div class="col-lg-3 col-xs-6 col-sm-6">
                                <h5 class="text-teal"><strong><i class="fas fa-id-card-alt mr-2"></i>Name: </strong>{{ $att->student->name }}</h5>
                            </div>
                            <div class="col-lg-3 col-xs-6 col-sm-6">
                                <h5 class="text-teal"><strong><i class="fas fa-sliders-h mr-2"></i>Student ID: </strong>{{ $att->student->student_code }}</h5>
                            </div>
                            <div class="col-lg-3 col-xs-6 col-sm-6">
                                <h5 class="text-teal"><strong> <i class="fas fa-building mr-2"></i>Class: </strong>{{ $att->section->class->class_number }}</h5>
                            </div>
                            <div class="col-lg-3 col-xs-6 col-sm-6">
                                <h5 class="text-teal"><strong><i class="fas fa-sliders-h mr-2"></i>Section: </strong>{{ $att->section->section_number }}</h5>
                            </div>
                        </div>
                        @break
                    @endforeach
                </div>
            </div>
            <div class="row information">
                <div class="col-6 col-lg-3 col-xs-6 col-sm-6">
                    <div class="dashboard-summery-two">
                        <div class="item-icon bg-light-blue-transparent">
                            <i class="fas fa-building text-light"></i>
                        </div>
                        <div class="item-content">
                            <div class="item-number"><span class="counter" data-num="{{ $total }}"></span></div>
                            <div class="item-title">Total Classes</div>
                        </div>
                    </div>
                </div>
                <div class="col-6 col-lg-3 col-sm-6 col-xs-6">
                    <div class="dashboard-summery-two">
                        <div class="item-icon bg-light-teal-transparent">
                            <i class="fas fa-clipboard-check text-light"></i>
                        </div>
                        <div class="item-content">
                            <div class="item-number"><span class="counter" data-num="{{ $present }}"></span></div>
                            <div class="item-title">Total Attends</div>
                        </div>
                    </div>
                </div>
                <div class="col-6 col-lg-3 col-sm-6 col-xs-6">
                    <div class="dashboard-summery-two">
                        <div class="item-icon bg-light-red-transparent">
                            <i class="far fa-times-circle text-light"></i>
                        </div>
                        <div class="item-content">
                            <div class="item-number"><span class="counter" data-num="{{ $absent }}"></span></div>
                            <div class="item-title">Total Absent</div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-sm-6 col-6">
                    <div class="dashboard-summery-two">
                        <div class="item-icon bg-light-yellow-transparent">
                            <i class="fas fa-sign-out-alt text-light"></i>
                        </div>
                        <div class="item-content">
                            <div class="item-number"><span class="counter" data-num="{{ $escaped }}"></span></div>
                            <div class="item-title">Total Escaped</div>
                        </div>
                    </div>
                </div>
            </div>
        @endif
        <div class="card">
            <div class="card-body false-height">
                @if(count($attendances) > 0)
                    @include('layouts.student.attendances-table')
                @else
                    <h4 class="text-center">No Attendance Found.</h4>
                @endif
            </div>
        </div>
        <!-- Student Attendence Area End Here -->
{{--    </div>--}}
@endsection
