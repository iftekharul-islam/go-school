@extends('layouts.student-app')

@if(count(array($user)) > 0)
  @section('title', $user->name)
@endif

@section('content')
<div class="container-fluid">
    <div class="breadcrumbs-area">
        <h3>Students</h3>
        <ul>
            <li>
                <a href="{{ url('home') }}">Home</a>
            </li>
            <li>Student Details</li>
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

                @component('components.new-user-profile',['user'=>$user])
                @endcomponent
            </div>
        @else
            <div class="">
                No Related Data Found.
            </div>
        @endif
    </div>
</div>
@endsection
