@extends('layouts.student-app')

@section('title', 'Manage Schools')

@section('content')
    <div class="breadcrumbs-area">
        <h3>Dashboard</h3>
        <ul>
            <li>
                <a href="{{ url('/home') }}">Home</a>
            </li>
            <li>Manage Academy</li>
        </ul>
    </div>

    <div class="card height-auto false-height">
        <div class="card-body">
            <div class="heading-layout1">
                <div class="item-title">
                    <a class="float-left" href="{{ url()->previous() }}"><h4 style="color: #fea801; margin-left: 10px;">Back</h4></a>
                    <h3>Manage Departments, Classes, Sections, Student Promotion, Courses</h3>
                </div>
            </div>
            <div class="col-md-{{ (\Auth::user()->role == 'master')? 12 : 12 }}" id="main-container">
                @if (session('status'))
                    <div class="alert alert-success">
                        {{ session('status') }}
                    </div>
                @endif
                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
                <div class="">
                    <div class="table-responsive">
{{--                        @if(\Auth::user()->role == 'master')--}}
{{--                            @include('layouts.master.create-school-form')--}}
{{--                            <h2>School List</h2>--}}
{{--                        @endif--}}
                        <div class="table-responsive">
                            <table class="table display text-wrap" style="border: 0px solid;">
                                <thead>
                                <tr>
{{--                                    @if(\Auth::user()->role == 'master')--}}
{{--                                        <th>#</th>--}}
{{--                                        <th>Name</th>--}}
{{--                                        <th>Code</th>--}}
{{--                                        <th>About</th>--}}
{{--                                    @endif--}}
                                    @if(\Auth::user()->role == 'admin')
                                        <th>Department</th>
                                        <th>Classes</th>
                                    @endif
                                    @if(\Auth::user()->role == 'master')
                                        <th>+Admin</th>
                                        <th>View Admins</th>
                                    @endif
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($schools as $school)
                                    @if(\Auth::user()->role == 'master' || \Auth::user()->school_id == $school->id)
                                        <tr>
{{--                                            @if(\Auth::user()->role == 'master')--}}
{{--                                                <td>{{($loop->index + 1)}}</td>--}}
{{--                                                <td>--}}
{{--                                                    {{$school->name}}--}}
{{--                                                </td>--}}
{{--                                                <td>--}}
{{--                                                    {{$school->code}}--}}
{{--                                                </td>--}}
{{--                                                <td>--}}
{{--                                                    {{$school->about}}--}}
{{--                                                </td>--}}
{{--                                            @endif--}}
                                            @if(\Auth::user()->school_id == $school->id)
                                                <td>
                                                    <a href="#" class="btn btn-primary btn-lg"
                                                            data-toggle="modal" data-target="#departmentModal">+ Create Department
                                                    </a>
                                                    <!-- Modal -->
                                                    <div class="modal fade" id="departmentModal" tabindex="-1" role="dialog"
                                                         aria-labelledby="departmentModalLabel">
                                                        <div class="modal-dialog" role="document">
                                                            <div class="modal-content">
                                                                <div class="modal-header">
                                                                    <h4 class="modal-title" id="departmentModalLabel">
                                                                        Create Department</h4>
                                                                    <button type="button" class="close"
                                                                            data-dismiss="modal" aria-label="Close">
                                                                        <span aria-hidden="true">&times;</span>
                                                                    </button>
                                                                </div>
                                                                <div class="modal-body">
                                                                    <form class="form-horizontal"
                                                                          action="{{url('school/add-department')}}"
                                                                          method="post">
                                                                        {{csrf_field()}}
                                                                        <div class="form-group">
                                                                            <label for="department_name"
                                                                                   class="col-sm-12 control-label">Department Name</label>
                                                                            <div class="col-sm-12">
                                                                                <input type="text" class="form-control"
                                                                                       id="department_name"
                                                                                       name="department_name"
                                                                                       placeholder="English, Mathematics,...">
                                                                            </div>
                                                                        </div>
                                                                        <div class="form-group">
                                                                            <div class="col-sm-offset-2 col-sm-10">
                                                                                <button type="submit" class="btn btn-danger btn-lg">Submit</button>
                                                                            </div>
                                                                        </div>
                                                                    </form>
                                                                </div>
                                                                <div class="modal-footer">
                                                                    <button type="button" class="btn btn-danger btn-lg" data-dismiss="modal">Close</button>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td>
                                                    <a href="#collapse{{($loop->index + 1)}}" role="button"
                                                       class="btn btn-primary btn-lg" data-toggle="collapse"
                                                       aria-expanded="false"
                                                       aria-controls="collapse{{($loop->index + 1)}}">Manage Class, Section
                                                    </a>
                                                </td>
                                            @endif
{{--                                            @if(\Auth::user()->role == 'master')--}}
{{--                                                <td>--}}
{{--                                                    <a class="btn btn-danger btn-lg" role="button"--}}
{{--                                                       href="{{url('register/admin/'.$school->id.'/'.$school->code)}}">--}}
{{--                                                        <small>+ Create Admin</small>--}}
{{--                                                    </a>--}}
{{--                                                </td>--}}
{{--                                                <td>--}}
{{--                                                    <a class="btn btn-success btn-lg" role="button"--}}
{{--                                                       href="{{url('school/admin-list/'.$school->id)}}">--}}
{{--                                                        <small>View Admins</small>--}}
{{--                                                    </a>--}}
{{--                                                </td>--}}
{{--                                            @endif--}}
                                        </tr>
                                        @if(\Auth::user()->school_id == $school->id)
                                            <tr class="collapse" id="collapse{{($loop->index + 1)}}"
                                                aria-labelledby="heading{{($loop->index + 1)}}" aria-expanded="false">
                                                <td colspan="12">
                                                    @include('layouts.master.add-class-form')
                                                    <div>
                                                        <small>Click Class to View All Sections</small>
                                                    </div>
                                                    <div class="row">
                                                        @foreach($classes as $class)
                                                            @if($class->school_id == $school->id)
                                                                <div class="col-sm-3">
                                                                    <button type="button" class="btn btn-danger btn-lg"
                                                                            data-toggle="modal"
                                                                            data-target="#myModal{{$class->id}}"
                                                                            style="margin-top: 5%;">
                                                                        Manage Class :  {{$class->class_number}} {{!empty($class->group)? '- '.$class->group:''}}</button>
                                                                    <!-- Modal -->
                                                                    <div class="modal fade" id="myModal{{$class->id}}"
                                                                         tabindex="-1" role="dialog"
                                                                         aria-labelledby="myModalLabel">
                                                                        <div class="modal-dialog modal-lg"
                                                                             role="document">
                                                                            <div class="modal-content">
                                                                                <div class="modal-header">
                                                                                    <h4 class="modal-title" id="myModalLabel">All Sections of Class {{$class->class_number}}</h4>
                                                                                    <button type="button" class="close"
                                                                                            data-dismiss="modal"
                                                                                            aria-label="Close">
                                                                                        <span aria-hidden="true">&times;</span>
                                                                                    </button>
                                                                                </div>
                                                                                <div class="modal-body">
                                                                                    <ul class="list-group">
                                                                                        @foreach($sections as $section)
                                                                                            @if($section->class_id == $class->id)
                                                                                                <li class="list-group-item">
                                                                                                    Section {{$section->section_number}}
                                                                                                    &nbsp;
                                                                                                    <a class="btn btn-lg btn-warning"
                                                                                                       href="{{url('courses/0/'.$section->id)}}">View All Assigned Courses</a>
                                                                                                    <span class="pull-right"> &nbsp;&nbsp;
                                                                                                                <a class="btn btn-lg btn-success mr-2"
                                                                                                                   href="{{url('school/promote-students/'.$section->id)}}">+ Promote Students</a>
                                                  {{-- &nbsp;<a class="btn btn-xs btn-primary" href="{{url('register/student/'.$section->id)}}">+ Register Student</a> --}}
                                                </span>
                                                                                                    @include('layouts.master.add-course-form')
                                                                                                </li>
                                                                                            @endif
                                                                                        @endforeach
                                                                                    </ul>
                                                                                    @include('layouts.master.create-section-form')
                                                                                </div>
                                                                                <div class="modal-footer">
                                                                                    <button type="button"
                                                                                            class="btn btn-danger btn-lg"
                                                                                            data-dismiss="modal">Close
                                                                                    </button>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            @endif
                                                        @endforeach
                                                    </div>
                                                </td>
                                            </tr>
                                        @endif
                                    @endif
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                        <br>
                        @foreach($schools as $school)
                            @if(\Auth::user()->role == 'admin' && \Auth::user()->school_id == $school->id)
                                <h4>Add Users</h4>
                                <table class="table display text-nowrap">
                                    <thead>
                                    <tr>
                                        <th>Student</th>
                                        <th>Teacher</th>
                                        <th>Accountant</th>
                                        <th>Librarian</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <tr>
                                        <td>
                                            <a class="btn btn-info btn-lg" href="{{url('register/student')}}">+ Add
                                                Student</a>
                                        </td>
                                        <td>
                                            <a class="btn btn-success btn-lg" href="{{url('register/teacher')}}">+ Add
                                                Teacher</a>
                                        </td>
                                        <td>
                                            <a class="btn btn-secondary btn-lg" href="{{url('register/accountant')}}">+
                                                Add Accountant</a>
                                        </td>
                                        <td>
                                            <a class="btn btn-warning btn-lg" href="{{url('register/librarian')}}">+ Add
                                                Librarian</a>
                                        </td>
                                    </tr>
                                    </tbody>
                                </table>
                                <br>
                                <h4>Upload</h4>
                                <table class="table display text-nowrap">
                                    <thead>
                                    <tr>
                                        <th>Notice</th>
                                        <th>Event</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <tr>
                                        <td>
                                            <a class="btn btn-info btn-lg" href="{{ url('academic/notice') }}">Upload
                                                Notice</a>
                                        </td>
                                        <td>
                                            <a class="btn btn-info btn-lg" href="{{ url('academic/event') }}">Upload
                                                Event</a>
                                        </td>
                                    </tr>
                                    </tbody>
                                </table>
                                @break
                            @endif
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
