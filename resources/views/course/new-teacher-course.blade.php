@extends('layouts.student-app')

@section('title', 'Course')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-md-10" id="main-container">
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
              @if(count($courses) > 0)
                  @foreach ($courses as $course)
                    <div class="page-panel-title" style="font-size: 20px;"><b>Teacher Code</b> - {{$course->teacher->student_code}} &nbsp;<b>Name</b> - <a href="{{url('user/'.$course->teacher->student_code)}}">{{$course->teacher->name}}</a></div>
                     @break($loop->first)
                  @endforeach
              @endif
                <div class="panel-body">
                    @if (session('status'))
                        <div class="alert alert-success">
                            {{ session('status') }}
                        </div>
                    @endif
                        <div class="card height-auto" style="min-height: 700px;">
                            <div class="card-body">
                                <div class="heading-layout1">
                                    <div class="item-title">
                                        <h3>Courses Taken by Teacher</h3>
                                    </div>
                                    <div class="dropdown">
                                        <a class="dropdown-toggle" href="#" role="button"
                                           data-toggle="dropdown" aria-expanded="false">...</a>

                                        <div class="dropdown-menu dropdown-menu-right">
                                            <a class="dropdown-item" href="#"><i class="fas fa-times text-orange-red"></i>Close</a>
                                            <a class="dropdown-item" href="#"><i class="fas fa-cogs text-dark-pastel-green"></i>Edit</a>
                                            <a class="dropdown-item" href="#"><i class="fas fa-redo-alt text-orange-peel"></i>Refresh</a>
                                        </div>
                                    </div>
                                </div>
                                <form class="mg-b-20">
                                    <div class="row gutters-8">
                                        <div class="col-3-xxxl col-xl-3 col-lg-3 col-12 form-group">
                                            <input type="text" placeholder="Search by ID ..." class="form-control">
                                        </div>
                                        <div class="col-4-xxxl col-xl-4 col-lg-3 col-12 form-group">
                                            <input type="text" placeholder="Search by Name ..." class="form-control">
                                        </div>
                                        <div class="col-4-xxxl col-xl-3 col-lg-3 col-12 form-group">
                                            <input type="text" placeholder="Search by Class ..." class="form-control">
                                        </div>
                                        <div class="col-1-xxxl col-xl-2 col-lg-3 col-12 form-group">
                                            <button type="submit" class="fw-btn-fill btn-gradient-yellow">SEARCH</button>
                                        </div>
                                    </div>
                                </form>
                                @if(count($courses) > 0)
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
