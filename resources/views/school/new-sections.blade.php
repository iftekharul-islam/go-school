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
            <div class="row">
                @if(count($classes)> 0)
                    @foreach($classes as $class)
                        <?php $total_student = 0 ?>
                        <div class="col-md-3">
                            <div class="card mb-4">
                                <div>
                                    <h5 class="card-header text-teal text-center">CLASS: <strong class="text-capitalize">{{$class->class_number}}</strong>
                                        @if($class ->group) | GROUP: <strong class="text-capitalize">{{ucfirst($class->group)}}</strong>
                                        @endif
                                    </h5>
                                </div>
                                <div class="card-body-customized">
                                    @foreach($class->sections as $sec)
                                        @php
                                            $total_student = $total_student + $sec->users->count();
                                        @endphp
                                    @endforeach
                                    <div>
                                        <h5 class="card-title float-left text-muted">Total Section :
                                            <b>{{ $class->sections->count() }}</b></h5>
                                        <h5 class="card-title float-right text-muted">Total Student
                                            : {{ $total_student }}</h5>
                                    </div>
                                    <div class="">
                                        @if(isset($_GET['course']) && $_GET['course'] == 1)
                                            <div class="">
                                                <div class="dropdown">
                                                    <button class="button2 button2--white button2--animation float-right mt-5 dropdown-toggle " type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                        Class Details
                                                    </button>
                                                    <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                                        @foreach($class->sections as $section)
                                                            <a class="dropdown-item" href="{{ url('school/section/details/'.$section->id. '?course=1') }}">Section: {{$section->section_number}}</a>
                                                        @endforeach
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="">
                                                <a role="button" class="button2 button2--white button2--animation float-left mt-5"
                                                   href="{{url('academic/syllabus/'.$class->id)}}"><b>View Syllabus</b></a>
                                            </div>
                                            @else

                                            @if(count($class->sections) > 0)
                                            <div class="">
                                                <div class="dropdown">
                                                    <button class="button2 button2--white button2--animation offset-4 mt-5 dropdown-toggle " type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                        Class Details
                                                    </button>
                                                    <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                                        @foreach($class->sections as $section)
                                                            <a class="dropdown-item" href="{{ url('section/details/attendance/'.$section->id.'/'.$class->id.'?att=1') }}">Section: {{$section->section_number}}</a>
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
                                            @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                @endif
            </div>
        </div>
    </div>

@endsection
