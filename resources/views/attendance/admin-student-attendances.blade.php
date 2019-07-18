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
                <li> <a href="javascript:history.back()" style="color: #32998f!important;">
                        Back &nbsp;&nbsp;|</a>
                    <a style="margin-left: 8px;" href="{{ url(\Illuminate\Support\Facades\Auth::user()->role.'/home') }}">&nbsp;&nbsp;Home</a>
                </li>
                <li>Student Attendance</li>
            </ul>
        </div>
        <div class="card">
            <div class="card-body false-height">
                @if(count($attendances) > 0)
                    <div class="row information">
                        <div class="col-3">
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
                        <div class="col-3">
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
                        <div class="col-3">
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
                        <div class="col-3">
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


                    @include('layouts.student.attendances-table')
                @else
                    No Related Data Found.
                @endif
            </div>
        </div>
        <!-- Student Attendence Area End Here -->
{{--    </div>--}}
@endsection
