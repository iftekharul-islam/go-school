@extends('layouts.student-app')

@section('title', 'Grade')

@section('content')
    <div class="breadcrumbs-area">
        <h3>
            Marks and Grades
        </h3>
        <ul>
            <li> <a href="{{ URL::previous() }}" style="color: #32998f!important;">
                    Back &nbsp;&nbsp;|</a>
                <a style="margin-left: 8px;" href="{{ url(\Illuminate\Support\Facades\Auth::user()->role.'/home') }}">&nbsp;&nbsp;Home</a>
            </li>
            <li><a href="{{url('/grades/classes')}}">Classes</a></li>
            @if(Auth::user()->role != 'student')
                <li class="active">Section</li>
            @endif
        </ul>
    </div>
    @if(count($students) > 0)
        <div class="card height-auto mb-5">
            <div class="card-body">
                <div class="heading-layout1">
                    <div class="item-title">
                        <h3><i class="fas fa-users mr-2"></i>Students of Section: <strong> {{$section->section_number}}</strong></h3>
                    </div>
                </div>
                <div class="table-responsive">
                    <table class="table display table-bordered table-data-div text-wrap">
                        <thead>
                        <tr>
                            <th>Sl.</th>
                            <th>Student Code</th>
                            <th>Student Name</th>
                            <th>Student Email</th>
                            <th>Grade History</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach ($students as $student)
                            <tr>
                                <td>{{($loop->index+1)}}</td>
                                <td>{{$student->student_code}}</td>
                                <td><a class="text-teal" href="{{url('user/'.$student->student_code)}}">{{$student->name}}</a></td>
                                <td>{{ $student->email }}</td>
                                <td><a class="btn-link text-teal" role="button" href="{{url('admin/grades/'.$student->id)}}">View Grade History</a></td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    @endif
    <div class="card height-auto false-height">
        <div class="card-body">
            <div class="heading-layout1">
                <div class="item-title">
                    <h3>Marks and Grades</h3>
                </div>
            </div>
            @if(count($grades) > 0)
                @if (session('status'))
                    <div class="alert alert-success">
                        {{ session('status') }}
                    </div>
                @endif
                <div class="mb-5">
                    @foreach($grades as $grade)
                        <b>Class:</b> {{$grade->course->class->class_number}} &nbsp;
                        <b>Section:</b> {{$grade->student->section->section_number}}
                        @break
                    @endforeach
                </div>
                <div class="table-responsive">
                    <table class="table display table-data-div text-wrap">
                        <thead>
                        <tr>
                            <th>Exam Name</th>
                            <th>Course Name</th>
                            <th>Student Code</th>
                            <th>Student Name</th>
                            <th>Total Mark</th>
                            <th>GPA</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($grades as $grade)
                            <tr>
                                <td>@if(isset($grade->exam->exam_name)){{$grade->exam->exam_name}}@endif</td>
                                <td>@if(isset($grade->course->course_name)){{$grade->course->course_name}}@endif</td>
                                <td>@if(isset($grade->student->student_code)){{$grade->student->student_code}}@endif</td>
                                <td><a class="text-teal btn-link" href="{{url('user/'.$grade->student->student_code)}}">{{$grade->student->name}}</a></td>
                                <td>@if(isset($grade->marks)){{$grade->marks}}@endif</td>
                                <td>@if(isset($grade->gpa)){{$grade->gpa}}@endif</td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <div class="card mt-5 false-height">
                    <div class="card-body">
                        <div class="card-body-body mt-5 text-center">
                            No Related Data Found.
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </div>
@endsection
