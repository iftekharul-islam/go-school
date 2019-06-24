@extends('layouts.student-app')

@if(count(array($user)) > 0)
  @section('title', $user->name)
@endif

@section('content')
<div class="container-fluid">
    <div class="breadcrumbs-area">
        <h3><a href="javascript:history.back()" class="float-left"><h4 style="color: #fea801; font-size: 22px;">Back</h4></a>&nbsp;&nbsp;@if($user->role === 'teacher')Teacher @else Student @endif Details</h3>
        <ul style="margin-left: -100px !important;">
            <li>
                <a style="margin-left: -43px;" href="{{ url('/home') }}">Home</a>
            </li>
            <li>@if($user->role === 'teacher')Teacher @else Student @endif Details</li>
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
