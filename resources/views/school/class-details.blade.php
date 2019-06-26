@extends('layouts.student-app')

@section('title', 'All Classes and Sections')

@section('content')

    <div class="breadcrumbs-area">
        <h3><a class="float-left" href="{{ url()->previous() }}"><h4 style="color: #fea801; font-size: 22px;">Back</h4></a>&nbsp;&nbsp;Class Details</h3>
        <ul style="margin-left: -100px !important;">
            <li>
                <a style="margin-left: -43px;" href="{{ url('/home') }}">Home</a>
            </li>
            <li>Class Details</li>
        </ul>
    </div>
    <div class="card height-auto false-height">
        <div class="card-body">
            @php
                $count = 0;
            @endphp
            <table class="table table-bordered">
                <thead>
                <tr>
                    <th>Name</th>
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
                    @if($class_id == $section->class_id)
                        @php $count++ @endphp
                        <tr>
                            <td>
                                <a class="text-muted" href="{{url('courses/0/'.$section->id)}}">Section {{$section->section_number}}</a>
                            </td>

                            @if(isset($_GET['att']) && $_GET['att'] == 1)
                                @foreach ($exams as $exam)
                                    @foreach($exam as $key => $ex)
                                        @if ($ex->class_id == $class_id)
                                            <td>
                                                <a role="button"
                                                   class="button2 button2--white button2--animation float-left" style="font-size: 20px"
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
                                       class="button2 button2--white button2--animation float-left"
                                       href="{{url('attendances/'.$section->id)}}">View Each
                                        Student's Attendance</a>
                                </td>
                                <td>
                                    <?php
                                    $ce = 0;
                                    ?>
                                    @foreach ($exams as $exam)
                                        @foreach($exam as $key => $ex)
                                            @if ($ex->class_id == $class_id)
                                                <?php
                                                $ce = 1;
                                                ?>
                                                <a role="button"
                                                   class="button2 button2--white button2--animation float-left"
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
                                       class="button2 button2--white button2--animation float-left"
                                       href="{{url('courses/0/'.$section->id)}}">View Courses</a>
                                </td>
                                <td>
                                    <a role="button"
                                       class="button2 button2--white button2--animation float-left"
                                       href="{{url('section/students/'.$section->id.'?section=1')}}">View
                                        Students</a>
                                </td>
                                <td>
                                    <a role="button"
                                       class="button2 button2--white button2--animation float-left"
                                       href="{{url('academic/routine/'.$section->id)}}">View
                                        Routines</a>
                                </td>
                            @endif
                        </tr>
                    @endif
                @endforeach
                </tbody>
            </table>
            @if($count === 0)
                <h3 style="text-align: center">No Related Data Found</h3>
            @endif
        </div>
    </div>

@endsection