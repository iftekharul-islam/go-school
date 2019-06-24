@extends('layouts.student-app')

@section('title', 'Course')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-md-12" id="main-container">
            <div class="panel panel-default">
                <div class="breadcrumbs-area">
                    <h3><a href="javascript:history.back()" class="float-left"><h4 style="color: #fea801; font-size: 22px;">Back</h4>
                        </a>&nbsp;&nbsp;Teacher All Sections
                    </h3>
                    <ul style="margin-left: -100px !important;">
                        <li>
                            <a style="margin-left: -43px;" href="{{ url('/home') }}">Home</a>
                        </li>
                        <li>Teacher All Sections</li>
                    </ul>
                </div>
                <div class="panel-body">
                    @if (session('status'))
                        <div class="alert alert-success">
                            {{ session('status') }}
                        </div>
                    @endif
                        <div class="card height-auto false-height">
                            <div class="card-body">
                                <div class="heading-layout1">
                                </div>
                                @if(count($courses) > 0)
                                    @if(count($courses) > 0)
                                        @foreach ($courses as $course)
                                            <div style="font-size: 20px;" class="mt-5"><b>Teacher Code</b> - {{$course->teacher->student_code}} &nbsp;<b>Name</b> - <a href="{{url('user/'.$course->teacher->student_code)}}">{{$course->teacher->name}}</a></div>
                                            @break($loop->first)
                                        @endforeach
                                    @endif
                                    @component('components.new-course-table',['courses'=>$courses, 'exams'=>$exams, 'student'=>false])
                                    @endcomponent
                                @else
                                    No Related Data Found.
                                @endif
                            </div>
                        </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
