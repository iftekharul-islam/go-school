@extends('layouts.student-app')

@section('title', 'Attendance')

@section('content')

    <div class="breadcrumbs-area">
        <h3>Attendance
        </h3>
        <ul>
            <li> <a href="javascript:history.back()" style="color: #32998f!important;">
                    Back &nbsp;&nbsp;|</a>
                <a style="margin-left: 8px;" href="{{ url('/home') }}">&nbsp;&nbsp;Home</a>
            </li>
            <li>Attendance</li>
        </ul>
    </div>

    <div class="card height-auto false-height">
        <div class="card-body">
            <div class="heading-layout1">
                <div class="item-title">
                </div>
            </div>
            @if(count($students) > 0)
                @foreach ($students as $student)
                    <div class="card-header-title mt-5 ml-2">
                        <b>Section</b> - {{ $student->section->section_number}}&nbsp;&nbsp; <b>Class</b> - {{$student->section->class->class_number}} &nbsp;&nbsp;<b>Date</b> - {{ Carbon\Carbon::now()->format('d/m/Y')}}
                    </div>
                    @break($loop->first)
                @endforeach
                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success">
                            {{ session('status') }}
                        </div>
                    @endif

                    @include('layouts.teacher.attendance-form')
                </div>
            @endif
        </div>
    </div>

    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12" id="main-container">
                <div class="panel panel-default">
                    @if(count($users) > 0)
                        <div class="panel-body">
                            @component('components.new-users-list',['users'=>$users,'current_page'=>$current_page,'per_page'=>$per_page])
                            @endcomponent
                        </div>
                    @else
                        <div class="panel-body">
                            No Related Data Found.
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection
