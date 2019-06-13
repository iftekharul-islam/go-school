@extends('layouts.student-app')

@section('title', 'Course')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-md-12" id="main-container">
            <div class="panel panel-default">
                <div class="breadcrumbs-area">
                    <h3>Dashboard</h3>
                    <ul>
                        <li>
                            <a href="{{ url('/home') }}">Home</a>
                        </li>
                        <li>Teacher all Classes</li>
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
                                    <div class="item-title">
                                        <a class="float-left" href="{{ url()->previous() }}"><h4 style="color: #fea801; margin-left: 10px;">Back</h4></a>
                                        <h3>Courses Taken by Teacher</h3>
                                    </div>
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
