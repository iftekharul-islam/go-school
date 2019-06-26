@extends('layouts.student-app')

@section('title', 'Grade')

@section('content')
    <div class="breadcrumbs-area">
        <h3><a class="float-left" href="{{ url()->previous() }}"><h4 style="color: #fea801; font-size: 22px;">Back</h4></a>&nbsp;&nbsp;All Grades</h3>
        <ul style="margin-left: -100px !important;">
            <li>
                <a style="margin-left: -43px;" href="{{ url('/home') }}">Home</a>
            </li>
            <li>All Grades</li>
        </ul>
    </div>
    <!-- Breadcubs Area End Here -->
    <!-- Teacher Table Area Start Here -->
    <div class="card height-auto false-height">
        @if(count($classes) > 0)
            <div class="card-body">
                <div class="heading-layout1">
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
                            <div class="card mb-5">
                                <h5 class="card-header" style="text-align: center">Class
                                    : {{$class->class_number}} @if($class->group)
                                        group:{{ucfirst($class->group)}} @endif</h5>
                                <div class="card-body">
                                    @foreach($class->sections as $sec)
                                        @php
                                            $total_student = $total_student + $sec->users->count();
                                        @endphp
                                    @endforeach
                                    <h5 class="card-title">Total Section : <b>{{ $class->sections->count() }}</b></h5>
                                    <h5 class="card-title float-right" style="margin-top: -35px;">Total Student
                                        : {{ $total_student }}</h5>
                                        <a class="btn-secondary btn btn-lg float-right mt-5"
                                           href="{{ url('all-exams-grade/details/'.$class->id) }}"><b>Derails</b></a>
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
