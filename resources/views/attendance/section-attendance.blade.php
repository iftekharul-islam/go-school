@extends('layouts.student-app')

@section('title', 'Attendance')

@section('content')

    <div class="breadcrumbs-area">
        <h3>All Students</h3>
        <ul>
            <li> <a href="{{ URL::previous() }}" style="color: #32998f!important;">
                    Back &nbsp;&nbsp;|</a>
                <a style="margin-left: 8px;" href="{{ url(\Illuminate\Support\Facades\Auth::user()->role.'/home') }}">&nbsp;&nbsp;Home</a>
            </li>
            <li>Students Attendance</li>
        </ul>
    </div>
    <div class="section-students">
        <div class="card height-auto mt-5 false-height">
            <div class="card-body">
                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
                <div class="panel panel-default">
                    @if(count($users) > 0)

                </div>

                <div class="card">
                    <div class="card-body">
                        @if (session('status'))
                            <div class="alert alert-success">
                                {{ session('status') }}
                            </div>

                        @elseif (session('error'))
                            <div class="alert alert-danger">
                                {{ session('error') }}
                            </div>
                        @endif
                        <div class="title mb-5" style="overflow: hidden" >
                            <div class="float-left">
                                <a class="button button--save mr-2 float-left"
                                   href={{ route('attendance.summary', $students[0]->section->id) }}>
                                    View Summary</a>
                                <a class="button button--save mr-2 float-left"
                                   href={{ route('student.attendance', $students[0]->section->id) }}>
                                    Take Attendance</a>
                                <a class="button button--save float-left"
                                   href={{ route('export.AbsentStudent', ['class_number'=>$class->class_number, 'section_number'=>$students[0]->section->section_number ]) }}>
                                    Export Absent Students</a>
                            </div>
                        </div>
                        @component('components.users',['users'=>$users,'current_page'=>$current_page,'per_page'=>$per_page])
                        @endcomponent
                    </div>
                </div>

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

