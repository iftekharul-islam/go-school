@extends('layouts.student-app')

@section('title', 'Grades')

@section('content')
    <div class="breadcrumbs-area">
        <h3>
            <i class="fas fa-poll-h"></i>
            All Grades
        </h3>
        <ul>
            <li><a href="javascript:history.back()" style="color: #32998f!important;">
                    Back &nbsp;&nbsp;|</a>
                <a style="margin-left: 8px;" href="{{ url(\Illuminate\Support\Facades\Auth::user()->role.'/home') }}">&nbsp;&nbsp;Home</a>
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
                        <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6 col-xl-3">
                            <div class="card-sub mb-5">
                                <h5 class="card-sub-header text-muted text-left">
                                    <i style='font-size:24px;margin-left:-20px;' class='flaticon-books text-teal'></i>
                                    &nbspClass
                                    <b> {{$class->class_number}} @if($class->group) </b>
                                    &nbsp; | &nbsp;Group: <b> {{ucfirst($class->group)}} @endif </b></h5>
                                <div class="card-body-customized">
                                    @foreach($class->sections as $sec)
                                        @php
                                            $total_student = $total_student + $sec->users->count();
                                        @endphp
                                    @endforeach
                                    <h5 class="card-title text-muted">Total
                                        Section: {{ $class->sections->count() }}</h5>
                                    <h5 class="card-title text-muted">Total Student: {{ $total_student }}</h5>
                                    @if(count($class->sections)>0)
                                        <div class="float-right">
                                            <div class="dropdown">
                                                <button class="button button--primary"
                                                        type="button" id="dropdownMenuButton" data-toggle="dropdown"
                                                        aria-haspopup="true" aria-expanded="false">
                                                    Sections
                                                    <i class="fa fa-caret-down"></i>
                                                </button>
                                                <div class="dropdown-content" aria-labelledby="dropdownMenuButton">
                                                    @foreach($class->sections as $section)
                                                        <a class=""
                                                           href="{{ url('admin/grades/section/'.$section->id) }}">Section: {{$section->section_number}}</a>
                                                    @endforeach
                                                </div>
                                            </div>
                                        </div>
                                    @else
                                        <div class="float-right">
                                            <div class="dropdown">
                                                <button
                                                        class="button button--primary font-weight-bold"
                                                        type="button" id="dropdownMenuButton"
                                                        data-toggle="dropdown"
                                                        aria-haspopup="true" aria-expanded="false">
                                                    Sections
                                                    <i class="fa fa-caret-down"></i>
                                                </button>

                                                <div class="dropdown-content"
                                                     aria-labelledby="dropdownMenuButton">
                                                    <!-- <button disabled class="btn disabled text-dark font-weight-bold"
                                                        type="button" aria-expanded="false">
                                                        No Info Available
                                                    </button>                                               -->
                                                    <p class="text-center text-muted font-weight-bold">
                                                        No Info Available
                                                    </p>
                                                </div>
                                            </div>
                                            <div>
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
