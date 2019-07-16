@extends('layouts.student-app')

@section('title', 'Promote Section Students')

@section('content')
    <div class="breadcrumbs-area">
        <h3>
            Promote Students
        </h3>
        <ul>
            <li> <a href="javascript:history.back()" style="color: #32998f!important;">
                    Back &nbsp;&nbsp;|</a>
                <a style="margin-left: 8px;" href="{{ url('/home') }}">&nbsp;&nbsp;Home</a>
            </li>
            <li>Promote Students</li>
        </ul>
    </div>

    <div class="card height-auto false-height">
        <div class="card-body">
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
                    <div class="">
                        No Related Data Found.
                    </div>
            @endif
        </div>
    </div>
@endsection
