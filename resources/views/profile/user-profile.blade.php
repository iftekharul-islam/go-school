@extends('layouts.student-app')

@if(count(array($user)) > 0)
    @section('title', $user->name)
@endif

@section('content')
    <div class="container-fluid">
        <div class="breadcrumbs-area">
            <h3>
                {{ $user->role }} Details
            </h3>
            <ul>
                <li> <a href="javascript:history.back()" style="color: #32998f!important;">
                        Back &nbsp;&nbsp;|</a>
                    <a style="margin-left: 8px;" href="{{ url(\Illuminate\Support\Facades\Auth::user()->role.'/home') }}">&nbsp;&nbsp;Home</a>
                </li>
                <li class="text-capitalize">{{ $user->role }} Details</li>
            </ul>
        </div>
        <!-- Breadcubs Area End Here -->
        <!-- Student Details Area Start Here -->
        <div>
            @if(count(array($user)) > 0)
                <div class="">
                    @if (session('status'))
                        <div class="alert alert-success">
                            {{ session('status') }}
                        </div>
                    @endif
                    <div class="card height-auto false-height">
                        <div class="card-body">
                            @component('components.new-user-profile',['user'=>$user])
                            @endcomponent
                        </div>
                    </div>
                </div>
            @else
                <div class="">
                    No Related Data Found.
                </div>
            @endif
        </div>
    </div>
@endsection
