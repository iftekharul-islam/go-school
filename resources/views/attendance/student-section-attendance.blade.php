@extends('layouts.student-app')

@section('title', 'Attendance')

@section('content')

    <div class="breadcrumbs-area">
        <h3>Students Attendance</h3>
        <ul>
            <li> <a href="javascript:history.back()" style="color: #32998f!important;">
                    Back &nbsp;&nbsp;|</a>
                <a style="margin-left: 8px;" href="{{ url(\Illuminate\Support\Facades\Auth::user()->role.'/home') }}">&nbsp;&nbsp;Home</a>
            </li>
            <li>Take Attendance</li>
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
                <div>
                    @if (session('status'))
                        <div class="alert alert-success">
                            {{ session('status') }}
                        </div>

                    @elseif (session('error'))
                            <div class="alert alert-danger">
                                {{ session('error') }}
                            </div>
                    @endif
                    @include('layouts.teacher.attendance-form')
                </div>
            @endif
        </div>
    </div>
@endsection

