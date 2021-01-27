@extends('layouts.student-app')
@section('title','Dashboard')
@section('content')
    <div class="breadcrumbs-area">
        <h3>Dashboard</h3>
        <ul>
            <li>
                <a href="{{ url(\Illuminate\Support\Facades\Auth::user()->role.'/home') }}">Home</a>
            </li>
            <li class="text-capitalize">{{ \Auth::user()->role }} Dashboard</li>
        </ul>
    </div>
    <!-- Breadcubs Area End Here -->
    <div class="false-height">
        <div class="row">
            <!-- Dashboard summery Start Here -->
{{--            <div class="col-12 col-4-xxxl">--}}
{{--                <div class="row">--}}
{{--                    <div class="col-6-xxxl col-lg-3 col-sm-6 col-12">--}}
{{--                        <div class="dashboard-summery-two">--}}
{{--                            <div class="item-icon bg-light-magenta">--}}
{{--                                <i class="flaticon-classmates text-magenta"></i>--}}
{{--                            </div>--}}
{{--                            <div class="item-content">--}}
{{--                                <div class="item-number"><span class="counter" data-num="{{ $totalStudents }}"></span></div>--}}
{{--                                <div class="item-title">Total Students</div>--}}
{{--                            </div>--}}
{{--                        </div>--}}
{{--                    </div>--}}
{{--                    <div class="col-6-xxxl col-lg-3 col-sm-6 col-12">--}}
{{--                        <div class="dashboard-summery-two">--}}
{{--                            <div class="item-icon bg-light-blue">--}}
{{--                                <i class="flaticon-shopping-list text-blue"></i>--}}
{{--                            </div>--}}
{{--                            <div class="item-content">--}}
{{--                                <div class="item-number"><span class="counter" data-num="{{ $exams->count() }}"></span></div>--}}
{{--                                <div class="item-title">Total Exams</div>--}}
{{--                            </div>--}}
{{--                        </div>--}}
{{--                    </div>--}}
{{--                    <div class="col-6-xxxl col-lg-3 col-sm-6 col-12">--}}
{{--                        <div class="dashboard-summery-two">--}}
{{--                            <div class="item-icon bg-light-yellow">--}}
{{--                                <i class="flaticon-maths-class-materials-cross-of-a-pencil-and-a-ruler text-green"></i>--}}
{{--                            </div>--}}
{{--                            <div class="item-content">--}}
{{--                                <div class="item-number"><span class="counter" data-num="{{ $totalClasses }}"></span></div>--}}
{{--                                <div class="item-title">Total Classes</div>--}}
{{--                            </div>--}}
{{--                        </div>--}}
{{--                    </div>--}}
{{--                    <div class="col-6-xxxl col-lg-3 col-sm-6 col-12">--}}
{{--                        <div class="dashboard-summery-two">--}}
{{--                            <div class="item-icon bg-light-red">--}}
{{--                                <i class="flaticon-books text-blue"></i>--}}
{{--                            </div>--}}
{{--                            <div class="item-content">--}}
{{--                                <div class="item-number"><span class="counter" data-num="{{ $totalSections }}"></span></div>--}}
{{--                                <div class="item-title">Total Sections</div>--}}
{{--                            </div>--}}
{{--                        </div>--}}
{{--                    </div>--}}
{{--                </div>--}}
{{--            </div>--}}
            <!-- Dashboard summery End Here -->
            <!-- Notice Board Start Here -->
{{--            <div class="col-lg-6 col-4-xxxl col-xl-6">--}}
{{--                <div class="card dashboard-card-six" style="min-height: 484px !important;">--}}
{{--                    <div class="card-body">--}}
{{--                        <div class="heading-layout1 mg-b-17">--}}
{{--                            <div class="item-title">--}}
{{--                                <h3>Notices</h3>--}}
{{--                            </div>--}}
{{--                        </div>--}}
{{--                        <div class="notice-box-wrap">--}}
{{--                            @foreach($notices as $notice)--}}
{{--                                <div class="notice-list">--}}
{{--                                    <div class="row">--}}
{{--                                        <div class="col-8">--}}
{{--                                            <h6 class="notice-title"><a href="{{ url($notice->file_path) }}">{{ $notice->title }}</a></h6>--}}
{{--                                        </div>--}}
{{--                                        <div class="col-4">--}}
{{--                                            <div class="">{{ date('d-m-Y', strtotime($notice->created_at)) }}</div>--}}
{{--                                        </div>--}}
{{--                                    </div>--}}
{{--                                </div>--}}
{{--                            @endforeach--}}
{{--                        </div>--}}
{{--                    </div>--}}
{{--                </div>--}}
{{--            </div>--}}
            <!-- Notice Board End Here -->
        </div>
    </div>
@endsection
