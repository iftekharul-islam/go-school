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
                            <li> <a href="{{ URL::previous() }}" style="color: #32998f!important;">
                                    Back &nbsp;&nbsp;|</a>
                                <a style="margin-left: 8px;" href="{{ url(\Illuminate\Support\Facades\Auth::user()->role.'/home') }}">&nbsp;&nbsp;Home</a>
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
                                @if(count($courses) > 0)
                                    @if(count($courses) > 0)
                                        @foreach ($courses as $course)
                                            <div style="font-size: 20px;" class="mt-5"><b><i class="far fa-address-card text-teal"></i>  Teacher Code</b> : {{$course->teacher->student_code}} &nbsp<b>  Name</b>: <a href="{{url('user/'.$course->teacher->student_code)}}">{{$course->teacher->name}}</a></div>
                                            @break($loop->first)
                                        @endforeach
                                    @endif
                                    @component('components.new-course-table',['courses'=>$courses, 'exams'=>$exams, 'student'=>false])
                                    @endcomponent
                                @else
                                    <div class="text-center mt-5">
                                        No Related Data Found.
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
