@extends('layouts.student-app')

@section('title', 'Course')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-md-12" id="main-container">
            <div class="panel panel-default">
                <div class="breadcrumbs-area">
                    <h3>
                        </a>Teacher All Sections
                    </h3>
                    <ul>
                        <li> <a href="javascript:history.back()" style="color: #32998f!important;">
                                Back &nbsp;&nbsp;|</a>
                            <a style="margin-left: 8px;" href="{{ url('/home') }}">&nbsp;&nbsp;Home</a>
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
                                            <div style="font-size: 20px;" class="mt-5"><b><i class="far fa-address-card text-teal"></i>  Teacher Code</b> : {{$course->teacher->student_code}} &nbsp;<i class="fas fa-signature text-teal"></i><b>  Name</b>: <a href="{{url('user/'.$course->teacher->student_code)}}">{{$course->teacher->name}}</a></div>
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
