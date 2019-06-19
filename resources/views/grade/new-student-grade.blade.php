@extends('layouts.student-app')

@section('title', 'Grade')

@section('content')
    <div class="dashboard-content-one">
        <!-- Breadcubs Area Start Here -->
        <div class="breadcrumbs-area">
            <h3>Dashboard</h3>
            <ul>
                <li>
                    <a href="{{ url('home') }}">Home</a>
                </li>
                <li>Grade</li>
                @if(Auth::user()->role != 'student')
                    <li><a href="{{url('grades/all-exams-grade')}}">Grades</a></li>
                    <li><a href="{{url()->previous()}}">Section Students</a></li>
                    <li class="active">History</li>
                @endif
            </ul>
        </div>
        <!-- Breadcubs Area End Here -->
        <div class="card false-height">
            <div class="card-body">
                <div class="heading-layout1">
                    <div class="item-title">
                        <a class="float-left" href="{{ url()->previous() }}"><h4 style="color: #fea801; margin-left: 10px;">Back</h4></a>
                        <h3>Marks and Grades History</h3>
                    </div>
                </div>
                @if(count($grades) > 0)
                    @foreach ($grades as $grade)
                        <?php
                        $studentName = $grade->student->name;
                        $classNumber = $grade->student->section->class->class_number;
                        $sectionNumber = $grade->student->section->section_number;
                        ?>
                        <div class="page-panel-title"><b>Student Code</b> - {{$grade->student->student_code}} &nbsp;<b>Name</b> -  {{$grade->student->name}} &nbsp;<b>Class</b> - {{$grade->student->section->class->class_number}} &nbsp;<b>Section</b> - {{$grade->student->section->section_number}}</div>
                        @break($loop->first)
                    @endforeach
                    <div class="panel-body">
                        @if (session('status'))
                            <div class="alert alert-success">
                                {{ session('status') }}
                            </div>
                        @endif

                        @include('layouts.student.grade-table')
                    </div>
                @else
                    <div class="panel-body">
                        No Related Data Found.
                    </div>
                @endif
            </div>
        </div>
    </div>
@endsection
