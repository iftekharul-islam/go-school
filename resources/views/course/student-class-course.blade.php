@extends('layouts.student-app')

@section('title', 'Course')

@section('content')

    <div class="dashboard-content-one">
        <!-- Breadcubs Area Start Here -->
        <div class="breadcrumbs-area">
            <h3>All Subjects</h3>
            <ul>
                <li>
                    <a href="{{ url('home') }}">Home</a>
                </li>
                <li>Subjects</li>
            </ul>
        </div>
        <!-- Breadcubs Area End Here -->
        <!-- All Subjects Area Start Here -->
        <div class="row">
            <div class="col-12-xxxl col-12">
                <div class="card height-auto false-height">
                    <div class="card-body">
                        <div class="heading-layout1">
                            @if(Auth::user()->role != 'student')
                                <ol class="breadcrumb" style="margin-top: 3%;">
                                    <li><a href="{{url('school/sections?course=1')}}" style="color:#3b80ef;">All Classes &amp; Sections</a></li>
                                    <li class="active">Courses</li>
                                </ol>
                            @endif
                            <div class="item-title">
                                <h3>Courses Related to Section</h3>
                                @if(count($courses) > 0)
                                    @foreach ($courses as $course)
                                        <div class="page-panel-title"><b>Section</b> -   {{$course->section->section_number}} &nbsp;<b>Class</b> -  {{$course->section->class->class_number}}</div>
                                        @break($loop->first)
                                    @endforeach
                                @endif
                            </div>
                            <div class="dropdown">
                                <a class="dropdown-toggle" href="#" role="button" data-toggle="dropdown"
                                   aria-expanded="false">...</a>

                                <div class="dropdown-menu dropdown-menu-right">
                                    <a class="dropdown-item" href="#"><i
                                                class="fas fa-times text-orange-red"></i>Close</a>
                                    <a class="dropdown-item" href="#"><i
                                                class="fas fa-cogs text-dark-pastel-green"></i>Edit</a>
                                    <a class="dropdown-item" href="#"><i
                                                class="fas fa-redo-alt text-orange-peel"></i>Refresh</a>
                                </div>
                            </div>
                        </div>
                        <form class="mg-b-20">
                            <div class="row gutters-8">
                                <div class="col-lg-4 col-12 form-group">
                                    <input type="text" placeholder="Search by Exam ..." class="form-control">
                                </div>
                                <div class="col-lg-3 col-12 form-group">
                                    <input type="text" placeholder="Search by Subject ..." class="form-control">
                                </div>
                                <div class="col-lg-3 col-12 form-group">
                                    <input type="text" placeholder="dd/mm/yyyy" class="form-control">
                                </div>
                                <div class="col-lg-2 col-12 form-group">
                                    <button type="submit"
                                            class="fw-btn-fill btn-gradient-yellow">SEARCH</button>
                                </div>
                            </div>
                        </form>
                        <div class="table-responsive">
                            @if(count($courses) > 0)
                                <div>
                                    @if (session('status'))
                                        <div class="alert alert-success">
                                            {{ session('status') }}
                                        </div>
                                    @endif
                                    @component('components.student-course-table',['courses'=>$courses, 'exams'=>$exams, 'student'=>(Auth::user()->role == 'student')?true:false])
                                    @endcomponent
                                </div>
                            @else
                                <div class="panel-body">
                                    No Related Data Found.
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- All Subjects Area End Here -->
    </div>

@endsection
