@extends('layouts.student-app')
@section('title','Dashboard')
@section('content')
    <!-- Breadcubs Area Start Here -->
    <div class="breadcrumbs-area">
        <h3>Dashboard</h3>
        <ul>
            <li>
                <a href="{{ url(\Illuminate\Support\Facades\Auth::user()->role.'/home') }}">Home</a>
            </li>
            <li>Account Suspended</li>
        </ul>
    </div>
    <!-- Breadcubs Area End Here -->

    <div class="row">
        <div class="col-12 col-md-12 col-lg-12">
            <div class="card mb-4 dashboard-card-ten">
                <div class="card-body profile-info">
                    <div class="heading-layout1 mb-5">
                        <div class="item-title text-center">
                            <h3>Insitution's account Suspended !</h3>
                            <h6>Please contact <a href="https://shoroborno.com/">Shoroborno Team</a></h6>
                        </div>
                    </div>
                </div>
            </div>
        </div>
@endsection
