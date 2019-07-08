@extends('layouts.student-app')

@section('title', 'Grades')

@section('content')
    <div class="breadcrumbs-area">
        <h3>
            All Classes
        </h3>
        <ul>
            <li> <a href="javascript:history.back()" style="color: #32998f!important;">
                    Back &nbsp;&nbsp;|</a>
                <a style="margin-left: 8px;" href="{{ url('/home') }}">&nbsp;&nbsp;Home</a>
            </li>
            <li>All Classes</li>
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
                                <h5 class="card-header text-left">
                                <i style='font-size:24px;margin-left:-20px;' class='flaticon-books text-teal'></i>
                                &nbsp;Class:
                                    <b> {{$class->class_number}} @if($class->group) </b>
                                    &nbsp; | &nbsp;Group: <b> {{ucfirst($class->group)}} @endif </b></h5>
                                <div class="card-body-customized">
                                    @foreach($class->sections as $sec)
                                        @php
                                            $total_student = $total_student + $sec->users->count();
                                        @endphp
                                    @endforeach
                                    <h5 class="card-title text-muted">Total Section: {{ $class->sections->count() }}</h5>
                                    <h5 class="card-title text-muted">Total Student: {{ $total_student }}</h5>
                                        @if(count($class->sections)>0)
                                        <div class="">
                                            <div class="dropdown">
                                                <button class="button2 button2--white button2--animation float-right mt-5 dropdown-toggle " type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                    Sections
                                                </button>
                                                <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                                    @foreach($class->sections as $section)
                                                        <a class="dropdown-item" href="{{ url('grades/section/'.$section->id) }}">Section: {{$section->section_number}}</a>
                                                    @endforeach
                                                </div>
                                            </div>
                                        </div>
                                            @else
                                            <div class="">
                                                <div>
                                                    <button disabled class="btn disabled text-dark font-bold offset-4 mt-5 " type="button"  aria-expanded="false">
                                                        No Info Available
                                                    </button>
                                                </div>
                                            </div>
                                    @endif
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
