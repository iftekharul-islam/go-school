@extends('layouts.app')

@if(count(array($user)) > 0)
    @section('title', $user->name)
@endif

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-2" id="side-navbar">
                @include('layouts.leftside-menubar')
            </div>
            <div class="col-md-10" id="main-container">
                <div class="panel panel-default">
                    @if(count(array($user)) > 0)
                        <div class="panel-body">
                            @if (session('status'))
                                <div class="alert alert-success">
                                    {{ session('status') }}
                                </div>
                            @endif

                            @component('components.user-profile',['user'=>$user])
                            @endcomponent
                        </div>
                    @else
                        <div class="card mt-5 false-height">
                            <div class="card-body">
                                <div class="card-body-body mt-5 text-center">
                                    {{ __('text.No_related_data_notification') }}
                                </div>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection
