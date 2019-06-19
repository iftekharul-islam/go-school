@extends('layouts.student-app')

@section('title', 'All Classes and Sections')

@section('content')

    <div class="breadcrumbs-area">
        <h3>All Classes</h3>
        <ul>
            <li>
                <a href="{{ url('/home') }}">Home</a>
            </li>
            <li>All Classes</li>
        </ul>
    </div>
    <div class="card height-auto false-height">
        <div class="card-body">
            <div class="heading-layout1">
                <div class="item-title">
                    <a class="float-left" href="{{ url()->previous() }}"><h4 style="color: #fea801; margin-left: 10px;">
                            Back</h4></a>
                    <h3>All Classes and Sections</h3>
                </div>
            </div>


            <div class="row">
                @if(count($classes) > 0)
                    @foreach ($classes as $class)
                        <?php $total_student = 0 ?>
                        <div class="col-md-6">
                            <div class="card mb-5">
                                <h5 class="card-header bg-dark text-white" style="text-align: center">Class
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
                                    <a class="btn-secondary btn btn-lg float-right" role="button" data-toggle="collapse"
                                       href="#collapse{{$class->id}}" aria-controls="collapse{{$class->id}}"><b>Sections
                                            under this Class</b></a>
                                    @if(isset($_GET['course']) && $_GET['course'] == 1)
                                        <div class="col-md-3">
                                            <a role="button" class="btn-secondary btn btn-lg"
                                               href="{{url('academic/syllabus/'.$class->id)}}"><b>View Syllabus</b></a>
                                        </div>
                                    @endif
                                </div>
                                <div id="collapse{{$class->id}}" class="panel-collapse collapse" role="tabpanel"
                                     aria-labelledby="heading{{$class->id}}">
                                    <table class="table table-bordered table-striped">
                                        <thead>
                                        <tr>
                                            <th>Section Name</th>
                                            @if(isset($_GET['att']) && $_GET['att'] == 1)
                                                <th>View Today's Attendance</th>
                                                <th>View Each Student's Attendance</th>
                                                <th>Give Attendance</th>
                                            @endif
                                            @if(isset($_GET['course']) && $_GET['course'] == 1)
                                                <th>View Courses</th>
                                                <th>View Students</th>
                                                <th>View Routines</th>
                                            @endif
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @foreach($sections as $section)
                                            @if($class->id == $section->class_id)
                                                <tr>
                                                    <td>
                                                        <a href="{{url('courses/0/'.$section->id)}}">{{$section->section_number}}</a>
                                                    </td>

                                                    @if(isset($_GET['att']) && $_GET['att'] == 1)
                                                        @foreach ($exams as $exam)
                                                            @foreach($exam as $key => $ex)
                                                                @if ($ex->class_id == $class->id)
                                                                    <td>
                                                                        <a role="button"
                                                                           class="btn-fill-md text-dodger-blue border-dodger-blue"
                                                                           href="{{url('attendances/'.$section->id.'/0/'.$ex->exam_id)}}">View
                                                                            Today's Attendance</a>
                                                                    </td>
                                                                    @if($key === 0)
                                                                        @break 2;
                                                                    @endif
                                                                @endif
                                                            @endforeach
                                                        @endforeach
                                                        <td>
                                                            <a role="button"
                                                               class="btn-fill-md text-orange-peel border-orange-peel"
                                                               href="{{url('attendances/'.$section->id)}}">View Each
                                                                Student's Attendance</a>
                                                        </td>
                                                        <td>
                                                            <?php
                                                            $ce = 0;
                                                            ?>
                                                            @foreach ($exams as $exam)
                                                                @foreach($exam as $key => $ex)
                                                                    @if ($ex->class_id == $class->id)
                                                                        <?php
                                                                        $ce = 1;
                                                                        ?>
                                                                        <a role="button"
                                                                           class="btn-fill-md text-mauvelous border-mauvelous"
                                                                           href="{{url('attendances/'.$section->id.'/0/'.$ex->exam_id)}}">Take
                                                                            Attendance</a>
                                                                    @endif
                                                                    @if($key === 0)
                                                                        @break 2;
                                                                    @endif
                                                                @endforeach
                                                            @endforeach
                                                            @if($ce == 0)
                                                                Assign Class Under Exam
                                                            @endif
                                                        </td>
                                                    @endif


                                                    @if(isset($_GET['course']) && $_GET['course'] == 1)
                                                        <td>
                                                            <a role="button"
                                                               class="btn-fill-md text-dodger-blue border-dodger-blue"
                                                               href="{{url('courses/0/'.$section->id)}}">View Courses
                                                                under this section</a>
                                                        </td>
                                                        <td>
                                                            <a role="button"
                                                               class="btn-fill-md text-orange-peel border-orange-peel"
                                                               href="{{url('section/students/'.$section->id.'?section=1')}}">View
                                                                Students of this section</a>
                                                        </td>
                                                        <td>
                                                            <a role="button"
                                                               class="btn-fill-md text-dark-pastel-green border-dark-pastel-green"
                                                               href="{{url('academic/routine/'.$section->id)}}">View
                                                                Routines for this section</a>
                                                        </td>
                                                    @endif
                                                </tr>
                                            @endif
                                        @endforeach
                                        </tbody>
                                    </table>
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