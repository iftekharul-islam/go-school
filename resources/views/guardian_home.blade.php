@extends('layouts.student-app')
@section('title','Dashboard')
@section('content')
    <div class="breadcrumbs-area">
        <h3>{{ __('text.Dashboard') }}</h3>
    </div>
    <!-- Breadcubs Area End Here -->
    <div class="false-height">
        <div class="row">
            <!-- Dashboard summery Start Here -->
            <div class="col-12 col-4-xxxl">
                <div class="row">
                    <div class="col-6-xxxl col-lg-3 col-sm-6 col-12">
                        <div class="dashboard-summery-two">
                            <div class="item-icon bg-light-teal-transparent">
                                <i class="flaticon-classmates text-light"></i>
                            </div>
                            <div class="item-content">
                                <div class="item-number"><span class="counter"
                                                               data-num="{{ $students->count() }}"></span></div>
                                <div class="item-title">{{ __('text.Total Students') }}</div>
                            </div>
                        </div>
                    </div>
                    <div class="col-6-xxxl col-lg-3 col-sm-6 col-12">
                        <div class="dashboard-summery-two">
                            <div class="item-icon bg-light-teal-transparent">
                                <i class="flaticon-multiple-users-silhouette text-light"></i>
                            </div>
                            <div class="item-content">
                                <div class="item-number"><span class="counter"
                                                               data-num="{{ isset($teachers) ? $teachers->count() : '' }}"></span>
                                </div>
                                <div class="item-title">{{ __('text.total_teacher') }}</div>
                            </div>
                        </div>
                    </div>
                    <div class="col-6-xxxl col-lg-3 col-sm-6 col-12">
                        <div class="dashboard-summery-two">
                            <div class="item-icon bg-light-teal-transparent">
                                <i class="flaticon-maths-class-materials-cross-of-a-pencil-and-a-ruler text-light"></i>
                            </div>
                            <div class="item-content">
                                <div class="item-number"><span class="counter" data-num="{{ $totalClasses }}"></span>
                                </div>
                                <div class="item-title">{{ __('text.Total Classes') }}</div>
                            </div>
                        </div>
                    </div>
                    <div class="col-6-xxxl col-lg-3 col-sm-6 col-12">
                        <div class="dashboard-summery-two">
                            <div class="item-icon bg-light-teal-transparent">
                                <i class="flaticon-books text-light"></i>
                            </div>
                            <div class="item-content">
                                <div class="item-number"><span class="counter" data-num="{{ $totalSections }}"></span>
                                </div>
                                <div class="item-title">{{ __('text.Total Sections') }}</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-6 col-4-xxxl col-xl-6">
                <div class="card dashboard-card-three" style="min-height: 484px !important;">
                    <div class="card-body">
                        <div class="heading-layout1">
                            <div class="item-title">
                                <h3>{{ __('text.Students') }}</h3>
                            </div>
                        </div>
                        <div class="doughnut-chart-wrap">
                            <canvas id="student-doughnut-chart" width="100" height="270"></canvas>
                        </div>
                        <div class="student-report">
                            <div class="student-count pseudo-bg-blue">
                                <h4 class="item-title">{{ __('text.Female Students') }}</h4>
                                <div class="item-number">{{ $female }}</div>
                            </div>
                            <div class="student-count pseudo-bg-yellow">
                                <h4 class="item-title">{{ __('text.Male Students') }}</h4>
                                <div class="item-number">{{ $male }}</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-6 col-4-xxxl col-xl-6">
                <div class="card dashboard-card-six" style="min-height: 484px !important;">
                    <div class="card-body">
                        <div class="heading-layout1 mg-b-17">
                            <div class="item-title">
                                <h3>{{ __('text.Notices') }}</h3>
                            </div>
                        </div>
                        <div class="notice-box-wrap">
                            @foreach($notices as $notice)
                                <div class="notice-list">
                                    <div class="row">
                                        <div class="col-8">
                                            <h6 class="notice-title"><a
                                                    href="{{ route('show.notice', $notice->id) }}">{{ $notice->title }}</a>
                                            </h6>
                                        </div>
                                        <div class="col-4">
                                            <div class="">{{ date('d-m-Y', strtotime($notice->created_at)) }}</div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
@endsection
@push('customjs')
    <script>
        var male = @json($male);
        var female = @json($female);
    </script>
@endpush
