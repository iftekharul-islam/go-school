@extends('layouts.app')

@section('content')
    <div class="breadcrumbs-area">
        <h3>Dashboard</h3>
        <ul>
            <li>
                <a href="{{ url('/home') }}">Home</a>
            </li>
            <li>Dashboard</li>
        </ul>
    </div>

    <div class="card height-auto false-height">
        <div class="card-body">
            <div class="heading-layout1">
                <div class="item-title">
                    <h3>Create New School</h3>
                </div>
            </div>
            <a class="btn-fill-lg bg-blue-dark btn-hover-yellow btn-block mt-5" href="{{url('create-school')}}" role="button" style="text-align: center">Manage Schools</a>
        </div>
    </div>
{{--<div class="container">--}}
{{--    <div class="row">--}}
{{--        <div class="col-md-12">--}}
{{--            <div class="panel panel-default">--}}
{{--                <div class="page-panel-title">Dashboard</div>--}}

{{--                <div class="panel-body">--}}
{{--                    <a class="btn btn-danger btn-lg btn-block" href="{{url('create-school')}}" role="button">Manage Schools</a>--}}
{{--                </div>--}}
{{--            </div>--}}
{{--        </div>--}}
{{--    </div>--}}
{{--</div>--}}
@endsection
