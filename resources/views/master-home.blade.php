@extends('layouts.student-app')
@section('title','Dashboard')
@section('content')
<div class="breadcrumbs-area">
    <h3>Dashboard</h3>
</div>

<div class="height-auto false-height">


    <div class="row">
        <div class="col-4-xxxl col-lg-3 col-sm-6 col-12">
            <div class="dashboard-summery-two">
                <div class="item-icon bg-light-teal">
                    <i class="fas fa-school text-light"></i>
                </div>
                <div class="item-content">
                    <div class="item-number"><span class="counter" data-num="{{ $school }}">{{ $school }}</span></div>
                    <div class="item-title">Total School</div>
                </div>
            </div>
        </div>
        <div class="col-4-xxxl col-lg-3 col-sm-6 col-12">
            <div class="dashboard-summery-two">
                <div class="item-icon bg-light-teal">
                    <i class="fas fa-users text-light"></i>
                </div>
                <div class="item-content">
                    <div class="item-number"><span class="counter" data-num="{{ $total_student }}">{{ $total_student }}</span></div>
                    <div class="item-title">Total Student</div>
                </div>
            </div>
        </div>
        <div class="col-4-xxxl col-lg-3 col-sm-6 col-12">
            <div class="dashboard-summery-two">
                <div class="item-icon bg-light-teal">
                    <i class="fas fa-user-cog text-light"></i>
                </div>
                <div class="item-content">
                    <div class="item-number"><span class="counter" data-num="{{ $total_admin }}">{{ $total_admin }}</span></div>
                    <div class="item-title">Total Admin</div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection


