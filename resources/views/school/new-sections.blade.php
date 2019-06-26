@extends('layouts.student-app')

@section('title', 'All Classes and Sections')

@section('content')

    <div class="breadcrumbs-area">
        <h3><a href="javascript:history.back()" class="float-left"><h4 style="color: #fea801; font-size: 22px;">Back</h4></a>&nbsp;&nbsp;All Class</h3>
        <ul style="margin-left: -100px !important;">
            <li>
                <a style="margin-left: -43px;" href="{{ url('/home') }}">Home</a>
            </li>
            <li>Student Attendance</li>
        </ul>
    </div>
    <div class="card height-auto false-height">
        <div class="card-body">
            <div class="heading-layout1">
                <div class="item-title">
                </div>
            </div>
            <div class="row">
                @if(count($classes) > 0)
                    @foreach ($classes as $class)
                        <?php $total_student = 0 ?>
                        <div class="col-md-3">
                            <div class="card mb-4">
                                <h5 class="card-header" style="text-align: center">CLASS
                                    : <b>{{$class->class_number}}</b> @if($class->group)
                                        group: <b>{{ucfirst($class->group)}}</b> @endif</h5>
                                <div class="card-body">
                                    @foreach($class->sections as $sec)
                                        @php
                                            $total_student = $total_student + $sec->users->count();
                                        @endphp
                                    @endforeach
                                    <div>
                                        <h5 class="card-title" style="color: #808080;">Total Section : <b>{{ $class->sections->count() }}</b></h5>
                                        <h5 class="card-title float-right" style="margin-top: -35px; color: #808080;">Total Student
                                            : {{ $total_student }}</h5>
                                    </div>
                                    @if(isset($_GET['course']) && $_GET['course'] == 1)
                                        <a class="btn-info btn btn-lg float-right mt-5" href="{{ url('school/sections/details/'.$class->id. '?course=1') }}"><b>Class Details</b></a>
                                    @else
                                       <a class="btn-info btn btn-lg float-right mt-5" href="{{ url('school/sections/details/'.$class->id. '?att=1') }}"><b>Class Details</b></a>
                                    @endif
                                    @if(isset($_GET['course']) && $_GET['course'] == 1)
                                        <div class="col-md-3">
                                            <a role="button" class="btn-info btn btn-lg mt-5"
                                               href="{{url('academic/syllabus/'.$class->id)}}"><b>View Syllabus</b></a>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    @endforeach
                @else
                    <div class="panel-body">
                        No Related Data Found.
                    </div>
                @endif
            </div>
        </div>
    </div>
@endsection