@extends('layouts.student-app')

@section('title', 'Teachers List')
@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12" id="main-container">
                <div class="panel panel-default">
                    @if(count($users) > 0)
                        <div class="panel-body">
                            @component('components.new-users-list',['users'=>$users, 'classes' => $classes, 'type' => $type])
                            @endcomponent
                        </div>
                    @else
                        <div class="breadcrumbs-area">
                            <ul>
                                <h3>{{ __('text.All Teacher') }}</h3>
                                <a class="btn btn-lg btn-info float-right font-bold" href="{{ route('inactive.teachers') }}">Inactive Teachers</a>
                                <li>
                                    <a href="{{ URL::previous() }}" style="color: #32998f!important;">{{ __('text.Back') }} &nbsp;|</a>
                                    <a style="margin-left: 8px;" href="{{ route(\Illuminate\Support\Facades\Auth::user()->role. '.home') }}">&nbsp;&nbsp;{{ __('text.Home') }}</a>
                                </li>
                                <li>{{ __('text.All Teacher') }}</li>
                            </ul>
                        </div>
                        <div class="card mt-5 false-height">
                            <div class="card-body">
                                <div class="card-body-body mt-5 text-center">
                                    {{ __('text.No Related Data Found') }}
                                </div>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection
