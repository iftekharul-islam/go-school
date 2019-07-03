@extends('layouts.student-app')

@section('title', 'All Classes and Sections')

@section('content')

<div class="breadcrumbs-area">
    <h3>
        All Class
    </h3>
    <ul>
        <li> <a href="javascript:history.back()" style="color: #32998f!important;">
                Back &nbsp;&nbsp;|</a>
            <a style="margin-left: 8px;" href="{{ url('/home') }}">&nbsp;&nbsp;Home</a>
        </li>
        <li>All Class</li>
    </ul>
</div>

<div class="card height-auto false-height">
    <div class="card-body">
        <div class="">
            <div class="item-title">
            </div>
        </div>
        <div class="row">
            @if(count($classes) > 0)
            @foreach ($classes as $class)
            <?php $total_student = 0 ?>
            <div class="col-md-3">
                <div class="card mb-4 mt-4">
                    <h5 class="card-header text-muted text-left">
                    <i style='font-size:24px;margin-left:-20px; color:#' class='flaticon-classmates'></i>
    
                    &nbsp;Class
                        <b>{{$class->class_number}}</b> @if($class->group)&nbsp; | &nbsp;
                        Group <b>{{ucfirst($class->group)}}</b> @endif</h5>
                    <div class="card-body-customized">
                        @foreach($class->sections as $sec)
                        @php
                        $total_student = $total_student + $sec->users->count();
                        @endphp
                        @endforeach
                        <div>
                            <h5 class="card-title text-muted text-left">Total Section: {{ $class->sections->count() }}</h5>
                            <h5 class="card-title text-muted text-left mb-4">Total Student: {{ $total_student }}</h5>
                        </div>
                        @if(isset($_GET['course']) && $_GET['course'] == 1)
                        <a class="button button--primary float-right"
                            href="{{ url('school/sections/details/'.$class->id. '?course=1') }}"><b>Class
                                Details</b></a>
                        @else
                        <a class="button button--primary float-right"
                            href="{{ url('school/sections/details/'.$class->id. '?att=1') }}"><b>Details</b></a>
                        @endif
                        @if(isset($_GET['course']) && $_GET['course'] == 1)
                        <div class="col-md-6" style="margin-left:50px;">
                            <a role="button" class="button button--primary float-right"
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
