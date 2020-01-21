@extends('layouts.student-app')

@section('title', 'Teachers List')
@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12" id="main-container">
                <div class="panel panel-default">
                    @if(count($users) > 0)
                        <div class="panel-body">
                            @component('components.new-users-list',['users'=>$users])
                            @endcomponent
                        </div>
                    @else
                        <div class="breadcrumbs-area">
                            <ul>
                                <h3>All Teachers</h3>
                                <a class="btn btn-lg btn-info float-right font-bold" href="{{ route('inactive.teachers') }}">Inactive Teachers</a>
                                <li>
                                    <a href="{{ URL::previous() }}" style="color: #32998f!important;">Back &nbsp;|</a>
                                    <a style="margin-left: 8px;" href="{{ route(\Illuminate\Support\Facades\Auth::user()->role. '.home') }}">&nbsp;&nbsp;Home</a>
                                </li>
                                <li>All Teachers</li>
                            </ul>
                        </div>
                        <div class="card mt-5 false-height">
                            <div class="card-body">
                                <div class="card-body-body mt-5 text-center">
                                    No Related Data Found.
                                </div>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection
