@extends('layouts.student-app')

@section('title', 'Grade')

@section('content')
{{--    <div class="dashboard-content-one">--}}
        <!-- Breadcubs Area Start Here -->
        <div class="breadcrumbs-area">
            <h3><a class="float-left" href="{{ url()->previous() }}"><h4 style="color: #fea801; font-size: 22px;">Back</h4>
                </a>&nbsp;&nbsp;Grade
            </h3>
            <ul style="margin-left: -100px !important;">
                <li>
                    <a style="margin-left: -43px;" href="{{ url('/home') }}">Home</a>
                </li>
                <li>Grade</li>
            </ul>
        </div>
        <!-- Breadcubs Area End Here -->
        <div class="card false-height">
            <div class="card-body">
                <div class="heading-layout1">
                    <div class="item-title">
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
{{--    </div>--}}
@endsection
