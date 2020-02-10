@extends('layouts.student-app')
@section('title','Dashboard')
@section('content')
<div class="breadcrumbs-area">
    <h3>{{ __("text.Dashboard") }}</h3>
</div>

<div class="height-auto false-height">
    @if (session('status'))
        <div class="alert alert-success">
            {{ session('status') }}
        </div>
    @endif

    <div class="row">
        <div class="col-4-xxxl col-lg-4 col-sm-6 col-12">
            <div class="dashboard-summery-two">
                <div class="item-icon bg-light-teal">
                    <i class="fas fa-school text-light"></i>
                </div>
                <div class="item-content">
                    <div class="item-number"><span class="counter" data-num="{{ $school }}">{{ $school }}</span></div>
                    <div class="item-title">{{ __("text.schools") }}</div>
                </div>
            </div>
        </div>
        <div class="col-4-xxxl col-lg-4 col-sm-6 col-12">
            <div class="dashboard-summery-two">
                <div class="item-icon bg-light-teal">
                    <i class="fas fa-users text-light"></i>
                </div>
                <div class="item-content">
                    <div class="item-number"><span class="counter" data-num="{{ $total_student }}">{{ $total_student }}</span></div>
                    <div class="item-title">{{ __("text.Total Students") }}</div>
                </div>
            </div>
        </div>
        <div class="col-4-xxxl col-lg-4 col-sm-6 col-12">
            <div class="dashboard-summery-two">
                <div class="item-icon bg-light-teal">
                    <i class="fas fa-user-cog text-light"></i>
                </div>
                <div class="item-content">
                    <div class="item-number"><span class="counter" data-num="{{ $total_admin }}">{{ $total_admin }}</span></div>
                    <div class="item-title">{{ __('text.total_admin') }}</div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection


