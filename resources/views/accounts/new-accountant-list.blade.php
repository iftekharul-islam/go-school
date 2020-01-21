@extends('layouts.student-app')

@section('title', 'Accountants')

@section('content')
<div>
    @if(count($users) > 0)
        <div class="">
            @component('components.new-users-list',['users'=>$users])@endcomponent
        </div>
    @else
        <div class="breadcrumbs-area">
            <h3>
                <i class="fas fa-users mr-2 "></i>All Accountants
                <a class="btn btn-lg btn-info float-right font-bold" href="{{ route('inactive.accountants') }}">Inactive Accountants</a>
            </h3>
            <ul>
                <li>
                    <a href="{{ URL::previous() }}" style="color: #32998f!important;">Back &nbsp;|</a>
                    <a style="margin-left: 8px;" href="{{ route(Auth::user()->role. '.home') }}">&nbsp;&nbsp;Home</a>
                </li>
                <li>All Accountants</li>
            </ul>
        </div>
        <div class="card mt-5 false-height">
            <div class="card-body text-center mt-5">
                No Related Data Found.
            </div>
        </div>
    @endif
</div>
@endsection
