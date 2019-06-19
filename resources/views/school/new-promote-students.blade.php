@extends('layouts.student-app')

@section('title', 'Promote Section Students')

@section('content')
    <div class="breadcrumbs-area">
        <h3>Dashboard</h3>
        <ul>
            <li>
                <a href="{{ url('/home') }}">Home</a>
            </li>
            <li>Promote Students</li>
        </ul>
    </div>

    <div class="card height-auto">
        <div class="card-body">
            <div class="heading-layout1">
                <div class="item-title">
                    <a class="float-left" href="{{ url()->previous() }}"><h4 style="color: #fea801; margin-left: 10px;">Back</h4></a>
                    <h3>All Class Schedules</h3>
                </div>
            </div>
            @if(count($students) > 0)
                @foreach ($students as $student)
                    <div class="page-panel-title">
                        <b>Section</b> - {{ $student->section->section_number}} &nbsp; <b>Class</b> - {{$student->section->class->class_number}}
                        <span class="float-right"><b>Current Date Time:</b> &nbsp;{{ Carbon\Carbon::now()->format('h:i A d/m/Y')}}</span>
                    </div>
                    @break($loop->first)
                @endforeach
                    <div class="card-body false-height">
                        @if (session('status'))
                            <div class="alert alert-success">
                                {{ session('status') }}
                            </div>
                        @endif
                        @component('components.promote-students',['students'=>$students,'classes'=>$classes,'section_id'=>$section_id])
                        @endcomponent
                    </div>
                @else
                    <div class="card-body">
                        No Related Data Found.
                    </div>
            @endif
        </div>
    </div>
@endsection
