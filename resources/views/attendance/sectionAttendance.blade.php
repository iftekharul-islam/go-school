@extends('layouts.student-app')

@section('title', 'Attendance')

@section('content')

    <div class="breadcrumbs-area">
        <h3>Attendance
        </h3>
        <ul>
            <li> <a href="javascript:history.back()" style="color: #32998f!important;">
                    Back &nbsp;&nbsp;|</a>
                <a style="margin-left: 8px;" href="{{ url(\Illuminate\Support\Facades\Auth::user()->role.'/home') }}">&nbsp;&nbsp;Home</a>
            </li>
            <li>Attendance</li>
        </ul>
    </div>

    <div class="card height-auto false-height">
        <div class="card-body">
            <div class="heading-layout1">
                <div class="item-title">
                    <h2 class="text-teal"><i class="far fa-chart-bar mr-2"></i>Attendance</h2>
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

<div class="section-students">
    <div class="card height-auto mt-5 false-height">
        <div class="card-body">
            <div class="heading-layout1">
                <div class="item-title ">
                    <h2 class="text-teal text-center">Students</h2>
                </div>
            </div>
            <div class="panel panel-default">
                @if(count($users) > 0)
                    <div class="panel-body">
                        <h4 class="text-teal text-left pl-5">Attendance Summary</h4>
                        <form method="get" action="/admin/attendances-summary">
                            <input type="hidden" name="section_id" value="{{ $student->section->id }}" >
                            <div class="row pl-5">
                                <div class="col-3">
                                    <div class="form-group">
                                        Start Date
                                        <input name="start_date" type="date" class="form-control">
                                    </div>
                                </div>
                                <div class="col-3">
                                    <div class="form-group">
                                        End Date
                                        <input name="end_date" type="date" class="form-control">
                                    </div>
                                </div>
                            </div>
                            <div class="row pl-5">
                                <div class="col-3">
                                    <button type="submit" class="button button--save">Submit</button>
                                </div>
                            </div>
                        </form>
                        @component('components.users',['users'=>$users,'current_page'=>$current_page,'per_page'=>$per_page])
                        @endcomponent
                    </div>
                @else
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

