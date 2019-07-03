@extends('layouts.student-app')

@section('title', 'Grade')

@section('content')
    <div class="breadcrumbs-area">
        <h3>
            All Grades
        </h3>
        <ul>
            <li> <a href="javascript:history.back()" style="color: #32998f!important;">
                    Back &nbsp;&nbsp;|</a>
                <a style="margin-left: 8px;" href="{{ url('/home') }}">&nbsp;&nbsp;Home</a>
            </li>
            <li>All Grades</li>
        </ul>
    </div>
    <!-- Breadcubs Area End Here -->
    <!-- Teacher Table Area Start Here -->
    <div class="card height-auto false-height">
        @if(count($classes) > 0)
            <div class="card-body">
                <div class="">
                    <div class="item-title">
                    </div>
                    @if (session('status'))
                        <div class="alert alert-success">
                            {{ session('status') }}
                        </div>
                    @endif
                </div>
                <div class="row">
                    @foreach ($classes as $class)
                        <?php $total_student = 0 ?>
                        <div class="col-md-3">
                            <div class="card mb-4 mt-4">
                                <h5 class="card-header text-muted text-left">
                                <i style='font-size:24px;margin-left:-20px;' class='flaticon-books'></i>    
                                &nbsp;Class
                                    <b> {{$class->class_number}} @if($class->group) </b>
                                    &nbsp; | &nbsp;Group <b> {{ucfirst($class->group)}} @endif </b></h5>
                                <div class="card-body-customized">
                                    @foreach($class->sections as $sec)
                                        @php
                                            $total_student = $total_student + $sec->users->count();
                                        @endphp
                                    @endforeach
                                    <h5 class="card-title text-muted">Total Section: {{ $class->sections->count() }}</h5>
                                    <h5 class="card-title text-muted">Total Student: {{ $total_student }}</h5>
                                        <a class="button button--primary float-right"
                                           href="{{ url('all-exams-grade/details/'.$class->id) }}"><b>Details</b></a>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        @else
            <div class="card-body">
                No Related Data Found.
            </div>
        @endif
    </div>
@endsection
