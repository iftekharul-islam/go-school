@extends('layouts.student-app')

@section('title', 'Staff Attendance')

@section('content')
    <div class="breadcrumbs-area">
        <h3>
            Staff Attendance
        </h3>
        <ul>
            <li> <a href="javascript:history.back()" style="color: #32998f!important;">
                    Back &nbsp;&nbsp;|</a>
                <a style="margin-left: 8px;" href="{{ url(\Illuminate\Support\Facades\Auth::user()->role.'/home') }}">&nbsp;&nbsp;Home</a>
            </li>
            <li>Staff Attendance</li>
        </ul>
    </div>

    <div class="card height-auto false-height">
        <div class="card-body">
                @if(count($librarians) > 0)
                <div class="card-header-title mt-5 ml-2">
                    <b>Date</b> - {{ Carbon\Carbon::now()->format('d/m/Y')}}
                </div>
                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success">
                            {{ session('status') }}
                        </div>
                    @endif

                    @include('layouts.librarian.librarian-attendance')
                </div>
            @else
                <div class="panel-body">
                    No Related Data Found.
                </div>
            @endif
        </div>
    </div>
@endsection