@extends('layouts.student-app')

@section('title', 'Grade')

@section('content')
    {{--    <div class="dashboard-content-one">--}}
    <!-- Breadcubs Area Start Here -->
    <div class="breadcrumbs-area">
        <h3>
            Grade
        </h3>
        <ul>
            <li> <a href="javascript:history.back()" style="color: #32998f!important;">
                    Back &nbsp;&nbsp;|</a>
                <a style="margin-left: 8px;" href="{{ url(\Illuminate\Support\Facades\Auth::user()->role.'/home') }}">&nbsp;&nbsp;Home</a>
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
                    <div class="page-panel-title mb-4"><b>Student Code</b> - {{$grade->student->student_code}} &nbsp;<b>Name</b> -  {{$grade->student->name}} &nbsp;<b>Class</b> - {{$grade->student->section->class->class_number}} &nbsp;<b>Section</b> - {{$grade->student->section->section_number}}</div>
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
    {{--    </div>--}}
@endsection
